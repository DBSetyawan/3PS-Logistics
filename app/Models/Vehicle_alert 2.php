<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle_alert extends Model
{

  use SoftDeletes;

    protected $table = "vehicle_alerts";
    protected $fillable = ["vehicle_id","id","alert_time","alert_name"];

    public function vehicle(){
        return $this->hasMany('warehouse\Models\Vehicle','id');
    }
}
