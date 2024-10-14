<?php

declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use App\Exceptions\HttpNotAcceptableException;

class ContentNegotiationMiddleware implements MiddlewareInterface
{
    public function process(Request $request, RequestHandler $handler): ResponseInterface
    {
        //* Step 1) Get/read the value HTTP AcceptHeader
        $requestValue = $request->getHeader("Accept");

        //var_dump($request->getHeader("Accept"));
        //echo ($requestValue[0]);

        //* Step 2) Compare it to "application/json" -> If it doesn't match, you produce an appropriate response
        if ($requestValue[0] !== "application/json") {

            // Method 1 - Throwing custom exception
            throw new HttpNotAcceptableException(
                $request,
                "Invalid resource representation requested.",
            );
        }

        //! DO NOT remove or change the following statements.
        $response = $handler->handle($request);
        return $response;
    }
}
