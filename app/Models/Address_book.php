<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Address_book extends Model
{
    protected $table = "address_book";
    
    protected $fillable = ['id','customer_id','city_id','name',
    'details','address','contact','phone','usersid',
    'pic_name_origin','pic_phone_origin','pic_name_destination','pic_phone_destination','users_company_id'];

    public function citys(){
        return $this->belongsTo('warehouse\Models\City','city_id');
    }

    public function customers(){
        return $this->belongsTo('warehouse\Models\Customer','customer_id');
    }

    public function users(){
        return $this->belongsTo('warehouse\User','usersid');
    }

    public function origins(){
        return $this->hasMany('warehouse\Models\Transport_orders','saved_origin_id');
    }

    public function destinations(){
        return $this->hasMany('warehouse\Models\Transport_orders','saved_destination_id');
    }
    
}
