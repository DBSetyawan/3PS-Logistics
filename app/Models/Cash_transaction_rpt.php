<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Cash_transaction_rpt extends Model
{
    protected $table = "cash_advanced_report";

    protected $fillable = ['job_id','category_cost_id','amount','status','cash_advanced_id','driversid'];

    public function status_cash_advanced(){

        return $this->belongsTo('warehouse\Models\Status_cash_advance','status');

    }

    public function categorys(){

        return $this->belongsTo('warehouse\Models\Category_cost','category_cost_id');

    }

    public function jobs_shipments(){

        return $this->belongsTo('warehouse\Models\Job_transports','job_id');

    }

}
