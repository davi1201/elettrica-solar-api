<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class SolarPotential extends Model
{
    public function getAverageAttribute()
    {
        $total = $this->january +
            $this->february +
            $this->march +
            $this->april +
            $this->may +
            $this->june +
            $this->july +
            $this->august +
            $this->september +
            $this->october +
            $this->november +
            $this->december;

        return ($total / 12) / 1000;
    }
}
