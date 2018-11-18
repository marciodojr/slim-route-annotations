<?php

namespace Mdojr\SlimAnnotations\Test\Action;

final class RouteCallbackWithTwoMethods
{
    public function firstRouteCallback($request, $response)
    {
        return $response->withJson([
            'callback' => __METHOD__,
        ]);
    }

    public function secondRouteCallback($request, $response)
    {
        return $response->withJson([
            'callback' => __METHOD__,
        ]);
    }
}
