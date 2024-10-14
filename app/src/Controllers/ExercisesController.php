<?php

namespace App\Controllers;

use App\Models\ExercisesModel;
use App\Services\ExerciseService;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ExercisesController extends BaseController
{
    //*Step 1) get the model class constructor
    public function __construct(private ExercisesModel $exercisesModel, private ExerciseService $exerciseService) //important to have the model as private
    {
        parent::__construct();
        $this->exerciseService = $exerciseService;
    }

    //*Step 2) method to handle the data
    public function handleGetExercises(Request $request, Response $response): Response
    {
        //get the query parameters
        $filter_params = $request->getQueryParams();
        //TODO: handle validation
        if (isset($filter_params["current_page"])) {
            if ($this->isPagingParamsValid($filter_params)) {
                $this->exercisesModel->setPaginationOptions(
                    $filter_params["current_page"],
                    $filter_params["page_size"]
                );
            }
        }
        //get data & encode the data into json format
        $exercisesData = $this->exercisesModel->getExercises($filter_params);
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

    public function handleGetRecommendationsByExercise(Request $request, Response $response, array $args): Response
    {
        //get the filter params

        //validate the filter params

        //validate pagination

        //get data
        var_dump($args);
        $data = $this->exercisesModel->getRecommendationsByExercise_id($args['exercise_id']);
        //return data in renderjson
        return $this->renderJson($response, $data);
    }

    //*POST exercises
    public function handleGetExercisesClass(Request $request, Response $response): Response
    {
        //echo "aye";
        // 1) Retrieve data included in the request (post body)
        $new_exercise = $request->getParsedBody();
        var_dump($new_exercise);
        $result = $this->exerciseService->createExercise($new_exercise);
        $payload = [];
        $status_code = 201;

        if ($result->isSuccess()) {
            $payload["success"] = true;
        } else {
            $status_code = 400;
            $payload["success"] = false;
        }
        $payload["message"] = $result->getMessage();
        $payload["errors"] = $result->getData();
        $payload["status"] = $status_code;
        //pass the received data to the service
        return $this->renderJson($response, $payload, $status_code);
    }
}
