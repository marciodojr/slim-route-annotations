<?php

namespace Mdojr\SlimAnnotations\Test\Action;

use Mdojr\SlimAnnotations\Annotation\Route;

final class RouteCallbackWithTwoAnnotatedMethods
{
    /**
     * @Route(pattern="/test-annotated-method1", methods={"GET"})
     */
    public function firstRouteCallback($request, $response)
    {
        return $response->withJson([
            'callback' => __METHOD__,
        ]);
    }
    /**
     * @Route(pattern="/test-annotated-method2", methods={"POST"})
     */
    public function secondRouteCallback($request, $response)
    {
        return $response->withJson([
            'callback' => __METHOD__,
        ]);
    }
}
