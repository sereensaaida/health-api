<?php

declare(strict_types=1);

use App\Controllers\AboutController;
use App\Controllers\DietsController;
use App\Controllers\FoodsController;
use App\Controllers\AccountController;
use App\Controllers\BMIController;
use App\Controllers\CountriesController;
use App\Controllers\ExercisesController;
use App\Controllers\GuidelinesController;
use App\Controllers\FactsController;
use App\Controllers\RecommendationsController;
use App\Helpers\DateTimeHelper;
use App\Middleware\AuthMiddleware;
use App\Services\BMICalculator;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Middleware\RoutingMiddleware;
use Slim\Routing\RouteCollectorProxy;
use App\Controllers\BMRController;
use App\Controllers\BFPController;


return static function (Slim\App $app): void {

    // Routes without authentication check: /login, /token
    $app->post('/login', [AccountController::class, 'handleUserLogin']);
    $app->post('/register', [AccountController::class, 'handleRegistration']);

    //* PING ROUTES
    $app->get('/ping', function (Request $request, Response $response, $args) {

        $payload = [
            "greetings" => "Reporting! Hello there!",
            "now" => DateTimeHelper::now(DateTimeHelper::Y_M_D_H_M),
        ];
        $response->getBody()->write(json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_PARTIAL_OUTPUT_ON_ERROR));
        return $response;
    });

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

    //* FOODS ROUTES
    //GET
    $app->get('/foods', [FoodsController::class, 'handleGetFoods']);
    $app->get('/foods/{food_id}', [FoodsController::class, 'handleGetFoodId']);
    $app->get('/foods/{food_id}/facts', [FoodsController::class, 'handleGetFoodFacts']);
    $app->get('/foods/{food_id}/composite_nutrition', [FoodsController::class, 'handleGetCompositeNutrition']);

    //* FACTS ROUTES
    // GET
    $app->get('/facts', [FactsController::class, 'handleGetFacts']);
    $app->get('/facts/{fact_id}', [FactsController::class, 'handleGetFactsId']);

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
    $app->get('/countries/{country_id}/compositeCountry', [CountriesController::class, 'handleCompositeCountry']);




    $app->group('admin', function (RouteCollectorProxy $group) {
        //POST
        $group->post('/exercises', [ExercisesController::class, 'handleGetExercisesClass']);
        //UPDATE
        $group->put('/exercises', [ExercisesController::class, 'handleUpdateExercises']);
        //DELETE
        $group->delete('/exercises', [ExercisesController::class, 'deleteExercise']);

        // POST
        $group->post('/foods', [FoodsController::class, 'handleCreateFood']);
        $group->post('/foods/calculate', [FoodsController::class, 'handleFoodComputation']);
        //PUT
        $group->put('/foods', [FoodsController::class, 'handleUpdateFood']);
        //DELETE
        $group->delete('/foods', [FoodsController::class, 'handleDeleteFood']);
        //POST
        $group->post('/countries', [CountriesController::class, 'handleCreateCountry']);
        //PUT
        $group->put('/countries', [CountriesController::class, 'handleUpdateCountry']);
        //DELETE
        $group->delete('/countries', [CountriesController::class, 'handleDeleteCountry']);
        // Log in route



        //*BFP CALCULATOR
        $group->post("/bfp", [BFPController::class, 'calculateBFP']);

        //*BMI CALCULATOR
        $group->post("/bmi", [BMIController::class, 'calculateBMI']);

        //* BMR CALCULATOR
        $group->post("/bmr", [BMRController::class, 'calculateBMR']);
    })->add(AuthMiddleware::class);
};
