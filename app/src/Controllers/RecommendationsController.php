<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\RecommendationsModel;

class RecommendationsController
{
    public function __construct(private RecommendationsModel $recommendations_model) {}
    public function handleGetRecommendations(Request $request, Response $response): Response
    {
        $json_payload = json_encode($this->recommendations_model->getRecommendations());
        $response->getBody()->write($json_payload);
        return $response->withHeader(
            "content-Type",
            "application/json"
        )->withStatus(201);
    }
}
