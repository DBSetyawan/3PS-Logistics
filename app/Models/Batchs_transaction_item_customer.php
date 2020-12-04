<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Batchs_transaction_item_customer extends Model
{
    protected $table = "batch_transaction_item_customer"; //this table alias from item_customer_transport

    protected $fillable = ['transport_id','itemID','qty','harga','detailnotes','cash_discount'];
    public $incrementing = true;
    public $timestamps = false;

    public function transportsIDX(){
        return $this->belongsTo('warehouse\Models\Transport_orders', 'transport_id');
    }

    public function masterItemIDACCURATE(){
        return $this->belongsTo('warehouse\Models\Item_transport', 'itemID');
    }

    public static function UpdateOrInserted(array $attributes, array $values = array())
    {
        $instance = static::firstOrNew($attributes);

        $instance->fill($values)->save();

        return $instance;
    }

}
