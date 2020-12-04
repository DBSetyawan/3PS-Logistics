<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle_type_detail extends Model
{
    protected $table = "vehicle_type_details";
    protected $fillable = ["vehicle_type_id","vehicle_container_id","tonase","kubikasi"];

    public function vehicle_type(){
      return $this->belongsTo('warehouse\Models\Vehicle_type','id');
    }

    public function vehicle_typex(){
      return $this->belongsTo('warehouse\Models\Vehicle_type','vehicle_type_id');
    }

    public function container(){
      return $this->belongsTo('warehouse\Models\Container','vehicle_container_id');
    }

    public function vendorrate_truck(){
      return $this->hasMany('warehouse\Models\Vendorrate_truck','id');
    }

}
