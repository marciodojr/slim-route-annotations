<?php

use Mdojr\SlimAnnotations\Test\TestCase;
use Mdojr\SlimAnnotations\Test\Action\RouteCallbackWithTwoMethods;

class RouteMethodCallbackTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->app->get('/test-method1', RouteCallbackWithTwoMethods::class . ':firstRouteCallback');
        $this->app->post('/test-method2', RouteCallbackWithTwoMethods::class . ':secondRouteCallback');
    }

    public function testProcessMethod1()
    {
        $response = $this->runApp('GET', '/test-method1');
        $jsonBody = $this->decodeResponse($response);

        $this->assertEquals([
            'callback' => RouteCallbackWithTwoMethods::class . '::firstRouteCallback',
        ], $jsonBody);
    }

    public function testProcessMethod2()
    {
        $response = $this->runApp('POST', '/test-method2');
        $jsonBody = $this->decodeResponse($response);

        $this->assertEquals([
            'callback' => RouteCallbackWithTwoMethods::class . '::secondRouteCallback',
        ], $jsonBody);
    }

    public function testProcessRouteNotFound()
    {
        $response = $this->runApp('GET', '/aaa/10');
        $this->assertEquals(404, $response->getStatusCode());
    }
}