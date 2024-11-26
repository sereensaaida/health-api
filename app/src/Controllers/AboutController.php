<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\AppSettings;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AboutController extends BaseController
{
    private const API_NAME = 'HEALTH-API';

    private const API_VERSION = '1.0.0';

    public function handleAboutWebService(Request $request, Response $response): Response
    {
        $data = array(
            'api' => self::API_NAME,
            'version' => self::API_VERSION,
            'about' => 'Welcome to our health API! This is a Web service that provides information concerning guidelines to achieve a healthier lifestyle!',
            'authors' => 'Sereen Saaida, Michaella Nsumanyi, Damiano Miloncini',
            'resources' => [
                [
                    "name" => "Countries",
                    "uri" => "/countries",
                    "description" => "Retrieves a list of all countries."
                ],
                [
                    "name" => "Diets",
                    "uri" => "/diets",
                    "description" => "Retrieves a list of all diets."
                ],
                [
                    "name" => "Exercise",
                    "uri" => "/exercises",
                    "description" => "Retrieves a list of all exercises."
                ],
                [
                    "name" => "Guidelines",
                    "uri" => "/guidelines",
                    "description" => "Retrieves a list of all guidelines."
                ],
                [
                    "name" => "Facts",
                    "uri" => "/facts",
                    "description" => "Retrieves a list of all facts."
                ],
                [
                    "name" => "Foods",
                    "uri" => "/foods",
                    "description" => "Retrieves a list of all foods."
                ],
                [
                    "name" => "recommendations",
                    "uri" => "/recommendations",
                    "description" => "Retrieves a list of all recommendations."
                ],

            ]
        );

        return $this->renderJson($response, $data);
    }
}
