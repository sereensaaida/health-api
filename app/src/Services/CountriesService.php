<?php


namespace App\Services;

use App\Core\Result;
use App\Validation\Validator;
use App\Models\CountriesModel;

class CountriesService
{

    /**
     * Function serving as a constructor for country model
     *
     * @param CountriesModel $countries_model
     *
     */
    public function __construct(private CountriesModel $countries_model)
    {
        $this->countries_model = $countries_model;
    }

    //return an instance of the result
    /**
     * Function for validating data with Valitron
     *
     * @param array $new_country
     * @return boolean returns a true or false
     */
    public function isCountryValid(array $new_country)
    {
        $data = array(
            // "country_id" => $new_country["country_id"],
            "name" => $new_country["name"],
            "population" => $new_country["population"],
            "vegetarian_percentage" => $new_country["vegetarian_percentage"],
            "daily_calorie_intake" =>  $new_country["daily_calorie_intake"],
            "consumed_dishes" =>  $new_country["consumed_dishes"],
            "food_culture" => $new_country["food_culture"],
            "nutritional_deficiency" => $new_country["nutritional_deficiency"],
        );
        $rules = array(
            'country_id' => [
                'integer',
                ['min', 1]
            ],
            'name' => array(
                'required',
                array('lengthMin', 1)
            ),
            'population' =>
            array(
                'integer',
                ['min', 1]
            ),
            'vegetarian_percentage' => [
                'required',
                'integer',
                ['min', 1]
            ],
            'daily_calorie_intake' =>
            array(
                'required',
                'integer',
                ['min', 1]
            ),
            'consumed_dishes' => [
                'required',
                array('lengthMin', 1)
            ],
            'food_culture' => array(
                'required',
                array('lengthMin', 1)
            ),
            'nutritional_deficiency' => array(
                'required',
                array('lengthMin', 1)
            ),
        );
        $validator = new Validator($data);
        $validator->mapFieldsRules($rules);

        return $validator->validate();
    }

    /**
     * Service for creating a new country
     *
     * @param array $new_country The array of country information from the request body
     * @return Result Returning the result in JSON format
     */
    public function createCountry(array $new_country): Result
    {
        var_dump($new_country);
        if ($this->isCountryValid($new_country)) {
            $this->countries_model->insertCountry($new_country);

            return Result::success("country was successfully created");
        } else {
            return Result::fail("The country was not created. Make sure that all the data is correct before trying again.");
        }
    }

    /**
     * Service for updating a country's fields
     *
     * @param array $update_country The array of country information from the request body
     * @return Result Returning the result in JSON format
     */
    public function updateCountry(array $update_country): Result
    {
        if ($this->isCountryValid($update_country)) {
            $this->countries_model->updateCountry($update_country);
            return Result::success("country was successfully updated");
        } else {
            return Result::fail("The country was not updated. Make sure that all the data is correct before trying again.", $update_country);
        }
    }

    /**
     * Service for deleting country
     *
     * @param array $country_id The array of country information from the request body
     * @return Result Returning the result in JSON format
     */
    public function deleteCountry(array $country_id)
    {
        //validate the id
        $data = array(
            "country_id" => $country_id["country_id"],
        );

        $rules = array(
            'country_id' => [
                'integer',
                ['min', 1]
            ],
        );

        $validator = new Validator($data);
        $validator->mapFieldsRules($rules);

        if ($validator->validate()) {
            //Step 3) Call delete country method
            $this->countries_model->deleteCountry($country_id);
            return Result::success("Country was successfully deleted");
        } else {
            return Result::fail("Error, Country couldn't be deleted");
        }
    }
}
