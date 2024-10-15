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
        // //*Filtering:
        $allowed_fields = ['country_id', 'calorie_intake', 'protein_intake', 'fats', 'carbohydrates', 'servings_per_day', 'guideline_notes'];
        $filter_result = $this->buildFilterConditions($filter_params, $allowed_fields);
        $sql .= $filter_result['sql_conditions'];
        $named_params = $filter_result['named_params'];
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
