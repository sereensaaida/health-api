<?php

namespace App\Middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Helpers\LogHelper;
use Psr\Http\Server\MiddlewareInterface;

//Middleware kinda acts like a controller where it handles the the interaction between the handler and the application.
//This class is the callback
class LogMiddleware implements MiddlewareInterface
{

    public function process(\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Server\RequestHandlerInterface $handler): ResponseInterface
    {
        //? Ask teacher: is it better to fetch from the server or from the request ?
        //get the information from the server
        $ip_address = $_SERVER["REMOTE_ADDR"];
        //by default, the date and time is added to the message
        $resource_uri = $_SERVER["REQUEST_URI"];
        $request_method = $_SERVER["REQUEST_METHOD"];
        $queryString = $request->getUri()->getQuery();
        $log_message = "\nTest message" . "\nClient IP address: " . $ip_address . "\nResource uri: " . $resource_uri . "\nRequest method: " . $request_method . "\nQuery strings: " . $queryString;

        //var_dump($request);
        //call the LogHelper
        //? How can i differenciate the access and the error ?
        LogHelper::handleAccess($log_message);
        // $response->getBody()->write("Successfully wrote in the Access log :)");

        return $handler->handle($request);
    }
    
}
