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
use GuzzleHttp\Client;

/**
 * Class FoodsController
 *
 * This controller class handles operations related to Foods
 */
class FoodsController extends BaseController
{

    /**
     * FoodsController constructor.
     *
     * @param FoodsModel $foods_model Reference to the foods model
     */
    public function __construct(private FoodsModel $foods_model, private FoodsService $food_service)
    {
        parent::__construct();
        $this->foods_model = $foods_model;
        $this->food_service = $food_service;
    }

    //* GET /foods -> Foods collection handler
    /**
     * Handler for getting the foods collection
     *
     * @param Request $request The user request
     * @param Response $response The generated response
     * @return Response Returning the response in JSON format
     */
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

    /**
     * Handler for getting the foods singleton resource
     *
     * @param Request $request The user request
     * @param Response $response The generated response
     * @return Response Returning the response in JSON format
     */
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

    /**
     * Handler for getting the foods sub-collection of facts
     *
     * @param Request $request The user request
     * @param Response $response The generated response
     * @return Response Returning the response in JSON format
     */
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

    //? POST /foods
    /**
     * Handler for creating a food
     *
     * @param Request $request The user request
     * @param Response $response The generated response
     * @return Response Returning the response in JSON format
     */
    public function handleCreateFood(Request $request, Response $response): Response
    {
        //* Step 1) Retrieve data included in the POST request body
        $new_food = $request->getParsedBody();
        //dd($new_food[0]);

        $result = $this->food_service->createFood($new_food[0]);

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

    //? PUT /foods
    /**
     * Handler for updating a food
     *
     * @param Request $request The user request
     * @param Response $response The generated response
     * @return Response Returning the response in JSON format
     */
    public function handleUpdateFood(Request $request, Response $response): Response
    {
        $new_food = $request->getParsedBody();

        // Checking if the food id is in the DB
        $food = $this->foods_model->getFoodId($new_food[0]["food_id"]);
        if ($food === false) {
            throw new HttpNotFoundException(
                $request,
                "No matching food found"
            );
        }

        $result = $this->food_service->updateFood($new_food[0]);

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

    //? DELETE /foods
    /**
     * Handler for deleting a food
     *
     * @param Request $request The user request
     * @param Response $response The generated response
     * @return Response Returning the response in JSON format
     */
    public function handleDeleteFood(Request $request, Response $response): Response
    {
        $new_food = $request->getParsedBody();

        // CHecking if the food id is in the DB
        $food = $this->foods_model->getFoodId($new_food[0]["food_id"]);
        if ($food === false) {
            throw new HttpNotFoundException(
                $request,
                "No matching food found"
            );
        }

        $result = $this->food_service->deleteFood($new_food[0]);

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

    /**
     * Handler for composite resource
     *
     * @param Request $request The user request
     * @param Response $response The generated response
     * @param array $uri_args The arguments from the URI
     * @return Response Returning the response in JSON format
     */
    public function handleGetCompositeNutrition(Request $request, response $response, array $uri_args): Response
    {
        //$query_params = $request->getQueryParams();
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
        $food_db = $this->foods_model->getFoodId($food_id);
        if ($food_db === false) {
            throw new HttpNotFoundException(
                $request,
                "No matching food found"
            );
        }
        // Getting the food name to use for the composite API
        $food_name = $food_db['name'];

        //API call
        // Api key:
        $api_url = "https://api.api-ninjas.com/v1/nutrition?query={$food_name}";
        //dd($api_url);
        $api_key =  "xPGnQwQ8Xr3NNAKUemA1hhxD7VDBNfFQJXVMvMV1";
        $client = new Client([
            'base_uri' => $api_url,
        ]);

        $api_call = $client->request('GET', "https://api.api-ninjas.com/v1/nutrition?query={$food_name}", [
            'headers' => [
                'X-Api-Key' => 'xPGnQwQ8Xr3NNAKUemA1hhxD7VDBNfFQJXVMvMV1',
                'Accept' => 'application/json'
            ]
        ]);

        // Get the content -> Get the body from the response
        $body = $api_call->getBody();
        //var_dump($body);
        // Then get contents from the body
        $response_payload = $body->getContents();

        // Decode it and convert it into JSON(array or object)
        $nutrition_info = json_decode($response_payload);
        $nutrition_info = $nutrition_info[0];
        //var_dump($nutrition_info);

        $nutrition = array(
            'fat_total_g' => $nutrition_info->fat_total_g,
            'fat_saturated_g' => $nutrition_info->fat_saturated_g,
            'fat_total_g' => $nutrition_info->fat_total_g,
            'sodium_mg' => $nutrition_info->sodium_mg,
            'potassium_mg' => $nutrition_info->potassium_mg,
            'cholesterol_mg' => $nutrition_info->cholesterol_mg,
            'carbohydrates_total_g' => $nutrition_info->carbohydrates_total_g,
            'fiber_g' => $nutrition_info->fiber_g
        );

        //var_dump($nutrition);

        $data = array(
            'Database Information' => $food_db,
            'NinjaAPI' => $nutrition
        );

        return $this->renderJson($response, $data);
    }
}

//? Notes
// For the POST the input has to be inserted in the request body in JSON format.

// For AA
