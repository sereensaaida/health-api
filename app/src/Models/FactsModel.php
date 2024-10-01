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

        $facts = (array) $this->fetchAll($sql, $named_params_values);
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
