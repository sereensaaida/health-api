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
    public function handleGetFoods(Request $request, Response $response): Response{

        //* Retrieving the filter parameters from the request
        $filter_params = $request->getQueryParams();

        $this->foods_model->setPaginationOptions(
            current_page: $filter_params
            ['current_page'],
            records_per_page: $filter_params
            ['page_size']
        );


        $foods = $this->foods_model->getFoods($filter_params);
        $json_payload = json_encode($foods);
        $response->getBody()->write($json_payload);
        return $response->withHeader(
            "Content-Type",
            "application/json",
        )->withStatus(200);
    }


}
