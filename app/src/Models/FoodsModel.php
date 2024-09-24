<?php

namespace App\Models;

use App\Core\PDOService;

class FoodsModel extends BaseModel
{
    public function __construct(PDOService $dbo)
    {
        parent::__construct($dbo);
    }

    public function getFoods(array $filter_params = []): array
    {
        $named_params_values = [];

        $sql = 'SELECT * from foods WHERE 1';

        if (isset($filter_params['category'])){
            $sql .= " AND category LIKE CONCAT(:category, '%') ";
            $named_params_values['category'] = $filter_params['category'];
        }

        // SERVING SIZE
        if (isset($filter_params['serving_size'])) {
            $sql .= " AND serving_size = CONCAT(:serving_size, '%') ";
            $named_params_values['serving_size'] = $filter_params['serving_size'];
        }

        //TODO CALORIES
        // if (isset($filter_params['min_calories'])) {
        //     $sql .= " AND calories BETWEEN CONCAT(:min_calories, '%') AND CONCAT(:max_calories, '%')";
        //     $named_params_values['category'] = $filter_params['category'];
        // }

        $foods = (array) $this->fetchAll($sql, $named_params_values);
        return $foods;
    }

}
