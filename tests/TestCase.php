<?php

namespace Mdojr\SlimAnnotations\Test;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Environment;
use Mdojr\SlimAnnotations\App;

class TestCase extends BaseTestCase
{
    protected $app;

    public function setUp()
    {
        $this->app = new App([
            'settings' => [
                'displayErrorDetails' => true,
                'routeAnnotations' => [
                    [
                        'dir' => __DIR__ . '/Action',
                        'namespacePrefix' => 'Mdojr\\SlimAnnotations\\Test\\Action'
                    ]
                ]
            ]
        ]);
    }

    protected function runApp(
        string $requestMethod,
        string $requestUri,
        array $requestData = null
    ) : Response {
        $environment = Environment::mock(
            [
                'REQUEST_METHOD' => $requestMethod,
                'REQUEST_URI' => $requestUri
            ]
        );
        $request = Request::createFromEnvironment($environment);
        if (isset($requestData)) {
            $request = $request->withParsedBody($requestData);
        }

        return $this->app->process($request, new Response());
    }

    protected function decodeResponse(Response $response, $asArray = true)
    {
        return json_decode($response->getBody(), $asArray);
    }

    public function tearDown()
    {
        $this->app = null;
    }
}
