<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Role_branch extends Model
{
    protected $table = 'role_branch';
    protected $fillable = ["user_id","role_id","branch_id"];

    public $timestamps = false;

    public function modelhasrole()
    {
        return $this->belongsTo('warehouse\Models\Roles','role_id');
    }

    public function modelhasbranch()
    {
        return $this->belongsTo('warehouse\Models\Company_branchs','branch_id');
    }

    public function modelhasuser()
    {
        return $this->belongsTo('warehouse\User','user_id');
    }

}
