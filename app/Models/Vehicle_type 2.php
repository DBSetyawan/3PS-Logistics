<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle_type extends Model
{
    protected $table = "vehicle_types";
    protected $fillable = ["name","id"];

    // public function container(){
    //   return $this->hasMany('warehouse\Models\Container','id');
    // }

    public function vehicles(){
      return $this->hasMany('warehouse\Models\Vehicle','id');
    }

    public function vehicle_type_detail(){
      return $this->hasMany('warehouse\Models\Vehicle_type_detail','id');
    }
}
