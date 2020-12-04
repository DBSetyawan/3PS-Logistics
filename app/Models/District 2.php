<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'districts';

    protected $fillable = ["id","city_id","name"];

    public function city(){
        return $this->belongsTo('warehouse\Models\City');
    }

    public function cit(){
        return $this->hasMany('warehouse\Models\City','city_id');
    }

    public function villages(){
        return $this->hasMany('warehouse\Models\Village');
    }

    //polimorhpsym
    public function districtable()
    {
      return $this->morphTo();
    }

    public function originable()
    {
      return $this->morphMany(Vendorrate_truck::class,'originable');
    }

    public function vendorrate_truck()
    {
      return $this->morphMany('warehouse\Models\Vendorrate_truck', 'originable');
    }

    public function vendorrate_nextweights()
    {
      return $this->morphMany('warehouse\Models\Vendorrate_nextweight', 'originable');
    }

    public function vendorrate_minweight()
    {
      return $this->morphMany('warehouse\Models\Vendorrate_minweight', 'originable');
    }

    public function vendorrate_trucks()
    {
      return $this->morphMany('warehouse\Models\Vendorrate_truck', 'destinationable');
    }

    public function vendorrate_nextweight()
    {
      return $this->morphMany('warehouse\Models\Vendorrate_nextweight', 'destinationable');
    }

    public function vendorrate_minweights()
    {
      return $this->morphMany('warehouse\Models\Vendorrate_minweight', 'destinationable');
    }
    
   
}
