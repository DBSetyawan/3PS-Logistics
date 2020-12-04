<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor_item_transports extends Model
{
    protected $table = "vendor_item_transport";                    
    protected $fillable = [
                            "item_code","origin","destination","usersid","ship_category","qty",
                            "itemovdesc","price","unit","sub_service_id","moda","vendor_id","flag","itemID_accurate",
                            "referenceID","next_price","batch_itemVendor"
                        ];
                    
    public function masteritemtcvendor(){
        return $this->belongsTo(MasterItemTransportX::class, 'referenceID');
    }

    public function sub_services(){
        return $this->belongsTo(Sub_service::class, 'sub_service_id');
    }

    public function scopeSearchVendorItem($query, $r_vendorid, $cost){
        return $query->join('vendors', function($join) use ($r_vendorid, $cost)
            {
                $join->on('vendor_item_transport.vendor_id', '=', 'vendors.id')
                    ->where('vendor_item_transport.vendor_id', '=',$r_vendorid)
                    ->where('vendor_item_transport.price', $cost);
            });

            return $query->join('cities', function($join)
            {
                $join->on('vendor_item_transport.origin', '=', 'cities.id');
            });
    }

    public function scopeSearchCityVendor($query, $r_vendorid, $cost){
        return $query->join('cities', function($join) use ($r_vendorid, $cost)
            {
                $join->on('vendor_item_transport.origin', '=', 'cities.id')
                    ->where('vendor_item_transport.vendor_id', '=',$r_vendorid)
                    ->where('vendor_item_transport.price', $cost);
            });

    }

    public static function UpdateOrInserted(array $attributes, array $values = array())
    {
        $instance = static::firstOrNew($attributes);

        $instance->fill($values)->save();

        return $instance;
    }

    public function scopeFindidVendors($query, $vidx){
        return $query->join('vendors', function($join) use ($vidx)
            {
                $join->on('vendor_item_transport.vendor_id', '=', 'vendors.id')
                    ->where('vendor_item_transport.id', '=',$vidx);
            });

    }

    public function scopeFindidVendorsidx($query, $vidx){
        return $query->join('vendors', function($join) use ($vidx)
            {
                $join->on('vendor_item_transport.vendor_id', '=', 'vendors.id')
                    ->where('vendor_item_transport.vendor_id', '=',$vidx);
            });

    }

    public function city(){
        return $this->belongsTo('warehouse\Models\City','id');
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

    public function users()
    {
        return $this->belongsTo('warehouse\User','usersid');
    }

}
