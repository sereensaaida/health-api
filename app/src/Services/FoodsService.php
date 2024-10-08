<?php

namespace App\Services;

use App\Models\FoodsModel;

class FoodsService
{
    public function __construct(private FoodsModel $food_model)
    {
        $this->food_model = $food_model;
    }

    public function createFood() : void
    {

    }

}
