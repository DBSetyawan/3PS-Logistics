<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Customer_status extends Model
{
    protected $table = 'customer_status';

    public function customers(){
      return $this->hasMany('warehouse\Models\Customers','id');
    }
}
