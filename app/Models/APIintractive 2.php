<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class APIintractive extends Model
{
    protected $table = "api_interactive";
    
    protected $fillable = ['id','check_is','operation'];

    public $timestamps = false;
}
