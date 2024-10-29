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
    public function isExerciseValid(array $new_exercise)
    {
        $data = array(
            "exercise_id" => $new_exercise["exercise_id"],
            "name" => isset($new_exercise["name"]),
            "exercise_type" => isset($new_exercise["exercise_type"]),
            "calories_burned_per_min" => isset($new_exercise["calories_burned_per_min"]),
            "equipment_needed" =>  isset($new_exercise["equipment_needed"]),
            "difficulty_level" =>  isset($new_exercise["difficulty_level"]),
            "muscles_targeted" =>  isset($new_exercise["muscles_targeted"]),
        );
        $rules = array(
            'exercise_id' => [
                'integer',
                ['min', 1]
            ],
            'name' => array(
                'required',
                array('lengthMin', 1)
            ), //check if i can have minimum character
            'exercise_type' =>
            array(
                'required',
                array('lengthMin', 4)
            ),
            'calories_burned_per_min' => [
                'integer',
                ['min', 1]
            ],
            'equipment_needed' =>
            array(
                'required',
                array('lengthMin', 1)
            ),
            'difficulty_level' => [
                'integer',
                ['min', 1],
                ['max', 4]
            ],
            'muscles_targeted' => array(
                'required',
                array('lengthMin', 1)
            ),
        );
        $validator = new Validator($data);
        $validator->mapFieldsRules($rules);

        return $validator->validate();
    }
    //make sure it is the one from App core
    public function createExercise(array $new_exercise): Result
    {
        if ($this->isExerciseValid($new_exercise)) {
            $this->exercisesModel->insertExercise($new_exercise);
            return Result::success("Exercise was successfully created");
        } else {
            return Result::fail("no");
        }
    }

    public function updateExercise(array $update_exercise): Result
    {
        if ($this->isExerciseValid($update_exercise)) {
            $this->exercisesModel->updateExercise($update_exercise);
            return Result::success("Exercise was successfully updated");
        } else {
            return Result::fail("no", $update_exercise);
        }
    }
}
