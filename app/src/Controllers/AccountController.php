<?php

namespace App\Controllers;

use App\Services\AccountService;
use App\Models\AccountModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Firebase\JWT\JWT as JWT;
use Firebase\JWT\Key;

class AccountController extends BaseController
{

    public function __construct(private AccountModel $account_model, private AccountService $account_service)
    {
        parent::__construct();
        $this->account_model = $account_model;
        $this->account_service = $account_service;
    }

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

    public function handleRegistration(Request $request, Response $response): Response
    {
        $new_user = $request->getParsedBody();
        //var_dump($new_user);

        $result = $this->account_service->createUser($new_user[0]);

        $payload = [];
        $status_code = 201;

        if ($result->isSuccess()) {
            $payload["success"] = true;
        } else {
            $status_code = 400;
            $payload['error'] = false;
        }

        $payload["message"] = $result->getMessage();
        $payload["errors"] = $result->getData();
        $payload["status"] = $status_code;

        return $this->renderJson($response, $payload, $status_code);
    }
}
