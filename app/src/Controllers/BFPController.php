<?php

namespace App\Controllers;

use App\Services\BFPService;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class BFPController extends BaseController
{
    /**
     * calculates the Body Fat Percentage based on the user's weight, height, age, and gender
     *
     * @param Request $request  containing the user input
     * @param Response $response returning the BFP information
     *
     * @return Response The JSON response containing the BFP calculation and input data.
     */
    public function calculateBFP(Request $request, Response $response): Response
    {
        $body = $request->getParsedBody();

        if (
            !isset($body["weight"], $body["height"], $body["age"], $body["gender"]) ||
            !is_numeric($body["weight"]) ||
            !is_numeric($body["height"]) ||
            !is_numeric($body["age"]) ||
            !in_array($body["gender"], ["male", "female"], true)
        ) {
            return $this->renderJson($response->withStatus(400), [
                "error" => "Invalid input data. Please provide valid weight, height, age, and gender (male or female)."
            ]);
        }

        $weight = (float)$body["weight"];
        $height = (float)$body["height"];
        $age = (int)$body["age"];
        $gender = $body["gender"];

        $calculator = new BFPService();
        $bfp = $calculator->BFPcalculation($weight, $height, $age, $gender);

        $bfp_information = [
            "Your weight" => $weight,
            "Your height" => $height,
            "Your age" => $age,
            "Your gender" => $gender,
            "Your calculated BFP (rounded)" => round($bfp, 2)
        ];

        return $this->renderJson($response, $bfp_information);
    }
}
