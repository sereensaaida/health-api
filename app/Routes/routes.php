<?php

declare(strict_types=1);

use App\Controllers\AboutController;
use App\Controllers\DietsController;
use App\Controllers\FoodsController;
use App\Controllers\CountriesController;
use App\Controllers\ExercisesController;
use App\Controllers\GuidelinesController;
use App\Controllers\FactsController;
use App\Controllers\RecommendationsController;
use App\Helpers\DateTimeHelper;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return static function (Slim\App $app): void {

    // Routes without authentication check: /login, /token

    // Routes with authentication
    //* ROUTE: GET /
    $app->get('/', [AboutController::class, 'handleAboutWebService']);
    //*get /diets
    $app->get('/diets', [DietsController::class, 'handleGetDiets']);
    //*get /diets/{diets_id}
    $app->get('/diets/{diet_id}', [DietsController::class, 'handleGetDietsId']);
    //*get /exercises
    $app->get('/exercises', [ExercisesController::class, 'handleGetExercises']);
    //*get /exercises/{exercise_id}
    $app->get('/exercises/{exercise_id}', [ExercisesController::class, 'handleGetExercisesById']);
    // $app->get('/test', [TestController::class, 'handleTest']);
    //*get /recommendation/{recommendation_id}/exercise
    $app->get('/exercises/{exercise_id}/recommendations', [ExercisesController::class, 'handleGetRecommendationsByExercise']);
    //*post /exercises
    $app->post('/exercises', [ExercisesController::class, 'handleGetExercisesClass']);
    // Foods route
    $app->get('/foods', [FoodsController::class, 'handleGetFoods']);
    $app->get('/foods/{food_id}', [FoodsController::class, 'handleGetFoodId']);
    $app->get('/foods/{food_id}/facts', [FoodsController::class, 'handleGetFoodFacts']);

    // Facts route
    $app->get('/facts', [FactsController::class, 'handleGetfacts']);
    $app->get('/facts/{fact_id}', [FactsController::class, 'handleGetFactsId']);

    // $app->get('/test', [TestController::class, 'handleTest']);

    //* ROUTE: GET /ping
    $app->get('/ping', function (Request $request, Response $response, $args) {

        $payload = [
            "greetings" => "Reporting! Hello there!",
            "now" => DateTimeHelper::now(DateTimeHelper::Y_M_D_H_M),
        ];
        $response->getBody()->write(json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_PARTIAL_OUTPUT_ON_ERROR));
        return $response;
    });

    //RECOMMENDATIONS RESSOURCE
    //* ROUTE: GET /recommendations
    $app->get('/recommendations', [RecommendationsController::class, 'handleGetRecommendations']);
    //*ROUTE: GET /recommendations/{recommendation_id}
    $app->get('/recommendations/{recommendation_id}', [RecommendationsController::class, 'handleGetRecommendationId']);

    //Guidelines Ressource
    $app->get('/guidelines', [GuidelinesController::class, 'handleGetGuidelines']);
    //*ROUTE: GET /recommendations/{recommendation_id}
    $app->get('/guidelines/{guideline_id}', [GuidelinesController::class, 'handleGetGuidelineId']);

    //COUNTRIES RESSOURCE
    //* ROUTE: GET /countries
    $app->get('/countries', [CountriesController::class, 'handleGetCountries']);
    $app->get('/countries/{country_id}', [CountriesController::class, 'handleGetCountryId']);
    $app->get('/countries/{country_id}/guidelines', [CountriesController::class, 'handleGetCountryGuidelines']);
    $app->post('/countries', [CountriesController::class, 'handleCreateCountry']);
};
