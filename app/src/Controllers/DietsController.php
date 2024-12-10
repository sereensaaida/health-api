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

    //*GET /diets
    public function handleGetDiets(Request $request, Response $response)
    {
        //*Retrieve filtering
        $filter_params = $request->getQueryParams();
        $current_page = $filter_params["current_page"] ?? 1;
        $page_size = $filter_params["page_size"] ?? 5;
        $value = [
            "current_page" => $current_page,
            "page_size" => $page_size
        ];
        if ($this->isPagingParamsValid($value)) {
            $this->dietsModel->setPaginationOptions(
                $value["current_page"],
                $value["page_size"]
            );
        }
        $diets = $this->dietsModel->getDiets($filter_params);

        return $this->renderJson($response, $diets);
    }

    //handle get diets by id (expecting an arg from request)
    //*GET /diets/{diet_id}
    public function handleGetDietsId(Request $request, Response $response, array $args)
    {
        //*Step 1: Validate that the user has sent the right argument
        $diet_id = $args["diet_id"];
        //*Step 2: Error handling
        //validate the id
        if (!$this->isIdValid(['id' => $diet_id])) {
            throw new HttpInvalidInputsException($request, "Invalid diet ID provided.");
        }
        //*Step 3: Call the db from the model
        $diets = $this->dietsModel->getDietsId($args["diet_id"]);
        //validate if the id is not out of bounds
        if ($diets == false) {
            throw new HttpInvalidInputsException(
                $request,
                "The ID provided does not exist in the database."
            );
        }
        //*Step 5: Send the response with the Header & status code
        return $this->renderJson(
            $response,
            $diets
        );
    }
}
