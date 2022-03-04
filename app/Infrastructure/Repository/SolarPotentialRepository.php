<?php


namespace App\Infrastructure\Repository;


use App\Entities\City;
use App\Entities\SolarPotential;

class SolarPotentialRepository
{
    public function getByCity(City $city)
    {
        return SolarPotential::where('latitude', '>=', $city->latitude)
            ->where('longitude', '>=', $city->longitude)
            ->first();
    }
}
