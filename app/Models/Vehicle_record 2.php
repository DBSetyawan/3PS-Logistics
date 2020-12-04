<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle_record extends Model
{
  use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = "vehicle_records";
    protected $fillable = ["date","id","vehicle_id","vehicle_record_category_id","remark","cost","updated_at"];

    public function vehicles(){
      return $this->belongsTo('warehouse\Models\Vehicle','vehicle_id');
    }
    public function vehicle_record_category(){
      return $this->belongsTo('warehouse\Models\Vehicle_record_categories','vehicle_record_category_id');
    }

}
