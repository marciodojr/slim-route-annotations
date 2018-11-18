<?php

use Mdojr\SlimAnnotations\Test\TestCase;
use Mdojr\SlimAnnotations\Test\Action\RouteCallbackWithTwoAnnotatedMethods;

class RouteMethodAnnotatedCallbackTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testProcessMethod1()
    {
        $response = $this->runApp('GET', '/test-annotated-method1');
        $jsonBody = $this->decodeResponse($response);

        $this->assertEquals([
            'callback' => RouteCallbackWithTwoAnnotatedMethods::class . '::firstRouteCallback',
        ], $jsonBody);
    }

    public function testProcessMethod2()
    {
        $response = $this->runApp('POST', '/test-annotated-method2');
        $jsonBody = $this->decodeResponse($response);

        $this->assertEquals([
            'callback' => RouteCallbackWithTwoAnnotatedMethods::class . '::secondRouteCallback',
        ], $jsonBody);
    }
}