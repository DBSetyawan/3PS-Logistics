<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Warehouse_order extends Model
{
    
    use SoftDeletes;

    protected $table = "warehouse_orders";
    protected $dates = ["created_at","update_at","deleted_at"];


    protected $fillable = ["id","order_id","service_id","company_branch_id",
    "customer_id_warehouse","usersid","sub_services_id_warehouse","contract_no",
    "remark","rate","volume","wom","status_order_id","tgl_kegiatan","itemno","start_date",
    "end_date","total_rate","sales_order_id"];

    protected $casts = ['total_rate' =>'float'];

    public function district(){
        return $this->belongsTo('warehouse\Models\District');
    }

    public function warehouse_o_status(){
        return $this->belongsTo('warehouse\Models\Warehouse_order_status','status_order_id');
    }

    public function company_branch(){
        return $this->belongsTo('warehouse\Models\Company_branchs','company_branch_id');
    }

    public function customers_warehouse(){
        return $this->belongsTo('warehouse\Models\Customer','customer_id_warehouse');
    }

    public function sub_service(){
        return $this->belongsTo('warehouse\Models\Sub_service','sub_services_id_warehouse');
    }

    public function service_house(){
        return $this->belongsTo('warehouse\Models\Service','service_id');
    }

    public function warehouse_order_customer_pics(){
        return $this->belongsToMany('warehouse\Models\Warehouse_order_customer_pic','warehouse_order_customer_pic');
    }

    public function whs_pics(){
        return $this->hasMany('warehouse\Models\Warehouse_order_customer_pic','warehouse_order_id');
    }

    public function cek_status_orders_pic(){
        return $this->hasMany('warehouse\Models\Warehouse_order_status','id');
    }

    public function item_t(){
        return $this->belongsTo(Item::class,'itemno');
    }

    public function users(){
        return $this->belongsTo('warehouse\User','usersid');
    }

    public function sales_name_whs(){
        return $this->belongsTo('warehouse\Models\Sales_order','sales_order_id');
    }

    public function scopeStatusOrderWarehouse($query, $status){
        return $query->join('warehouse_order_status', function($join) use ($status)
            {
                $join->on('warehouse_orders.status_order_id', '=', 'warehouse_order_status.id')
                    ->whereIn('warehouse_order_status.status_name', $status)
                    ->orderByDesc('warehouse_orders.id');
            });
            
    }

    public function scopeStatusOrderWarehouseWithJoins($query, $index){
        return $query->join('warehouse_order_status', function($join) use ($index)
            {
                $join->on('warehouse_orders.status_order_id', '=', 'warehouse_order_status.id')
                    ->whereIn('warehouse_orders.id', [$index]);
            });
            
    }

    public function scopeIdDescending($query)
    {
        return $query->orderByDesc('id','order_id','updated_at');
    } 

     

}
