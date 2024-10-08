<?php

namespace App\Services;

use App\Core\Result;
use App\Models\ExercisesModel;

class ExerciseService
{
    public function __construct(private ExercisesModel $exercisesModel)
    {
        $this->exercisesModel = $exercisesModel;
    }
    //return an instance of the result

    //make sure it is the one from App core
    public function createExercise(array $new_exercise): Result
    {
        //Validate the data of the new exercise collection using validront
        //if valid, insert it in the db.
        //if not, add an error message related to the current item of the errors array

        //insert into db
        // $this->exercisesModel->insertExercise();
        // return Result::fail(
        //     "Random",
        //     [
        //         "Missing ID",
        //         "AYE"
        //     ]
        // );
        return Result::success("");
    }
}
