<?php

namespace App\Models;

use App\Core\PDOService;

class GuidelinesModel extends BaseModel
{
    public function __construct(PDOService $pdo)
    {
        parent::__construct($pdo);
    }
    public function getGuidelines(array $filter_params = []): mixed
    {
        $named_params = [];
        $sql = "SELECT * FROM guidelines WHERE 1";

        if (isset($filter_params['country_id'])) {
            $sql .= " AND country_id LIKE  CONCAT(:country_id,'%')";
            $named_params['country_id'] = $filter_params['country_id'];
        }

        if (isset($filter_params['calorie_intake'])) {
            $sql .= " AND calorie_intake LIKE  CONCAT(:calorie_intake,'%')";
            $named_params['calorie_intake'] = $filter_params['calorie_intake'];
        }

        if (isset($filter_params['protein_intake'])) {
            $sql .= " AND protein_intake LIKE  CONCAT(:protein_intake,'%')";
            $named_params['protein_intake'] = $filter_params['protein_intake'];
        }

        if (isset($filter_params['fats'])) {
            $sql .= " AND fats LIKE  CONCAT(:fats,'%')";
            $named_params['fats'] = $filter_params['fats'];
        }

        if (isset($filter_params['carbohydrates'])) {
            $sql .= " AND carbohydrates LIKE  CONCAT(:carbohydrates,'%')";
            $named_params['carbohydrates'] = $filter_params['carbohydrates'];
        }

        if (isset($filter_params['servings_per_day'])) {
            $sql .= " AND servings_per_day LIKE  CONCAT(:servings_per_day,'%')";
            $named_params['servings_per_day'] = $filter_params['servings_per_day'];
        }

        if (isset($filter_params['guideline_notes'])) {
            $sql .= " AND guideline_notes LIKE  CONCAT(:guideline_notes,'%')";
            $named_params['guideline_notes'] = $filter_params['guideline_notes'];
        }


        $guidelines = (array) $this->fetchAll($sql, $named_params);

        return $guidelines;
    }

    public function getGuidelinesId(string $guideline_id): mixed
    {

        $query = "SELECT * FROM guidelines WHERE guideline_id = :guideline_id";
        $guidelines_info = $this->fetchSingle(
            $query,
            ["guideline_id" => $guideline_id]
        );
        return $guidelines_info;
    }
}
