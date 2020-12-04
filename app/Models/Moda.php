<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Moda extends Model
{
    protected $table = "modas";
    protected $fillable = ["name","capacity","tonase","usersid","sub_service_id_fk"];

    public function users()
    {
        return $this->belongsTo('warehouse\User','usersid');
    }

    public function sub_services()
    {
        return $this->belongsTo('warehouse\Models\Sub_service','sub_service_id_fk');
    }

    public function MasterItemAccurate()
    {
        return $this->hasMany(MasterItemTransportX::class,'sub_service_id_fk');
    }

}
