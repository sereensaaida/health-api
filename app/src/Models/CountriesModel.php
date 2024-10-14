<?php

namespace App\Models;

use App\Core\PDOService;

class CountriesModel extends BaseModel
{

    /**
     * CountriesModel constructor.
     *
     * @param PDOService $dbo The database service object.
     */
    public function __construct(PDOService $pdo)
    {
        parent::__construct($pdo);
    }

    //* Get /countries
    /**
     * Retrieves a list of countries based on the filter parameters.
     *
     * @param array $filter_params An array of filtering options such as population, vegetarian percentage, name, etc.
     * @return array The filtered list of countries.
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
    /**
     * Retrieves a singleton resource for countries
     *
     * @param string $country_id The ID of the country to retrieve.
     * @return mixed The country data or null if not found.
     */
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
    //* Sub collection resource
    // We retrieve a single/specific country's guidelines. This is because guidelines is dependent on countries.
    /**
     * Retrieves guidelines for a specific countries.
     *
     * @param string $country_id The country of the guidelines we are searching for.
     * @return mixed The country's guidelines.
     */
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
