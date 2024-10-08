<?php


namespace App\Services;

use App\Models\CountriesModel;

class CountriesService{


    public function __construct(private CountriesModel $countries_model){
        
    }
}
