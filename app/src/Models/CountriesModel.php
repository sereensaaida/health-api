<?php

namespace App\Models;

use App\Core\PDOService;

class CountriesModel extends BaseModel
{
    public function __construct(PDOService $pdo)
    {
        parent::__construct($pdo);
    }
    public function getCountries(array $filter_params = []): mixed
    {
        $named_params = [];
        $sql = "SELECT * FROM countries WHERE 1";

        if (isset($filter_params['name'])) {
            $sql .= " AND name LIKE CONCAT(:name,'%')";
            $named_params['name'] = $filter_params['name'];
        }

        if (isset($filter_params['population'])) {
            $sql .= " AND population LIKE (:population,'%')";
            $named_params['population'] = $filter_params['population'];
        }

        if (isset($filter_params['vegetarian_percentage'])) {
            $sql .= " AND vegetarian_percentage LIKE CONCAT(:vegetarian_percentage,'%')";
            $named_params['vegetarian_percentage'] = $filter_params['vegetarian_percentage'];
        }

        if (isset($filter_params['daily_calorie_intake'])) {
            $sql .= " AND daily_calorie_intake LIKE CONCAT(:daily_calorie_intake,'%')";
            $named_params['daily_calorie_intake'] = $filter_params['daily_calorie_intake'];
        }

        if (isset($filter_params['consumed_dishes'])) {
            $sql .= " AND consumed_dishes LIKE CONCAT(:consumed_dishes,'%')";
            $named_params['consumed_dishes'] = $filter_params['consumed_dishes'];
        }

        if (isset($filter_params['food_culture'])) {
            $sql .= " AND food_culture LIKE CONCAT(:food_culture,'%')";
            $named_params['food_culture'] = $filter_params['food_culture'];
        }

        if (isset($filter_params['nutritional_deficiency'])) {
            $sql .= " AND nutritional_deficiency LIKE CONCAT(:nutritional_deficiency,'%')";
            $named_params['nutritional_deficiency'] = $filter_params['nutritional_deficiency'];
        }
        return   (array)$this->fetchAll($sql, $named_params);
    }

    public function getCountryId(string $country_id): mixed
    {
        $query = "SELECT * FROM countries WHERE country_id = :country_id";
        $country_info = $this->fetchSingle(
            $query,
            ["country_id" => $country_id]
        );
        return $country_info;
    }

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
}
