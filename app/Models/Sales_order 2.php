<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Sales_order extends Model
{
    protected $table = "sales_order_warehouse";
    protected $fillable = ["*"];
    public $timestamp = true;

    public function warehouse_order(){
        return $this->hasMany('warehouse\Warehouse_order','sales_order_id');
    }

}
