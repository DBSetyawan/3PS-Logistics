<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class CustomModelUnits extends Model
{
    public $name;
    public $id;

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtoupper($value);
        $this->attributes['id'] = (String) $value;
    }
    

}
