<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Vendorrate_nextweight extends Model
{
    protected $table = "vendorrate_nextweights";
    // protected $fillable = ["originable_id","first_weight","first_rate","next_rate","leadTime","ship_category_id"];

    public function vendorratenextweightable()
    {
      return $this->morphTo();
    }

    public function vendors(){
      return $this->belongsTo('warehouse\Models\Vendor');
    }

    public function originable()
    {
      return $this->morphTo();
    }

    public function destinationable()
    {
      return $this->morphTo();
    }

    public function sub_services(){
      return $this->belongsTo('warehouse\Models\Sub_service','sub_services_id');
    }

    public function vendorrate_nextweight()
    {
      return $this->morphTo(Vendorrate_nextweight::class,'vendorrateable','vendorrateable_id');
    }
    
    public function vendorrate()
    {
      return $this->morphMany('warehouse\Models\Vendorrate', 'vendorrateable');
    }

    public function city()
    {
      return $this->morphTo();
    }

    public function district()
    {
      return $this->morphMany('warehouse\Models\District', 'districtable');
    }

}
