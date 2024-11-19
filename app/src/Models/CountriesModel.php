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
    /**
     * Inserts a new Country item into the database.
     *
     * @param array $country An array containing the information for the new Country item.
     * @return mixed return a string or a bool.
     */
    public function insertCountry(array $country): mixed
    {
        var_dump($country);
        $last_id = $this->insert("countries",  $country);

        return $last_id;
    }

    //*UPDATE
    /**
     * Model method for updating a country
     *
     * @param array $country The country information inputted by the user
     * @return void Updates the country.
     */
    public function updateCountry(array $country): mixed
    {
        $country_id = $country["country_id"];
        unset($country["country_id"]);
        $last_id = $this->update("countries", $country, ["country_id" => $country_id]);

        return $last_id;
    }

    //*DELETE
    /**
     * Model method for deleting a country
     *
     * @param array $delete_id the id associated with the country to be deleted
     * @return mixed Deletes the country.
     */
    public function deleteCountry(array $delete_id)
    {
        $country_id = $delete_id["country_id"];
        $deleted_id = $this->delete("countries", ["country_id" => $country_id]);

        return $deleted_id;
    }
}
