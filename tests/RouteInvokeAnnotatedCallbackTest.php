<?php

use Mdojr\SlimAnnotations\Test\TestCase;
use Mdojr\SlimAnnotations\Test\Action\RouteCallbackAnnotedWithInvoke;

class RouteInvokeAnnotatedCallbackTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testProcessGetAnnotationInInvoke()
    {
        $response = $this->runApp('GET', '/route/with-annotations');
        $this->assertEquals(200, $response->getStatusCode());
        $jsonBody = $this->decodeResponse($response);
        $this->assertEquals([
            'callback' => RouteCallbackAnnotedWithInvoke::class . '::__invoke',
        ], $jsonBody);
    }

    public function testProcessPostAnnotationInInvoke()
    {
        $response = $this->runApp('POST', '/route/with-annotations');
        $this->assertEquals(200, $response->getStatusCode());
        $jsonBody = $this->decodeResponse($response);
        $this->assertEquals([
            'callback' => RouteCallbackAnnotedWithInvoke::class . '::__invoke',
        ], $jsonBody);
    }

    public function testMethodNotAllowed()
    {
        $response = $this->runApp('PATCH', '/route/with-annotations');
        $this->assertEquals(405, $response->getStatusCode());
    }
}
