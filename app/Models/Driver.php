<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $table = "drivers";

    protected $fillable = array('id','name');

    public function cash_advanced(){

        return $this->hasMany('warehouse\Models\cashadvance','id_penerima');

    }

}