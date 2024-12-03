<?php

namespace App\Models;

use App\Core\PDOService;

class ExercisesModel extends BaseModel
{
    //*Step 1) establish connection with the parent PDO

    /**
     * ExercisesModel constructor.
     *
     * @param PDOService $dbo The database service object.
     */
    public function __construct(PDOService $pdo)
    {
        parent::__construct($pdo);
    }
    //*Step 2) Get all the exercices from the db
    /**
     * Retrieves all exercises.
     *
     * @param array $filter_params An array of filtering options such as by IDs,duration, etc..
     * @return mixed An array of filtered or unfiltered exercises.
     */
    public function getExercises(array $filter_params): mixed
    {
        //possible filters: exercise_type,difficulty_level, muscle_targeted, calories_burned, equipment_needed
        //query statement
        $named_params = [];

        $sortBy = isset($filter_params['sort_by']) ? $filter_params['sort_by'] : 'exercise_id';
        $order = isset($filter_params['order']) ? $filter_params['order'] : 'asc';

        // Validating te sorting params
        $validSortingParameters = ['exercise_id', 'name', 'exercise_type'];
        $sortBy = in_array($sortBy, $validSortingParameters) ? $sortBy : 'exercise_id';

        //*Sorting:
        $order = ($order === 'desc') ? 'desc' : 'asc';
        $sql = "SELECT * FROM exercises WHERE 1";
        //* Filtering:
        $allowed_fields = ['exercise_type', 'difficulty_level', 'muscles_targeted', 'calories_burned_per_min', 'equipment_needed'];
        $filter_result = $this->buildFilterConditions($filter_params, $allowed_fields);
        $sql .= $filter_result['sql_conditions'];
        $named_params = $filter_result['named_params'];

        $sql .= " ORDER BY $sortBy $order";
        $exercise = $this->paginate($sql, $named_params);
        return $exercise;
    }

    //*Step 3) Get informations by id
    /**
     * Retrieves a singleton resource of exercise by its ID
     *
     * @param string $exercises_id The ID of the exercise
     * @return mixed The exercise data
     */
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

    /**
     * Retrieves workout recommendations for a specific exercise.
     *
     * @param string $exercise_id The ID of the exercise to get workout recommendations for.
     * @return mixed The exercise's recommendations.
     */
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

    //*POST
    /**
     * Inserts a new Exercise item into the database.
     *
     * @param array $new_exercise An array containing the information for the new exercise item.
     * @return mixed return a string or a bool.
     */
    public function insertExercise(array $new_exercise): mixed
    {
        $last_id = $this->insert("exercises",  $new_exercise);

        return $last_id;
    }

    //*UPDATE
    /**
     * Model method for updating an exercise
     *
     * @param array $updated_exercise The exercise information inputted by the user
     * @return void Updates the exercise.
     */
    public function updateExercise(array $updated_exercise): mixed
    {
        $exercise_id = $updated_exercise["exercise_id"];
        //var_dump($exercise_id);
        unset($updated_exercise["exercise_id"]);
        $last_id = $this->update("exercises", $updated_exercise, ["exercise_id" => $exercise_id]);

        return $last_id;
    }

    //*DELETE
    /**
     * Model method for deleting a food
     *
     * @param array $delete_id The exercise information inputted by the user
     * @return mixed Deletes the exercise.
     */
    public function deleteExercise(array $delete_id)
    {
        $exercise_id = $delete_id[0]["exercise_id"];
        $deleted_id = $this->delete("exercises", ["exercise_id" => $exercise_id]);

        return $deleted_id;
    }
}
