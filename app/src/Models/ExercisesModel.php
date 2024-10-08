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
    public function getExercices(): mixed
    {
        //query statement
        $sql = "SELECT * FROM exercises";

        //fetch all
        $exercises_info = $this->fetchAll($sql);
        //return the fetch all
        return $exercises_info;
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

    //*! come back to it  get exercices based on the recommendations
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
}
