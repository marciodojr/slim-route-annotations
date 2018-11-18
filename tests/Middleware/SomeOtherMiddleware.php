<?php

namespace Mdojr\SlimAnnotations\Test\Middleware;

class SomeOtherMiddleware
{
    public function __invoke($request, $response, $next)
    {
        return $next($request->withAttribute('some-other-middleware', self::class), $response);
    }
}