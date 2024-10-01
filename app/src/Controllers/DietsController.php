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
        //$filter_params = $request->getQueryParams();
        $diets = $this->dietsModel->getDiets();

        return $this->renderJson($response, $diets);
    }

    //handle get diets by id (expecting an arg from request)
    public function handleGetDietsId(Request $request, Response $response, array $args)
    {
        //*Step 1: Validate that the user has sent the right argument

        //*Step 2: Error handling

        //*Step 3: Call the db from the model
        $diets = $this->dietsModel->getDietsId($args["diet_id"]);
        //*Step 4: Encode in json & put it in the response
        //$json_info = json_encode($diets);
        //*Step 5: Send the response with the Header & status code
        //$response = $response->getBody()->write($json_info);

        return $this->renderJson(
            $response,
            $diets
        );
    }
}
