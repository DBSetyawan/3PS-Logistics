<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Order_job_transaction_detail_history extends Model
{
    protected $table = "order_job_transaction_detail_histories";
    protected $fillable = ['id','shipment_id','job_no','location','datetime','user_id','notes','status','created_at','updated_at'];
    

    public function user_order_job_shipment_history()
    {
        return $this->belongsTo('warehouse\User','user_id');
    }
}
