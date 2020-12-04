<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse_order_status extends Model
{
    protected $table = "warehouse_order_status";

    public function warehouse_order(){
        return $this->belongsTo('warehouse\Models\Warehouse_order','id');
    }
}
