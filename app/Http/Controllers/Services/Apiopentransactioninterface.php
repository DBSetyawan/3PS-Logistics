<?php

namespace warehouse\Http\Controllers\Services;

interface Apiopentransactioninterface
{
    
    public function getOpenWarehouseWithBranchId($id);

    public function getBranchIdWithdynamicChoosenBrach($id);

    public function cekAllRoleBranchAccessPoint($id);

}
