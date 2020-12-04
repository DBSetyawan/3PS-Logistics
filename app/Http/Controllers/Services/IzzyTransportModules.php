<?php

 /**
 * [Author] Developer PT. 3 permata logistik. API Received webhooks from izzy transport.
 *
 * @param  \warehouse\Http\Controllers\Services\IzzytransportsHooks  $APIClient
 * @param  Interface @POD @POP @CREATE
 * @return \Illuminate\Http\Response $responseString
 */

namespace warehouse\Http\Controllers\Services;

use Auth;
use Carbon\Carbon;
use warehouse\User;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Promise\EachPromise;
use Illuminate\Support\Facades\Bus;
use warehouse\Jobs\HWBhooksCreated;
use warehouse\Jobs\WHMhooksCreated;
use warehouse\Jobs\HVHHookTransport;
use warehouse\Jobs\FHCreatedWebhooks;
use warehouse\Jobs\HandleJobsCreated;
use warehouse\Jobs\MoackUpHandlewebs;
use warehouse\Jobs\FuncWebhookCreated;
use warehouse\Models\Transport_orders;
use Illuminate\Support\Facades\Artisan;
use warehouse\Jobs\FuncWebhooksCreated;
use warehouse\Jobs\WhooksHandleCreated;
use warehouse\Jobs\HMVMCreatedTransport;
use warehouse\Jobs\HVMGWebhookTransport;
use Illuminate\Database\Schema\Blueprint;
use warehouse\Jobs\HMethodCreatedWebhook;
use warehouse\Jobs\HVMJWebhooksTransport;
use warehouse\Jobs\HVNMWebhooksTransport;
use warehouse\Jobs\HVVMWebhooksTransport;
use warehouse\Jobs\HWVHooksPODTransports;
use warehouse\Jobs\HWVHooksPoPTransports;
use warehouse\Jobs\MethodCreatedWebhooks;
use warehouse\Http\Controllers\Controller;
use warehouse\Jobs\HandleIzzyTransportPOD;
use warehouse\Jobs\HandleIzzyTransportPoP;
use warehouse\Jobs\WebhooksIzyyTransports;
use warehouse\Jobs\HVMVPODWebhookTransport;
use warehouse\Jobs\HVVMPoPWebhookTransport;
use warehouse\Jobs\HWVHooksCreatedTransports;
use warehouse\Jobs\HandleIzzyTransportCreated;
use warehouse\Jobs\HWVMCHooksCreatedTransprot;
use warehouse\Models\Batchs_transaction_item_customer;
use warehouse\Http\Controllers\Services\IzzytransportsHooks;
use warehouse\Http\Controllers\Services\AccuratecloudInterface;
use warehouse\Models\Order_transport_history as TrackShipments;
use warehouse\Http\Controllers\ManagementController as RESTAPIs;


class IzzyTransportModules extends Controller implements IzzytransportsHooks
{

    protected $openModulesAccurateCloud;
    protected $REST;
    public $datenow;
    protected $transport;
    protected $batch_item;
    
    private $tbl_transport;

    public function __construct(
                                    Request $REST,
                                    AccuratecloudInterface $APInterfacecloud,
                                    Transport_orders $TBLT,
                                    Batchs_transaction_item_customer $batch_item
                            )
    {

        $this->openModulesAccurateCloud = $APInterfacecloud;
        $this->rest = $REST;
        $this->tbl_transport = $TBLT;
        $this->batch_item = $batch_item;
        $this->transport = New Transport_orders;
        $this->datenow = date('d/m/Y');

    }


    protected function DataTransportID($shipment_code){

        $fetch_data = Transport_orders::whereIn('order_id', [$shipment_code])
                                ->with(['customers','itemtransports.masteritemtc'])
                                    ->get();
                
                return collect($fetch_data->toArray())->map(function ($data){

                    return $data;
                
                }
            )
        ;
            
    }

    public function ProcessingResponse(Transport_orders $tc, $response, $shipment_code){
        
        if($response == "CREATE"):
                
                MoackUpHandlewebs::dispatch($shipment_code, Auth::User()->id);
                // return response()->json(WHMhooksCreated::dispatch($shipment_code, Auth::User()->id)->delay(now()->addSeconds(3)));
                return response()->json("shipment_CREATE");

        endif;

                if($response == "POP"):
                    
                    HVVMPoPWebhookTransport::dispatch($shipment_code, Auth::User()->id);
                    return response()->json("shipment_PoP");

                endif;

            if($response == "POD"): 

                    HVMVPODWebhookTransport::dispatch($shipment_code, Auth::User()->id);
                    // return response()->json(Bus::dispatch(new HandleIzzyTransportPOD($shipment_code)));

                return response()->json("shipment_POD");

            endif;

    }

    public function ReSyncAccurateDelivery(Transport_orders $tc, $shipment_code){ 

        $primaryShipment = $tc->whereIn('order_id', [$shipment_code])->with(['customers','itemtransports.masteritemtc'])->first();
        $fetch_data = $tc->whereIn('order_id', [$shipment_code])->with(['customers','itemtransports.masteritemtc'])->get();
         $fetchBatchItemOrderDetail = $this->batch_item
            ->with(['transportsIDX','masterItemIDACCURATE'])
                ->whereIn('transport_id',[$primaryShipment->id])
                    ->get();
         
         foreach($fetchBatchItemOrderDetail as $key => $thisdataBatchItemTransports){
             
             $transport_id[] = $thisdataBatchItemTransports->transport_id;
             $itemTRANSPORT[] = $thisdataBatchItemTransports->masterItemIDACCURATE->itemID_accurate;
             $itemName[] = $thisdataBatchItemTransports->masterItemIDACCURATE->itemovdesc;
             $qty[] = $thisdataBatchItemTransports->qty;
             $hargaID[] = $thisdataBatchItemTransports->harga;
             $detailnotes[] = $thisdataBatchItemTransports->detailnotes;
             $itemDiscount[] = $thisdataBatchItemTransports->cash_discount;
             $unitName[] = $thisdataBatchItemTransports->masterItemIDACCURATE->unit;
             
           }

           foreach($fetch_data as $key => $thisDataTransports){

                $order_id[] = $thisDataTransports->order_id;
                $status_order__[] = $thisDataTransports->status_order_id;
                $dataARRXCUSTOMER[] = $thisDataTransports->customers->itemID_accurate;
                $dataARRXITEMTRANSPORT[] = $thisDataTransports->itemtransports->masteritemtc->itemID_accurate;
                $SalesQuotationNumber[] = $thisDataTransports->recovery_SQ;
                $dataHARGA[] = $thisDataTransports->harga;
                $dataARRXQTITY[] = $thisDataTransports->quantity;
                $dataARRXITEMTRANSPORTITEMUNIT[] = $thisDataTransports->itemtransports->unit;
                $SalesOrdersNumber[] = $thisDataTransports->recovery_SO;

           }

                $AccurateCloud = $this->openModulesAccurateCloud
                    ->FuncOpenmoduleAccurateCloudSaveDeliveryOrders(
                        'DO.'.$order_id[0],
                        $dataARRXCUSTOMER[0],
                        $this->datenow,
                        $itemTRANSPORT,
                        $SalesQuotationNumber[0],
                        $SalesOrdersNumber[0],
                        $unitName,
                        $qty,
                        $hargaID,
                        $transport_id,
                        $detailnotes

                );

                $DO = $AccurateCloud->getData('+');

                $CEKDO  = isset($DO["d"][0]["r"]) 
                        ? $DO["d"][0]["r"] 
                        : [];
                
                $checkAsync = collect($CEKDO)->isEmpty();

                if($checkAsync == true):

                    $tc->whereIn('order_id', [$order_id[0]])->update(
                                [
                                    'sync_accurate' => "true"
                                ]
                            ) 
                        ;
 
                            return response()->json(["response" => "Data gagal dihubungkan ke Accurate online. Pastikan Item/Barang & Jasa sudah dibuat diaccurate, sebelum melakukan transaksi!"]);

                        else:

                            $tc->whereIn('order_id', [$order_id[0]])->update(
                                [
                                    'deliveryOrders_cloud' => substr($DO["d"][0]["r"]["number"],0,2).'.'.$shipment_code,
                                    'recovery_DO' => $DO["d"][0]["r"]["number"],
                                    'status_order_id' => '4'
                                ]
                            );
                
                                $data_order[] = [
                                    'user_id' => Auth::User()->id,
                                    'order_id' => $shipment_code,
                                    'status' => '4',
                                    'datetime' => Carbon::now(),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now()
                                ];
                
                            TrackShipments::insert($data_order);
            
                        return response()->json(["response" => "Data berhasil terhubung dengan accurate", "response" => "Data berhasil terhubung dengan accurate", "response" => "Data berhasil terhubung dengan accurate", "success" => "true"]);

                endif;

    }

    public function ReSyncAccurate(Transport_orders $tc, $shipment_code){ 

        $primaryShipment = $tc->whereIn('order_id', [$shipment_code])->with(['customers','itemtransports.masteritemtc'])->first();
        $fetch_data = $tc->whereIn('order_id', [$shipment_code])->with(['customers','itemtransports.masteritemtc'])->get();
         $fetchBatchItemOrderDetail = $this->batch_item->with(['transportsIDX','masterItemIDACCURATE'])->whereIn('transport_id',[$primaryShipment->id])->get();
       
        if(Auth::User()->oauth_accurate_company == "146583"){

         foreach($fetchBatchItemOrderDetail as $key => $thisdataBatchItemTransports){
             
            $transport_id[] = $thisdataBatchItemTransports->transport_id;
            $itemTRANSPORT[] = $thisdataBatchItemTransports->masterItemIDACCURATE->itemID_accurate;
            $itemName[] = $thisdataBatchItemTransports->masterItemIDACCURATE->itemovdesc;
            $qty[] = $thisdataBatchItemTransports->qty;
            $hargaID[] = $thisdataBatchItemTransports->harga;
            $detailnotes[] = $thisdataBatchItemTransports->detailnotes;
            $itemDiscount[] = $thisdataBatchItemTransports->cash_discount;
            $unitName[] = $thisdataBatchItemTransports->masterItemIDACCURATE->unit;
             
        }

           foreach($fetch_data as $key => $thisDataTransports){

               $id[] = $thisDataTransports->id;
               $method_izzy[] = $thisDataTransports->method_izzy;
               $order_id[] = $thisDataTransports->order_id;
               $status_order__[] = $thisDataTransports->status_order_id;
               $dataARRXCUSTOMER[] = $thisDataTransports->customers->itemID_accurate3PL;
               $dataARRXITEMTRANSPORT[] = $thisDataTransports->itemtransports->masteritemtc->itemID_accurate;
               $SalesQuotationNumber[] = $thisDataTransports->recovery_SQ;
               $dataHARGA[] = $thisDataTransports->harga;
               $dataARRXQTITY[] = $thisDataTransports->quantity;
               $dataARRXITEMTRANSPORTITEMUNIT[] = $thisDataTransports->itemtransports->unit;

           }

        }

        if(Auth::User()->oauth_accurate_company == "146584"){

            foreach($fetchBatchItemOrderDetail as $key => $thisdataBatchItemTransports){
                
               $transport_id[] = $thisdataBatchItemTransports->transport_id;
               $itemTRANSPORT[] = $thisdataBatchItemTransports->masterItemIDACCURATE->itemID_accurate;
               $itemName[] = $thisdataBatchItemTransports->masterItemIDACCURATE->itemovdesc;
               $qty[] = $thisdataBatchItemTransports->qty;
               $hargaID[] = $thisdataBatchItemTransports->harga;
               $detailnotes[] = $thisdataBatchItemTransports->detailnotes;
               $itemDiscount[] = $thisdataBatchItemTransports->cash_discount;
               $unitName[] = $thisdataBatchItemTransports->masterItemIDACCURATE->unit;
                
           }
   
              foreach($fetch_data as $key => $thisDataTransports){
   
                  $id[] = $thisDataTransports->id;
                  $method_izzy[] = $thisDataTransports->method_izzy;
                  $order_id[] = $thisDataTransports->order_id;
                  $status_order__[] = $thisDataTransports->status_order_id;
                  $dataARRXCUSTOMER[] = $thisDataTransports->customers->itemID_accurate;
                  $dataARRXITEMTRANSPORT[] = $thisDataTransports->itemtransports->masteritemtc->itemID_accurate;
                  $SalesQuotationNumber[] = $thisDataTransports->recovery_SQ;
                  $dataHARGA[] = $thisDataTransports->harga;
                  $dataARRXQTITY[] = $thisDataTransports->quantity;
                  $dataARRXITEMTRANSPORTITEMUNIT[] = $thisDataTransports->itemtransports->unit;
   
              }
   
           }

           $checkStatusShipment = $this->transport
                                           ->whereIn('status_order_id', [$status_order__[0]])
                                               ->first();

           if($checkStatusShipment['status_order_id'] == 2):
            // dd("asdas");
            //   if(empty($method_izzy[0])):
              
            //             return response()->json(["response" => "maaf anda harus melakukan PoP via mobile izzyTransport", "success" => "true"]);
               
            //         else:

            //                 if($method_izzy[0] == "pop"):

            //                         $AccurateCloudSalesOrders = $this->openModulesAccurateCloud
            //                             ->FuncOpenmoduleAccurateCloudSaveSalesOrders(
                                        
            //                                 'SO.'.$order_id[0],
            //                                 Auth::User()->oauth_accurate_branch,
            //                                 $dataARRXCUSTOMER[0],
            //                                 // $dataARRXITEMTRANSPORT[0],
            //                                 $itemTRANSPORT,//modifyitemTRANSPORT
            //                                 $this->datenow,
            //                                 // $SO["d"][0]["r"]["number"],
            //                                 $hargaID,//modify
            //                                 $qty,//modify
            //                                 $transport_id,
            //                                 $detailnotes

            //                         );

            //                         dd($AccurateCloudSalesOrders);

            //                             $SO = $AccurateCloudSalesOrders->getData("+"); 

            //                             $CEKSQ  = isset($SO["d"][0]["r"]) 
            //                             ? $SO["d"][0]["r"] 
            //                             : [];
                                                        
            //                                 $checkAsync = collect($CEKSQ)->isEmpty();
                                                        
            //                                     if($checkAsync == true):

            //                                             $tc->whereIn('order_id', [$order_id[0]])->update(
            //                                                         [   
            //                                                             'sync_accurate' => "true"
            //                                                         ]
            //                                                     ) 
            //                                                 ;

            //                                             return response()->json(["response" => "Data gagal dihubungkan ke Accurate online. Pastikan Item/Barang & Jasa sudah dibuat diaccurate, sebelum melakukan transaksi!"]);

            //                                         else:
                                                        
            //                                                 $tc->whereIn('order_id', [$order_id[0]])->update(
            //                                                         [
            //                                                             'sync_accurate' => "false"
            //                                                         ]
            //                                                     )
            //                                                 ;

            //                                         $tc->whereIn('order_id', [$order_id[0]])->update(
            //                                                 [
            //                                                     'salesOrders_cloud' => substr($SO["d"][0]["r"]["number"],0,2).'.'.$order_id[0],
            //                                                     'recovery_SO' => $SO["d"][0]["r"]["number"],
            //                                                 ]
            //                                             )
            //                                         ;

            //                     return response()->json(["response" => "Data berhasil terhubung dengan accurate", "success" => "true"]);   
            //             endif;
            //         endif;
            //     endif;
                // if(empty($method_izzy[0])):

                //         return response()->json(["response" => "maaf anda harus melakukan PoP via mobile izzyTransport ", "success" => "true"]);

                //     else:
                    // dd(session('UserMultiBranchAccurate')["d"][0]["id"]);

                                $AccurateCloudSalesOrders = $this->openModulesAccurateCloud
                                ->FuncOpenmoduleAccurateCloudSaveSalesOrders(
                                
                                    'SO.'.$order_id[0],
                                    Auth::User()->oauth_accurate_branch,
                                    // session('UserMultiBranchAccurate')["d"][0]["id"],
                                    $dataARRXCUSTOMER[0],
                                    // $dataARRXITEMTRANSPORT[0],
                                    $itemTRANSPORT,//modifyitemTRANSPORT
                                    $this->datenow,
                                    // $SO["d"][0]["r"]["number"],
                                    $hargaID,//modify
                                    $qty,//modify
                                    $transport_id,
                                    $detailnotes

                            );

                            // dd($AccurateCloudSalesOrders);

                            $SO = $AccurateCloudSalesOrders->getData("+"); 

                            $CEKSQ  = isset($SO["d"][0]["r"]) 
                            ? $SO["d"][0]["r"] 
                            : [];
                                            
                                $checkAsync = collect($CEKSQ)->isEmpty();
                                            
                                    if($checkAsync == true):

                                                $tc->whereIn('order_id', [$order_id[0]])->update(
                                                        [
                                                            'sync_accurate' => "true"
                                                        ]
                                                    ) 
                                                ;

                                            return response()->json(["response" => "Data gagal dihubungkan ke Accurate online. Pastikan Item/Barang & Jasa sudah dibuat diaccurate, sebelum melakukan transaksi!"]);

                                        else:
                                            
                                    $tc->whereIn('order_id', [$order_id[0]])->update(
                                            [
                                                'sync_accurate' => "false"
                                            ]
                                        )
                                    ;

                            $tc->whereIn('order_id', [$order_id[0]])->update(
                                    [
                                        'salesOrders_cloud' => substr($SO["d"][0]["r"]["number"],0,2).'.'.$order_id[0],
                                        'recovery_SO' => $SO["d"][0]["r"]["number"],
                                    ]
                                )
                            ;

                        return response()->json(["response" => "Data berhasil terhubung dengan accurate", "success" => "true"]);   

                endif;
            endif;

        if($checkStatusShipment['status_order_id'] == 8):

                // if(empty($method_izzy[0])):

                //         return response()->json(["response" => "maaf anda harus melakukan PoP via mobile izzyTransport ", "success" => "true"]);

                //     else:
                    // dd(session('UserMultiBranchAccurate')["d"][0]["id"]);

                            $AccurateCloudSalesOrders = $this->openModulesAccurateCloud
                                ->FuncOpenmoduleAccurateCloudSaveSalesOrders(
                                
                                    'SO.'.$order_id[0],
                                    Auth::User()->oauth_accurate_branch,
                                    // session('UserMultiBranchAccurate')["d"][0]["id"],
                                    $dataARRXCUSTOMER[0],
                                    // $dataARRXITEMTRANSPORT[0],
                                    $itemTRANSPORT,//modifyitemTRANSPORT
                                    $this->datenow,
                                    // $SO["d"][0]["r"]["number"],
                                    $hargaID,//modify
                                    $qty,//modify
                                    $transport_id,
                                    $detailnotes

                            );

                            // bug barang & jasa tidak ada diaccurate
                            // dd($AccurateCloudSalesOrders);


                            $SO = $AccurateCloudSalesOrders->getData("+"); 

                            $CEKSQ  = isset($SO["d"][0]["r"]) 
                            ? $SO["d"][0]["r"] 
                            : [];
                                            
                                $checkAsync = collect($CEKSQ)->isEmpty();
                                            
                                    if($checkAsync == true):

                                                $tc->whereIn('order_id', [$order_id[0]])->update(
                                                        [
                                                            'sync_accurate' => "true"
                                                        ]
                                                    ) 
                                                ;

                                            return response()->json(["response" => "Data gagal dihubungkan ke Accurate online. Pastikan Item/Barang & Jasa sudah dibuat diaccurate, sebelum melakukan transaksi!"]);

                                        else:
                                            
                                    $tc->whereIn('order_id', [$order_id[0]])->update(
                                            [
                                                'sync_accurate' => "false"
                                            ]
                                        )
                                    ;

                            $tc->whereIn('order_id', [$order_id[0]])->update(
                                    [
                                        'salesOrders_cloud' => substr($SO["d"][0]["r"]["number"],0,2).'.'.$order_id[0],
                                        'recovery_SO' => $SO["d"][0]["r"]["number"],
                                    ]
                                )
                            ;

                        return response()->json(["response" => "Data berhasil terhubung dengan accurate", "success" => "true"]);   

                endif;

           endif;

           if($checkStatusShipment['status_order_id'] == 4):

                $AccurateCloudSalesOrders = $this->openModulesAccurateCloud
                    ->FuncOpenmoduleAccurateCloudSaveSalesOrders(
                        
                            'SO.'.$order_id[0],
                            Auth::User()->oauth_accurate_branch,
                            // session('UserMultiBranchAccurate')["d"][0]["id"],
                            $dataARRXCUSTOMER[0],
                            // $dataARRXITEMTRANSPORT[0],
                            $itemTRANSPORT,//modifyitemTRANSPORT
                            $this->datenow,
                            // $SO["d"][0]["r"]["number"],
                            $hargaID,//modify
                            $qty,//modify
                            $transport_id,
                            $detailnotes

                    );


                    $SO = $AccurateCloudSalesOrders->getData("+"); 

                    $CEKSQ  = isset($SO["d"][0]["r"]) 
                    ? $SO["d"][0]["r"] 
                    : [];
                                    
                        $checkAsync = collect($CEKSQ)->isEmpty();
                                    
                            if($checkAsync == true):

                                        $tc->whereIn('order_id', [$order_id[0]])->update(
                                                [
                                                    'sync_accurate' => "true"
                                                ]
                                            ) 
                                        ;

                                    return response()->json(["response" => "Data gagal dihubungkan ke Accurate online. Pastikan Item/Barang & Jasa sudah dibuat diaccurate, sebelum melakukan transaksi!"]);

                                else:
                                    
                            $tc->whereIn('order_id', [$order_id[0]])->update(
                                    [
                                        'sync_accurate' => "false"
                                    ]
                                )
                            ;

                    $tc->whereIn('order_id', [$order_id[0]])->update(
                            [
                                'salesOrders_cloud' => substr($SO["d"][0]["r"]["number"],0,2).'.'.$order_id[0],
                                'recovery_SO' => $SO["d"][0]["r"]["number"],
                            ]
                        )
                    ;

                return response()->json(["response" => "Data berhasil terhubung dengan accurate", "success" => "true"]);   

            endif;

            // if(empty($method_izzy[0])):
            
            //             return response()->json(["response" => "maaf anda harus melakukan POD via mobile izzyTransport", "success" => "true"]);
             
            //       else:

            //             $AccurateCloudSalesOrders = $this->openModulesAccurateCloud
            //                     ->FuncOpenmoduleAccurateCloudSaveSalesOrders(
                                
            //                         'SO.'.$order_id[0],
            //                         Auth::User()->oauth_accurate_branch,
            //                         $dataARRXCUSTOMER[0],
            //                         // $dataARRXITEMTRANSPORT[0],
            //                         $itemTRANSPORT,//modifyitemTRANSPORT
            //                         $this->datenow,
            //                         // $SO["d"][0]["r"]["number"],
            //                         $hargaID,//modify
            //                         $qty,//modify
            //                         $transport_id,
            //                         $detailnotes

            //                 );

            //                     $SO = $AccurateCloudSalesOrders->getData("+"); 

            //                           $CEKSQ  = isset($SO["d"][0]["r"]) 
            //                           ? $SO["d"][0]["r"] 
            //                           : [];
                                                      
            //                               $checkAsync = collect($CEKSQ)->isEmpty();

            //                                   if($checkAsync == true):

            //                                           $tc->whereIn('order_id', [$order_id[0]])->update(
            //                                                       [   
            //                                                           'sync_accurate' => "true"
            //                                                       ]
            //                                                   ) 
            //                                               ;

            //                                           return response()->json(["response" => "Data gagal dihubungkan ke Accurate online. Pastikan Item/Barang & Jasa sudah dibuat diaccurate, sebelum melakukan transaksi!"]);

            //                                       else:
                                                      
            //                                             $tc->whereIn('order_id', [$order_id[0]])->update(
            //                                                     [
            //                                                         'sync_accurate' => "false"
            //                                                     ]
            //                                                 )
            //                                             ;

            //                                       $tc->whereIn('order_id', [$order_id[0]])->update(
            //                                               [
            //                                                   'salesOrders_cloud' => substr($SO["d"][0]["r"]["number"],0,2).'.'.$order_id[0],
            //                                                   'recovery_SO' => $SO["d"][0]["r"]["number"],
            //                                               ]
            //                                           )
            //                                       ;


            //                     return response()->json(["response" => "Data berhasil terhubung dengan accurate", "success" => "true"]);   
            //           endif;
                      
            //       endif;

              endif;

       
              //        $AccurateCloudSalesQuotation = $this->openModulesAccurateCloud
        //            ->FuncOpenmoduleAccurateCloudSaveSalesQoutation(

        //                'SQ.'.$order_id[0],
        //                $dataARRXCUSTOMER[0],
        //                $itemTRANSPORT,//modifyitemTRANSPORT
        //                // $dataARRXITEMTRANSPORT[0],
        //                $this->datenow,
        //                // $dataHARGA[0],
        //                $hargaID,//modify
        //                $qty,//modify
        //                $unitName,
        //                $transport_id,
        //                $detailnotes,
        //                $itemDiscount

        //        );
               
        //            $SQ = $AccurateCloudSalesQuotation->getData('+');

        //            $CEKSQ  = isset($SQ["d"][0]["r"]) 
        //                    ? $SQ["d"][0]["r"] 
        //                    : [];
                   
        //            $checkAsync = collect($CEKSQ)->isEmpty();
                   
        //        if($checkAsync == true):

        //            $tc->whereIn('order_id', [$order_id[0]])->update(
        //                        [
        //                            'sync_accurate' => "true"
        //                        ]
        //                    ) 
        //                ;

        //                    return response()->json(["response" => "Data gagal dihubungkan ke Accurate online. Pastikan Item/Barang & Jasa sudah dibuat diaccurate, sebelum melakukan transaksi!"]);

        //                else:

        //                        $tc->whereIn('order_id', [$order_id[0]])->update(
        //                                [
        //                                    'sync_accurate' => "false"
        //                                ]
        //                            )
        //                        ;

        //                        $AccurateCloudSalesOrders = $this->openModulesAccurateCloud
        //                            ->FuncOpenmoduleAccurateCloudSaveSalesOrders(
                                   
        //                                'SO.'.$order_id[0],
        //                                $dataARRXCUSTOMER[0],
        //                                // $dataARRXITEMTRANSPORT[0],
        //                                $itemTRANSPORT,//modifyitemTRANSPORT
        //                                $this->datenow,
        //                                $SQ["d"][0]["r"]["number"],
        //                                // $dataHARGA[0],
        //                                $hargaID,//modify
        //                                // $dataARRXQTITY[0]
        //                                $qty,//modify
        //                                $transport_id,
        //                                $detailnotes
           
        //                        );
           
        //                            $SO = $AccurateCloudSalesOrders->getData('+');
                               
        //                        $tc->whereIn('order_id', [$order_id[0]])->update(
        //                                [
        //                                    'salesQuotation_cloud' => substr($SQ["d"][0]["r"]["number"],0,2).'.'.$order_id[0],
        //                                    'recovery_SQ' => $SQ["d"][0]["r"]["number"],
        //                                    'status_order_id' => '8'
        //                                ]
        //                            )
        //                        ;
           
        //                        $tc->whereIn('order_id', [$order_id[0]])->update(
        //                                [
        //                                    'salesOrders_cloud' => substr($SO["d"][0]["r"]["number"],0,2).'.'.$order_id[0],
        //                                    'recovery_SO' => $SO["d"][0]["r"]["number"],
        //                                    'status_order_id' => '2'
        //                                ]
        //                            )
        //                        ;
                                       
        //                /**
        //                * end processing for next step async sales quotation
        //                * 
        //                */
        //                $data_order[] = [
        //                    'user_id' => Auth::User()->id,
        //                    'order_id' => $order_id[0],
        //                    'status' => '8',
        //                    'datetime' => Carbon::now(),
        //                    'created_at' => Carbon::now(),
        //                    'updated_at' => Carbon::now()
        //                ];
   
        //                        $data_order[] = [
        //                            'user_id' => Auth::User()->id,
        //                            'order_id' => $order_id[0],
        //                            'status' => '2',
        //                            'datetime' => Carbon::now(),
        //                            'created_at' => Carbon::now(),
        //                            'updated_at' => Carbon::now()
        //                        ];
       
        //                TrackShipments::insert($data_order);
   
        //            /**
        //             * end processing for next step async sales orders
        //             * 
        //             */

        //                    return response()->json(["response" => "Data berhasil terhubung dengan accurate", "response" => "Data berhasil terhubung dengan accurate", "response" => "Data berhasil terhubung dengan accurate", "success" => "true"]);

        //            endif;

        //    else:

        //            if($checkStatusShipment['status_order_id'] == 8):

        //                    $tc->whereIn('order_id', [$order_id[0]])->update(
        //                        [
        //                            'status_order_id' => '2'
        //                        ]
        //                    );
           
        //                            $data_order[] = [
        //                                'user_id' => Auth::User()->id,
        //                                'order_id' => $shipment_code,
        //                                'status' => '2',
        //                                'datetime' => Carbon::now(),
        //                                'created_at' => Carbon::now(),
        //                                'updated_at' => Carbon::now()
        //                            ];
                       
        //                        TrackShipments::insert($data_order);
               
        //                    return response()->json("shipment_PoP");

        //                else:

        //                        $AccurateCloud = $this->openModulesAccurateCloud
        //                            ->FuncOpenmoduleAccurateCloudSaveSalesOrders(
        //                                'SO.'.$order_id[0],
        //                                $dataARRXCUSTOMER[0],
        //                                $dataARRXITEMTRANSPORT[0],
        //                                $this->datenow,
        //                                $SalesQuotationNumber[0],
        //                                $dataHARGA[0],
        //                                $dataARRXQTITY[0]
        //                        );

        //                        $tc->whereIn('order_id', [$order_id[0]])->update(
        //                            [
        //                                'salesOrders_cloud' => substr($AccurateCloud->original,0,2).'.'.$shipment_code,
        //                                'recovery_SO' => $AccurateCloud->original,
        //                                'status_order_id' => '2'
        //                            ]
        //                        );
               
        //                        $data_order[] = [
        //                            'user_id' => Auth::User()->id,
        //                            'order_id' => $shipment_code,
        //                            'status' => '2',
        //                            'datetime' => Carbon::now(),
        //                            'created_at' => Carbon::now(),
        //                            'updated_at' => Carbon::now()
        //                        ];
                       
        //                    TrackShipments::insert($data_order);
               
        //                return response()->json("shipment_PoP");

        //        endif;


    }

}