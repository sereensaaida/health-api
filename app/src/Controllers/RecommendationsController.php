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

        $filter_params = $request->getQueryParams();
        if (isset($filter_params["current_page"])) {
            if ($this->isPagingParamsValid($filter_params)) {
                $this->recommendations_model->setPaginationOptions(
                    $filter_params["current_page"],
                    $filter_params["page_size"]
                );
            }
        }
        $recommendations = $this->recommendations_model->getRecommendations($filter_params);
        return $this->renderJson($response, $recommendations);
    }

    public function handleGetRecommendationId(Request $request, Response $response, array $uri_args): Response
    {
        $recommendation_id = $uri_args["recommendation_id"];
        if (!$this->isIdValid(['id' => $recommendation_id])) {
            throw new HttpInvalidInputsException($request, "Invalid recommendation ID provided.");
        }
        $recommendation = $this->recommendations_model->getRecommendationsId($recommendation_id);
        //check if the value exists in the db (out of bounds error handling)
        if ($recommendation == false) {
            throw new HttpInvalidInputsException(
                $request,
                "The recommendation ID provided does not exist in the database."
            );
        }
        return $this->renderJson($response, $recommendation);
    }

    //handle get recommendation by exercice id

}
