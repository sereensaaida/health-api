<?php

namespace App\Controllers;

use App\Models\CountriesModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CountriesController {

    public function __construct(private CountriesModel $countries_model) {}
    public function handleGetCountries(Request $request, Response $response): Response
    {
        $json_payload = json_encode($this->countries_model->getCountries());
        $response->getBody()->write($json_payload);
        return $response->withHeader(
            "content-Type",
            "application/json"
        )->withStatus(201);
    }
}
