<?php

use Mdojr\SlimAnnotations\Test\TestCase;

class RouteAnonymousFunctionCallbackTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->app->group('/route', function() {
            $this->get('/param1/{p1}', function($request, $response, $args) {
                return $response->withJson([
                    'route' => '/route/param1',
                    'p1' => $args['p1']
                ]);
            });
            $this->get('/param2/{p2}', function($request, $response, $args) {
                return $response->withJson([
                    'route' => '/route/param2',
                    'p2' => $args['p2']
                ]);
            });
        });
    }

    public function testProcessRouteParam1()
    {
        $response = $this->runApp('GET', '/route/param1/10');
        $jsonBody = $this->decodeResponse($response);

        $this->assertEquals([
            'route' => '/route/param1',
            'p1' => 10
        ], $jsonBody);
    }

    public function testProcessRouteParam2()
    {
        $response = $this->runApp('GET', '/route/param2/5');
        $jsonBody = $this->decodeResponse($response);

        $this->assertEquals([
            'route' => '/route/param2',
            'p2' => 5
        ], $jsonBody);
    }

    public function testProcessRouteNotFound()
    {
        $response = $this->runApp('GET', '/3333/10');
        $this->assertEquals(404, $response->getStatusCode());
    }
}