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

        // CATEGORY
        if (isset($filter_params['category'])) {
            $sql .= " AND category LIKE CONCAT(:category, '%') ";
            $named_params_values['category'] = $filter_params['category'];
        }

        // SERVING SIZE
        if (isset($filter_params['serving_size'])) {
            $sql .= " AND serving_size = CONCAT(:serving_size, '%') ";
            $named_params_values['serving_size'] = $filter_params['serving_size'];
        }

        // CALORIES

        //TODO Check that minimum is smaller than maximum
        // Minimum
        if (isset($filter_params['minimum_calories'])) {
            $sql .= " AND calories >= CONCAT(:minimum_calories)";
            $named_params_values['minimum_calories'] = $filter_params['minimum_calories'];
        }

        // Maximum
        if (isset($filter_params['maximum_calories'])) {
            $sql .= " AND calories <= CONCAT(:maximum_calories)";
            $named_params_values['maximum_calories'] = $filter_params['maximum_calories'];
        }

        // CONTENT SIZE
        //TODO Check that minimum is smaller than maximum
        // Minimum
        if (isset($filter_params['minimum_content'])) {
            $sql .= " AND content >= CONCAT(:minimum_content)";
            $named_params_values['minimum_content'] = $filter_params['minimum_content'];
        }

        // Maximum
        if (isset($filter_params['maximum_content'])) {
            $sql .= " AND content <= CONCAT(:maximum_content)";
            $named_params_values['maximum_content'] = $filter_params['maximum_content'];
        }

        $foods = (array) $this->fetchAll($sql, $named_params_values);
        return $foods;
    }
}
