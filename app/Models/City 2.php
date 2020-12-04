<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';

    protected $fillable = ["id","province_id","name","citiesable_id","citiesable_type"];

    public function dis(){
      return $this->belongsTo('warehouse\Models\District','id');
    }

    public function province(){
        return $this->belongsTo('warehouse\Models\Province');
    }

    public function districts(){
        return $this->hasMany('warehouse\Models\District','id');
    }

    public function vendors(){
      return $this->hasMany('warehouse\Models\Vendors');
    }

    //Polimorphysm

    public function districtable()
    {
      return $this->morphMany(Vendorrate_truck::class,'destinationable');
    }

    public function citiesable()
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

    public function address_books_origin(){
      return $this->hasMany('warehouse\Models\Address_book','id');
    }

    public function vendor_items_transport(){
      return $this->hasMany('warehouse\Models\Vendor_item_transports','id');
    }

    public function city_jb(){
      return $this->hasMany('warehouse\Models\Job_transports','origin_id');
    }

    public function destination_jb(){
      return $this->hasMany('warehouse\Models\Job_transports','destination_id');
    }

    public function origin_tc(){
      return $this->hasMany('warehouse\Models\Transport_orders','saved_origin_id');
    }

    public function destination_tc(){
      return $this->hasMany('warehouse\Models\Transport_orders','saved_destination_id');
    }
  
}
