<?php

namespace App\Repositories;

use App\Models\City;

class CityRepository extends Repository
{
    public function __construct(City $model)
    {
        $this->model = $model;
    }
}
