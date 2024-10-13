<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\RecommendationsModel;
use Fig\Http\Message\StatusCodeInterface;
use App\Exceptions\HttpInvalidInputsException;
use App\Helpers\PaginationHelper;

class RecommendationsController extends BaseController
{
    public function __construct(private RecommendationsModel $recommendations_model) {}
    public function handleGetRecommendations(Request $request, Response $response): Response
    {
        // if (isset($filter_params["current_page"])) {
        //     $this->exercisesModel->setPaginationOptions(
        //         $filter_params["current_page"],
        //         $filter_params["page_size"]
        //     );
        // }
        $filter_params = $request->getQueryParams();
        if (isset($filter_params["current_page"])) {
            $this->recommendations_model->setPaginationOptions(
                $filter_params["current_page"],
                $filter_params["page_size"]
            );
        }
        $recommendations = $this->recommendations_model->getRecommendations($filter_params);
        return $this->renderJson($response, $recommendations);
    }

    public function handleGetRecommendationId(Request $request, Response $response, array $uri_args): Response
    {

        if (!isset($uri_args["recommendation_id"])) {
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

        $recommendation_id = $uri_args["recommendation_id"];
        $recommendation_id_pattern = '/^([0-9]*)$/';


        if (preg_match($recommendation_id_pattern, $recommendation_id) === 0) {
            throw new HttpInvalidInputsException(
                $request,
                "invalid recommendation id provided"
            );
        }
        $recommendation = $this->recommendations_model->getRecommendationsId($recommendation_id);
        return $this->renderJson($response, $recommendation);
    }

    //handle get recommendation by exercice id

}
