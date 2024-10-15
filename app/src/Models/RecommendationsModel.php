<?php

namespace App\Models;

use App\Core\PDOService;

class RecommendationsModel extends BaseModel
{
    /**
     * RecommendationsModel constructor.
     *
     * @param PDOService $dbo The database service object.
     */
    public function __construct(PDOService $pdo)
    {
        parent::__construct($pdo);
    }
    /**
     * Retrieves all workout recommendations.
     *
     * @param array $filter_params An array of filtering options such as by IDs,duration, etc..
     * @return mixed An array of filtered or unfiltered workout recommendations.
     */
    public function getRecommendations(array $filter_params = []): mixed
    {
        $named_params = [];
        //* Sorting:
        $sortBy = isset($filter_params['sort_by']) ? $filter_params['sort_by'] : 'recommendation_id';
        $order = isset($filter_params['order']) ? $filter_params['order'] : 'asc';
        // Validating the sorting params
        $validSortingParameters = ['recommendation_id', 'duration_minutes', 'sets'];
        $sortBy = in_array($sortBy, $validSortingParameters) ? $sortBy : 'recommendation_id';
        $order = ($order === 'desc') ? 'desc' : 'asc';
        //query statement
        $sql = "SELECT * FROM recommendations WHERE 1";
        //*Filtering:
        $allowed_fields = ['diet_id', 'exercise_id', 'duration_minutes', 'reps', 'sets', 'distance', 'additional_notes'];
        $filter_result = $this->buildFilterConditions($filter_params, $allowed_fields);
        $sql .= $filter_result['sql_conditions'];
        $named_params = $filter_result['named_params'];
        //add the sorting statement at the end of the query
        $sql .= " ORDER BY $sortBy $order";
        $recommendations = $this->paginate($sql, $named_params);

        return $recommendations;
    }

    /**
     * Retrieves workout recommendations from a specific workout id.
     *
     * @param string $recommendation_id The ID of the recommendation you want to get information from.
     * @return mixed data about the recommendation id.
     */
    public function getRecommendationsId(string $recommendation_id): mixed
    {
        //sql statement
        $query = "SELECT * FROM recommendations WHERE recommendation_id = :recommendation_id";
        //fetch single as we are expecting only one row
        $recommendation_info = $this->fetchSingle(
            $query,
            ["recommendation_id" => $recommendation_id]
        );
        //return the object to the controller
        return $recommendation_info;
    }
}
