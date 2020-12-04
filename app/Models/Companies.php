<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    protected $table = "companies";
    protected $fillable = ['name','owner_id'];

    public function company_branch(){
      return $this->hasMany('warehouse\Models\Company_branchs','id');
    }

    public function sub_services(){
      return $this->hasMany('warehouse\Models\Sub_service','id');
    }

    public function user(){
      return $this->hasMany('warehouse\User','company_id');
    }

}
