<?php

namespace App\Models;

use App\Core\PDOService;

class DietsModel extends BaseModel
{
    //instantiate the pdo connection
    public function __construct(PDOService $pdo)
    {
        parent::__construct($pdo);
    }

    //get /diets
    public function getDiets(): mixed
    {
        //*Step 1:query
        $query = "SELECT * FROM diets";
        //*Step 2: fetchAll
        $diets_info = $this->fetchAll(
            $query,
        );
        //*Step 3: should return an array
        return $diets_info;
    }

    // get diets by id

    public function getDietsId(int $diet_id): mixed
    {
        //*sql query
        $query = "SELECT * from diets WHERE diet_id = :diet_id";
        //*fetch Single
        $diet_info = $this->fetchSingle(
            $query,
            ["diet_id" => $diet_id]
        );
        //*return the information to the controller
        return $diet_info;
    }
}
