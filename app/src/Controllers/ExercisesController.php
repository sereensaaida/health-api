<?php

namespace App\Controllers;

use App\Models\ExercisesModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ExercisesController extends BaseController
{
    //*Step 1) get the model class constructor
    public function __construct(private ExercisesModel $exercisesModel) //important to have the model as private
    {
        parent::__construct();
    }

    //*Step 2) method to handle the data
    public function handleGetExercises(Request $request, Response $response): Response
    {
        //get the query parameters
        $filter_params = $request->getQueryParams();
        //TODO: handle validation

        //get data & encode the data into json format
        $exercisesData = $this->exercisesModel->getExercices();
        return $this->renderJson($response, $exercisesData);
    }
    //* Handle fetch by id
    public function handleGetExercisesById(Request $request, Response $response, array $args): Response
    {
        // fetch the query params
        $filter_params = $request->getQueryParams();
        //TODO: validate the filters

        //fetch the data from the model
        $data = $this->exercisesModel->getExercisesById($args["exercise_id"]);
        //json encode
        return $this->renderJson($response, $data);
    }
}
