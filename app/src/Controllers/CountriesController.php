<?php

namespace App\Controllers;

use App\Core\PDOService;
use App\Exceptions\HttpInvalidInputsException;
use App\Helpers\PaginationHelper;
use App\Models\CountriesModel;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Symfony\Component\Console\Event\ConsoleCommandEvent;

class CountriesController extends BaseController
{

    public function __construct(private CountriesModel $countries_model) {}
    public function handleGetCountries(Request $request, Response $response): Response
    {
        $filter_params = $request->getQueryParams();
        $countries = $this->countries_model->getCountries($filter_params);
        return $this->renderJson($response, $countries);
    }

    public function handleGetCountryId(Request $request, Response $response, array $uri_args): Response
    {

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

        $country_id = $uri_args["country_id"];
        $country_id_pattern = '/^([0-9]*)$/';


        if (preg_match($country_id_pattern, $country_id) === 0) {
            throw new HttpInvalidInputsException(
                $request,
                "Invalid country id provided"
            );
        }


        $country = $this->countries_model->getCountryId(country_id: $country_id);
        return $this->renderJson($response, $country);
    }

    public function handleGetCountryGuidelines(Request $request, Response $response,  array $uri_args): Response
    {

        $country_id = $uri_args['country_id'];
        $results = $this->countries_model->getCountryGuidelines($country_id);

        return $this->renderJson($response, $results);
    }

    //


    public function handleCreateCountry(Request $request, Response $response): Response
    {
        echo "hiiiii";

        return $response;
    }
}
