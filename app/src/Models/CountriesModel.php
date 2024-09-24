<?php

namespace App\Models;

use App\Core\PDOService;

class CountriesModel extends BaseModel
{
    public function __construct(PDOService $pdo)
    {
        parent::__construct($pdo);
    }
    public function getCountries(): mixed
    {
        $sql = "SELECT * FROM countries";
        return   (array)$this->fetchAll($sql);
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
}
