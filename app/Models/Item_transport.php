<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Item_transport extends Model
{
    protected $table = "item_transports"; //this table alias from item_customer_transport

    public $timestamps = true;
    public $dates = ["created_at","updated_at"];

    protected $fillable = ["item_code","origin","destination","usersid","ship_category","qty",
    "itemovdesc","price","unit","sub_service_id","moda","customer_id","flag","itemID_accurate",
    "referenceID","next_price","batch_itemCustomer","branch_item"];

    protected $casts = array(
        "batch_itemCustomer" => "array"
    );

    public function sub_services(){
        return $this->belongsTo(Sub_service::class, 'sub_service_id');
    }

    public function masteritemtc(){
        return $this->belongsTo(MasterItemTransportX::class, 'referenceID');
    }

    public function transport_orderss(){
        return $this->belongsTo(Transport_orders::class, 'item_transport');
    }

    public function ItemsTransports(){
        return $this->hasMany(Item_transport::class, 'id');
    }

    public function customers(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function BatchItemCustomers(){
        return $this->hasMany(Batchs_transaction_item_customer::class, 'id');
    }

    public function city_show_it_origin(){
        return $this->belongsTo(City::class, 'origin');
    }

    public function city_show_it_destination(){
        return $this->belongsTo(City::class, 'destination');
    }

    public function users(){
        return $this->belongsTo('warehouse\User', 'usersid');
    }

    public static function UpdateOrInserted(array $attributes, array $values = array())
    {
        $instance = static::firstOrNew($attributes);

        $instance->fill($values)->save();

        return $instance;
    }
   
}
