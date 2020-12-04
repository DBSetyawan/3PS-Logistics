<?php

namespace warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $table = "vehicles";
    protected $fillable = ["registrationNumberPlate","nameOfOwner","ownerAddress","brand",
    "type","model","manufactureYear","cylinderCapacity","vehicleIdentificationNumber","engineNumber",
    "color","typeFuel","licensePlateColor","registrationYear","vehicleOwnershipDocumentNumber","locationCode","users_company_id",
    "registrationQueNumber","dateOfExpire"];

    public function companys_branch(){
        return $this->belongsTo('warehouse\Models\Company_branchs','position');
    }
    public function vehicles_number(){
        return $this->belongsTo('warehouse\Models\Vehicle_number','id');
    }
    public function vehicles_type(){
      return $this->belongsTo('warehouse\Models\Vehicle_type','vehicle_type_id');
    }
    public function vehicle_records(){
      return $this->hasMany('warehouse\Models\Vehicle_record','id');
    }
    public function vehicle_alerts(){
      return $this->belongsTo('warehouse\Models\Vehicle_alert','id');
    }

}
