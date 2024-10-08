<?php

namespace App\Services;

use App\Models\ExercisesModel;

class ExerciseService
{
    public function __construct(private ExercisesModel $exercisesModel)
    {
        $this->exercisesModel = $exercisesModel;
    }
    //return an instance of the result
    public function createExercice() {
        
    }
}
