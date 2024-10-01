<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\GuidelinesModel;
use Fig\Http\Message\StatusCodeInterface;
use App\Exceptions\HttpInvalidInputsException;
use App\Helpers\PaginationHelper;

class GuidelinesController extends BaseController
{
    public function __construct(private GuidelinesModel $guidelines_model) {}
    public function handleGetGuidelines(Request $request, Response $response): Response
    {
        $filter_params = $request->getQueryParams();
        $guidelines = $this->guidelines_model->getGuidelines($filter_params);
        return $this->renderJson($response, $guidelines);
    }

    public function handleGetGuidelinesId(Request $request, Response $response, array $uri_args): Response
    {

        if (!isset($uri_args["guideline_id"])) {
            return $this->renderJson(
                $response,
                [
                    "status" => "error",
                    "code" => "400",
                    "message" => "The supplied guideline Id is not found"
                ],
                StatusCodeInterface::STATUS_BAD_REQUEST
            );
        }

        $guideline_id = $uri_args["guideline_id"];
        $guideline_id_pattern = '/^([0-9]*)$/';


        if (preg_match($guideline_id_pattern, $guideline_id) === 0) {
            throw new HttpInvalidInputsException(
                $request,
                "invalid recommendation id provided"
            );
        }
        $guideline = $this->guidelines_model->getGuidelinesId($guideline_id);
        return $this->renderJson($response, $guideline);
    }
}
