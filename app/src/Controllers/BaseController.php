<?php

//declare(strict_types=1);

namespace App\Controllers;

use App\Validation\Validator;
use Psr\Http\Message\ResponseInterface as Response;

abstract class BaseController
{

    public function __construct() {}

    protected function renderJson(Response $response, array $data, int $status_code = 200): Response
    {
        // var_dump($data);
        $payload = json_encode($data, JSON_UNESCAPED_SLASHES |    JSON_PARTIAL_OUTPUT_ON_ERROR);
        //-- Write JSON data into the response's body.
        $response->getBody()->write($payload);

        return $response->withStatus($status_code)->withAddedHeader(HEADERS_CONTENT_TYPE, APP_MEDIA_TYPE_JSON);
    }

    protected static function isPagingParamsValid($data): bool
    {
        // An array element can be associated with one or more validation rules.
        // Validation rules must be wrapped in an associative array where:
        // NOTE:
        //     key => must be an existing key  in the data array to be validated.
        //     value => array of one or more rules.
        $rules = array(
            'current_page' => [
                'required',
                'integer',
                ['min', 1]
            ],
            'page_size' => [
                'required',
                'integer',
                ['min', 1],
                ['max', 10]
            ]
        );
        // Create a validator and override the default language used in expressing the error messages.
        $validator = new Validator($data, [], 'en');
        // Important: map the validation rules before calling validate()
        $validator->mapFieldsRules($rules);
        // if ($validator->validate()) {
        //     return false;
        // }
        return $validator->validate();
    }

    protected static function isIdValid($data): bool
    {
        $rules = array(
            'id' => [
                'required',
                'integer',
                ['min', 1]
            ]
        );

        $validator = new Validator($data, [], 'en');
        $validator->mapFieldsRules($rules);
        return $validator->validate();
    }

    protected static function isExerciseValid($data): bool
    {
        $rules = array(
            'exercise_id' => [],
            'name' => [
                'required',
                'string',
                // ['min', 1] //check if i can have minimum character
            ],
            'exercise_type' => [
                'string',
                // ['min', 1]
                // ['max',1]
            ],
            'calories' => [
                'float',
                // ['min', 1]
            ],
            'equipment' => [
                'string',
                // ['min', 1]
            ],
            'difficulty' => [
                'int',
                ['min', 1],
                ['max', 4]
            ],
            'muscle' => [
                'int',
                ['min', 1],
                ['max', 4]
            ],
        );
    }

    protected static function isCountryDataValid($data): bool
    {
        $rules = array(
            'country_id' => [
                'required',
                'integer',
                ['min', 1]

            ],
            'population' => [
                'required',
                'integer'
            ],
            'vegetarian_percentage' => [
                'required',
                'integer'
            ],
            'daily_calorie_intake' => [
                'required',
                'integer'
            ],
            'consumed_dishes' => [
                'required',
                'string'
            ],
            'food_culture' => [
                'required',
                'string'
            ],
            'nutritional_deficiency' => [
                'required',
                'string',
                ['min', 1]
            ],


        );

        $validator = new Validator($data, [], 'en');
        $validator->mapFieldsRules($rules);
        return $validator->validate();
    }
}
