<?php

use Mdojr\SlimAnnotations\Test\TestCase;
use Mdojr\SlimAnnotations\Test\Action\RouteCallbackWithInvoke;

class RouteInvokeCallbackTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->app->get('/test-invoke', RouteCallbackWithInvoke::class);
    }

    public function testProcessInvoke()
    {
        $response = $this->runApp('GET', '/test-invoke');
        $jsonBody = $this->decodeResponse($response);

        $this->assertEquals([
            'callback' => RouteCallbackWithInvoke::class . '::__invoke',
        ], $jsonBody);
    }

    public function testProcessRouteNotFound()
    {
        $response = $this->runApp('GET', '/aaa/10');
        $this->assertEquals(404, $response->getStatusCode());
    }
}