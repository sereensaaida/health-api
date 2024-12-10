<?php

namespace App\Controllers;

use App\Services\BMRService;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Class BMRController
 *
 * This controller class handles the computational operations to calculate BMR based on height, weight, age, and gender
 */
class BMRController extends BaseController
{
    /**
     * BMRController constructor.
     *
     * @param BMRService $BMR_service Reference to the BMR service
     */
    public function __construct(private BMRService $BMR_service)
    {
        parent::__construct();
        $this->BMR_service = $BMR_service;
    }

    /**
     * CalculateBMR method
     *
     * @param Request $request Client request
     * @param Response $response Server response
     * @return Response Returning a response object
     */
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
