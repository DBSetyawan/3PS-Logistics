<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle_record_categories extends Model
{
    protected $table = "vehicle_record_categories";

    public function vehicle_records(){
      return $this->hasMany('warehouse\Model\Vehicle_record','id');
    }
}
