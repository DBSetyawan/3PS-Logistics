<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class model_hasRoles extends Model
{
    protected $table = "model_has_roles";
    
    public function model_type()
    {
        return $this->morphTo('model_type');
    }
    
}