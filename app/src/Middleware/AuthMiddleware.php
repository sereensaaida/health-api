<?php

namespace App\Middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Helpers\LogHelper;
use LogicException;
use Psr\Http\Server\MiddlewareInterface;
use Slim\Exception\HttpUnauthorizedException;
use UnexpectedValueException;
use Firebase\JWT\JWT as JWT;
use Firebase\JWT\Key;

//Middleware kinda acts like a controller where it handles the the interaction between the handler and the application.
//This class is the callback
class AuthMiddleware implements MiddlewareInterface
{

    public function process(\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Server\RequestHandlerInterface $handler): ResponseInterface
    {

        $uri = $request->getUri()->getPath();

        if (
            str_contains($uri, '/login')
            || str_contains($uri, '/register')

        ) {
            return $handler->handle($request);
        }
        // Extract the JWT from the request Auth header


        $auth_header = $request->getHeaderLine("Authorization");
        $jwt = str_replace("Bearer ", "", $auth_header);
        //var_dump($jwt);

        try {
            $decoded = JWT::decode($jwt, new Key(SECRET_KEY, "HS256"));
        } catch (LogicException $e) {
            throw new HttpUnauthorizedException($request, $e->getMessage());
        } catch (UnexpectedValueException $e) {
            throw new HttpUnauthorizedException($request, $e->getMessage());
        }

        $response = $handler->handle($request);

        return $response;
    }
}
