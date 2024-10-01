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


        $facts = $this->facts_model->getFacts($filter_params);
        return $this->renderJson(
            $response,
            $facts
        );
    }

    public function handleGetFactsId(Request $request, Response $response, array $uri_args): Response
    {
        $fact_id = $uri_args['fact_id'];

        //* Checking that the fact id was inputted in the uri
        if (!isset($uri_args["fact_id"])) {
            return $this->renderJson(
                $response,
                [
                    "status" => "error",
                    "code" => "400",
                    "message" => "No fact ID provided."

                ],
                StatusCodeInterface::STATUS_BAD_REQUEST
            );
        }

        $fact = $this->facts_model->getFactId($fact_id);
        if ($fact === false) {
            throw new HttpNotFoundException(
                $request,
                "No matching fact found"
            );
        }

        return $this->renderJson(
            $response,
            $fact
        );
    }
}
