<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = "items";
    protected $fillable = ["itemno","itemovdesc","unit","price","flag",
    "sub_service_id","by_user_permission_allows","items_by_customer"];

    public function sub_service(){
        return $this->belongsTo('warehouse\Models\Sub_service','sub_service_id');
    }

    public function warehouse_order(){
        return $this->hasMany('warehouse\Models\Warehouse_order','id');
    }

    public function check_users_logged_in(){
        return $this->belongsTo('warehouse\User','id');
    }

}