<?php

namespace App\Services;

/**
 * Class BMRService
 *
 * This service class handles returning the appropriate computed result from the user's BMR
 */
class BMRService
{
    /**
     * CalculateBMR method
     *
     * @param string $gender gender
     * @param int $age age
     * @param float $height height
     * @param float $weight weight
     * @return array Returns an array
     */
    public function BMRcalculation(string $gender, int $age, float $height, float $weight)
    {
        // Men and female have different results
        $bmr = 0;
        if ($gender === "male") {
            $bmr = 88.362 + (13.397 * $weight) + (4.799 * $height) - (5.677 * $age);
        }
        if ($gender === "female") {
            $bmr = 447.593 + (9.247 * $weight) + (3.098 * $height) - (4.330 * $age);
        }

        $calories_needed = $bmr * 1.55;
        // Rounding to the nearest tenth
        $bmr = round($bmr, 1);
        $calories_needed = round($calories_needed, 1);

        $data = array(
            'BMR' => $bmr,
            'Calories needed per day' => $calories_needed
        );

        return $data;
    }
}
