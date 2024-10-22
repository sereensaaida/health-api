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

/**
 * Class FactsController
 *
 * This controller class handles operations related to Facts
 */
class FactsController extends BaseController
{

    /**
     * FoodsModel constructor.
     *
     * @param FactsModel $facts_model Reference to the facts model
     */
    public function __construct(private FactsModel $facts_model)
    {
        parent::__construct();
    }

    //* GET /foods -> Foods collection handler
    /**
     * Handler for getting the facts collection
     *
     * @param Request $request The user request
     * @param Response $response The generated response
     * @return Response Returning the response in JSON format
     */
    public function handleGetFacts(Request $request, Response $response): Response
    {
        //* Retrieving the filter parameters from the request
        $filter_params = $request->getQueryParams();

        //* Pagination: Retrieving the filter parameters from the request
        $filter_params = $request->getQueryParams();
        //dd($filter_params);
        if ($this->isPagingParamsValid($filter_params) === true) {
            $this->facts_model->setPaginationOptions(
                current_page: $filter_params['current_page'],
                records_per_page: $filter_params['page_size']
            );
        }


        $facts = $this->facts_model->getFacts($filter_params);
        return $this->renderJson(
            $response,
            $facts
        );
    }

    /**
     * Handler for getting the facts singleton resource
     *
     * @param Request $request The user request
     * @param Response $response The generated response
     * @return Response Returning the response in JSON format
     */
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

        if (!$this->isIdValid(['id' => $fact_id])) {
            throw new HttpInvalidInputsException($request, "Invalid fact ID provided.");
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
