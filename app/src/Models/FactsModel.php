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


        if (isset($filter_params['category'])) {
            $sql .= " AND category LIKE CONCAT(:category, '%') ";
            $named_params_values['category'] = $filter_params['category'];
        }

        $foods = (array) $this->fetchAll($sql, $named_params_values);
        return $foods;
    }
}
