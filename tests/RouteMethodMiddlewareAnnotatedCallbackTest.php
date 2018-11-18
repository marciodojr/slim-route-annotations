<?php

use Mdojr\SlimAnnotations\Test\TestCase;
use Mdojr\SlimAnnotations\Test\Action\RouteCallbackWithMiddleware;
use Mdojr\SlimAnnotations\Test\Middleware\SomeMiddleware;
use Mdojr\SlimAnnotations\Test\Middleware\SomeOtherMiddleware;

class RouteMethodMiddlewareAnnotatedCallbackTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testProcessMethod1()
    {
        $response = $this->runApp('GET', '/test-annotated-middleware');
        $jsonBody = $this->decodeResponse($response);

        $this->assertEquals([
            'middleware1' => SomeMiddleware::class,
            'middleware2' => SomeOtherMiddleware::class,
            'callback' => RouteCallbackWithMiddleware::class,
        ], $jsonBody);
    }
}