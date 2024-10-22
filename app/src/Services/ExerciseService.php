<?php

namespace App\Services;

use App\Core\Result;
use App\Validation\Validator;
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
        $rules = array(
            'exercise_id' => [
                'required',
                'integer',
                ['min', 1]
            ],
            'name' => [
                'required',
                // ['min', 1] //check if i can have minimum character
            ],
            'exercise_type' => [
                'alpha',
                // ['min', 1]
                // ['max',1]
            ],
            'calories' => [
                'integer',
                // ['min', 1]
            ],
            'equipment' => [
                'alpha',
                // ['min', 1]
            ],
            'difficulty' => [
                'integer',
                ['min', 1],
                ['max', 4]
            ],
            'muscle' => [
                'integer',
                ['min', 1],
                ['max', 4]
            ]
        );

        $validator = new Validator($new_exercise, [], 'en');
        $validator->mapFieldsRules($rules);
        if ($validator->validate()) {
            return Result::success("");
        } else {
            return Result::fail("no");
        }


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
        //return Result::success("");
    }
}
