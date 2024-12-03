<?php

namespace App\Services;

use App\Core\Result;
use App\Validation\Validator;
use App\Models\ExercisesModel;

class ExerciseService
{
    /**
     * Constructor for ExerciseService class
     *
     * @param ExercisesModel $exercises_model Instance of the ExerciseModel class
     */
    public function __construct(private ExercisesModel $exercises_model)
    {
        $this->exercises_model = $exercises_model;
    }
    //return an instance of the result
    /**
     * Function for validating data with Valitron
     *
     * @param array $new_exercise
     * @return boolean returns a true or false
     */
    public function isExerciseValid(array $new_exercise)
    {
        $data = array(
            "name" => $new_exercise["name"],
            "exercise_type" => $new_exercise["exercise_type"],
            "calories_burned_per_min" => $new_exercise["calories_burned_per_min"],
            "equipment_needed" =>  $new_exercise["equipment_needed"],
            "difficulty_level" =>  $new_exercise["difficulty_level"],
            "muscles_targeted" => $new_exercise["muscles_targeted"],
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
    /**
     * Service for creating a new exercise
     *
     * @param array $new_exercise The array of exercise information from the request body
     * @return Result Returning the result in JSON format
     */
    public function createExercise(array $new_exercise): Result
    {
        if ($this->isExerciseValid($new_exercise)) {
            $this->exercises_model->insertExercise($new_exercise);
            return Result::success("Exercise was successfully created");
        } else {
            return Result::fail("The exercise was not created. Make sure that all the data is correct before trying again.");
        }
    }
    /**
     * Service for updating exercise
     *
     * @param array $update_exercise The array of exercise information from the request body
     * @return Result Returning the result in JSON format
     */
    public function updateExercise(array $update_exercise): Result
    {
        if ($this->isExerciseValid($update_exercise)) {
            $this->exercises_model->updateExercise($update_exercise);
            return Result::success("Exercise was successfully updated");
        } else {
            return Result::fail("The exercise was not updated. Make sure that all the data is correct before trying again.", $update_exercise);
        }
    }

    /**
     * Service for deleting exercise
     *
     * @param array $food_info The array of exercise information from the request body
     * @return Result Returning the result in JSON format
     */
    public function deleteExercise(array $exercise_id)
    {
        //validate the id
        //var_dump($exercise_id);
        $data = array(
            "exercise_id" => $exercise_id[0]["exercise_id"],
        );

        $rules = array(
            'exercise_id' => [
                'integer',
                ['min', 1]
            ],
        );

        $validator = new Validator($data);
        $validator->mapFieldsRules($rules);

        if ($validator->validate()) {
            //delete the exercise
            $this->exercises_model->deleteExercise($exercise_id);
            return Result::success("The exercise was successfully deleted");
        } else {
            return Result::fail("The exercise could not be deleted");
        }
    }
}
