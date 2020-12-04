<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Company_branchs extends Model
{
    protected $table = "company_branchs";

    protected $fillable = array('branch','company_id');

    public function vehicles(){
        return $this->hasMany('warehouse\Models\Vehicle','vehicle_id');
    }

    public function warehouse_order(){
        return $this->hasMany('warehouse\Models\Warehouse_order','id');
    }

    public function company(){
        return $this->belongsTo('warehouse\Models\Companies','company_id');
    }

    public function user(){
        return $this->hasMany('warehouse\User','company_branch_id');
    }

    public function transports_order(){
        return $this->hasMany('warehouse\Models\Transport_orders','id');
    }

    public function modeltorolebranch(){
        return $this->hasMany('warehouse\Models\Role_branch','branch_id');
    }

    public function jobs_shipments(){
        return $this->hasMany('warehouse\Models\Job_transports','id');
    }
    
    public function scopeBranchs($query, $value)
    {
        return $query->where('id', $value);
    }

    public function scopeUsers($query, $value)
    {
        return $query->where('id', $value);
    }

    public function scopeGlobalMaster($query, $value)
    {
        return $query->where('id', $value);
    }

    public function scopeBranchName($query, $value)
    {
        return $query->where('id', $value);
    }

    public function scopeBranchNameAfterRegister($query, $value)
    {
        return $query->where('id', $value);
    }

    public function scopeBranchJobs($query, $value)
    {
        return $query->where('id', $value);
    }

    public function scopeBranchPermission($query, $value)
    {
        return $query->where('id', $value);
    }

    public function scopeRoles($query, $value)
    {
        return $query->where('id', $value);
    }

    public function scopeBranchWarehouse($query, $value)
    {
        return $query->where('id', $value);
    }

    public function branchs()
    {
        return $this->hasMany(User::class, 'company_branch_id');
    }

}
