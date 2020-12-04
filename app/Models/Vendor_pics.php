<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor_pics extends Model
{

  protected $table = 'vendor_pics';

  protected $fillable = [
        "name","vendor_id","vendor_pic_status_id","position","email","phone","mobile_phone"
    ];

  public function vendor_pic_status(){
      return $this->belongsTo('warehouse\Models\Vendor_pic_status');
  }

  public function vendor(){
    return $this->belongsTo('warehouse\Models\Vendor');
  }

}
