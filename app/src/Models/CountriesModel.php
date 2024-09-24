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
}
