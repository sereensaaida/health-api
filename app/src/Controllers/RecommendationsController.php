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

    //*GET /recommendations
    public function handleGetRecommendations(Request $request, Response $response): Response
    {
        $filter_params = $request->getQueryParams();
        $current_page = $filter_params["current_page"] ?? 1;
        $page_size = $filter_params["page_size"] ?? 5;
        $value = [
            "current_page" => $current_page,
            "page_size" => $page_size
        ];
        if ($this->isPagingParamsValid($value)) {
            $this->recommendations_model->setPaginationOptions(
                $value["current_page"],
                $value["page_size"]
            );
        }
        $recommendations = $this->recommendations_model->getRecommendations($filter_params);
        return $this->renderJson($response, $recommendations);
    }

    //*GET /recommendations/{recommendation_id}
    public function handleGetRecommendationId(Request $request, Response $response, array $uri_args): Response
    {
        $recommendation_id = $uri_args["recommendation_id"];
        //validate the id
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
}
