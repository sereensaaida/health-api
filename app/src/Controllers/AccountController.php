<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Firebase\JWT\JWT as JWT;
use Firebase\JWT\Key;

class AccountController extends BaseController
{
    public function handleUserLogin(Request $request, Response $response): Response
    {

        // TODO: 1) Validate the received user credentials against the DB: check if there is a record matching the log in information from the client. ex: user/email: password.

        // When the user is logged in:
        //! Generate JWT (token) containing private claims about the authenticated user.
        $issued_at = time();
        $expires_at = $issued_at + 3600;
        $registered_claims = [
            'iss' => 'http://localhost/health-api/',
            'aud' => 'http://healthapi.com',
            'iat' => $issued_at,
            'exp' => $expires_at
        ];

        $private_claims = array(
            'user_id' => 1,
            'email' => 'health@gmail.com',
            'username' => 'lasagna',
            'role' => 'admin'
        );

        $payload = array_merge($private_claims, $registered_claims);
        $jwt = JWT::encode($payload, SECRET_KEY, 'HS256');
        $jwt_data = array(
            "status" => "Success",
            "message" => "Successfully logged in!",
            "token" => $jwt
        );

        return $this->renderJson($response, $jwt_data);
    }
}
