<?php

namespace App\Models;

use App\Core\PDOService;

class ExercisesModel extends BaseModel
{
    //*Step 1) establish connection with the parent PDO

    public function __construct(PDOService $pdo)
    {
        parent::__construct($pdo);
    }
    //*Step 2) Get all the exercices from the db
    public function getExercises(array $filter_params): mixed
    {
        //possible filters: exercise_type,difficulty_level, muscle_targeted, calories_burned, equipment_needed
        //query statement
        $params_value = [];
        //* Sorting:
        $sortBy = isset($filter_params['sort_by']) ? $filter_params['sort_by'] : 'exercise_id';
        $order = isset($filter_params['order']) ? $filter_params['order'] : 'asc';

        // Validating te sorting params
        $validSortingParameters = ['exercise_id', 'name', 'exercise_type'];
        $sortBy = in_array($sortBy, $validSortingParameters) ? $sortBy : 'exercise_id';

        //*Filtering
        $order = ($order === 'desc') ? 'desc' : 'asc';
        $sql = "SELECT * FROM exercises WHERE 1";
        //*exercise_type
        if (isset($filter_params["exercise_type"])) {
            //add to the sql statement
            $sql .= " AND exercise_type LIKE CONCAT (:exercise_type, '%')";
            $params_value["exercise_type"] = $filter_params["exercise_type"];
        }
        //*difficulty_level
        if (isset($filter_params["difficulty_level"])) {
            //add to the sql statement
            $sql .= " AND difficulty_level LIKE CONCAT (:difficulty_level, '%')";
            $params_value["difficulty_level"] = $filter_params["difficulty_level"];
        }
        //*muscles_targeted
        if (isset($filter_params["muscles_targeted"])) {
            //add to the sql statement
            $sql .= " AND muscles_targeted LIKE CONCAT (:muscles_targeted, '%')";
            $params_value["muscles_targeted"] = $filter_params["muscles_targeted"];
        }
        //*calories_burned
        if (isset($filter_params["calories_burned_per_min"])) {
            //add to the sql statement
            $sql .= " AND calories_burned_per_min LIKE CONCAT (:calories_burned_per_min, '%')";
            $params_value["calories_burned_per_min"] = $filter_params["calories_burned_per_min"];
        }
        //*equipment_needed
        if (isset($filter_params["equipment_needed"])) {
            //add to the sql statement
            $sql .= " AND equipment_needed LIKE CONCAT (:equipment_needed, '%')";
            $params_value["equipment_needed"] = $filter_params["equipment_needed"];
        }
        $sql .= " ORDER BY $sortBy $order";
        $exercise = $this->paginate($sql, $params_value);
        return $exercise;
    }

    //*Step 3) Get informations by id
    public function getExercisesById($exercises_id): mixed
    {
        //query statement
        $sql = "SELECT * FROM exercises WHERE exercise_id = :exercise_id";
        //fetch single
        $exercises_info = $this->fetchSingle(
            $sql,
            ["exercise_id" => $exercises_id]
        );
        //return the data
        return $exercises_info;
    }

    public function getRecommendationsByExercise_id($exercise_id): mixed
    {
        $exercise = $this->getExercisesById($exercise_id);
        //*sql statement
        $sql = "SELECT * FROM recommendations WHERE exercise_id = :exercise_id";
        //*fetch all the results
        $recommendation = $this->fetchAll(
            $sql,
            ['exercise_id' => $exercise_id]
        );
        $result =
            [
                'exercise' => $exercise,
                'recommendation' => $recommendation
            ];
        //*return the information
        return $result;
    }

    public function insertExercise(array $new_exercise): mixed
    {
        $last_id = $this->insert("exercises",  $new_exercise);
        //missing the http response
        return $last_id;
    }
}
