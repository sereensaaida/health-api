<?php

namespace App\Controllers;

use App\Exceptions\HttpInvalidInputsException;

//require_once("../validation/index.php");
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

        if (isset($filter_params["current_page"])) {
            if ($this->isPagingParamsValid($filter_params)) {
                $this->dietsModel->setPaginationOptions(
                    $filter_params["current_page"],
                    $filter_params["page_size"]
                );
            }
        }
        $diets = $this->dietsModel->getDiets($filter_params);

        return $this->renderJson($response, $diets);
    }

    //handle get diets by id (expecting an arg from request)
    public function handleGetDietsId(Request $request, Response $response, array $args)
    {
        //*Step 1: Validate that the user has sent the right argument
        $diet_id = $args["diet_id"];
        //*Step 2: Error handling
        $diet_id_pattern = '/^([0-9]*)$/';


        if (preg_match($diet_id_pattern, $diet_id) === 0) {
            throw new HttpInvalidInputsException(
                $request,
                "invalid id provided"
            );
        }
        //*Step 3: Call the db from the model
        $diets = $this->dietsModel->getDietsId($args["diet_id"]);
        //*Step 4: Encode in json & put it in the response
        //$json_info = json_encode($diets);
        //*Step 5: Send the response with the Header & status code
        //$response = $response->getBody()->write($json_info);
        if ($diets == false) {
            throw new HttpInvalidInputsException(
                $request,
                "The ID provided does not exist in the database."
            );
        }
        return $this->renderJson(
            $response,
            $diets
        );
    }
}
