<?php

namespace App\Controllers;

use App\Services\BMRService;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class BMRController extends BaseController
{
    public function __construct(private BMRService $BMR_service)
    {
        parent::__construct();
        $this->BMR_service = $BMR_service;
    }
    public function calculateBMR(Request $request, Response $response): Response
    {
        //echo "hello";
        $user_information = $request->getParsedBody();

        $gender = $user_information['gender'];
        $age = $user_information['age'];
        $height = $user_information['height'];
        $weight = $user_information['weight'];

        $computed_result = $this->BMR_service->BMRcalculation($gender, $age, $height, $weight);

        $data = array(
            'gender' => $gender,
            'age' => $age,
            'height' => $height,
            'weight' => $weight,
            'Results' => $computed_result,
        );

        return $this->renderJson($response, $data);
    }
}
