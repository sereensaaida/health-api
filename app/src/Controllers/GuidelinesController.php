<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\GuidelinesModel;
use Slim\Exception\HttpNotFoundException;
use Fig\Http\Message\StatusCodeInterface;
use App\Exceptions\HttpInvalidInputsException;
use App\Helpers\PaginationHelper;

class GuidelinesController extends BaseController
{
    //*Creating Construct Method
    public function __construct(private GuidelinesModel $guidelines_model)
    {
        parent::__construct();
        $this->guidelines_model = $guidelines_model;
    }

    //*Get /guidelines -> guidelines collection handler
    public function handleGetGuidelines(Request $request, Response $response): Response
    {
        //*Pagination and filter implementing
        $filter_params = $request->getQueryParams();

        //*Validating pagination
        if ($this->isPagingParamsValid($filter_params) === true) {
            $this->guidelines_model->setPaginationOptions(
                current_page: $filter_params['current_page'],
                records_per_page: $filter_params['page_size']
            );
        }

        //*Send to guidelines model, retrieve json response
        $guidelines = $this->guidelines_model->getGuidelines($filter_params);
        return $this->renderJson($response, $guidelines);
    }

    //* Get /guidelines/{guidelines_id} implementation
    public function handleGetGuidelinesId(Request $request, Response $response, array $uri_args): Response
    {
        //* Checking if guideline ID is present, if not throw an error
        if (!isset($uri_args["guideline_id"])) {
            return $this->renderJson(
                $response,
                [
                    "status" => "error",
                    "code" => "400",
                    "message" => "The supplied guideline Id is not found"
                ],
                StatusCodeInterface::STATUS_BAD_REQUEST
            );
        }



        //* If valid, retrieving guideline id and defining appropriate pattern
        $guideline_id = $uri_args["guideline_id"];
        if (!$this->isIdValid(['id' => $guideline_id])) {
            throw new HttpInvalidInputsException($request, "Invalid guideline ID provided.");
        }

        //* Fetch guideline record with proper model method, return JSON response
        $guideline = $this->guidelines_model->getGuidelinesId($guideline_id);
        if ($guideline === false) {
            throw new HttpNotFoundException(
                $request,
                "no guideline found"
            );
        }
        return $this->renderJson($response, $guideline);
    }
}
