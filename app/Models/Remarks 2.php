<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Remarks extends Model
{
    protected $table = "remark";

    public function sub_services(){
        return $this->hasMany('warehouse\Models\Sub_service');
    }

}
