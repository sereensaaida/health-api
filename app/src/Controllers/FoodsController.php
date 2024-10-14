<?php

namespace App\Controllers;

use App\Models\FoodsModel;
use App\Core\AppSettings;
use App\Exceptions\HttpInvalidInputsException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Fig\Http\Message\StatusCodeInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpSpecializedException;
use validation\index;
use App\Services\FoodsService;

/**
 * Class FoodsController
 *
 * This controller class handles operations related to Foods
 */
class FoodsController extends BaseController
{

    /**
     * FoodsModel constructor.
     *
     * @param FoodsModel $foods_model The 
     */
    public function __construct(private FoodsModel $foods_model, private FoodsService $food_service)
    {
        parent::__construct();
        $this->foods_model = $foods_model;
        $this->food_service = $food_service;
    }

    //* GET /foods -> Foods collection handler
    public function handleGetFoods(Request $request, Response $response): Response
    {
        // Obtaining the query parameters
        $filter_params = $request->getQueryParams();

        //* Pagination
        //dd($filter_params);
        if ($this->isPagingParamsValid($filter_params) === true) {
            $this->foods_model->setPaginationOptions(
                current_page: $filter_params['current_page'],
                records_per_page: $filter_params['page_size']
            );
        }


        $foods = $this->foods_model->getFoods($filter_params);

        return $this->renderJson(
            $response,
            $foods
        );
    }

    public function handleGetFoodId(Request $request, Response $response, array $uri_args): Response
    {
        // Getting the food_id form the URI
        $food_id = $uri_args['food_id'];

        //* Validating that a valid ID is inputted in the URI - Because we can never trust what the user is putting in.
        if (!isset($uri_args["food_id"])) {
            return $this->renderJson(
                $response,
                [
                    "status" => "error",
                    "code" => "400",
                    "message" => "No food ID provided."

                ],
                StatusCodeInterface::STATUS_BAD_REQUEST
            );
        }

        if (!$this->isIdValid(['id' => $food_id])) {
            throw new HttpInvalidInputsException($request, "Invalid food ID provided.");
        }

        //* Step 3) If valid, fetch the appropriate data for the specific player from the DB
        $food = $this->foods_model->getFoodId($food_id);
        if ($food === false) {
            throw new HttpNotFoundException(
                $request,
                "No matching food found"
            );
        }

        return $this->renderJson(
            $response,
            $food
        );
    }

    public function handleGetFoodFacts(Request $request, Response $response, array $uri_args): Response
    {
        $food_id = $uri_args['food_id'];

        //* Validating that a valid ID is inputted in the URI - Because we can never trust what the user is putting in.
        if (!isset($uri_args["food_id"])) {
            return $this->renderJson(
                $response,
                [
                    "status" => "error",
                    "code" => "400",
                    "message" => "No food ID provided."

                ],
                StatusCodeInterface::STATUS_BAD_REQUEST
            );
        }

        if (!$this->isIdValid(['id' => $food_id])) {
            throw new HttpInvalidInputsException($request, "Invalid food ID provided.");
        }

        //* Step 3) If valid, fetch the appropriate data for the specific food from the DB
        $food = $this->foods_model->getFoodId($food_id);
        if ($food === false) {
            throw new HttpNotFoundException(
                $request,
                "No matching food found"
            );
        }

        $results = $this->foods_model->getFoodFacts($food_id);

        return $this->renderJson($response, $results);
    }

    public function handleGetFoodIdRecommendation(Request $request, Response $response, array $uri_args): Response
    {
        $food_id = $uri_args['food_id'];

        $results = $this->foods_model->getFoodRecommendations($food_id);

        return $this->renderJson($response, $results);
    }

    //? POST /foods
    public function handleCreateFood(Request $request, Response $response): Response
    {
        //* Step 1) Retrieve data included in the POST request body
        $new_food = $request->getParsedBody();
        //dd($new_food);

        //* Step 2) Pass the data that is received to the service
        $result = $this->food_service->createFood($new_food);

        $payload = [];
        $status_code = 201;

        if ($result->isSuccess()) {
            $payload["success"] = true;
        } else {
            $status_code = 400;
            $payload['success'] = false;
        }
        $payload["message"] = $result->getMessage();
        $payload["errors"] = $result->getData();
        $payload["status"] = $status_code;

        return $this->renderJson($response, $payload, $status_code);
    }
}
