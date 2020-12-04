<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Customer_pics extends Model
{
    protected $table = "customer_pics";
    protected $fillable = ["id","name","customer_id","customer_pic_status_id",
    "position","email","email","phone","mobile_phone"];

    public function customers(){
      return $this->belongsTo('warehouse\Models\Customers');
    }
  
}
