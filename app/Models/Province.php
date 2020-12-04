<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = "provinces";

    public function cities(){
        return $this->hasMany('warehouse\Models\City');
    }
}
