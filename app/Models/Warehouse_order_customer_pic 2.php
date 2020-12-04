<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse_order_customer_pic extends Model
{
    protected $table = "warehouse_order_customer_pic";

    protected $fillable = ["id","warehouse_id","warehouse_order_customer_pic_id","created_at","updated_at"];

    public function warehouse_order(){
        return $this->belongsTo('warehouse\Models\Warehouse_order','warehouse_id');
    }

    public function warehouse_customers_pic(){
        return $this->belongsToMany('warehouse\Models\Customer_pics','warehouse_order_customer_pic_id');
    }

    function pics_whs(){
        return $this->hasMany('warehouse\Models\Warehouse_order','id');
    }

    public function to_do_list_cspics(){
        return $this->belongsTo('warehouse\Models\Customer_pics','warehouse_order_customer_pic_id');
    }

}