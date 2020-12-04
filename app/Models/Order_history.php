<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Order_history extends Model
{
    //
    protected $table = "order_histories";
    protected $fillable =  array('order_id','status','datetime','user_id');

    protected $timestamp = TRUE;


    public function user_order_history()
    {
        return $this->belongsTo('warehouse\User','user_id');
    }
    
}
