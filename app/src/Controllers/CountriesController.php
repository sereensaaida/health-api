<?php

namespace App\Controllers;

use App\Core\PDOService;
use App\Exceptions\HttpInvalidInputsException;
use App\Helpers\PaginationHelper;
use App\Models\CountriesModel;
use App\Services\CountriesService;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpSpecializedException;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Symfony\Component\Console\Event\ConsoleCommandEvent;

class CountriesController extends BaseController
{

    //*Creating Construct Method
    /**
     * Countries constructor.
     *
     * @param CountriesModel $countries_model Reference to the countries model
     * @param CountriesService $countries_service reference to the countries service
     */
    public function __construct(private CountriesModel $countries_model, private CountriesService $countries_service)
    {
        parent::__construct();
        $this->countries_model = $countries_model;
        $this->countries_service = $countries_service;
    }

    //* Get /countries -> countries collection handler
    /**
     * Handler for getting the countries collection
     *
     * @param Request $request The user request
     * @param Response $response The generated response
     * @return Response Returning the response in JSON format
     */
    public function handleGetCountries(Request $request, Response $response): Response
    {
        //*Pagination  and filter implementation
        $filter_params = $request->getQueryParams();
        //*Pagination validation
        if ($this->isPagingParamsValid($filter_params) === true) {
            $this->countries_model->setPaginationOptions(
                current_page: $filter_params['current_page'],
                records_per_page: $filter_params['page_size']
            );
        }

        //*send to countries model and return JSON response
        $countries = $this->countries_model->getCountries($filter_params);
        return $this->renderJson($response, $countries);
    }

    //* Get /countries/{country_id}
    /**
     * Handler for getting the country collection by id
     *
     * @param Request $request The user request
     * @param array $uri_args Arguments representing id entered by user
     * @param Response $response The generated response
     * @return Response Returning the response in JSON format
     */
    public function handleGetCountryId(Request $request, Response $response, array $uri_args): Response
    {

        //* Checking if country ID is present, if not throw an error
        if (!isset($uri_args["country_id"])) {
            return $this->renderJson(
                $response,
                [
                    "status" => "error",
                    "code" => "400",
                    "message" => "The supplied country Id is not found"
                ],
                StatusCodeInterface::STATUS_BAD_REQUEST
            );
        }

        //* If valid, retrieving country id and defining appropriate pattern
        $country_id = $uri_args["country_id"];

        if (!$this->isIdValid(['id' => $country_id])) {
            throw new HttpInvalidInputsException($request, "Invalid country ID provided.");
        }


        //* Fetch country record with proper model method, return JSON response
        $country = $this->countries_model->getCountryId(country_id: $country_id);
        if ($country === false) {
            throw new HttpNotFoundException(
                $request,
                "no country found"
            );
        }
        return $this->renderJson($response, $country);
    }

    //* Subcollection implementation
    /**
     * Handler for getting the countries sub-collection of guidelines
     *
     * @param Request $request The user request
     * @param Response $response The generated response
     * @return Response Returning the response in JSON format
     */
    public function handleGetCountryGuidelines(Request $request, Response $response,  array $uri_args): Response
    {
        //* Checking if country ID is present, if not throw an error
        if (!isset($uri_args["country_id"])) {
            return $this->renderJson(
                $response,
                [
                    "status" => "error",
                    "code" => "400",
                    "message" => "The supplied country Id is not found"
                ],
                StatusCodeInterface::STATUS_BAD_REQUEST
            );
        }

        //* If valid, retrieving country id and defining appropriate pattern
        $country_id = $uri_args["country_id"];

        if (!$this->isIdValid(['id' => $country_id])) {
            throw new HttpInvalidInputsException($request, "Invalid country ID provided.");
        }


        //*Checking if entry is present in country table, if not throwing an exception
        $country = $this->countries_model->getCountryId($country_id);
        if ($country === false) {
            throw new HttpNotFoundException(
                $request,
                "No matching country record found"
            );
        }

        //*Fetching guidelines from proper country id
        $results = $this->countries_model->getCountryGuidelines($country_id);
        return $this->renderJson($response, $results);
    }

    //*(Build 2: Create Country instance)
    /**
     * Handler for creating a country
     *
     * @param Request $request The user request
     * @param Response $response The generated response
     * @return Response Returning the response in JSON format
     */
    public function handleCreateCountry(Request $request, Response $response): Response
    {
        //* 1) Handle Client Request (extract and validate?)
        $new_country = $request->getParsedBody();
        //Call Country service create method
        $result = $this->countries_service->createCountry($new_country[0]);
        $payload = [];
        $status_code = 201;

        //* 2) checking for success and retrieving appropriate errors
        if ($result->isSuccess()) {
            $payload["success"] = true;
        } else {
            $status_code = 400;
            $payload["success"] = false;
        }
        $payload["message"] = $result->getMessage();
        $payload["errors"] = $result->getData();
        $payload["status"] = $status_code;
        //* 3) pass the received data to the service
        return $this->renderJson($response, $payload, $status_code);
    }

    //*Update Country Instance
    /**
     * Handler for updating a country
     *
     * @param Request $request The user request
     * @param Response $response The generated response
     * @return Response Returning the response in JSON format
     */
    public function handleUpdateCountry(Request $request, Response $response): Response
    {
        //* 1) Handle Client Request (extract and validate?)
        $update_country = $request->getParsedBody();
        //Call Country service update method
        $result = $this->countries_service->updateCountry($update_country[0]);
        $payload = [];
        $status_code = 201;


        //* 2) checking for success and retrieving appropriate errors
        if ($result->isSuccess()) {
            $payload["success"] = true;
        } else {
            $status_code = 400;
            $payload["success"] = false;
        }
        $payload["message"] = $result->getMessage();
        $payload["errors"] = $result->getData();
        $payload["status"] = $status_code;
        //* 3) pass the received data to the service
        return $this->renderJson($response, $payload, $status_code);
    }

    //*Delete Country Instance
    /**
     * Handler for deleting a country
     *
     * @param Request $request The user request
     * @param Response $response The generated response
     * @return Response Returning the response in JSON format
     */
    public function handleDeleteCountry(Request $request, Response $response): Response
    {
        //* 1) Handle Client Request (extract and validate?)
        $delete_country = $request->getParsedBody();
        //Call create Country Service
        $result = $this->countries_service->deleteCountry($delete_country[0]);
        $payload = [];
        $status_code = 201;

        //* 2) checking for success and retrieving appropriate errors
        if ($result->isSuccess()) {
            $payload["success"] = true;
        } else {
            $status_code = 400;
            $payload["success"] = false;
        }
        $payload["message"] = $result->getMessage();
        $payload["errors"] = $result->getData();
        $payload["status"] = $status_code;
        //* 3) pass the received data to the service
        return $this->renderJson($response, $payload, $status_code);
    }
}
