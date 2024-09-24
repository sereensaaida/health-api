<?php

namespace App\Controllers;

use App\Models\FactsModel;
use App\Core\AppSettings;
use App\Exceptions\HttpInvalidInputsException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Fig\Http\Message\StatusCodeInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpSpecializedException;

class FactsController extends BaseController
{

    public function __construct(private FactsModel $facts_model)
    {
        parent::__construct();
    }

    //* GET /foods -> Foods collection handler
    public function handleGetFacts(Request $request, Response $response): Response
    {

        //* Retrieving the filter parameters from the request
        $filter_params = $request->getQueryParams();

        //TODO Pagination
        // $this->foods_model->setPaginationOptions(
        //     current_page: $filter_params
        //     ['current_page'],
        //     records_per_page: $filter_params
        //     ['page_size']
        // );


        $foods = $this->facts_model->getFacts($filter_params);
        $json_payload = json_encode($foods);
        $response->getBody()->write($json_payload);
        return $response->withHeader(
            "Content-Type",
            "application/json",
        )->withStatus(200);
    }
}
