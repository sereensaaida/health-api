<?php

namespace App\Services;

use App\Models\FoodsModel;
use App\Validation\Validator;
use App\Core\Result;

/**
 * Class FoodsService
 *
 * This service class handles validation for the Foods table using Valitron libraries
 */

class FoodsService
{
    /**
     * Constructor for FoodsService class
     *
     * @param FoodsModel $food_model Instance of the FoodModel class
     */
    public function __construct(private FoodsModel $food_model)
    {
        $this->food_model = $food_model;
    }

    /**
     * Service for creating a new food
     *
     * @param array $new_food The array of food information from the request body
     * @return Result Returning the result in JSON format and calling the appropriate model method
     */
    public function createFood(array $new_food): Result
    {
        //* Step 1) Using Valitron, validate the data
        $data = array(
            "name" => $new_food['name'],
            "category" => $new_food['category'],
            "calories" => $new_food['calories'],
            "serving_size" => $new_food['serving_size'],
            "content" => $new_food['content'],
            "avg_price" => $new_food["avg_price"],
            "is_vegan" => $new_food['is_vegan'],
        );

        $rules = array(
            'food_id' => [
                'integer',
                ['min', 1]
            ],
            'name' => array(
                'required',
                array('lengthMin', 4)
            ),
            'category' => array(
                'required',
                array('lengthMin', 4)
            ),
            'calories' => [
                'integer',
                ['min', 1]
            ],
            'serving_size' => [
                'integer',
            ],
            'content' => [
                'integer',
            ],
            'avg_price' => [
                'integer',
            ],
            'is_vegan' => [
                'integer',
                ['min', 1],
                ['max', 1]
            ],
        );

        //* Step 2) Insert into the database
        $validator = new Validator($data, [], 'en');

        // Fix this:
        $validator->mapFieldsRules($rules);

        if ($validator->validate()) {
            $this->food_model->insertFood($new_food);
            return Result::success("Food has been inserted!");
        } else {
            return Result::fail("Data not valid.");
        }
    }

    /**
     * Service for updating food
     *
     * @param array $food_info The array of food information from the request body
     * @return Result Returning the result in JSON format and calling the appropriate model method
     */
    public function updateFood(array $food_info): Result
    {
        $data = array(
            "food_id" => $food_info['food_id'],
            "name" => $food_info['name'],
            "category" => $food_info['category'],
            "calories" => $food_info['calories'],
            "serving_size" => $food_info['serving_size'],
            "content" => $food_info['content'],
            "avg_price" => $food_info["avg_price"],
            "is_vegan" => $food_info['is_vegan'],
        );

        $rules = array(
            'food_id' => [
                'integer',
                ['min', 1]
            ],
            'name' => array(
                'required',
                array('lengthMin', 4)
            ),
            'category' => array(
                'required',
                array('lengthMin', 4)
            ),
            'calories' => [
                'integer',
                ['min', 1]
            ],
            'serving_size' => [
                'integer',
            ],
            'content' => [
                'integer',
            ],
            'avg_price' => [
                'integer',
            ],
            'is_vegan' => [
                'integer',
                ['min', 1],
                ['max', 1]
            ],
        );

        //* Step 2) Insert into the database
        $validator = new Validator($data, [], 'en');

        // Fix this:
        $validator->mapFieldsRules($rules);

        if ($validator->validate()) {
            $this->food_model->updateFood($food_info);
            return Result::success("Food has been updated.");
        } else {
            return Result::fail("Data not valid.");
        }
    }

    /**
     * Service for deleting food
     *
     * @param array $food_info The array of food information from the request body
     * @return Result Returning the result in JSON format and calling the appropriate model method
     */
    public function deleteFood(array $food_info): Result
    {
        $data = array(
            "food_id" => $food_info['food_id'],
        );

        $rules = array(
            'food_id' => [
                'integer',
                ['min', 1]
            ],
        );

        //* Step 2) Insert into the database
        $validator = new Validator($data, [], 'en');

        // Fix this:
        $validator->mapFieldsRules($rules);

        if ($validator->validate()) {
            $this->food_model->deleteFood($food_info);
            return Result::success("Food has been deleted.");
        } else {
            return Result::fail("Data not valid.");
        }
    }

    /*
    public function isFoodValid($data): bool
    {
        $rules = array(
            'id' => [
                'required',
                'integer',
                ['min', 1]
            ],
            'name' => [
                'alpha',
                ['min', 1],
                ['max', 100]
            ],
            'category' => [
                'alpha',
                ['min', 1],
                ['max', 50]
            ],
            'calories' => [
                'integer',
                ['min', 1]
            ],
            'serving_size' => [
                'integer',
            ],
            'content' => [
                'integer',
            ],
            'avg_price' => [
                'integer',
            ],
            'is_vegan' => [
                'integer',
                ['min', 1],
                ['max', 1]
            ],
        );

        $validator = new Validator($data, [], 'en');
        $validator->mapFieldsRules($rules);
        return $validator->validate();
    }
    */
}
