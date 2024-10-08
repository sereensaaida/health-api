<?php


namespace App\Services;

use App\Models\CountriesModel;

class CountriesService{


    public function __construct(private CountriesModel $countries_model){
        $this->countries_model = $countries_model;
    }

    //do not return boolean or array, return instance of result
    public function createCountry(): ReturnType{
        return $this->countries_model->create([]);
        
    }
}
