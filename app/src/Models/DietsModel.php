<?php

namespace App\Models;

use App\Core\PDOService;

class DietsModel extends BaseModel
{
    //instantiate the pdo connection
    /**
     * DietsModel constructor.
     *
     * @param PDOService $dbo The database service object.
     */
    public function __construct(PDOService $pdo)
    {
        parent::__construct($pdo);
    }

    //get /diets
    /**
     * Retrieves all diets.
     *
     * @param array $filter_params An array of filtering options such as by IDs,duration, etc..
     * @return mixed An array of filtered or unfiltered diets.
     */
    public function getDiets(array $filter_params = []): mixed
    {
        $named_params = [];

        //* Sorting:
        $sortBy = isset($filter_params['sort_by']) ? $filter_params['sort_by'] : 'diet_id';
        $order = isset($filter_params['order']) ? $filter_params['order'] : 'asc';

        // Validating te sorting params
        $validSortingParameters = ['diet_id', 'diet_name', 'protein_goal'];
        $sortBy = in_array($sortBy, $validSortingParameters) ? $sortBy : 'diet_id';
        $order = ($order === 'desc') ? 'desc' : 'asc';
        //where we'll store the filters to send to the controller
        //*Step 1:query
        $sql = "SELECT * FROM diets WHERE 1";
        //*Step 2: get the filters
        $allowed_fields = ['is_gluten_free', 'is_vegetarian', 'protein_goal', 'carbohydrate_goal', 'calorie_goal', 'diet_name'];
        $filter_result = $this->buildFilterConditions($filter_params, $allowed_fields);
        $sql .= $filter_result['sql_conditions'];
        $named_params = $filter_result['named_params'];
        //sorting
        $sql .= " ORDER BY $sortBy $order";
        //*paginate the response
        $diets_info = $this->paginate(
            $sql,
            $named_params
        );
        //*Step 3: should return an array
        return $diets_info;
    }

    // get diets by id
    /**
     * Retrieves a singleton resource of exercise by its ID
     *
     * @param string $diet_id The ID of the diet
     * @return mixed The diet data
     */
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
