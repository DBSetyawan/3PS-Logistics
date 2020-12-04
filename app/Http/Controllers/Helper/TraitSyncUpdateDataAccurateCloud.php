<?php

namespace warehouse\Http\Controllers\Helper;

Trait TraitSyncUpdateDataAccurateCloud
{
    
    public function GetallListDBAccurateCloud(){
        return $this->CallAccurate->AccurateCloudpatternDBLIST();
    }

    public function UpdateSyncBarangJasa($CodeItem, $Qty, $Cost){
        return $this->CallAccurate->__getBarangJasa($CodeItem, $Qty, $Cost);
    }

    public function UpdateSyncBarangJasaCustomer($CodeItem, $Qty, $Cost, $name){
        return $this->CallAccurate->__getBarangJasaCustomers($CodeItem, $Qty, $Cost, $name);
    }

    public function UpdateSyncBarangJasaVendor($CodeItem, $Qty, $Cost, $name){
        return $this->CallAccurate->__getBarangJasaVendors($CodeItem, $Qty, $Cost, $name);
    }

    public function MasterUpdateSyncBarangJasa($CodeItem, $Qty, $Cost){
        return $this->callFromDataCustomer->__getBarangJasa($CodeItem, $Qty, $Cost);
    }

    public function MasterUpdateSyncBarangJasaV($CodeItem, $Qty, $Cost){
        return $this->callFromDataVendor->__getBarangJasa($CodeItem, $Qty, $Cost);
    }

    public function getSyncBarangJasa($CodeItem, $_TS){
        return $this->callFromDataCustomer->getQtyBarangJasa($CodeItem, $_TS);
    }

    public function getSyncSatuanBarangJasa($CodeItem, $_TS){
        return $this->callFromDataCustomer->getSyncSatuanBarangJasa($CodeItem, $_TS);
    }

    public function UpdateSyncSQ($CodeSQ, $Qty, $price, $Comments){
        return $this->CallAccurate->getSQnumber($CodeSQ, $Qty, $price, $Comments);
    }

    public function ResetSyncDetailItemSO($CodeSQ, $branch_id, $itemNo, $itemID, $transport_id){
        return $this->CallAccurate->__ResetDetailItem($CodeSQ, $branch_id, $itemNo, $itemID, $transport_id);
    }

    public function UpdateSyncSO($arritemID, $branch_id, $pelanggan, $id, $Shipment, $PO, $Qty, $Comments, $price, $itemIDinternalaccurate){
        return $this->CallAccurate->getSOnumber($arritemID, $branch_id, $pelanggan, $id, $Shipment, $PO, $Qty, $Comments, $price, $itemIDinternalaccurate);
    }

    public function UpdateSynCustomers($idcustomers, $namaPelanggan){
        return $this->callSignRepos->UpdateCustomers($idcustomers, $namaPelanggan);
    }

    public function UpdateSynCPemasok($code, $name){
        return $this->callVsignRepos->__getPemasok($code, $name);
    }

}


