<?php

namespace App\Controllers;

use App\Services\BMIService;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Exceptions\HttpInvalidInputsException;

class BMIController extends BaseController
{
    public function calculateBMI(Request $request, Response $response): Response
    {
        //get the body from the request
        $body = $request->getParsedBody();
        $weight = $body["weight"];
        $height = $body["height"];
        //TODO:Data validation
        if (!is_numeric($weight) || !is_numeric($height)) {
            throw new HttpInvalidInputsException(
                $request,
                "Weight and height must be numeric"
            );
        }
        //call the service method to calculate the BMI
        $calculator = new BMIService();
        $bmi = $calculator->BMIcalculation($weight, $height);
        //var_dump($bmi);
        $bmi_information =
            [
                "Your weight:" => $weight,
                "Your height:" => $height,
                "Your calculated BMI (rounded)" => round($bmi)
            ];

        //renderjson after
        return $this->renderJson(
            $response,
            $bmi_information //needs to be an array
        );
    }
}
