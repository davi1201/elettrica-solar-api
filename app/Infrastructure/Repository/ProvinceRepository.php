<?php 

namespace App\Infrastructure\Repository;

use App\Model\Province;

class ProvinceRepository
{
    public function getAll()
    {
        $provinces = Province::orderBy('name')->get();
        return $provinces;
    }
}

