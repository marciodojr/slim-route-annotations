<?php

namespace Mdojr\SlimAnnotations\Annotation;

/**
 * @Annotation
 */
class Route
{
    /**
     * @Required
     * @var string
     */
    public $pattern;

    /**
     * @var array
     */
    public $methods = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'];

    /**
     * @var array
     */
    public $middlewares = [];

    public function __get($name)
    {
        return $this->$name;
    }
}
