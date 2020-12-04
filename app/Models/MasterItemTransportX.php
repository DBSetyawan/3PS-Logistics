<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class MasterItemTransportX extends Model
{
    protected $table = "master_item_transports";

    protected $guarded = [];
    protected $fillable = ["item_code","origin","destination","userid","ship_category","itemIDaccurate",
    "itemovdesc","unit","sub_service_id","moda","customer_id","flag","itemID_accurate","vendor_id"];
    
    public function item_transport_customer(){
        return $this->hasMany(Item_transport::class, 'referenceID');
    }

    public function batchItemMasterItemTransport(){
        return $this->hasMany(Batchs_transaction_item_customer::class, 'itemID');
    }

    public function batchItemMasters(){
        return $this->hasMany(Batchs_transaction_item_customer::class, 'id');
    }

    public function item_transport_vendor(){
        return $this->hasMany(Vendor_item_transports::class, 'referenceID');
    }

    public function sub_services(){
        return $this->belongsTo(Sub_service::class, 'sub_service_id');
    }

    public function modas(){
        return $this->belongsTo(Moda::class, 'sub_service_id');
    }

    public function customers(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function vendors(){
        return $this->belongsTo(Vendor::class, 'vendor_id');
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

    // just call with propetry on controller [with] instead [load] mode
    public function load($relations) :string
    {
        $query = $this->newQuery()->with(
            is_string($relations) ? func_get_args() : $relations
        );

        $query->eagerLoadRelations([$this]);

        return $this;
    }

    public static function UpdateOrInserted(array $attributes, array $values = array())
    {
        $instance = static::firstOrNew($attributes);

        $instance->fill($values)->save();

        return $instance;
    }

}
