<?php

namespace App\Middleware;

use App\Helpers\DateTimeHelper;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Helpers\LogHelper;
use Psr\Http\Server\MiddlewareInterface;
use App\Models\AccessLogModel;
use UnexpectedValueException;
use Firebase\JWT\JWT as JWT;
use Firebase\JWT\Key;
use App\Exceptions\HttpInvalidInputsException;


//Middleware kinda acts like a controller where it handles the the interaction between the handler and the application.
//This class is the callback
class LogMiddleware implements MiddlewareInterface
{
    public function __construct(private AccessLogModel $accessLogModel) {}
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

        //TODO: get the decoded token to get information about the user

        $auth_header = $request->getHeaderLine("Authorization");
        $jwt = str_replace("Bearer ", "", $auth_header);
        $date = new DateTimeHelper();
        $time = $date->nowForDb();
        // try {
        //for now, this will stop the issues ig
        if ($jwt != null) {
            $decoded_token = (array)(JWT::decode($jwt, new Key(SECRET_KEY, "HS256")));
            /*
                'user_id' => 1,
                'email' => 'health@gmail.com',
                'username' => 'lasagna',
                'role' => 'admin'
                 */
            //var_dump($time);
            $log_information = [
                "user_id" => 1,
                "email" => $decoded_token["email"],
                "ip_address" => $ip_address,
                "method" => $request_method,
                "logged_at" => $time
            ];
            //log into db
            $this->accessLogModel->insertLogDb($log_information);
        }
        // } catch (UnexpectedValueException $e) {
        //     // throw new HttpInvalidInputsException($request, $e->getMessage());
        //     echo "yur";
        // };


        //var_dump($request);
        //call the LogHelper
        //? How can i differenciate the access and the error ?
        LogHelper::handleAccess($log_message);
        // $response->getBody()->write("Successfully wrote in the Access log :)");

        return $handler->handle($request);
    }
}
