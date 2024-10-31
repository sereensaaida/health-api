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
    /**
     * ExerciseController constructor.
     *
     * @param ExercisesModel $exercisesModel Reference to the exercises model
     * @param ExerciseService $exerciseService Reference to the exercises service
     */
    public function __construct(private ExercisesModel $exercisesModel, private ExerciseService $exerciseService) //important to have the model as private
    {
        parent::__construct();
        $this->exercisesModel = $exercisesModel;
        $this->exerciseService = $exerciseService;
    }


    //*GET /exercises
    /**
     * Handler for getting the Exercise collection
     *
     * @param Request $request The user request
     * @param Response $response The generated response
     * @return Response Returning the response in JSON format
     */
    public function handleGetExercises(Request $request, Response $response): Response
    {
        //get the query parameters
        $filter_params = $request->getQueryParams();
        //: handle pagination validation
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
    //*GET /exercises/{exercise_id}
    /**
     * Handler for getting the exercise singleton resource
     *
     * @param Request $request The user request
     * @param Response $response The generated response
     * @param array $args the array containing the query from the URI
     * @return Response Returning the response in JSON format
     */
    public function handleGetExercisesById(Request $request, Response $response, array $args): Response
    {
        $exercise_id = $args["exercise_id"];
        //validate the id
        if (!$this->isIdValid(['id' => $exercise_id])) {
            throw new HttpInvalidInputsException($request, "Invalid exercise ID provided.");
        }
        //fetch the data from the model
        $data = $this->exercisesModel->getExercisesById($args["exercise_id"]);
        //validate if the id is not out of bounds
        if ($data == false) {
            throw new HttpInvalidInputsException(
                $request,
                "The ID provided does not exist in the database."
            );
        }
        return $this->renderJson($response, $data);
    }

    //*GET /exercise/{exercise_id}/recommendations
    /**
     * Handler for getting the exercise sub-collection of recommendations
     *
     * @param Request $request The user request
     * @param Response $response The generated response
     * @param array $args the array containing the query from the URI
     * @return Response Returning the response in JSON format
     */
    public function handleGetRecommendationsByExercise(Request $request, Response $response, array $args): Response
    {
        $exercise_id = $args["exercise_id"];
        //validate the id
        if (!$this->isIdValid(['id' => $exercise_id])) {
            throw new HttpInvalidInputsException($request, "Invalid exercise ID provided.");
        }
        //get data
        $data = $this->exercisesModel->getRecommendationsByExercise_id($args['exercise_id']);
        //validate if the id is not out of bounds
        if ($data["exercise"] == false) {
            throw new HttpInvalidInputsException(
                $request,
                "The ID provided does not exist in the database."
            );
        }
        //return data in renderjson
        return $this->renderJson($response, $data);
    }

    //*POST exercises
    /**
     * Handler for creating an exercise
     *
     * @param Request $request The user request
     * @param Response $response The generated response
     * @return Response Returning the response in JSON format
     */
    public function handleGetExercisesClass(Request $request, Response $response): Response
    {
        //echo "aye";
        // 1) Retrieve data included in the request (post body)
        $new_exercise = $request->getParsedBody();

        $result = $this->exerciseService->createExercise($new_exercise[0]);
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

    //*UPDATE exercises
    /**
     * Handler for updating an exercise
     *
     * @param Request $request The user request
     * @param Response $response The generated response
     * @return Response Returning the response in JSON format
     */
    public function handleUpdateExercises(Request $request, Response $response): Response
    {
        $update_exercise = $request->getParsedBody();

        var_dump($update_exercise[0]);

        $result = $this->exerciseService->updateExercise($update_exercise[0]);
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

    //*DELETE exercise
    /**
     * Handler for deleting an exercise
     *
     * @param Request $request The user request
     * @param Response $response The generated response
     * @return Response Returning the response in JSON format
     */
    public function deleteExercise(Request $request, Response $response): Response
    {
        //get the array from the JSON body
        $delete_exercise = $request->getParsedBody();

        $result = $this->exerciseService->deleteExercise($delete_exercise[0]);
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

        return $this->renderJson($response, $payload, $status_code);
    }
}
