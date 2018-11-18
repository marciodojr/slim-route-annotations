<?php

namespace Mdojr\SlimAnnotations\Test\Middleware;

class SomeMiddleware
{
    public function __invoke($request, $response, $next)
    {
        return $next($request->withAttribute('some-middleware', self::class), $response);
    }
}