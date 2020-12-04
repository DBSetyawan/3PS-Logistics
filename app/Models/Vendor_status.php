<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor_status extends Model
{
    protected $table = "vendor_status";

    public function vendors(){
        return $this->hasMany('warehouse\Models\Vendors');
    }
}
