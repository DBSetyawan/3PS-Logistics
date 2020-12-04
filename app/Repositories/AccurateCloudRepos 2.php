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

                                        $CodeSHipments,
                                        $POCODES,
                                        $QTY,
                                        $Comments,
                                        $price

                            );

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