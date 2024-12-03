<?php

namespace App\Services;

class BFPService
{
    public function BFPcalculation(float $weight, float $height, int $age, string $gender): float
    {
        //maybe call bmi service?
        $bmi = $weight / (($height / 100) ** 2);

        if ($gender === 'male') {
            $bfp = 1.20 * $bmi + 0.23 * $age - 16.2;
        } elseif ($gender === 'female') {
            $bfp = 1.20 * $bmi + 0.23 * $age - 5.4;
        } 

        //what if its not female throw error!


        //return
        return $bfp;
    }
}
