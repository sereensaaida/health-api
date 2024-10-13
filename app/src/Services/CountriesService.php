<?php


namespace App\Services;

use App\Core\Result;
use App\Models\CountriesModel;

class CountriesService
{


    public function __construct(private CountriesModel $countries_model)
    {
        $this->countries_model = $countries_model;
    }

    //do not return boolean or array, return instance of result
    public function createCountry(array $new_country): Result
    {

        //Step 3) Call create country method
        // $this->countries_model->insertCountry($new_country);
        return Result::success("RANDOM MESSAGE");
    }
}
