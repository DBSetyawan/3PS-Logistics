<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Vendorrate extends Model
{
    protected $table = "vendorrates";
    protected $fillable = ["vendor_id","sub_services","vendorrateable_id","vendorrateable_type"];

    public function vendorrateable()
    {
      return $this->morphTo();
    }
    
    public function sub_services(){
      return $this->belongsTo('warehouse\Models\Sub_service','sub_services_id');
    }

    public function vendors(){
      return $this->belongsTo('warehouse\Models\Vendor','vendor_id');
    }

  public function Vendorrate_trucks()
  {
    return $this->morphMany('warehouse\Models\Vendorrate_truck', 'vendorratetruckable');
  }

  public function Vendorrate_nextweights()
  {
    return $this->morphMany('warehouse\Models\Vendorrate_nextweight', 'vendorratenextweightable');
  }

  public function Vendorrate_minweight()
  {
    return $this->morphMany('warehouse\Models\Vendorrate_minweight', 'vendorrateminweightable');
  }
  
}
