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
        //* Step 1) Using Valitron, validate the data
            // If its valid, INSERT into the database
            // If its not valid, send an error message

        //* Step 2) Insert into the database
        return Result::success("RANDOM");
    }

}
