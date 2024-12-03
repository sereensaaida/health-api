<?php

namespace App\Services;

class BMIService
{
    public function BMIcalculation(float $weight, float $height)
    {
        //TODO: Allow user to enter lbs and in & kg and m
        //make the calculation
        $bmi = ($weight / ($height * $height));

        //return it to the controller
        return $bmi;
    }
}
