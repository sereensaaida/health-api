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
