<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = "services";

    public function sub_services(){
        return $this->hasMany('warehouse\Models\Sub_service');
    }

    public function warehouse_order(){
        return $this->hasMany('warehouse\Models\Warehouse_order','id');
    }

}
