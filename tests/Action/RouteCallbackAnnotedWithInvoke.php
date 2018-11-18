<?php

namespace Mdojr\SlimAnnotations\Test\Action;

use Mdojr\SlimAnnotations\Annotation\Route;

final class RouteCallbackAnnotedWithInvoke
{
    /**
     * @Route(pattern="/route/with-annotations", methods={"GET", "POST"})
     */
    public function __invoke($request, $response)
    {
        return $response->withJson(['callback' => __METHOD__]);
    }
}
