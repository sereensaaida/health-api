<?php

namespace App\Models;

use App\Core\PDOService;

class CountriesModel extends BaseModel
{
    public function __construct(PDOService $pdo)
    {
        parent::__construct($pdo);
    }

    //* Get /countries
    public function getCountries(array $filter_params = []): mixed
    {
        //*Declaring named parameters and initiating query
        $named_params = [];
        $sql = "SELECT * FROM countries WHERE 1";

        //*FILTERING:
        //*Filter implementation for each field, check if a value is present and concats it to SQL
        //name
        $allowed_fields = ['name', 'population', 'vegetarian_percentage', 'daily_calorie_intake', 'consumed_dishes', 'food_culture', 'nutritional_deficiency'];
        $filter_result = $this->buildFilterConditions($filter_params, $allowed_fields);
        $sql .= $filter_result['sql_conditions'];
        $named_params = $filter_result['named_params'];
        //*SORTING:
        //*Retrieving all sorting/order params
        $sortBy = isset($filter_params['sort_by']) ? $filter_params['sort_by'] : 'country_id';
        $order = isset($filter_params['order']) ? $filter_params['order'] : 'asc';

        //*Sorting validation
        $validSortingParameters = ['population', 'name', 'vegetarian_percentage', 'daily_calorie_intake', 'consumed_dishes', 'food_culture', 'nutritional_deficiency'];
        $sortBy = in_array($sortBy, $validSortingParameters) ? $sortBy : 'name';
        $order = ($order === 'desc') ? 'desc' : 'asc';

        //*Adding it so SQL
        $sql .= " ORDER BY $sortBy $order";
        return   (array)$this->fetchAll($sql, $named_params);
    }


    //* Get /country/{country_id}
    public function getCountryId(string $country_id): mixed
    {
        $query = "SELECT * FROM countries WHERE country_id = :country_id";
        $country_info = $this->fetchSingle(
            $query,
            ["country_id" => $country_id]
        );
        return $country_info;
    }

    //*Subcollection implementation /country/guidelines/{country_id}
    public function getCountryGuidelines($country_id): mixed
    {
        $country = $this->getCountryId($country_id);
        $sql = "SELECT * FROM GUIDELINES WHERE country_id = :country_id";
        $guideline_info = $this->fetchAll(
            $sql,
            ["country_id" => $country_id]
        );

        $result = [
            'country' => $country,
            'guideline_info' => $guideline_info
        ];

        return $result;
    }

    //*(Build 2): Create Country implementation
    public function insertCountry(array $country): mixed
    {
        $last_id = $this->insert(
            "Countries",
            $country
        );

        return $last_id;
    }
}
