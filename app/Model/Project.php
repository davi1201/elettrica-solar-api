<?php

namespace App\Model;

use App\Entities\MiscellaneousOption;
use App\Model\ProjectTransformer;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'agent_id',
        'client_id',
        'province_id',
        'city_id',
        'roof_type_id',
        'inverter_brand',
        'panel_brand',
        'price',
        'price_cost',
        'active',
        'agent_percentage',
        'metreage',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function roof()
    {
        return $this->belongsTo(MiscellaneousOption::class, 'roof_type_id');
    }

    public function projectProduct()
    {
        return $this->hasOne(ProjectProduct::class);
    }

    public function transformers()
    {
        return $this->hasMany(ProjectTransformer::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function preInspectionAttachments()
    {
        return $this->hasMany(PreInspectionAttachments::class);
    }

    public function preInspection()
    {
        return $this->hasOne(PreInspection::class);
    }

    public function inspection()
    {
        return $this->hasOne(Inspection::class);
    }

    public function discounts()
    {
        return $this->hasMany(ProjectDiscount::class);
    }
}
