<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Vendorrate_minweight extends Model
{
    protected $table = "vendorrate_minweights";
    // protected $fillable = [""];

    public function originable()
    {
      return $this->morphTo();
    }

    public function vendors(){
      return $this->belongsTo('warehouse\Models\Vendor');
    }

    public function sub_services(){
      return $this->belongsTo('warehouse\Models\Sub_service','sub_services_id');
    }

    public function destinationable()
    {
      return $this->morphTo();
    }

    public function vendorrateminweightable()
    {
      return $this->morphTo();
    }

    public function vendorrate_minweight()
    {
      return $this->morphTo(Vendorrate_minweight::class,'vendorrateable');
    }

    public function vendorrate()
    {
      return $this->morphMany('warehouse\Models\Vendorrate', 'vendorrateable');
    }

    public function city()
    {
      return $this->morphMany(City::class, 'citiesable');
    }

    public function district()
    {
      return $this->morphMany('warehouse\Models\District', 'districtable');
    }
}
