<?php

namespace warehouse\Repositories;

use warehouse\Repositories\AccurateCloudRepos;
use warehouse\Http\Controllers\TestGenerator\CallSignature;
use warehouse\Http\Controllers\Services\AccurateCloudmodules;

class AccurateCloudRepositoryEloquent extends AccurateCloudmodules implements AccurateCloudRepos
{   
    use CallSignature;
    
    private $cloneClass;
    private $invokeTest;

    protected $moduleAccurateCloud;
    
    /**
    * @method form params
    */
    public function AccurateCloudpatternDBLIST()
    {

        return response()->json(
            ['data' =>$this->FuncOpenmoduleAccurateCloudDblist(
                            $this->_TS()
                        )
                    ->original['d'][0]
            ]
        );

    }

    /**
     * search primary id SQ number
      * @method GET 
    */
    public function getSQnumber($CODESQ, $kuantitas, $price, $Comments)
    {
        $segmentBodyListSalesQuotation = $this->FuncOpenmoduleAccurateCloudListSalesQoutation($CODESQ);
        $id_SQ = $segmentBodyListSalesQuotation->getData('+');

        $segmentBodyDetailSalesQuotation = $this->FuncOpenmoduleAccurateCloudDetailSalesQoutation($id_SQ, $this->_TS());
        $detailIDSQ_number = $this->FuncOpenmoduleAccurateCloudDetailSalesQoutation($id_SQ, $this->_TS());

        $code_SQ = $detailIDSQ_number->getData('+')["d"]["number"];
        $priamryIDSQ = $detailIDSQ_number->getData('+')["d"]["id"];
        $data = $detailIDSQ_number->getData('+')["d"];
        $detailItem = $detailIDSQ_number->getData('+')["d"]["detailItem"][0]["id"];

        return $this->FuncOpenmoduleAccurateCloudUpdateSalesQoutation($kuantitas, $id_SQ, $detailItem, $price, $Comments);
    }

    /**
     * search primary id SO number
      * @method GET 
    */
    public function getSOnumber($arritemID, $branch_id, $dataPemesan, $id, $CodeSHipment, $POCODES, $Qty, $Comments, $price, $itemIDinternalaccurate)
    {
      $segmentBodyListSalesOrders = $this->FuncOpenmoduleAccurateCloudListSalesOrders($CodeSHipment);
      $id_SO = $segmentBodyListSalesOrders->getData('+');

      $listerFetchIDPRIMARY = $this->FuncOpenmoduleAccurateCloudDetailSalesOrders($id_SO, $this->_TS());

      
      $Accurateid_codeSO = $listerFetchIDPRIMARY->getData('+')["d"]["number"];
      $Accurateid_SO = $listerFetchIDPRIMARY->getData('+')["d"]["id"];
      $data = $listerFetchIDPRIMARY->getData('+')["d"];
      $detailItemIDarray = $listerFetchIDPRIMARY->getData('+')["d"]["detailItem"];

        foreach ($detailItemIDarray as $key => $value) {
            # code...
            $detailItemID[] = $value['id'];
        }

      return $this->FuncOpenmoduleAccurateCloudUpdateSalesOrders($arritemID, $branch_id, $dataPemesan, $id, $Comments, $POCODES, $id_SO, $detailItemID, $Qty, $price, $itemIDinternalaccurate, $Accurateid_SO);
    }

    public function __ResetDetailItem($CodeSHipment, $branch_id, $itemNo, $itemID, $transport_id)
    {
      $segmentBodyListSalesOrders = $this->FuncOpenmoduleAccurateCloudListSalesOrders($CodeSHipment);
      $id_SO = $segmentBodyListSalesOrders->getData('+');
      $listerFetchIDPRIMARY = $this->FuncOpenmoduleAccurateCloudDetailSalesOrders($id_SO, $this->_TS());
      $Accurateid_SO = $listerFetchIDPRIMARY->getData('+')["d"]["id"];
      $detailItemIDarray = $listerFetchIDPRIMARY->getData('+')["d"]["detailItem"];

        foreach ($detailItemIDarray as $key => $value) {
            # code...
            $detailItemID[] = $value['id'];
        }

      return $this->FuncOpenmoduleAccurateCloudResetDetailItem($Accurateid_SO, $branch_id, $detailItemID, $itemNo, $listerFetchIDPRIMARY, $itemID, $transport_id);
    }

    public function UpdateCustomers($customersNo, $namaPelanggan)
    {

        $segmentBodyListCustomers = $this->FuncOpenmoduleAccurateCloudAllMasterCustomerList($customersNo);
        $IDCustomer = $segmentBodyListCustomers->getData('+')["d"][0]["id"];
        
        $detailData = $this->FuncOpenmoduleAccurateCloudDetailCustomers($IDCustomer, $this->_TS());
        $idPelanggan = $detailData->getData('+')["d"]["id"];
        return $this->FuncOpenmoduleAccurateCloudUpdateCustomer($idPelanggan, $namaPelanggan);
        
    }
    
    public function __getBarangJasa($CodeNumberItemBarang, $Qty, $Cost)
    {
        $segmentBodyListBarangJasa = $this->FuncOpenmoduleAccurateCloudListBarangJasa($CodeNumberItemBarang);
        $ITEMID = $segmentBodyListBarangJasa->getData('+')["d"][0]["id"];
        return $this->FuncOpenmoduleAccurateCloudUpdateBarangJasa($ITEMID, $Qty, $Cost);
    }

    public function __getBarangJasaCustomers($CodeNumberItemBarang, $Qty, $Cost, $name)
    {
        $segmentBodyListBarangJasa = $this->FuncOpenmoduleAccurateCloudListBarangJasa($CodeNumberItemBarang);
        $ITEMID = $segmentBodyListBarangJasa->getData('+')["d"];
        // dd($ITEMID);
        return $this->FuncOpenmoduleAccurateCloudUpdateBarangJasaCustomers($ITEMID, $Qty, $Cost, $name);
    }

    public function __getBarangJasaVendors($CodeNumberItemBarang, $Qty, $Cost, $name)
    {
        $segmentBodyListBarangJasa = $this->FuncOpenmoduleAccurateCloudListBarangJasa($CodeNumberItemBarang);
        $ITEMID = $segmentBodyListBarangJasa->getData('+')["d"];
        // dd($ITEMID);
        return $this->FuncOpenmoduleAccurateCloudUpdateBarangJasaVendors($ITEMID, $Qty, $Cost, $name);
    }

    public function getQtyBarangJasa($CodeNumberItemBarang, $_TS)
    {
        $segmentBodyListBarangJasa = $this->FuncOpenmoduleAccurateCloudListBarangJasa($CodeNumberItemBarang);
        $ITEMID = $segmentBodyListBarangJasa->getData('+')["d"][0]["id"];
        $detailDataBarangjasa = $this->FuncOpenmoduleAccurateCloudDetailBarangJasa($ITEMID, $_TS);
        $totalQuantity = $detailDataBarangjasa->getData('+')["d"]["totalUnit1Quantity"];
        return $totalQuantity;
    }

    public function getSyncSatuanBarangJasa($CodeNumberItemBarang, $_TS)
    {
        $segmentBodyListBarangJasa = $this->FuncOpenmoduleAccurateCloudListBarangJasa($CodeNumberItemBarang);
        $ITEMID = $segmentBodyListBarangJasa->getData('+')["d"][0]["id"];
        $detailDataBarangjasa = $this->FuncOpenmoduleAccurateCloudDetailBarangJasa($ITEMID, $_TS);
        return $detailDataBarangjasa->getData('+')["d"]["unit1"]["name"];
    }

    public function __getPemasok($CodeNumberPemasok, $name)
    {
        $segmentBodyListPemasok = $this->FuncOpenmoduleAccurateCloudListPemasok($CodeNumberPemasok);
        $ITEMID = $segmentBodyListPemasok->getData('+');
        $detailDataPemasok = $this->FuncOpenmoduleAccurateCloudDetailPemasok($ITEMID);
        $poor = $detailDataPemasok->getData('+')["d"]["id"];
        return $this->FuncOpenmoduleAccurateCloudUpdatePemasok($poor, $name);
    }

    protected function _TS()
    {
        return $this->GeneratorFetchJustTime()->getData('+')['_ts'];
    }

    /**
    * update primary id DO number
    * @method POST 
    */
    public function getDOnumber()
    {
        //do something else with when data status done ?
    }
    
}
