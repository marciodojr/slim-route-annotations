<?php

namespace Mdojr\SlimAnnotations\Test\Action;

use Mdojr\SlimAnnotations\Annotation\Route;

final class RouteCallbackWithMiddleware
{
    /**
     * @Route(
     *      pattern="/test-annotated-middleware",
     *      methods={"GET"},
     *      middlewares={
     *          "Mdojr\SlimAnnotations\Test\Middleware\SomeMiddleware",
     *          "Mdojr\SlimAnnotations\Test\Middleware\SomeOtherMiddleware"
     *      }
     * )
     */
    public function callbackWithMiddleware($request, $response)
    {
        return $response->withJson([
            'middleware1' => $request->getAttribute('some-middleware'),
            'middleware2' => $request->getAttribute('some-other-middleware'),
            'callback' => self::class,
        ]);
    }
}
