<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Container extends Model
{
    protected $table = "containers";
    protected $fillable = ["name","id"];

    public function vehicle_type_detail(){
      return $this->hasMany('warehouse\Models\vehicle_type_detail','id');
    }

}
