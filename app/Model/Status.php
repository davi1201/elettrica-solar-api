<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
  public function department()
  {
      return $this->belongsTo(Department::class);
  }
}
