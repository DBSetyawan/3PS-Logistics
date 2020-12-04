<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle_number extends Model
{
    protected $table = "vehicle_numbers";
      protected $fillable = ["vehicle_id","name","id"];

      public function vehicles(){
        return $this->hasMany('warehouse\Models\Vehicle','vehicle_id');
      }

}
