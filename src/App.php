<?php

namespace Mdojr\SlimAnnotations;

use Slim\App as SlimApp;
use Psr\Http\Message\ServerRequestInterface;
use InvalidArgumentException;
use ReflectionClass;
use Doctrine\Common\Annotations\AnnotationReader;
use Mdojr\SlimAnnotations\Annotation\Route as RouteAnnotation;
use Psr\Http\Message\ResponseInterface;

class App extends SlimApp
{
    public function __construct($container = [])
    {
        parent::__construct($container);

        if ($this->noRouteCache()) {
            $this->parseAnnotatedRoutes();
        }
    }

    /**
     * Parse all route annotations
     *
     * Parse only if there is no cache file.
     * If you want to parse new routes delete the *routerCacheFile*
     */
    protected function parseAnnotatedRoutes()
    {
        $annotationConfig = $this->getAnnotationConfig();

        foreach ($annotationConfig as $dirConfig) {
            if (
                !is_array($dirConfig)
                || !array_key_exists('dir', $dirConfig)
                || !array_key_exists('namespacePrefix', $dirConfig)
            ) {
                throw new InvalidArgumentException('The route callable path
                config must be an array with keys \'dir\' and \'namespacePrefix\'');
            }

            $annotatedClasses = $this->getClasses($dirConfig['dir'], $dirConfig['namespacePrefix']);
            $this->readClasses($annotatedClasses);
        }
    }

    protected function noRouteCache()
    {
        $settings = $this->getContainer()->get('settings');
        return empty($settings['routerCacheFile']) || !file_exists($settings['routerCacheFile']);
    }

    protected function getAnnotationConfig()
    {
        $c = $this->getContainer();
        $annotationConfig = [];
        if (isset($c->get('settings')['routeAnnotations'])) {
            $annotationConfig = $c->get('settings')['routeAnnotations'];
        }

        return $annotationConfig;
    }

    protected function getClasses(string $dir, string $namespacePrefix)
    {
        if (!is_dir($dir)) {
            throw new InvalidArgumentException(sprintf('Directory not found: %s', $dir));
        }

        return array_map(function ($file) use ($namespacePrefix) {
            return $namespacePrefix . '\\'. basename($file, '.php');
        }, glob(rtrim($dir, '/') . '/*.php'));
    }

    protected function readClasses(array $annotatedClasses)
    {
        $routeAnnotationObj = new RouteAnnotation;
        $reader = new AnnotationReader();
        foreach ($annotatedClasses as $class) {
            $reflClass = new ReflectionClass($class);
            $reflPublicMethods = $reflClass->getMethods(\ReflectionMethod::IS_PUBLIC);

            foreach ($reflPublicMethods as $method) {
                if ($annotation = $reader->getMethodAnnotation($method, $routeAnnotationObj)) {
                    $this->readMethodAnnotations(
                        $annotation,
                        $class,
                        $method->getName(),
                        $method->isStatic()
                    );
                }
            }
        }
    }

    protected function readMethodAnnotations(
        RouteAnnotation $annotation,
        string $class,
        string $method,
        bool $isStatic
    ) {
        $callable = $class;

        if ($isStatic) {
            $callable = [$class, $method];
        } elseif ($method != '__invoke') {
            $callable = $class . ':'. $method;
        }

        $route = $this->map($annotation->methods, $annotation->pattern, $callable);

        foreach ($annotation->middlewares as $middleware) {
            $route->add($middleware);
        }
    }
}
