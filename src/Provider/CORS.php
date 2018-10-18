<?php

declare(strict_types=1);

namespace App\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\App;

class CORS implements ServiceProviderInterface
{
    public function register(Container $cnt)
    {
        $cnt[App::class]->add(function (Request $request, Response $response, callable $next) {
            $uri = $request->getUri();
            $path = $uri->getPath();
            if ($path != '/' && substr($path, -1) == '/') {
                // permanently redirect paths with a trailing slash
                // to their non-trailing counterpart
                $uri = $uri->withPath(substr($path, 0, -1));
                if($request->getMethod() == 'GET') {
                    return $response->withRedirect((string)$uri, 301);
                }
                else {
                    return $next($request->withUri($uri), $response);
                }
            }
            return $next($request, $response);
        });

        $cnt[App::class]->add(function ($req, $res, $next) {
            $response = $next($req, $res);
            return $response
                ->withHeader('Access-Control-Allow-Origin', $cnt['settings']['cors'])
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        });
    }
}