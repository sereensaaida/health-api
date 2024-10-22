<?php

namespace App\Services;

use App\Models\FoodsModel;
use App\Core\Result;

class FoodsService
{
    public function __construct(private FoodsModel $food_model)
    {
        $this->food_model = $food_model;
    }

    public function createFood(array $new_food) : Result
    {
        //* Step 1) Using Validtron, validate the data
            // If its valid, INSERT into the database
            // If its not valid, send an error message

        //* Step 2) Insert into the database
        return Result::success("RANDOM");
    }

    protected static function isFoodValid($data): bool
    {
        $rules = array(
            'id' => [
                'required',
                'integer',
                ['min', 1]
            ],
            'name' => [
                'required',
                'alpha',
                ['min', 1],
                ['max', 100]
            ],
            'category' => [
                'alpha ',
                ['min', 1],
                ['max', 50]
            ],
            'calories' => [
                'integer',
                ['min', 1]
            ],
            'serving_size' => [
                'float',
            ],
            'content' => [
                'float',
            ],
            'avg_price' => [
                'decimal',
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
