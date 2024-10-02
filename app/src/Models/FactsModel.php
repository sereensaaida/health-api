<?php

namespace App\Models;

use App\Core\PDOService;

class FactsModel extends BaseModel
{
    public function __construct(PDOService $dbo)
    {
        parent::__construct($dbo);
    }

    public function getFacts(array $filter_params = []): array
    {
        $named_params_values = [];

        $sql = 'SELECT * from facts WHERE 1';

        // Filtering:

        // PROTEIN
        // Minimum
        if (isset($filter_params['minimum_protein'])) {
            $sql .= " AND protein >= CONCAT(:minimum_protein)";
            $named_params_values['minimum_protein'] = $filter_params['minimum_protein'];
        }

        // Maximum
        if (isset($filter_params['maximum_protein'])) {
            $sql .= " AND protein <= CONCAT(:maximum_protein)";
            $named_params_values['maximum_protein'] = $filter_params['maximum_protein'];
        }

        // CARBS
        // Minimum
        if (isset($filter_params['minimum_carbs'])) {
            $sql .= " AND carbohydrates >= CONCAT(:minimum_carbs)";
            $named_params_values['minimum_carbs'] = $filter_params['minimum_carbs'];
        }

        // Maximum
        if (isset($filter_params['maximum_carbs'])) {
            $sql .= " AND carbohydrates <= CONCAT(:maximum_carbs)";
            $named_params_values['maximum_carbs'] = $filter_params['maximum_carbs'];
        }

        $facts = (array) $this->paginate($sql, $named_params_values);
        return $facts;
    }

    public function getFactId(string $nutrition_id): mixed
    {

        $sql = "SELECT * FROM facts WHERE nutrition_id = :nutrition_id";

        $fact_info = $this->fetchSingle(
            $sql,
            ["nutrition_id" => $nutrition_id]
        );

        return $fact_info;
    }
}
