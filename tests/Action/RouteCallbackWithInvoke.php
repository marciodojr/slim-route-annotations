<?php

namespace Mdojr\SlimAnnotations\Test\Action;

use Mdojr\SlimAnnotations\Annotation\Route;

final class RouteCallbackWithInvoke
{
    public function __invoke($request, $response)
    {
        return $response->withJson(['callback' => __METHOD__]);
    }
}
