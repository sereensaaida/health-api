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
    public function getDiets(array $filter_params): mixed
    {
        //where we'll store the filters to send to the controller
        $params_values = [];
        //*Step 1:query
        $query = "SELECT * FROM diets WHERE 1";
        //*Step 2: get the filters
        //*is_gluten_free
        if (isset($filter_params["is_gluten_free"])) {
            $query .= " AND is_gluten_free LIKE CONCAT (:is_gluten_free, '%')";
            $params_values["is_gluten_free"] = $filter_params["is_gluten_free"];
        }
        //*is_vegetarian
        if (isset($filter_params["is_vegetarian"])) {
            $query .= " AND is_vegetarian LIKE CONCAT (:is_vegetarian, '%')";
            $params_values["is_vegetarian"] = $filter_params["is_vegetarian"];
        }
        //*protein_goal
        if (isset($filter_params["protein_goal"])) {
            $query .= " AND protein_goal LIKE CONCAT (:protein_goal, '%')";
            $params_values["protein_goal"] = $filter_params["protein_goal"];
        }
        //*carbohydrate_goal
        if (isset($filter_params["carbohydrate_goal"])) {
            $query .= " AND carbohydrate_goal LIKE CONCAT (:carbohydrate_goal, '%')";
            $params_values["carbohydrate_goal"] = $filter_params["carbohydrate_goal"];
        }
        //*calorie_goal
        if (isset($filter_params["calorie_goal"])) {
            $query .= " AND calorie_goal LIKE CONCAT (:calorie_goal, '%')";
            $params_values["calorie_goal"] = $filter_params["calorie_goal"];
        }
        //*name
        if (isset($filter_params["diet_name"])) {
            $query .= " AND diet_name LIKE CONCAT (:diet_name, '%')";
            $params_values["diet_name"] = $filter_params["diet_name"];
        }
        //*paginate the response
        $diets_info = $this->paginate(
            $query,
            $params_values
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
