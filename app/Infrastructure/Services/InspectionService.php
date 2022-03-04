<?php

namespace App\Infrastructure\Services;

use App\Model\Inspection;

class InspectionService
{
    public function create(array $data)
    {
        $inspection = new Inspection($data);
        $inspection->save();
    }

    public function update(Inspection $inspection, array $data)
    {
        return $inspection->update($data);
    }
}
