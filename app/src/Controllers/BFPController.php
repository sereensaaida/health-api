<?php

namespace App\Controllers;

use App\Services\BFPService;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class BFPController extends BaseController
{
    public function calculateBFP(Request $request, Response $response): Response
    {
        // Get the body from the request
        $body = $request->getParsedBody();

        $weight = $body[0]["weight"];
        $height = $body[0]["height"];
        $age = $body[0]["age"];
        $gender = $body[0]["gender"];



        // calling service
        $calculator = new BFPService();
        $bfp = $calculator->BFPcalculation($weight, $height, $age, $gender);

        $bfp_information = [
            "Your weight" => $weight,
            "Your height" => $height,
            "Your age" => $age,
            "Your gender" => $gender,
            "Your calculated BFP (rounded)" => round($bfp, 2)
        ];

        // Render JSON response
        return $this->renderJson(
            $response,
            $bfp_information
        );
    }
}
