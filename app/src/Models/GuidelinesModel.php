<?php

namespace App\Models;

use App\Core\PDOService;

class GuidelinesModel extends BaseModel
{
    public function __construct(PDOService $pdo)
    {
        parent::__construct($pdo);
    }

    //*Get /countries
    public function getGuidelines(array $filter_params = []): mixed
    {

        //*Declaring named parameters and initiating query
        $named_params = [];
        $sql = "SELECT * FROM guidelines WHERE 1";

        //*FILTERING:
        //*Filter implementation for each field, check if a value is present and concats it to SQL
        //country
        if (isset($filter_params['country_id'])) {
            $sql .= " AND country_id LIKE  CONCAT(:country_id,'%')";
            $named_params['country_id'] = $filter_params['country_id'];
        }
        //calorie intake
        if (isset($filter_params['calorie_intake'])) {
            $sql .= " AND calorie_intake LIKE  CONCAT(:calorie_intake,'%')";
            $named_params['calorie_intake'] = $filter_params['calorie_intake'];
        }
        //protein intake
        if (isset($filter_params['protein_intake'])) {
            $sql .= " AND protein_intake LIKE  CONCAT(:protein_intake,'%')";
            $named_params['protein_intake'] = $filter_params['protein_intake'];
        }
        //fats
        if (isset($filter_params['fats'])) {
            $sql .= " AND fats LIKE  CONCAT(:fats,'%')";
            $named_params['fats'] = $filter_params['fats'];
        }
        //carbohydrates
        if (isset($filter_params['carbohydrates'])) {
            $sql .= " AND carbohydrates LIKE  CONCAT(:carbohydrates,'%')";
            $named_params['carbohydrates'] = $filter_params['carbohydrates'];
        }
        //servings per day
        if (isset($filter_params['servings_per_day'])) {
            $sql .= " AND servings_per_day LIKE  CONCAT(:servings_per_day,'%')";
            $named_params['servings_per_day'] = $filter_params['servings_per_day'];
        }
        //guideline notes
        if (isset($filter_params['guideline_notes'])) {
            $sql .= " AND guideline_notes LIKE  CONCAT(:guideline_notes,'%')";
            $named_params['guideline_notes'] = $filter_params['guideline_notes'];
        }

        //*SORTING:
        //*Retrieving all sorting/order params
        $sortBy = isset($filter_params['sort_by']) ? $filter_params['sort_by'] : 'guidelines_id';
        $order = isset($filter_params['order']) ? $filter_params['order'] : 'asc';

        //*Sorting validation
        $validSortingParameters = ['country_id', 'calorie_intake', 'protein_intake', 'fats', 'carbohydrates', 'servings_per_day', 'guideline_notes'];
        $sortBy = in_array($sortBy, $validSortingParameters) ? $sortBy : 'country_id';
        $order = ($order === 'desc') ? 'desc' : 'asc';

        //*Adding it to SQL
        $sql .= " ORDER BY $sortBy $order";
        $guidelines = (array) $this->fetchAll($sql, $named_params);
        return $guidelines;
    }

    //* Get /guideline/{guideline_id}
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
