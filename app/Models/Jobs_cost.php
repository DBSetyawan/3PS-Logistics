<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jobs_cost extends Model
{
    // use SoftDeletes;

        protected $table = "job_costs";
        protected $fillable = ['id','vendor_item_id','job_cost_id','job_id','cost_id','cost','by_users','note','driver_name','plat_number','driver_number','doc_reference'];
        protected $dates = ['created_at','updated_at'];

        // protected $dates = ['deleted_at'];

    public function vendor_item_transports(){
        return $this->belongsTo(Vendor_item_transports::class, 'vendor_item_id');
    }

    public function cost_category(){
        return $this->belongsTo(Category_cost::class, 'cost_id');
    }

    public function job_transports(){
        return $this->belongsTo(Job_transports::class, 'job_id');
    }

    public function scopeJobTransports($query, $userid){
        return $query->join('job_transport', function($join) use ($userid)
            {
                $join->on('job_costs.job_id', '=', 'job_transport.id')
                    ->where('job_transport.by_users', $userid);
            });
            
    }

    public function scopeCategoryCost($query){
        return $query->join('cost_categories', function($join)
            {
                $join->on('job_costs.cost_id', '=', 'cost_categories.id');
                
            });

    }

    public function scopeVendorItemTransports($query){
            return $query->join('vendor_item_transport', function ($join) {
                $join->on('job_costs.vendor_item_id', '=', 'vendor_item_transport.id');
            });

    }


}