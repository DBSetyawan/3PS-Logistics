<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Customer_pic_status extends Model
{
    protected $table = "customer_pic_status";

    public function customers(){
      return $this->hasMany('\warehouse\Models\Customers');
    }
}
