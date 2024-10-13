<?php

namespace App\Controllers;

use App\Models\ExercisesModel;
use App\Services\ExerciseService;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Fig\Http\Message\StatusCodeInterface;
use App\Exceptions\HttpInvalidInputsException;

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
        // $recommendation_id = $uri_args["recommendation_id"];

        // if (!isset($recommendation_id)) {
        //     return $this->renderJson(
        //         $response,
        //         [
        //             "status" => "error",
        //             "code" => "400",
        //             "message" => "The supplied recommendation Id is not found"
        //         ],
        //         StatusCodeInterface::STATUS_BAD_REQUEST
        //     );
        // }

        // $recommendation_id_pattern = '/^([0-9]*)$/';


        // if (preg_match($recommendation_id_pattern, $recommendation_id) === 0) {
        //     throw new HttpInvalidInputsException(
        //         $request,
        //         "invalid recommendation id provided"
        //     );
        // }
        // $recommendation = $this->recommendations_model->getRecommendationsId($recommendation_id);
        // //check if the value exists in the db (out of bounds error handling)
        // if ($recommendation == false) {
        //     throw new HttpInvalidInputsException(
        //         $request,
        //         "The recommendation ID provided does not exist in the database."
        //     );
        // }
        //get the query parameters
        $filter_params = $request->getQueryParams();
        //TODO: handle validation
        if (!isset($exercise_id)) {
            return $this->renderJson(
                $response,
                [
                    "status" => "error",
                    "code" => "400",
                    "message" => "The supplied recommendation Id is not found"
                ],
                StatusCodeInterface::STATUS_BAD_REQUEST
            );
        }
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
        $exercise_id = $args["exercise_id"];
        //TODO: validate the filters
        if (!isset($exercise_id)) {
            return $this->renderJson(
                $response,
                [
                    "status" => "error",
                    "code" => "400",
                    "message" => "The supplied Id is not found"
                ],
                StatusCodeInterface::STATUS_BAD_REQUEST
            );
        }
        $exercise_id_pattern = '/^([0-9]*)$/';


        if (preg_match($exercise_id_pattern, $exercise_id) === 0) {
            throw new HttpInvalidInputsException(
                $request,
                "invalid id provided"
            );
        }
        //fetch the data from the model
        $data = $this->exercisesModel->getExercisesById($args["exercise_id"]);
        //json encode
        if ($data == false) {
            throw new HttpInvalidInputsException(
                $request,
                "The ID provided does not exist in the database."
            );
        }
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
