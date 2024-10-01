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

class FoodsController extends BaseController
{

    public function __construct(private FoodsModel $foods_model)
    {
        parent::__construct();
    }

    //* GET /foods -> Foods collection handler
    public function handleGetFoods(Request $request, Response $response): Response
    {

        //* Retrieving the filter parameters from the request
        $filter_params = $request->getQueryParams();

        //TODO Pagination: Find a way to make it work without conflicting
        // $this->foods_model->setPaginationOptions(
        //     current_page: $filter_params
        //     ['current_page'],
        //     records_per_page: $filter_params
        //     ['page_size']
        // );

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

        //TODO ADD VALIDATION
        // if (preg_match($player_id_pattern, $player_id) === 0) {
        //     throw new HttpInvalidInputsException(
        //         $request,
        //         "Invalid food ID provided",
        //     );
        // }

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

        $results = $this->foods_model->getFoodFacts($food_id);

        return $this->renderJson($response, $results);
    }

    public function handleGetFoodIdRecommendation(Request $request, Response $response, array $uri_args): Response
    {
        $food_id = $uri_args['food_id'];

        $results = $this->foods_model->getFoodRecommendations($food_id);

        return $this->renderJson($response, $results);
    }
}
