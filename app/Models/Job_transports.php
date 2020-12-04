<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Job_transports extends Model
{
    protected $table = "job_transport";
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = ['job_no','origin_id','destination_id',
    'by_users','user_of_company_branch_id','status','estimated_time_of_delivery',
    'estimated_time_of_arrival','driver_name','plate_number',
    'total_collie','total_volume','total_actual_weight',
    'driver_number','document_reference'];

    public $timestamps = true;

    public function transport_orders(){
        return $this->belongsTo('warehouse\Models\Transport_orders','id');
    }

    public function hallong_vendor_job_transport(){
        return $this->belongsToMany('warehouse\Models\Vendor','vendor_id');
    }

    public function vendors(){
        return $this->belongsTo(Vendor::class,'vendor_id');
    }

    public function companysbranchs_uuid(){
        return $this->belongsTo(Company_branchs::class,'user_of_company_branch_id');
    }

    public function job_costs(){
        return $this->hasMany(Jobs_cost::class,'job_id');
    }

    public function status_vendor_jobs(){
        return $this->belongsTo(Jobs_status::class,'status');
    }

    public function jobtransactiondetil(){
        return $this->hasMany('warehouse\Models\Jobs_transaction_detail','job_id');
    }

    public function cashtransactionrpt(){
        return $this->hasMany('warehouse\Models\Cash_transaction_rpt','job_id');
    }

    public function origin(){
        return $this->belongsTo('warehouse\Models\City','origin_id');
    }

    public function destination(){
        return $this->belongsTo('warehouse\Models\City','destination_id');
    }

}
