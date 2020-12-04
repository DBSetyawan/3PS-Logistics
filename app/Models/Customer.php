<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{

  use SoftDeletes;

    protected $table = "customers";
    protected $dates = ['deleted_at'];

    protected $fillable = ["customer_id","itemID_accurate3PL","branch_item","customerID3PL","no_rek","bank_name","an_bank","company_id","personno",
    "term_of_payment","name", "industry_id","since","director","address","city_id","customerTaxType","ops_kodepos","provinceops",
    "phone","fax","email", "website", "tax_no", "tax_address","tax_city" , "tax_phone","itemID_accurate","PNGHN_alamat","PNGHN_city","PNGHN_province","PNGHN_country",
    "tax_fax" ,"status_id","created_at","updated_at","project_id","users_permissions","userWithToken"];

    public function industry(){
      return $this->belongsTo('warehouse\Models\Industrys');
    }

    public function MasterItemAccurate(){
        return $this->hasMany(Customer::class, 'customer_id');
    }

    public function city(){
        return $this->belongsTo('warehouse\Models\City');
    }

    public function status(){
        return $this->belongsTo('warehouse\Models\Vendor_status');
    }

    public function cstatusid(){
        return $this->belongsTo('warehouse\Models\Customer_status','status_id');
    }

    public function customer_pic(){
        return $this->hasMany('warehouse\Models\Customer_pics');
    }

    public function customer_pic_status(){
        return $this->belongsTo('warehouse\Models\Customer_pic_status');
    }

    public function warehouse_order(){
        return $this->hasMany('warehouse\Models\Warehouse_order','id');
    }

    public function transport_order(){
        return $this->hasMany('warehouse\Models\Transport_orders','id');
    }

    public function check_users_logged_in(){
        return $this->belongsTo('warehouse\User','users_permissions');
    }

    public function customer_item_transport(){
        return $this->hasMany(Item_transports::class,'id');
    }

    public function address_book_releated_this(){
        return $this->hasMany(Address_book::class,'id');
    }

}
