<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $table = 'roles';

    public function modelhasrole()
    {
        return $this->hasMany('warehouse\Models\model_hasRoles');
    }

    public function modeltorole(){
        return $this->hasMany('warehouse\Models\Role_branch','role_id');
    }
}
