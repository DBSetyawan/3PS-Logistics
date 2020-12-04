<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Sub_service extends Model
{
    protected $table = "sub_services";
    protected $fillable = ["company_id","remark","prefix","service_id","name"];
    
      public function service(){
        return $this->belongsTo('warehouse\Models\Service','service_id');
      }

      public function modas(){
        return $this->hasMany('warehouse\Models\Moda','id');
      }

      public function vendorrate_trucks(){
        return $this->hasMany('warehouse\Models\Vendorrate_truck','id');
      }
       
    public function vendorrateable(){
      return $this->hasMany('warehouse\Models\Sub_service','id');
    }

    public function originable()
    {
      return $this->morphTo();
    }

    public function warehouse_order(){
      return $this->hasMany('warehouse\Models\Warehouse_order','id');
    }

    public function remarks(){
      return $this->hasMany('warehouse\Models\Remarks','id');
    }

    public function item(){
      return $this->hasMany(Item::class,'id');
    }

    public function item_transport(){
      return $this->hasMany(Item_transport::class,'id');
    }

    public function companys(){
      return $this->belongsTo(Companies::class,'company_id');
    }

    public function users(){
      return $this->belongsTo('warehouse\User','usersid');
    }

    public function MasterItemAccurate(){
      return $this->hasMany(MasterItemAccurate::class,'sub_service_id');
    }

}