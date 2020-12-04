<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Jobs_status extends Model
{
    protected $table = "job_status";

    public function job_transports(){
        return $this->hasMany('warehouse\Models\Job_transports','status');
    }
}
