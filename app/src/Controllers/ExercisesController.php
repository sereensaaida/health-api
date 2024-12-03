<?php

namespace App\Controllers;

use App\Models\ExercisesModel;
use App\Services\ExerciseService;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Fig\Http\Message\StatusCodeInterface;
use App\Exceptions\HttpInvalidInputsException;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpSpecializedException;
use GuzzleHttp\Client;

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
        var_dump($new_exercise);
        $result = $this->exerciseService->createExercise($new_exercise[0]); //there is an issue because i had [0] before
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

        $exercise = $this->exercisesModel->getExercisesById($update_exercise["exercise_id"]);
        if ($exercise === false) {
            throw new HttpNotFoundException(
                $request,
                "No matching exercise found"
            );
        }
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

        $exercise = $this->exercisesModel->getExercisesById($delete_exercise[0]["exercise_id"]);
        if ($exercise === false) {
            throw new HttpNotFoundException(
                $request,
                "No matching exercise found"
            );
        }

        $result = $this->exerciseService->deleteExercise($delete_exercise); //there is an issue because i had [0] before
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

    //handle log
    public function handleLog(Request $request, Response $response): Response
    {
        //get the information from the server
        $ip_address = $_SERVER["REMOTE_ADDR"];
        //by default, the date and time is added to the message
        $resource_uri = $_SERVER["REQUEST_URI"];
        $request_method = $_SERVER["REQUEST_METHOD"];
        $queryString = $request->getUri()->getQuery();
        $log_message = "\nTest message" . "\nClient IP address: " . $ip_address . "\nResource uri: " . $resource_uri . "\nRequest method: " . $request_method . "\Query strings: " . $queryString;

        //call the

        return $response;
    }

    public function handleComposite(Request $request, Response $response, array $uri_args): Response
    {

        $exercise_id = $uri_args['exercise_id'];
        $exercise_db = $this->exercisesModel->getExercisesById($exercise_id);
        //var_dump($exercise_db);
        $exercise_type = $exercise_db["exercise_type"];
        // var_dump($exercise_type);
        //API call
        // Api key:
        //$api_url = "https://api.api-ninjas.com/v1/nutrition?type={$exercise_type}";
        //dd($api_url);
        $api_key =  "xPGnQwQ8Xr3NNAKUemA1hhxD7VDBNfFQJXVMvMV1";
        $client = new Client([
            'base_uri' => 'https://api.api-ninjas.com/v1/',
        ]);
        $response = $client->request('GET', "exercises?type={$exercise_type}", [
            'headers' => [
                'X-Api-Key' => 'xPGnQwQ8Xr3NNAKUemA1hhxD7VDBNfFQJXVMvMV1',
                'Accept' => 'application/json'
            ]
        ]);

        // Get the content -> Get the body from the response
        $body = $response->getBody();
        //var_dump($body);
        // Then get contents from the body
        $response_payload = $body->getContents();
        //log($response_payload);
        // Catch it into a variable $response_payload (its as a string so we need to decode it into json representation)

        // Decode it and convert it into JSON(array or object)
        $exercise_info = json_decode($response_payload);
        //$exercise_info = $exercise_info;

        // Parse the data (list of leagues)
        // Inspect everything -> Its an object with an array of objects
        // Iterate through every row of data
        $api_exercise = [];
        // var_dump($exercise_info);
        foreach ($exercise_info as $exercise) {
            //var_dump($exercise);
            $data = [
                'name' => $exercise->name,
                'type' => $exercise->type,
                'muscle' => $exercise->muscle,
                'equipment' => $exercise->equipment,
                'difficulty' => $exercise->difficulty,
                'instructions' => $exercise->instructions,
            ];
            // var_dump($data);
            // exit;
            $api_exercise = array_merge($api_exercise, $data);
            // var_dump($api_exercise);
            // $api_exercise += $data;
        }
        //var_dump($api_exercise);
        // $api_exercise = array(
        //     'name' => $exercise_info->name,
        //     'type' => $exercise_info->type,
        //     'muscle' => $exercise_info->muscle,
        //     'equipment' => $exercise_info->equipment,
        //     'difficulty' => $exercise_info->difficulty,
        //     'instructions' => $exercise_info->instructions,
        // );
        var_dump($api_exercise);
        return $response;
    }
}
