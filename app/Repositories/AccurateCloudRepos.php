<?php

namespace warehouse\Repositories;

interface AccurateCloudRepos
{
   
    public function AccurateCloudpatternDBLIST();

    public function getSQnumber(
                                        $CodeSHipment,
                                        $QTY,
                                        $price,
                                        $Comments
                            );

    public function getSOnumber(
                                        $arritemID,
                                        $branch_id,
                                        $pelanggan,
                                        $id,
                                        $CodeSHipments,
                                        $POCODES,
                                        $QTY,
                                        $Comments,
                                        $price,
                                        $itemIDInternalaccurate
                            );

    public function __ResetDetailItem(Int $codeshipments, $branch_id, String $itemNo, String $itemID, String $transport_id);
                            
    public function getDOnumber();

    public function UpdateCustomers(
                                        String $customersNo,
                                        String $Pelanggan 
                            );
                            
    public function __getBarangJasa(

                                        $CodeNumberBarang,
                                        $Qty,
                                        $Cost

                            );

        public function __getBarangJasaCustomers(

                $CodeNumberBarang,
                $Qty,
                $Cost,
                $name

        );

        public function __getBarangJasaVendors(

                $CodeNumberBarang,
                $Qty,
                $Cost,
                $name

        );


    public function getQtyBarangJasa(

                                    String $CodeNumberBarang,
                                    $_TS

                            );

    public function getSyncSatuanBarangJasa(

                                    $CodeNumberBarang,
                                    $_TS
 
                            );

    public function __getPemasok(

                                        $CodeNumberBarang,
                                        $name

                        );

}