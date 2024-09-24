<?php

namespace App\Controllers;

use App\Models\DietsModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class DietsController extends BaseController
{

    //call DietsModel
    public function __construct(private DietsModel $dietsModel)
    {
        parent::__construct();
    }

    public function handleGetDiets(Request $request, Response $response)
    {
        //*Retrieve filtering
        $filter_params = $request->getQueryParams();

        $diets = $this->dietsModel->getDiets();

        return $response->withHeader(
            "Content-Type",
            "application/json",
        )->withStatus(200);
    }
}
