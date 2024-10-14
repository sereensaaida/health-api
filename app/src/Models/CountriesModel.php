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
/**
 * this method fetches a list of countries customized with given filtering and sorting parameters entered from the user
 *
 *the method creates an sql query that has additional conditions concatenated to it based on the *entered/valid parameters equivalent to each field in the countries table. the query can also be *concatenated with sorting parameters (if entered by the user)
 *
 *
 * @param array $filter_params is an associative array containing any/ALL parameters inputted by the user through thunder client
 * @return mixed is the returned value that includes countries corresponding to the filtered parameters (if any)
 *
 * @throws Exception if an error occurs when executing the sql statement, errors can range from syntax to db configuration problems
 */
    public function getCountries(array $filter_params = []): mixed
    {
        //*Declaring named parameters and initiating query
        $named_params = [];
        $sql = "SELECT * FROM countries WHERE 1";

        //*FILTERING:
        //*Filter implementation for each field, check if a value is present and concats it to SQL
        //name
        if (isset($filter_params['name'])) {
            $sql .= " AND name LIKE CONCAT(:name,'%')";
            $named_params['name'] = $filter_params['name'];
        }
        //population
        if (isset($filter_params['population'])) {
            $sql .= " AND population LIKE (:population,'%')";
            $named_params['population'] = $filter_params['population'];
        }
        //vegetarian
        if (isset($filter_params['vegetarian_percentage'])) {
            $sql .= " AND vegetarian_percentage LIKE CONCAT(:vegetarian_percentage,'%')";
            $named_params['vegetarian_percentage'] = $filter_params['vegetarian_percentage'];
        }
        //daily calorie intake
        if (isset($filter_params['daily_calorie_intake'])) {
            $sql .= " AND daily_calorie_intake LIKE CONCAT(:daily_calorie_intake,'%')";
            $named_params['daily_calorie_intake'] = $filter_params['daily_calorie_intake'];
        }
        //consumed dishes
        if (isset($filter_params['consumed_dishes'])) {
            $sql .= " AND consumed_dishes LIKE CONCAT(:consumed_dishes,'%')";
            $named_params['consumed_dishes'] = $filter_params['consumed_dishes'];
        }
        //food culture
        if (isset($filter_params['food_culture'])) {
            $sql .= " AND food_culture LIKE CONCAT(:food_culture,'%')";
            $named_params['food_culture'] = $filter_params['food_culture'];
        }
        //nutritional deficiency
        if (isset($filter_params['nutritional_deficiency'])) {
            $sql .= " AND nutritional_deficiency LIKE CONCAT(:nutritional_deficiency,'%')";
            $named_params['nutritional_deficiency'] = $filter_params['nutritional_deficiency'];
        }

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
