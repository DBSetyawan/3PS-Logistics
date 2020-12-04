<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;
use warehouse\Scope\ShippingScope;

class Jobs_transaction_detail extends Model
{
    protected $table = "jobs_transaction_details";

    protected $fillable = ['id','job_id','shipment_id','file_list_pod',
    'status_detail_shipment_id','shipping_to','id_shipment'];

    // protected $dates = ['created_at','updated_at'];
    protected $casts = [
        'file_list_pod' => 'array'
    ];

    public function job_transports(){
        return $this->belongsTo(Job_transports::class,'job_id')->latest();
    }

    public function job_transports_normalize(){
        return $this->belongsTo(Job_transports::class,'job_id');
    }

    public function scopeJobTransportsdas($query, $userid){
        return $query->join('job_transport', function($join) use ($userid)
            {
                $join->on('jobs_transaction_details.job_id', '=', 'job_transport.id')
                    ->where('job_transport.by_users', $userid);

            });
            
    }

    public function scopeSearchTcUsers($query, $userid){
        return $query->join('job_transport', function($join) use ($userid)
            {
                $join->on('jobs_transaction_details.job_id', '=', 'job_transport.id')
                    ->where('job_transport.by_users', $userid);

            });
            
    }

    public function transport_shipment_status(){
        return $this->belongsTo(Transports_orders_statused::class,'status_detail_shipment_id');
    }

    public function transports(){
        return $this->belongsTo('warehouse\Models\Transport_orders','id_shipment');
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ShippingScope('shipping_to', 'asc'));
    }

}
