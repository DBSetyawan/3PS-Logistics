<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor_pic_status extends Model
{
    protected $table = 'vendor_pic_status';

    public function vendor_pics(){
        return $this->hasMany('warehouse\Models\Vendor_pics');
    }
}
