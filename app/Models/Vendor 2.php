<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
  use SoftDeletes;

    protected $table = "vendors";
    protected $dates = ['deleted_at'];

    protected $fillable = ["website", "status_id","industry_id","tax_phone","fax","email","an_bank","term_of_payment","norek","users_company_id",
      "nama_pic", "no_pic", "bank_name","title_name_pic" , "city_npwp","fax_npwp" ,"phone","address_npwp", "no_npwp","vendor_id","company_name","created_at",
      "updated_at","zip_code","since", "users_permissions", "director", "address","itemID_accurate","vendorTaxType","PNGHN_country","PNGHN_province",
      "PNGHN_city","PNGHN_alamat","no_phone_npwp", "fax", "type_of_business", "city_id","tax_no","tax_address","tax_city","tax_fax", "id"];

    public function status(){
        return $this->belongsTo('warehouse\Models\Vendor_status');
    }

    public function city(){
        return $this->belongsTo('warehouse\Models\City');
    }

    public function industry(){
      return $this->belongsTo('warehouse\Models\Industrys');
    }

    public function vendor_pics(){
      return $this->hasMany('warehouse\Models\Vendor_pics');
    }

    public function mobileusers(){
        return $this->belongsToMany('warehouse\Models\MobileUser');
    }

    public function vendorrate(){
        return $this->hasMany('warehouse\Models\Vendorrate','id');
    }

    public function check_users_permissions(){
      return $this->belongsTo('warehouse\User','users_permissions');
    }

    public function vendor_item_transports(){
        return $this->hasMany('warehouse\Models\Vendor_item_transports','id');
    }

    public function job_transports_vendor_pivot(){
        return $this->belongsToMany('warehouse\Models\Vendor', 'vendor_id');
    }

    public function MasterItemAccurate(){
        return $this->hasMany(Vendor::class, 'vendor_id');
    }

}
