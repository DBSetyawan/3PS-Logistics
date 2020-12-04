<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    public function district(){
        return $this->belongsTo('warehouse\Models\District');
    }
}
