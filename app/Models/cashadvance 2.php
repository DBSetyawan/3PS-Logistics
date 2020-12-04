<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class cashadvance extends Model
{
    protected $table = "cash_advanced";
    protected $fillable = ['id','id_penerima','id_pemberi','status','amount','selisih','report_amount'];

    public function status_advanced(){

        return $this->belongsTo('warehouse\Models\Status_cash_advance','status');

    }

    public function drivers_master(){

        return $this->belongsTo('warehouse\Models\Driver','id_penerima');

    }
}
