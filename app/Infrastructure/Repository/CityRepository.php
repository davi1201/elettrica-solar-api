<?php

namespace App\Infrastructure\Repository;

use App\Model\City;
use App\Model\Province;

class CityRepository
{
    public function getByProvince(Province $province)
    {
        $cities = $province->cities;

        return $cities;
    }
}
