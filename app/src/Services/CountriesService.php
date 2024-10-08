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
        //Step 1) Validate params given using valitron (validate collection given)

        //Step 2) Create instance of country/insert in db (here or model?) if its valid
        //if not valid throw error msg on current  result
        if($new_country.)

        //Step 3) Call create country method
        $this->countries_model->insertCountry($new_country);
        return Result::success("RANDOM MESSAGE");
    }
}
