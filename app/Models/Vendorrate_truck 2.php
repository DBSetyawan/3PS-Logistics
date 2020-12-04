<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Vendorrate_truck extends Model
{
    protected $table = "vendorrate_trucks";

    public function vehicle_type_detail(){
      return $this->belongsTo('warehouse\Models\Vehicle_type_detail');
    }
    
    public function ship_categories(){
      return $this->belongsTo('warehouse\Models\Ship_categorie','id');
    }

    public function sub_services(){
      return $this->belongsTo('warehouse\Models\Sub_service');
    }

    public function vendors(){
      return $this->belongsTo('warehouse\Models\Vendor');
    }

    // public function vehicle_type_detil(){
    //   return $this->belongsTo('warehouse\Models\Vehicle_type_detail','id');
    // }

    public function originable()
    {
      return $this->morphTo();
    }

    public function vendorrate_truck()
    {
      return $this->morphTo(Vendorrate_truck::class,'vendorrateable');
    }

    public function vendorratetruckable()
    {
      return $this->morphTo();
    }

    public function destinationable()
    {
      return $this->morphTo();
    }

    public function city()
    {
      return $this->morphTo();
    }

    public function district()
    {
      return $this->morphMany('warehouse\Models\District', 'districtable');
    }

    public function vendorrate()
    {
      return $this->morphMany('warehouse\Models\Vendorrate', 'vendorrateable');
    }

}
