<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Ship_categorie extends Model
{
    protected $table = "ship_categories";
    protected $fillable = array('name','usersid');

    public function vendorrate_truck(){
        return $this->hasMany('warehouse\Models\Vendorrate_truck','ship_category_id');
    }

    public function users(){
        return $this->belongsTo('warehouse\User','usersid');
    }

}
