<?php

namespace App\Services;

use App\Models\FoodsModel;
use App\Validation\Validator;
use App\Core\Result;

class FoodsService
{
    public function __construct(private FoodsModel $food_model)
    {
        $this->food_model = $food_model;
    }

    public function createFood(array $new_food): Result
    {
        //* Step 1) Using Valitron, validate the data
        $rules = array(
            'food_id' => [
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

        //* Step 2) Insert into the database
        $validator = new Validator($new_food, [], 'en');

        // Fix this:
        //$validator->mapFieldsRules($rules);

        if ($validator->validate()) {
            $this->food_model->insertFood($new_food);
            return Result::success("Food has been inserted!");
        } else {
            return Result::fail("Data not valid.");
        }
    }

    public function updateFood(array $food_info): Result
    {
        //* Step 2) Insert into the database
        $validator = new Validator($food_info, [], 'en');

        // Fix this:
        //$validator->mapFieldsRules($rules);

        if ($validator->validate()) {
            $this->food_model->updateFood($food_info);
            return Result::success("Food has been updated.");
        } else {
            return Result::fail("Data not valid.");
        }
    }

    public function deleteFood(array $food_info): Result
    {


        //* Step 2) Insert into the database
        $validator = new Validator($food_info, [], 'en');

        // Fix this:
        //$validator->mapFieldsRules($rules);

        if ($validator->validate()) {
            $this->food_model->deleteFood($food_info);
            return Result::success("Food has been deleted.");
        } else {
            return Result::fail("Data not valid.");
        }
    }


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
}
