<?php

namespace App\Infrastructure\Facades\Repository;

use App\Infrastructure\Services\SolarCalculatorService;
use Illuminate\Support\Facades\Facade;

class PanelRepository extends Facade
{
    protected static function getFacadeAccessor()
    {
        return SolarCalculatorService::class;
    }

}
