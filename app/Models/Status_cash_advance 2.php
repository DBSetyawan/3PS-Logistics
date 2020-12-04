<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Status_cash_advance extends Model
{
    protected $table = "status_cash_advanced";

    public function cashadvanced(){

        return $this->hasMany('warehouse\Models\cashadvanced','status');

    }

    public function cash_transaction(){

        return $this->hasMany('warehouse\Models\Cash_transaction_advanced','status');

    }
}
