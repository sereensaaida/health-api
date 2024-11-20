<?php

declare(strict_types=1);

use App\Controllers\AboutController;
use App\Controllers\DietsController;
use App\Controllers\FoodsController;
use App\Controllers\AccountController;
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


    // get /
    $app->get('/', [AboutController::class, 'handleAboutWebService']);

    //* DIET ROUTES
    //GET
    $app->get('/diets', [DietsController::class, 'handleGetDiets']);
    $app->get('/diets/{diet_id}', [DietsController::class, 'handleGetDietsId']);

    //* EXERCISE ROUTES
    //GET
    $app->get('/exercises', [ExercisesController::class, 'handleGetExercises']);
    $app->get('/exercises/{exercise_id}', [ExercisesController::class, 'handleGetExercisesById']);
    $app->get('/exercises/{exercise_id}/recommendations', [ExercisesController::class, 'handleGetRecommendationsByExercise']);
    //POST
    $app->post('/exercises', [ExercisesController::class, 'handleGetExercisesClass']);
    //UPDATE
    $app->put('/exercises', [ExercisesController::class, 'handleUpdateExercises']);
    //DELETE
    $app->delete('/exercises', [ExercisesController::class, 'deleteExercise']);

    //* FOODS ROUTES
    //GET
    $app->get('/foods', [FoodsController::class, 'handleGetFoods']);
    $app->get('/foods/{food_id}', [FoodsController::class, 'handleGetFoodId']);
    $app->get('/foods/{food_id}/facts', [FoodsController::class, 'handleGetFoodFacts']);
    // POST
    $app->post('/foods', [FoodsController::class, 'handleCreateFood']);
    //PUT
    $app->put('/foods', [FoodsController::class, 'handleUpdateFood']);
    //DELETE
    $app->delete('/foods', [FoodsController::class, 'handleDeleteFood']);

    //* FACTS ROUTES
    // GET
    $app->get('/facts', [FactsController::class, 'handleGetfacts']);
    $app->get('/facts/{fact_id}', [FactsController::class, 'handleGetFactsId']);



    //* PING ROUTES
    $app->get('/ping', function (Request $request, Response $response, $args) {

        $payload = [
            "greetings" => "Reporting! Hello there!",
            "now" => DateTimeHelper::now(DateTimeHelper::Y_M_D_H_M),
        ];
        $response->getBody()->write(json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_PARTIAL_OUTPUT_ON_ERROR));
        return $response;
    });

    //* RECOMMENDATIONS ROUTES
    //GET
    $app->get('/recommendations', [RecommendationsController::class, 'handleGetRecommendations']);
    $app->get('/recommendations/{recommendation_id}', [RecommendationsController::class, 'handleGetRecommendationId']);

    //* GUIDELINES ROUTES
    //GET
    $app->get('/guidelines', [GuidelinesController::class, 'handleGetGuidelines']);
    $app->get('/guidelines/{guideline_id}', [GuidelinesController::class, 'handleGetGuidelineId']);

    //* COUNTRIES ROUTES
    //GET
    $app->get('/countries', [CountriesController::class, 'handleGetCountries']);
    $app->get('/countries/{country_id}', [CountriesController::class, 'handleGetCountryId']);
    $app->get('/countries/{country_id}/guidelines', [CountriesController::class, 'handleGetCountryGuidelines']);
    //POST
    $app->post('/countries', [CountriesController::class, 'handleCreateCountry']);
    //PUT
    $app->put('/countries', [CountriesController::class, 'handleUpdateCountry']);
    //DELETE
    $app->delete('/countries', [CountriesController::class, 'handleDeleteCountry']);

    // Log in route
    $app->post('/login', [AccountController::class, 'handleUserLogin']);
};
