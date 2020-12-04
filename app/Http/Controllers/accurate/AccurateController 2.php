<?php

namespace warehouse\Http\Controllers\accurate;

use Auth;
use SWAL;
use Storage;
use Exporter;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use warehouse\Models\Item;
use Illuminate\Http\Request;
use GuzzleHttp\Psr7\Response;
use warehouse\Models\Customer;
use warehouse\Exports\UsersExport;
use warehouse\Models\Exports_list;
use GuzzleHttp\Promise\EachPromise;
use warehouse\Models\Order_history;
use Illuminate\Support\Facades\Gate;
use warehouse\Models\Company_branchs;
use warehouse\Models\Warehouse_order;
use warehouse\Models\Transport_orders;
use Illuminate\Database\Eloquent\Builder;
use warehouse\Http\Controllers\Controller;
use warehouse\Models\Vendor_item_transports;
use warehouse\Models\Warehouse_order_status;
use warehouse\Models\APIintractive as dbcheck;
use warehouse\Repositories\AccurateCloudRepos;
use warehouse\Models\Transports_orders_statused;
use warehouse\Models\Batchs_transaction_item_customer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use warehouse\Http\Controllers\Services\AccuratecloudInterface;
use warehouse\Models\Order_transport_history as TrackShipments;
use warehouse\Http\Controllers\ManagementController as RESTAPIs;
use warehouse\Models\Item_transport as Customer_item_transports;
use GuzzleHttp\Exception\ClientException as handlingAPIAccurateCloud;

class AccurateController extends Controller
{

  protected $APIaccurateimport;
  protected $rest;
  protected $openModulesAccurateCloud;
  protected $session;
  protected $date;
  protected $datenow;
  private $cloudAccurateSync;

  public function __construct(RESTAPIs $apiaccurate, Batchs_transaction_item_customer $batch_item, Request $REST, AccuratecloudInterface $APInterfacecloud, AccurateCloudRepos $UpdateDataSQ)
  {
    $this->middleware(['BlockedBeforeSettingUser','verified','permission:developer|transport|superusers|warehouse|accounting']);
    $this->APIaccurateimport = $apiaccurate;
    $this->rest = $REST;
    $this->cloudAccurateSync = $UpdateDataSQ;
    $this->batch_item = $batch_item;
    $this->session = "31d26482-94b7-44e1-8303-e31945f422d7";
    $this->date = gmdate('Y-m-d\TH:i:s\Z');
    $this->datenow = date('d/m/Y');
    $this->openModulesAccurateCloud = $APInterfacecloud;

  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      /**
       * Testing successfully for call back inherits from other class
       */
        return $this->cloudAccurateSync->AccurateCloudpatternDBLIST();
    }

    private function getSQNUMBER($shipments, $Qty)
    {
        return $this->cloudAccurateSync->getSQnumber($shipments, $Qty);
    }

    private function getSONUMBER($shipments, $POCODES, $Comments, $Qty)
    {
        return $this->cloudAccurateSync->getSOnumber($shipments, $POCODES, $Comments, $Qty);
    }

    private function __getBarangJasa($CodeNumberBarang, $Qty, $Cost)
    {
        return $this->cloudAccurateSync->__getBarangJasa($CodeNumberBarang, $Qty, $Cost);
    }

    public function getvalstatusshipment(Transport_orders $tc, $idx)
    {
      $sdxcccc = $tc->with('cek_status_transaction')->where('id', $idx)->get();

      return response()->json($sdxcccc);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function loadDataStatus(Warehouse_order $whs, Warehouse_order_status $wos, Request $request, $id_order)
    {

        $query = $whs->with('warehouse_o_status','customers_warehouse','sub_service.remarks','users')
        ->where('company_branch_id', session()->get('id'))->where('id', $id_order)
        ->orderByDesc('id')->get();
          // dd($query);die;
        foreach ($query as $querys) {
            $results = $querys->warehouse_o_status->status_name;
        }

          $user = Auth::User()->roles;
          $datauser = array();
          foreach ($user as $key => $value) {
            # code...
            $datauser[] = $value->name;

          }
          
          if(in_array('administrator', $datauser)){
              $cari = $request->q;
                $data_for_tc = array('draft','cancel','process','pod');
                // return $data_for_tc;
                $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();

                return response()->json($data);

            }

          if(in_array('super_users', $datauser)){
              $cari = $request->q;
                $data_for_tc = array('draft','cancel','process','pod');
                // return $data_for_tc;
                $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();

                return response()->json($data);

            } 
                else {
                  if (in_array('3PL SURABAYA ALL PERMISSION', $datauser)) {
                      # code...

                      if ($results=="upload") {
                          # code...
                          $cari = $request->q;
                          $data_for_tc = array('invoice');
                          // $data_for_tc = array('draft','cancel','process','pod');
                          $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();
    
                          return response()->json($data);
                      }

                      if ($results=="invoice") {
                          # code...
                          $cari = $request->q;
                          $data_for_tc = array('paid');
                          // $data_for_tc = array('draft','cancel','process','pod');
                          $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();
    
                          return response()->json($data);
                      }

              
                      if ($results=="paid") {
                          # code...
                          $cari = $request->q;
                          $data_for_tc = array('');
                          // $data_for_tc = array('draft','cancel','process','pod');
                          $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();
    
                          return response()->json($data);
                      }

                      if ($results=="process") {
                          # code...
                          $cari = $request->get('q');
                          $data_for_tc = array('upload');
                          // $data_for_tc = array('draft','cancel','process','pod');
                          $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();
    
                          return response()->json($data);
                      }

                      if ($results=="draft") {
                          # code...
                          $cari = $request->q;
                          $data_for_tc = array('process','cancel');
                          // $data_for_tc = array('draft','cancel','process','pod');
                          $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();
    
                          return response()->json($data);
                      }

                      if ($results=="cancel") {
                          # code...
                          $cari = $request->q;
                          $data_for_tc = array('');
                          // $data_for_tc = array('draft','cancel','process','pod');
                          $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();
                          return response()->json($data);
                      }

                      if ($results=="pod") {
                          # code...
                          $cari = $request->q;
                          $data_for_tc = array('invoice');
                          // $data_for_tc = array('draft','cancel','process','pod');
                          $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();
                          return response()->json($data);
                      }
                  }

                  if (in_array('3PL - SURABAYA WAREHOUSE', $datauser)) {
                    # code...

                    if ($results=="upload") {
                        # code...
                        $cari = $request->q;
                        $data_for_tc = array('invoice');
                        // $data_for_tc = array('draft','cancel','process','pod');
                        $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();
  
                        return response()->json($data);
                    }

                    if ($results=="invoice") {
                        # code...
                        $cari = $request->q;
                        $data_for_tc = array('paid');
                        // $data_for_tc = array('draft','cancel','process','pod');
                        $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();
  
                        return response()->json($data);
                    }

            
                    if ($results=="paid") {
                        # code...
                        $cari = $request->q;
                        $data_for_tc = array('');
                        // $data_for_tc = array('draft','cancel','process','pod');
                        $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();
  
                        return response()->json($data);
                    }

                    if ($results=="process") {
                        # code...
                        $cari = $request->get('q');
                        $data_for_tc = array('upload');
                        // $data_for_tc = array('draft','cancel','process','pod');
                        $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();
  
                        return response()->json($data);
                    }

                    if ($results=="draft") {
                        # code...
                        $cari = $request->q;
                        $data_for_tc = array('process','cancel');
                        // $data_for_tc = array('draft','cancel','process','pod');
                        $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();
  
                        return response()->json($data);
                    }

                    if ($results=="cancel") {
                        # code...
                        $cari = $request->q;
                        $data_for_tc = array('');
                        // $data_for_tc = array('draft','cancel','process','pod');
                        $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();
                        return response()->json($data);
                    }

                    if ($results=="pod") {
                        # code...
                        $cari = $request->q;
                        $data_for_tc = array('invoice');
                        // $data_for_tc = array('draft','cancel','process','pod');
                        $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();
                        return response()->json($data);
                    }
                }
  
                  // if ($datauser=="3PL[ACCOUNTING][TC]" || $datauser=="super_users") {
             

                  if ($datauser=="3PL[ACCOUNTING][WHS]" || $datauser == "super_users") {
                      // if (Gate::allows('accounting')) {
                      # code...
                      if ($results=="invoice") {
                          # code...
                          $cari = $request->q;
                          $data_for_tc = array('paid');
                          // $data_for_tc = array('draft','cancel','process','pod');
                          $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();
                          return response()->json($data);
                      }

                      if ($results=="paid") {
                          # code...
                          $cari = $request->q;
                          $data_for_tc = array('done');
                          // $data_for_tc = array('draft','cancel','process','pod');
                          $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();
                          return response()->json($data);
                      }

                      if ($results=="upload") {
                          # code...
                          $cari = $request->q;
                          $data_for_tc = array('invoice');
                          // $data_for_tc = array('draft','cancel','process','pod');
                          $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();
                          return response()->json($data);
                      }

                      if ($results=="process") {
                          # code...
                          $cari = $request->q;
                          $data_for_tc = array('upload');
                          // $data_for_tc = array('draft','cancel','process','pod');
                          $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();
                          return response()->json($data);
                      }
                  }

                  // information where OPRASONAL : WAREHOUSE, TRANSPORT, AND WAREHOUSE OR TRANSPORT
              
                  // if ($datauser=="3PL[OPRASONAL][WHS]" || $datauser=="super_users") {
                  if (in_array('3PL SURABAYA ALL PERMISSION', $datauser)) {
                      // if (Gate::allows('warehouse')) {
                      # code...

                      if ($results=="process") {
                          # code...
                          // $cari = $request->q;
                          $cari = $request->get('q');

                          $data_for_tc = array('');
                          // $data_for_tc = array('draft','cancel','process','pod');
                          $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();
        
                          return response()->json($data);
                      }

                      if ($results=="draft") {
                          # code...
                          $cari = $request->q;
                          $data_for_tc = array('process','cancel');
                          // $data_for_tc = array('draft','cancel','process','pod');
                          $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();
        
                          return response()->json($data);
                      }

                      if ($results=="pod") {
                          # code...
                          $cari = $request->q;
                          $data_for_tc = array('');
                          // $data_for_tc = array('draft','cancel','process','pod');
                          $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();
        
                          return response()->json($data);
                      }

                      if ($results=="upload") {
                          # code...
                          $cari = $request->q;
                          $data_for_tc = array('invoice');
                          $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();
        
                          return response()->json($data);
                      }

                      if ($results=="cancel") {
                          # code...
                          $cari = $request->q;
                          $data_for_tc = array('');
                          $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();
        
                          return response()->json($data);
                      }
                      // return response()->json($results);
                }
            }
            // if ($datauser=="3PL[OPRASONAL][TC][WHS]" || $datauser=="super_users") {
           

            
        // }

    }

    public function LoadDataStatusTransportAccounting(Transports_orders_statused $status_transport,Transport_orders $tc, Request $request, $id_xml)
    {
      $data_status = $tc->with('cek_status_transaction')->where('id', $id_xml)->get();

        foreach($data_status as $value_name_status) {

          $data_status_perfiles = $value_name_status->cek_status_transaction;
          $statusname = $value_name_status->cek_status_transaction->status_name;

        }

          if($statusname == "upload"){

              // $arrays = array(8);
              $arrays = array('2');
              $status = $status_transport->select('id','status_name')->where('id', $arrays)->get();

              return response()->json($status);

          }

          if($statusname == "new"){

              $arrays = array('');
              $status = $status_transport->select('id','status_name')->where('id', $arrays)->get();

              return response()->json($status);

          }

          if($statusname == "proses"){

              $arrays = array('');
              $status = $status_transport->select('id','status_name')->where('id', $arrays)->get();

              return response()->json($status);

          }

          if($statusname == "done"){

              $arrays = array('');
              $status = $status_transport->select('id','status_name')->where('id', $arrays)->get();

              return response()->json($status);

          }
      

    }

    public function LoadStatusFTC(Transports_orders_statused $status_transport,Transport_orders $tc, Request $request, $id_xml)
    {
      $data_status = $tc->with('cek_status_transaction')->where('id', $id_xml)->get();

      foreach($data_status as $value_name_status) {

        $data_status_perfiles = $value_name_status->cek_status_transaction;
        $statusname = $value_name_status->cek_status_transaction->status_name;

      }

      $user = Auth::User()->roles;
      $datauser = array();
      foreach ($user as $key => $value) {
        # code...
        $datauser = $value->name;

      }
      
      if($statusname == "draft"){
        $arrays = array('8');

        $status = $status_transport->select('id','status_name')->where('id', $arrays)->get();
        return response()->json($status);

      }

      return response()->json(false);

  }

    public function loadDataStatusListOrderWarehouseAccounting(Warehouse_order $whs, Warehouse_order_status $wos, Request $request, $odpz)
    {

        $query = $whs->with('warehouse_o_status','customers_warehouse','sub_service.remarks','users')
        ->where('company_branch_id', $request->session()->get('id'))
        ->where('id', $odpz)
        ->orderByDesc('id')->get();

        foreach ($query as $querys) {
            $results = $querys->warehouse_o_status->status_name;
        }

          $user = Auth::User()->roles;
          foreach ($user as $key => $value) {
            # code...
            $datauser = $value->name;

          }

          if ($datauser=="3PL[ACCOUNTING][TC]") {
            # code...
            $cari = $request->q;
            $data_for_tc = array('upload','paid','invoice');
            // return $data_for_tc;
            $data = $wos->select('id', 'status_name')->whereIn('status_name',$data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();

            return response()->json($data);

          }

            if ($datauser=="3PL[ACCOUNTING][WHS]|3PL SURABAYA ALL PERMISSION") {
              # code...

              if ($results=="upload") {
                # code...
                $cari = $request->q;
                $data_for_tc = array('invoice');
                // $data_for_tc = array('draft','cancel','process','pod');
                $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();
    
                return response()->json($data);

              }

              if ($results=="invoice") {
                # code...
                $cari = $request->q;
                $data_for_tc = array('paid');
                // $data_for_tc = array('draft','cancel','process','pod');
                $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();
    
                return response()->json($data);

              }

              
              if ($results=="paid") {
                # code...
                $cari = $request->q;
                $data_for_tc = array('');
                // $data_for_tc = array('draft','cancel','process','pod');
                $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();
    
                return response()->json($data);

              }

              if ($results=="process") {
                # code...
                $cari = $request->q;
                $data_for_tc = array('upload');
                // $data_for_tc = array('draft','cancel','process','pod');
                $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();
    
                return response()->json($data);

              }

              if ($results=="draft") {
                # code...
                $cari = $request->q;
                $data_for_tc = array('');
                // $data_for_tc = array('draft','cancel','process','pod');
                $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();
    
                return response()->json($data);

              }

              if ($results=="cancel") {
                # code...
                $cari = $request->q;
                $data_for_tc = array('');
                // $data_for_tc = array('draft','cancel','process','pod');
                $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();
                return response()->json($data);

              }

              if ($results=="pod") {
                # code...
                $cari = $request->q;
                $data_for_tc = array('invoice');
                // $data_for_tc = array('draft','cancel','process','pod');
                $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();
                return response()->json($data);

              }

            }

            if ($datauser=="3PL[ACCOUNTING][WHS][TC]") {
              # code...

              if ($results=="upload") {
                # code...
                $cari = $request->q;
                $data_for_tc = array('invoice');
                // $data_for_tc = array('draft','cancel','process','pod');
                $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();
    
                return response()->json($data);

              }

              if ($results=="invoice") {
                # code...
                $cari = $request->q;
                $data_for_tc = array('paid');
                // $data_for_tc = array('draft','cancel','process','pod');
                $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();
    
                return response()->json($data);

              }

              
              if ($results=="paid") {
                # code...
                $cari = $request->q;
                $data_for_tc = array('');
                // $data_for_tc = array('draft','cancel','process','pod');
                $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();
    
                return response()->json($data);

              }

              if ($results=="process") {
                # code...
                $cari = $request->q;
                $data_for_tc = array('upload');
                // $data_for_tc = array('draft','cancel','process','pod');
                $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();
    
                return response()->json($data);

              }

              if ($results=="draft") {
                # code...
                $cari = $request->q;
                $data_for_tc = array('process','cancel');
                // $data_for_tc = array('draft','cancel','process','pod');
                $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();
    
                return response()->json($data);

              }

              if ($results=="cancel") {
                # code...
                $cari = $request->q;
                $data_for_tc = array('');
                // $data_for_tc = array('draft','cancel','process','pod');
                $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();
                return response()->json($data);

              }

              if ($results=="pod") {
                # code...
                $cari = $request->q;
                $data_for_tc = array('invoice');
                // $data_for_tc = array('draft','cancel','process','pod');
                $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();
                return response()->json($data);

              }

            }

            // information where OPRASONAL : WAREHOUSE, TRANSPORT, AND WAREHOUSE OR TRANSPORT

            if ($datauser=="3PL[OPRASONAL][WHS]|3PL SURABAYA ALL PERMISSION") {
              # code...

              if ($results=="process") {
                # code...
                $cari = $request->q;
                $data_for_tc = array('');
                // $data_for_tc = array('draft','cancel','process','pod');
                $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();
    
                return response()->json($data);

              }

              if ($results=="paid") {
                # code...
                $cari = $request->q;
                $data_for_tc = array('');
                // $data_for_tc = array('draft','cancel','process','pod');
                $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();
    
                return response()->json($data);

              }

              if ($results=="invoice") {
                # code...
                $cari = $request->q;
                $data_for_tc = array('');
                // $data_for_tc = array('draft','cancel','process','pod');
                $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();
    
                return response()->json($data);

              }

              if ($results=="draft") {
                # code...
                $cari = $request->q;
                $data_for_tc = array('process','cancel');
                // $data_for_tc = array('draft','cancel','process','pod');
                $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();
    
                return response()->json($data);

              }

              if ($results=="pod") {
                # code...
                $cari = $request->q;
                $data_for_tc = array('');
                // $data_for_tc = array('draft','cancel','process','pod');
                $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();
    
                return response()->json($data);

              }

              if ($results=="upload") {
                # code...
                $cari = $request->q;
                $data_for_tc = array('invoice');
                $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();
    
                return response()->json($data);

              }

              if ($results=="cancel") {
                # code...
                $cari = $request->q;
                $data_for_tc = array('');
                $data = $wos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();
    
                return response()->json($data);

              }
                // return response()->json($results);
            
  
            }

            if ($datauser=="3PL[OPRASONAL][TC][WHS]|3PL SURABAYA ALL PERMISSION") {
              # code...
              $cari = $request->q;
              $data_for_tc = array('draft','cancel','process','pod');
              // return $data_for_tc;
              $data = $wos->select('id', 'status_name')->whereIn('status_name',$data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();

              return response()->json($data);

            }

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function xml($id){
        $warehouseTolist = Warehouse_order::with('warehouse_o_status','company_branch','item_t','customers_warehouse','sub_service.remarks','service_house')->find($id);
        $warehouse_order_pic = Warehouse_order_customer_pic::with('to_do_list_cspics','pics_whs')->where('warehouse_order_id',$id)->get();
            
          try {
                if (!$warehouseTolist == null) {
                  
                  $news_status = $warehouseTolist->find($id);
                    $news_status->status_order_id = 02;
                      $results = $news_status->save();
                      if ($results == TRUE) {
  
                        if ($news_status->status_order_id == 2) {
  
                          $doc = new DOMDocument('1.0','UTF-8');
                          $doc->preserveWhiteSpace = false;
                          $doc->formatOutput = true;
  
                          // create root node
                          $root = $doc->createElement('NMEXML');
                          $invalid_exim = $doc->createAttribute('EximID');
                          $invalid_BranchCode = $doc->createAttribute('BranchCode');
                          $invalid_AccountantID = $doc->createAttribute('ACCOUNTANTCOPYID');
  
                          $invalid_exim->value = '490';
                          $invalid_BranchCode->value = '238055809';
                          $invalid_AccountantID->value = '';
                          $root->appendChild($invalid_exim);
                          $root->appendChild($invalid_BranchCode);
                          $root->appendChild($invalid_AccountantID);
                          $doc->appendChild($root);
  
                          
                        $id = array();
                        $signed_values = array(
                                    'TRANSACTIONID' => '26620'
                                    );
  
                                    $items = array(
                                      'keyID' => '0',
                                      // 'ITEMNO' => '10101',
                                      'ITEMNO' => $warehouseTolist->item_t->itemno,
                                      // 'QUANTITY' => '50',
                                      'QUANTITY' => $warehouseTolist->volume,
                                      'ITEMUNIT' => '',
                                      'UNITRATIO' => '1',
                                      'ITEMRESERVED1' => '',
                                      // 'ITEMRESERVED2' => 'M2',
                                      'ITEMRESERVED2' => $warehouseTolist->wom,
                                      'ITEMRESERVED3' => '',
                                      'ITEMRESERVED4' => '',
                                      'ITEMRESERVED5' => '',
                                      'ITEMRESERVED6' => '',
                                      'ITEMRESERVED7' => '',
                                      'ITEMRESERVED8' => '',
                                      'ITEMRESERVED9' => '',
                                      'ITEMRESERVED10' => '',
                                      // 'ITEMOVDESC' => 'Sewa Gudang Bulanan',
                                      'ITEMOVDESC' => $warehouseTolist->item_t->itemovdesc,
                                      // 'UNITPRICE' => '800',
                                      'UNITPRICE' => $warehouseTolist->rate,
                                      'DISCPC' => '',
                                      'TAXCODES' => '',
                                      // 'DEPTID' => '01',
                                      'DEPTID' => $warehouseTolist->company_branch->depid,
                                      'QTYSHIPPED' => '0',
                                      );
  
                                      $SONO_LUR = array(
                                        'SONO' => '4956',
                                        // 'SODATE' => '2018-09-28',
                                        'SODATE' => $warehouseTolist->tgl_kegiatan,
                                        'TAX1ID' => 'T',
                                        'TAX1CODE' => 'T',
                                        'TAX2CODE' => '',
                                        'TAX1RATE' => '10',
                                        'TAX2RATE' => '0',
                                        'TAX1AMOUNT' => '0',
                                        'TAX2AMOUNT' => '0',
                                        'RATE' => '1',
                                        'TAXINCLUSIVE' => '0',
                                        'CUSTOMERISTAXABLE' => '1',
                                        'CASHDISCOUNT' => '0',
                                        'CASHDISCPC' => '',
                                        'FREIGHT' => '0',
                                        'TERMSID' => 'Net 14',
                                        'FOB' => '',
                                        'ESTSHIPDATE' => '2018-09-25',
                                        'DESCRIPTION' => 'Sewa Gudang bulanan 50 m2 --description',
                                        // 'SHIPTO1' => 'ADI BHIROWO, DRS EC',
                                        'SHIPTO1' => $warehouseTolist->customers_warehouse->name,
                                        // 'SHIPTO2' => 'JL. BHAKTI HUSADA 3/18 RT 001/RW',
                                        'SHIPTO2' => $warehouseTolist->customers_warehouse->address,
                                        // 'SHIPTO3' => '005 MOJO, GUBENG - SURABAYA',
                                        'SHIPTO3' => '',
                                        'SHIPTO4' => '',
                                        'SHIPTO5' => '',
                                        'DP' => '0',
                                        'DPACCOUNTID' => '211',
                                        'DEPUSED' => '',
                                        // 'CUSTOMERID' => '1170',
                                        'CUSTOMERID' => $warehouseTolist->customers_warehouse->personno,
                                        'PONO' => 'PO001',
                                      );
  
                                      $salesman = array(
                                          'LASTNAME' => '',
                                          'FIRSTNAME' => 'AGUNG',
                                      );
  
                                      $currencyname = array(
                                        'CURRENCYNAME' => 'Rupiah',
                                    );
                              // }
                              foreach ($signed_values as $key => $val) {
                                $occ = $doc->createElement('TRANSACTIONS');
                                $error = $doc->createAttribute('OnError');
                                $error->value = 'CONTINUE';
                                $occ->appendChild($error);
                                $occ = $root->appendChild($occ);
  
                                      foreach ($signed_values as $key => $val) {
                                        $occc = $doc->createElement('SALESORDER');
                                        $errors = $doc->createAttribute('operation');
                                        $requestids = $doc->createAttribute('REQUESTID');
  
                                        $errors->value = 'Add';
                                        $requestids->value = '1';
                                        $occc->appendChild($errors);
                                        $occc->appendChild($requestids);
                                        $occc = $occ->appendChild($occc);
  
                                          foreach ($signed_values as $fieldname => $fieldvalue) {
                                            $child = $doc->CreateElement($fieldname);
                                            $child = $occc->appendChild($child);
                                            $value = $doc->createTextNode($fieldvalue);
                                            $value = $child->appendChild($value);
                                            
                                        }
                                          foreach ($signed_values as $key => $val) {
                                                $itemline = $doc->createElement('ITEMLINE');
                                                $opr = $doc->createAttribute('operation');
          
                                                $opr->value = 'Add';
                                                $itemline->appendChild($opr);
                                                $itemline = $occc->appendChild($itemline);
  
                                                      foreach ($items as $fieldname => $fieldvalue) {
                                                          $child = $doc->CreateElement($fieldname);
                                                          $child = $itemline->appendChild($child);
                                                          $value = $doc->createTextNode($fieldvalue);
                                                          $value = $child->appendChild($value);
                                                          
                                                      }
  
                                            foreach ($SONO_LUR as $fieldname => $fieldvalue) {
                                              $child = $doc->CreateElement($fieldname);
                                              $child = $occc->appendChild($child);
                                              $value = $doc->createTextNode($fieldvalue);
                                              $value = $child->appendChild($value);
                                              
                                            }
  
                                                    foreach ($signed_values as $key => $val) {
                                                      $sales = $doc->createElement('SALESMANID');
                
                                                      $sales = $occc->appendChild($sales);
  
                                                            foreach ($salesman as $fieldname => $fieldvalue) {
                                                                $child = $doc->CreateElement($fieldname);
                                                                $child = $sales->appendChild($child);
                                                                $value = $doc->createTextNode($fieldvalue);
                                                                $value = $child->appendChild($value);
                                                                
                                                            }
                                                      }
  
                                                      foreach ($currencyname as $fieldname => $fieldvalue) {
                                                        $child = $doc->CreateElement($fieldname);
                                                        $child = $occc->appendChild($child);
                                                        $value = $doc->createTextNode($fieldvalue);
                                                        $value = $child->appendChild($value);
                                                        
                                                    }
  
                                            }
  
                                  }
  
                                  foreach ($signed_values as $key => $val) {
                                    $occc = $doc->createElement('SALESORDER');
                                    $errors = $doc->createAttribute('operation');
                                    $requestids = $doc->createAttribute('REQUESTID');
  
                                    $errors->value = 'Add';
                                    $requestids->value = '1';
                                    $occc->appendChild($errors);
                                    $occc->appendChild($requestids);
                                    $occc = $occ->appendChild($occc);
  
                                      foreach ($signed_values as $fieldname => $fieldvalue) {
                                        $child = $doc->CreateElement($fieldname);
                                        $child = $occc->appendChild($child);
                                        $value = $doc->createTextNode($fieldvalue);
                                        $value = $child->appendChild($value);
                                        
                                    }
                                      foreach ($signed_values as $key => $val) {
                                            $itemline = $doc->createElement('ITEMLINE');
                                            $opr = $doc->createAttribute('operation');
      
                                            $opr->value = 'Add';
                                            $itemline->appendChild($opr);
                                            $itemline = $occc->appendChild($itemline);
  
                                                  foreach ($items as $fieldname => $fieldvalue) {
                                                      $child = $doc->CreateElement($fieldname);
                                                      $child = $itemline->appendChild($child);
                                                      $value = $doc->createTextNode($fieldvalue);
                                                      $value = $child->appendChild($value);
                                                      
                                                  }
  
                                        foreach ($SONO_LUR as $fieldname => $fieldvalue) {
                                          $child = $doc->CreateElement($fieldname);
                                          $child = $occc->appendChild($child);
                                          $value = $doc->createTextNode($fieldvalue);
                                          $value = $child->appendChild($value);
                                          
                                        }
  
                                                foreach ($signed_values as $key => $val) {
                                                  $sales = $doc->createElement('SALESMANID');
            
                                                  $sales = $occc->appendChild($sales);
  
                                                        foreach ($salesman as $fieldname => $fieldvalue) {
                                                            $child = $doc->CreateElement($fieldname);
                                                            $child = $sales->appendChild($child);
                                                            $value = $doc->createTextNode($fieldvalue);
                                                            $value = $child->appendChild($value);
                                                            
                                                        }
                                                  }
  
                                                  foreach ($currencyname as $fieldname => $fieldvalue) {
                                                    $child = $doc->CreateElement($fieldname);
                                                    $child = $occc->appendChild($child);
                                                    $value = $doc->createTextNode($fieldvalue);
                                                    $value = $child->appendChild($value);
                                                    
                                                }
  
                                        }
  
                                    }
  
                            }
                              
                              ob_clean();
                            flush();
  
                              $response = Response($doc->saveXML(), 200);
                              $response->header('Content-Description','File Transfer');
                              $response->header('Content-Transfer-Encoding','binary');
                              $response->header('Expires','0');
                              $response->header('Cache-Control:',' must-revalidate');
                              $response->header('Paragma','public');
                              $response->header('Content-Type','text/xml');
                              $test = Storage::disk('public')->put("$generate_exports.xml",$response);
  
                              return $response;
                            
                                  if ($test!==false) {
                                    # code...
                                    $StoragePath  = Storage::disk('public')->getDriver()->getAdapter()->applyPathPrefix("$generate_exports.xml");

                                      $file = new Exports_list();
                                      $file->path = $StoragePath;
                                      $file->fieldname = "$generate_exports.xml";
                                      $file->user_by = Auth::User()->name;
                                      $file->company_branch_id = $this->rest->session()->get('id');
                                      $file->save();
  
                                    return redirect()->back()->withSuccess('Data has been saved, check export list.');
  
                                  } 
                                    else {
  
                                      return false;
                                      
                                }
                            } 
                        }
                    }
  
                } catch(\Exception $e){
                        
                      report($e);
                  
                          return false;
  
            }
  
      }

      function table_exports($branch_id){

        $APIs = $this->APIaccurateimport::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);

        $id_gens = 1;
        $alert_items = Item::where('flag',0)->get();
        $data_customer_transport_sys_alerts = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $prefix = Company_branchs::globalmaster($branch_id)->first();
        
        $file = Exports_list::whereIn('company_branch_id', [$branch_id])->orderBy('updated_at', 'DESC')->get();
          return Response()->view('xml_files.export_list',[
            'menu'=>'Export List',
            'files' => $file,
            'gens' => $id_gens,
            'choosen_user_with_branch' => $this->rest->session()->get('id'),
            'some' => $this->rest->session()->get('id'),
            'prefix' => $prefix,
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2'],
            'system_alert_item_vendor' => $data_customer_transport_sys_alerts,
            'system_alert_item_customer' => $data_item_alert_sys_allows0,
            'alert_items' => $alert_items,
            'alert_customers' => $alert_customers]);
      }
      
      function table_warehouse_order($branch_id){

        $APIs = $this->APIaccurateimport::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);

        $id_auto = 1;
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $alert_items = Item::where('flag',0)->get();
        $data_customer_transport_sys_alerts = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $warehouseTolist = Warehouse_order::with('warehouse_o_status','customers_warehouse','sub_service.remarks','users')
        ->where('company_branch_id', $branch_id)
        ->orderByDesc('updated_at')->get();
        $trashlist = Warehouse_order::with('customers_warehouse','sub_service.remarks')
                                        ->onlyTrashed()
                                          ->get();
          $prefix = Company_branchs::branchwarehouse($branch_id)->first();
                      $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
                          'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();

                  $branch = $this->rest->session()->get('id');
        return view('admin.accounting.list_order_status_warehouse',[
            'menu'=>'Warehouse Order List',
            'choosen_user_with_branch' => $branch_id,
            'some' => $branch_id,
            'alert_customers'=> $alert_customers,
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2'],
            'system_alert_item_customer' => $data_item_alert_sys_allows0,
            'system_alert_item_vendor' => $data_customer_transport_sys_alerts,
            'alert_items'=> $alert_items])->with(compact('warehouse_o_status','trashlist',
            'warehouseTolist','id_auto','prefix','date_now','customers_warehouse','sub_service')
          );
      }

      function table_transport_order($branch_id){
        $APIs = $this->APIaccurateimport::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);
        $alert_items = Item::where('flag',0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        // $data_transport = Transport_orders::with('')
        $data_transport = Transport_orders::with('customers','cek_status_transaction')
        ->where('company_branch_id', $branch_id)
        ->orderBy('order_id', 'asc')->get();
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();

        $fetch_izzy = dbcheck::where('check_is','=','api_izzy')->get();

        foreach ($fetch_izzy as $value) {
            # code...
            $fetchArrays[] = $value->check_is;
        } 

        if(isset($fetchArrays) != null){
            $operations_api_izzy_is_true_v1 = dbcheck::where('check_is','=','api_izzy')->get();

            foreach ($operations_api_izzy_is_true_v1 as $operationz) {
                # code...
                $fetchArray1 = $operationz->operation;
            } 

            $operations_api_izzy_is_true_v2 = dbcheck::where('check_is','=','api_accurate')->get();
            
            foreach ($operations_api_izzy_is_true_v2 as $operations) {
                # code...
                $fetchArray2 = $operations->operation;
            } 

        } 

        $prefix = Company_branchs::branchwarehouse($branch_id)->first();
        return view('admin.accounting.list_order_status_transport',[
            'menu'=>'Transport Order List',
            'system_alert_item_customer' => $data_item_alert_sys_allows0,
            'alert_items' => $alert_items,
            'choosen_user_with_branch' => $branch_id,
            'some' => $branch_id,
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2'],
            'system_alert_item_vendor' => $system_alert_item_vendor,
            'alert_customers' => $alert_customers]
        )->with(compact('data_transport','prefix'));
      }

      
    public function download_exports($branch_id, Exports_list $exp, $id)
    {
      $file = Exports_list::orderBy('created_at', 'DESC')->find($id);
      $StoragePath = Storage::url($file->fieldname);
      $donlod = Storage::disk('public')->getAdapter()->applyPathPrefix($file->fieldname);

        if (file_exists($donlod)) { 
        
          return \Response::download($donlod); 
         
        } else { 
              return redirect()->back()->with("error","File yang diminta tidak tersedia di server kami, Report developer!");
          
          }

    }

      public function object_unique($obj){

          $objArray = (array) $obj;

          $objArray = array_intersect_assoc(array_unique($objArray), $objArray);

          foreach((array) $obj as $n => $f) {
              if(!array_key_exists($n, $objArray)) unset($obj->$n);
          }

          return $obj;

      }

    function xml_files($branch_id, Request $request){
          # code...
      if ($request->has('check_sales_order')) {
        $fetch_id = count($request->get('check_sales_order'));

            if ( $fetch_id >= 2) {
              # code...
  
          $warehouseTolist = Warehouse_order::with('sales_name_whs','warehouse_o_status','customers_warehouse','sub_service.item','sub_service.remarks')
              ->find($request->input('check_sales_order'));
             
              $id = Exports_list::select('id')->max('id');
              $increment_ex = $id+1;
              if ($id==null) {
                # code...
                $generate_exports = (str_repeat(Carbon::now()->format('dmy').'0', 2-strlen($increment_ex))). $increment_ex;
              }
              if ($id >= 1 && $id < 10) {
                $generate_exports = (str_repeat(Carbon::now()->format('dmy').'0', 2-strlen($increment_ex))). $increment_ex;
              }
               if ($id >= 9 && $id < 101) {
                $generate_exports = (str_repeat(Carbon::now()->format('dmy').'0', 3-strlen($increment_ex))). $increment_ex;
                }
              if ($id >= 99 && $id < 100) {
              $generate_exports = (str_repeat(Carbon::now()->format('dmy').'0', 4-strlen($increment_ex))). $increment_ex;
              } 
            if ($id >= 100 && $id < 1000) {
              $generate_exports = (str_repeat(Carbon::now()->format('dmy').'0', 4-strlen($increment_ex))). $increment_ex;
            }
              if ($id >= 999 && $id < 10000) {
                $generate_exports = (str_repeat(Carbon::now()->format('dmy').'0', 5-strlen($increment_ex))). $increment_ex;
              }     
                if ($id >= 9999 && $id < 100000) {
                  $generate_exports = (str_repeat(Carbon::now()->format('dmy').'0', 6-strlen($increment_ex))). $increment_ex;
                }
          if (ob_get_contents()) ob_end_clean();
          flush();
          $time = Carbon::now()->format('dmy');
            $response = response()->view('xml_files.xml_so',[
              'warehouse_orders' => $warehouseTolist ,
              'SODATE' => $time
            ])->getContent();
              $test = Storage::disk('public')->put("$generate_exports.xml",$response);
                if ($test!==false) {
                  # code...
                  $StoragePath  = Storage::disk('public')->getDriver()->getAdapter()->applyPathPrefix("$generate_exports.xml");
                  $file = new Exports_list();
                  $file->path = $StoragePath;
                  $file->fieldname = "$generate_exports.xml";
                  $file->user_by = Auth::User()->name;
                  $file->json_file = $request->input('check_sales_order');
                  $file->id_table = 0;
                  $file->company_branch_id = $this->rest->session()->get('id');
                  $file->save();
                    # code...
                  $whs = Warehouse_order::whereIn('id',$request->input('check_sales_order'));
                  
                  $data_status_fix = array();
                  
                  foreach ($warehouseTolist as $key => $value) {
                    # code...
                     $data[] = $value;
        
                  }
                      foreach ($data as $key => $value) {
                        # code...
                        $ko[] = $value->warehouse_o_status->status_name;

                      }

                      $data_status_fix = $ko;

                      $asdas = implode(",",$data_status_fix);
                      $asdasxz = explode(",",$asdas);
                      $asdzxccczxxx = array();

                    foreach ($asdasxz as $keysxc => $value) {
                      
                      $asdzxccczxxx[$keysxc] = $value;

                    }
                    
                foreach ($asdzxccczxxx as $sdsadxc => $valuesdx) {

                      // this update track history data with status draft only -> update data on warehouse order
                        if($valuesdx=="draft"){
                          // #code to do something code
                          $arrayorderlog = array();
                          $iddsd = array();
                          $array_set_vnd = array();

                          $sdkoaskd = implode(",", $request->input('check_sales_order'));
                          $sadasczxc = explode(",", $sdkoaskd);
          
                            foreach($sadasczxc as $keyx=>$value) {
                
                              $iddsd[] = $value;
                    
                            }
                        
                                $sadasczxc = $iddsd;
                                

                                $idToLogOrderIdArray = Warehouse_order::whereIn('id',$sadasczxc)->where('status_order_id','=',1)->get();
          
                                foreach($idToLogOrderIdArray as $keyx=>$value) {
                    
                                  $arrayorderlog[] = $value->order_id;
                        
                                }
            
                                  $idToLogOrderIdArray = $arrayorderlog;
                                  // dd($sdsadxc);
                                
                                  // die();
                                  $sdkoaskd = implode(",", $idToLogOrderIdArray);
                                  $asdzxsd = explode(",", $sdkoaskd);

                                  foreach($asdzxsd as $key=>$value) {
                                
                                      $array_set_vnd[] = $value;
                      
                                  }

                      $data_order_draft = array();
                      $asdzxsd = $array_set_vnd;
                      
                      $idToLogOrderIdArray = Warehouse_order::whereIn('id',$sadasczxc)->where('status_order_id','=',1)->get();

                        foreach($idToLogOrderIdArray as $keyx=>$value) {
              
                          $arrayorderlog[] = $value->order_id;
                
                          $idToLogOrderIdArray = $arrayorderlog;

                        $keys_order_id = $this->object_unique($keyx);
                          $data_order_draft[] = [
                            'user_id' => Auth::User()->id,
                            'order_id' => $idToLogOrderIdArray[$keys_order_id],
                            'status' => 2,
                            'datetime' => Carbon::now(),
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                          ];

                      continue;

                    }

              }

                    if ($valuesdx=="process") {
                      # code...
                        $arrayorderlog = array();
                        $iddsd = array();
                        $array_set_vnd = array();
    
                        $sdkoaskd = implode(",", $request->input('check_sales_order'));
                        $sadasczxc = explode(",", $sdkoaskd);
        
                          foreach($sadasczxc as $keyx=>$value) {
              
                            $iddsd[] = $value;
                  
                          }
                      
                              $sadasczxc = $iddsd;
    
                              $idToLogOrderIdArray = Warehouse_order::whereIn('id',$sadasczxc)->where('status_order_id','=',2)->get();
        
                              foreach($idToLogOrderIdArray as $keyx=>$value) {
                  
                                $arrayorderlog[] = $value->order_id;
                      
                              }
      
                            $idToLogOrderIdArray = $arrayorderlog;
                      
                          $data_order_process = array();


                          $idToLogOrderIdArray = Warehouse_order::whereIn('id',$sadasczxc)->where('status_order_id','=',2)->get();
                            foreach($idToLogOrderIdArray as $keyx=>$value) {
                  
                                $arrayorderlog[] = $value->order_id;
                          
                                  $idToLogOrderIdArray = $arrayorderlog;
          
                                  # code...
                                  $keys_order_id = $this->object_unique($keyx);
                                      $data_order_process[] = [
                                        'user_id' => Auth::User()->id,
                                        'order_id' => $idToLogOrderIdArray[$keys_order_id],
                                        'status' => 2,
                                        'datetime' => Carbon::now(),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                      ];
                                  continue;
                              
                            }
        
                    }


                        if ($valuesdx=="upload") {
                          # code...
                            $arrayorderlog = array();
                            $iddsd = array();
                            $array_set_vnd = array();
        
                            $sdkoaskd = implode(",", $request->input('check_sales_order'));
                            $sadasczxc = explode(",", $sdkoaskd);
            
                              foreach($sadasczxc as $keyx=>$value) {
                  
                                $iddsd[] = $value;
                      
                              }
                          
                                  $sadasczxc = $iddsd;
        
                                  $idToLogOrderIdArray = Warehouse_order::whereIn('id',$sadasczxc)->where('status_order_id','=',6)->get();
            
                                  foreach($idToLogOrderIdArray as $keyx=>$value) {
                      
                                    $arrayorderlog[] = $value->order_id;
                          
                                  }
          
                                $idToLogOrderIdArray = $arrayorderlog;
                          
                              $data_order_upload = array();
                              

                                $idToLogOrderIdArray = Warehouse_order::whereIn('id',$sadasczxc)->where('status_order_id','=',6)->get();
      
                              foreach($idToLogOrderIdArray as $keyx=>$value) {
                    
                                  $arrayorderlog[] = $value->order_id;
                            
                                  $idToLogOrderIdArray = $arrayorderlog;
            
                                  # code...
                                    $keys_order_id = $this->object_unique($keyx);
                                      $data_order_upload[] = [
                                        'user_id' => Auth::User()->id,
                                        'order_id' => $idToLogOrderIdArray[$keys_order_id],
                                        'status' => 6,
                                        'datetime' => Carbon::now(),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                      ];

                                  continue;
                              }


                        }

                           // this update track history data with status invoice only
                           if ($valuesdx=="invoice") {
                            # code...
                              $arrayorderlog = array();
                              $iddsd = array();
                              $array_set_vnd = array();
          
                              $sdkoaskd = implode(",", $request->input('check_sales_order'));
                              $sadasczxc = explode(",", $sdkoaskd);
              
                                foreach($sadasczxc as $keyx=>$value) {
                    
                                  $iddsd[] = $value;
                        
                                }
                            
                                    $sadasczxc = $iddsd;
          
                                    $idToLogOrderIdArray = Warehouse_order::whereIn('id',$sadasczxc)->where('status_order_id','=',3)->get();
              
                                    foreach($idToLogOrderIdArray as $keyx=>$value) {
                        
                                      $arrayorderlog[] = $value->order_id;
                            
                                    }
            
                                  $idToLogOrderIdArray = $arrayorderlog;
                            
                                $data_order_invoice = array();
                                

                                
                                  $idToLogOrderIdArray = Warehouse_order::whereIn('id',$sadasczxc)->where('status_order_id','=',3)->get();
            
                                    foreach($idToLogOrderIdArray as $keyx=>$value) {
                          
                                      $arrayorderlog[] = $value->order_id;
                              
                                      $idToLogOrderIdArray = $arrayorderlog;
              
                                    $keys_order_id = $this->object_unique($keyx);
                                        $data_order_invoice[] = [
                                          'user_id' => Auth::User()->id,
                                          'order_id' => $idToLogOrderIdArray[$keys_order_id],
                                          'status' => 3,
                                          'datetime' => Carbon::now(),
                                          'created_at' => Carbon::now(),
                                          'updated_at' => Carbon::now(),
                                        ];
                                        
                                    continue;

                                  }

                    
                          }

                            if ($valuesdx=="pod") {
                              # code...
                                $arrayorderlog = array();
                                $iddsd = array();
            
                                $sdkoaskd = implode(",", $request->input('check_sales_order'));
                                $sadasczxc = explode(",", $sdkoaskd);
                
                                  foreach($sadasczxc as $keyx=>$value) {
                      
                                    $iddsd[] = $value;
                          
                                  }
                              
                                      $sadasczxc = $iddsd;
            
                                      $idToLogOrderIdArray = Warehouse_order::whereIn('id',$sadasczxc)->where('status_order_id','=',7)->get();
                
                                      foreach($idToLogOrderIdArray as $keyx=>$value) {
                          
                                        $arrayorderlog[] = $value->order_id;
                              
                                      }
              
                                    $idToLogOrderIdArray = $arrayorderlog;
                              
                                  $data_order_pod = array();
                                  

                                        $idToLogOrderIdArray = Warehouse_order::whereIn('id',$sadasczxc)->where('status_order_id','=',7)->get();
                    
                                        foreach($idToLogOrderIdArray as $keyx=>$value) {
                                  
                                          $arrayorderlog[] = $value->order_id;
                                
                                        $idToLogOrderIdArray = $arrayorderlog;
                    
                                          $keys_order_id = $this->object_unique($keyx);
                                              $data_order_pod[] = [
                                                'user_id' => Auth::User()->id,
                                                'order_id' => $idToLogOrderIdArray[$keys_order_id],
                                                'status' => 7,
                                                'datetime' => Carbon::now(),
                                                'created_at' => Carbon::now(),
                                                'updated_at' => Carbon::now(),
                                              ];
                                              
                                          continue;
                                          
                                        }
                                        
                    
                            }

                              if ($valuesdx=="paid") {
                                # code...
                                  $arrayorderlog = array();
                                  $iddsd = array();
                                  $array_set_vnd = array();
              
                                  $sdkoaskd = implode(",", $request->input('check_sales_order'));
                                  $sadasczxc = explode(",", $sdkoaskd);
                  
                                    foreach($sadasczxc as $keyx=>$value) {
                        
                                      $iddsd[] = $value;
                            
                                    }
                                
                                        $sadasczxc = $iddsd;
              
                                        $idToLogOrderIdArray = Warehouse_order::whereIn('id',$sadasczxc)->where('status_order_id','=',8)->get();
                  
                                        foreach($idToLogOrderIdArray as $keyx=>$value) {
                            
                                          $arrayorderlog[] = $value->order_id;
                                
                                        }
                
                                      $idToLogOrderIdArray = $arrayorderlog;
                                
                                    $data_order_paid = array();
                                    
                                  $idToLogOrderIdArray = Warehouse_order::whereIn('id', $sadasczxc)->where('status_order_id', '=', 8)->get();
            
                                    foreach ($idToLogOrderIdArray as $keyx=>$value) {

                                        $arrayorderlog[] = $value->order_id;
                        
                                        $idToLogOrderIdArray = $arrayorderlog;
        
                                          $keys_order_id = $this->object_unique($keyx);
                                              $data_order_paid[] = [
                                                'user_id' => Auth::User()->id,
                                                'order_id' => $idToLogOrderIdArray[$keys_order_id],
                                                'status' => 8,
                                                'datetime' => Carbon::now(),
                                                'created_at' => Carbon::now(),
                                                'updated_at' => Carbon::now(),
                                              ];
                                              
                                          continue;
            
                                    }

                            }

                }

                foreach ($asdzxccczxxx as $sdsadxc => $valuesdx) {
                      if ($valuesdx=="draft") {
                        # code...
                            if($sdsadxc > 0){

                                $arrayorderlog = array();
                                $iddsd = array();
                                $array_set_vnd = array();
            
                                $sdkoaskd = implode(",", $request->input('check_sales_order'));
                                $sadasczxc = explode(",", $sdkoaskd);
                
                                  foreach($sadasczxc as $keyx=>$value) {
                      
                                    $iddsd[] = $value;
                          
                                  }
                              
                                  $sadasczxc = $iddsd;
                                  $values=array('status_order_id'=> 2);
                                  $sdasd = $warehouseTolist->whereIn('id',$sadasczxc)->where('status_order_id','=',1);
                                  
                                    foreach ($sdasd as $command)
                                    {
                                        $command->status_order_id = 2;
                                        $command->save();
                                    }

                                $results = Order_history::insert($data_order_draft);
                                break 1;

                            }

                      }

                }


                foreach ($asdzxccczxxx as $sdsadxc => $valuesdx) {
                  if ($valuesdx=="process") {
                    if($sdsadxc >= 0){
                      $results = Order_history::insert($data_order_process);
                      break 1;
                    }
                  }
                }

                foreach ($asdzxccczxxx as $sdsadxc => $valuesdx) {
                  if ($valuesdx=="upload") {
                    if($sdsadxc >= 0){
                      $results = Order_history::insert($data_order_upload);
                      break 1;
                    }
                  }
                }

                foreach ($asdzxccczxxx as $sdsadxc => $valuesdx) {
                  if ($valuesdx=="invoice") {
                    if($sdsadxc >= 0){
                      $results = Order_history::insert($data_order_invoice);
                      break 1;
                    }
                  }
                }

                foreach ($asdzxccczxxx as $sdsadxc => $valuesdx) {
                  if ($valuesdx=="pod") {
                    if($sdsadxc >= 0){
                      $results = Order_history::insert($data_order_pod);
                      break 1;
                    }
                  }
                }

                foreach ($asdzxccczxxx as $sdsadxc => $valuesdx) {
                  if ($valuesdx=="paid") {
                    if($sdsadxc >= 0){
                      $results = Order_history::insert($data_order_paid);
                      break 1;
                    }
                  }
                }
               
            return redirect()->back()->withSuccess("Data berhasil di export, file:$generate_exports.xml");
                
                } 
                      else {
    
                          return false;
  
                    }
                
                return redirect()->back()->withSuccess("export berhasil dengan nama file:$generate_exports.xml");
                
              } 
                  
              else {
                
                    swal()->toast()->message("Maaf anda tidak boleh mengeksport file kurang dari 2 file","\n[ Peringatan ] Maaf process tidak bisa dilanjutkan",'warning'); 
                  
                  return redirect()->back();
                
              }

          }
              else {
              
                  swal()->toast()->message("Maaf anda belum memilih list order\nsilahkan check list file pada tabel order yang tersedia!","\n[ Peringatan ] Maaf process tidak bisa dilanjutkan",'error'); 
                
                  return redirect()->back();
              
            }
  
      }

      public function find_show_status_order(Exports_list $export_list,Warehouse_order $whs, Request $request, $id)
      {
        $data_results = $export_list->where('id',$id)->first();
        $sdas = $data_results->json_file;

        return response()->json($sdas);
      }

      public function find_show_status_order_3pl_whs_ops(Exports_list $export_list,Warehouse_order $whs, Request $request, $id)
      {
    
        $warehouseTolist = $whs->with('warehouse_o_status')->where('id',$id)->get();

        // $arrayorderlog = array();

        //   foreach($warehouseTolist as $keyx=>$value) {
              
        //       $arrayorderlog[$keyx] = $value->order_id;
    
        //   }
    
        //     $warehouseTolist = $arrayorderlog;

        //     foreach($warehouseTolist as $oo =>$arrvitemidx) {

        //       $data_order[] = [
        //           'user_id' => Auth::User()->id,
        //           'order_id' => $arrvitemidx,
        //           'status' => 2,
        //           'datetime' => Carbon::now(),
        //           'created_at' => Carbon::now(),
        //           'updated_at' => Carbon::now(),
        //       ];
    
        //     }

        // Order_history::insert($data_order);
      
      }

      public function findShowStatusOrderTransport(Exports_list $export_list,Warehouse_order $whs, Request $request, $id)
      {
          // $warehouseTolist = $whs->with('warehouse_o_status')->where('id', $id)->first();
          // return response()->json($warehouseTolist);

          // $dor = $export_list->findOrFail($id);
          // $dor->status_download = "1";
          // $dor->save();
      }

      public function updateStatusTransportOrders(Exports_list $exp, Transport_orders $tc, Request $request, $id_shipmnts)
      {

        try {

          $transports = $tc->where('id',$id_shipmnts)->update(['status_order_id' => $request->update_status_trnports]);
          $dor = $exp->findOrFail($request->id_xml);
          $dor->status_download = "1";
          $dor->save();

          $idToLogOrderIdArray = $tc->whereIn('id',[$id_shipmnts])->get();

          foreach($idToLogOrderIdArray as $keyx=>$value) {
            
            $arrayorderlog[$keyx] = $value->order_id;
    
          }

          $idToLogOrderIdArray = $arrayorderlog;

              $exploit_array = implode(",", $idToLogOrderIdArray);
              $reverse = explode(",", $exploit_array);

                      foreach($reverse as $kunci =>$arrvitemidx) {

                        $data_order[] = [
                            'user_id' => Auth::User()->id,
                            'order_id' => $arrvitemidx,
                            'status' => $request->update_status_trnports,
                            'datetime' => Carbon::now(),
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];

                      }

                    TrackShipments::insert($data_order);

                return back();

            } catch(\Exception $e){

              return back()->withError($e->getMessage())->withInput();
              
            }

      }

      public function findIdSt(Transport_orders $tc, $id){

        $transportList = $tc->with('cek_status_transaction')->where('id', $id)->first();

        return response()->json($transportList);

      }

      public function updateStatusTC(TrackShipments $oh, Transport_orders $tc, Request $request, $index, $status)
      {
          
          try {

                  $idToArray = explode(",",$index);
                  $tempArray = array();
                  
                      foreach($idToArray as $key=>$value) {
                        
                          $tempArray[$key] = $value;

                      }

                  $idToArray = $tempArray;

                $idToLogOrderIdArray = $tc->find([$idToArray]);


                      foreach($idToLogOrderIdArray as $keyx=>$value) {
                        
                          $arrayorderlog[$keyx] = $value->order_id;

                      }

              $idToLogOrderIdArray = $arrayorderlog;

            $tc->whereIn('id', $idToArray)->update(['status_order_id' => $status]);
            // $tc->whereIn('id', $idToArray)->update(['status_order_id' => $request->update_status_trnports]);
                  
                  if ($status == "8"):

                    $primaryShipment = $tc->whereIn('id', [$idToArray])->with(['customers','itemtransports.masteritemtc'])->first();
                    $fetch_data = $tc->whereIn('id', [$idToArray])->with(['customers','itemtransports.masteritemtc'])->get();
                    $fetchBatchItemOrderDetail = $this->batch_item->with(['transportsIDX','masterItemIDACCURATE'])->whereIn('transport_id', [$primaryShipment->id] )->get();
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
                        
                          /**
                          * @form_data send rached izzy Transport 
                          */

                          $sub_service_id[] = $thisDataTransports->itemtransports["sub_service_id"];
                          $projectId = (Int) $thisDataTransports->customers["project_id"];
                          $Collie = $thisDataTransports["collie"];
                          $actual_weight = $thisDataTransports["actual_weight"];
                          $chargeable_weight = $thisDataTransports["chargeable_weight"]; 
                          $etd = $thisDataTransports["estimated_time_of_delivery"]; 
                          $eta = $thisDataTransports["estimated_time_of_arrival"]; 
                          $time_zone = $thisDataTransports["time_zone"];
                          $notes = $thisDataTransports["notes"];

                          $origin = $thisDataTransports["origin"];
                          $origin_address = $thisDataTransports["origin_address"];
                          $origin_contact = $thisDataTransports["origin_contact"];
                          $origin_phone = $thisDataTransports["origin_phone"];

                          $destination = $thisDataTransports["destination"];
                          $destination_details = $thisDataTransports["destination_details"];
                          $pic_name_destination = $thisDataTransports["pic_name_destination"];
                          $pic_phone_destination = $thisDataTransports["pic_phone_destination"];

                          $x[] = $thisDataTransports;

                          break 1;

                       }
                        // $AccurateCloudSalesQuotation = $this->openModulesAccurateCloud
                        //   ->FuncOpenmoduleAccurateCloudSaveSalesQoutation(
                        //       'SQ.'.$order_id[0],
                        //       $dataARRXCUSTOMER[0],
                        //       $dataARRXITEMTRANSPORT[0],
                        //       $this->datenow,
                        //       $dataHARGA[0],
                        //       $dataARRXQTITY[0],
                        //       $dataARRXITEMTRANSPORTITEMUNIT[0]
                        // ); 
                        // dd($projectId);die;

                        $client = new Client(['auth' => ['samsunguser', 'asdf123']]);
                        $response = $client->post(
                                'http://api.trial.izzytransport.com/customer/v1/shipment/new',
                                [
                                    'headers' => [
                                        'Content-Type' => 'application/x-www-form-urlencoded',
                                        'X-IzzyTransport-Token' => 'ab567919190b1b8df2b089c02e0eb3321124cf6f.1575862464',
                                        'Accept' => 'application/json'
                                    ],
                                        'form_params' => [
                                            'Sh[projectId]' => $projectId,
                                            'Sh[vendorId]' => '10', // remember this manually, check your request from matching API izzy and form order
                                            'Sh[poCodes]' => '',
                                            'Sh[collie]' => $Collie,
                                            'Sh[actualWeight]' => $actual_weight,
                                            'Sh[chargeableWeight]' => $chargeable_weight,
                                            'Sh[loadingType]' => 'Item Code',
                                            'Sh[service]' => (Int) $sub_service_id,
                                            'Sh[etd]' => $etd,
                                            'Sh[eta]' => $eta,
                                            'Sh[timeZone]' => $time_zone,
                                            'Sh[notes]' => $notes,
                                            'Sh[origin]' => $origin,
                                            'Sh[originCompany]' => $origin,
                                            'Sh[originAddress]' => $origin_address,
                                            'Sh[originContact]' => $origin_contact,
                                            'Sh[originPhone]' => $origin_phone,
                                            'Sh[destination]' => $destination,
                                            'Sh[destinationCompany]' => $destination,
                                            'Sh[destinationAddress]' => $destination_details,
                                            'Sh[destinationContact]' => $pic_name_destination,
                                            'Sh[destinationPhone]' => $pic_phone_destination
                                        ]
                                    ]
                                );
            
                        $jsonArray = json_decode($response->getBody()->getContents(), true);

                        $ShipmentCode = (String) $jsonArray['Shipment']['code'];

                        $AccurateCloudSalesOrders = $this->openModulesAccurateCloud
                            ->FuncOpenmoduleAccurateCloudSaveSalesOrders(
                                'SO.'.$ShipmentCode,
                                $dataARRXCUSTOMER[0],
                                // $dataARRXITEMTRANSPORT[0],
                                $itemTRANSPORT,//modifyitemTRANSPORT
                                $this->datenow,
                                // $SQ["d"][0]["r"]["number"],
                                $hargaID,//modify
                                $qty,//modify
                                $transport_id,
                                $detailnotes
                        );

                        $SO = $AccurateCloudSalesOrders->getData("+"); 

                                $CEKSQ  = isset($SO["d"][0]["r"]["number"]) 
                                ? $SO["d"][0]["r"]["number"]
                                : [];
                        
                        $checkAsync = collect($CEKSQ)->isEmpty();
                        
                    if($checkAsync == true):

                          $tc->whereIn('id', [$idToArray])->update(
                                      [
                                          'sync_accurate' => "true"
                                      ]
                                  ) 
                              ;

                                  $tc->whereIn('id', [$idToArray])->update(

                                      [
                                        'order_id' => $ShipmentCode
                                      ]
                                
                                  );

                                return response()->json(["response" => "Mohon maaf sinkronisasi gagal diproses"]);

                            else:

                                  $tc->whereIn('id', [$idToArray])->update(
                                          [
                                              'sync_accurate' => "false"
                                          ]
                                      )
                                  ;

                                    $tc->whereIn('id', [$idToArray])->update(
                                          [
                                            'order_id' => $ShipmentCode,
                                            'salesOrders_cloud' => "SO".'.'.$ShipmentCode
                                          ]
                                      )
                                    ;
    
                          return response()->json($CEKSQ);   

                  endif;
                        
                    /**
                     * Update stock barang & jasa [fix]
                     */
                    // self::__getBarangJasa($dataARRXITEMTRANSPORT[0], $dataARRXQTITY[0], $dataHARGA[0]);

                    /**
                     * Update stock inside detail item SQ [fix]
                     */
                    // self::getSQNUMBER($AccurateCloudSalesQuotation->original, $dataARRXQTITY[0]);

                    // $AccurateCloudSalesOrders = $this->openModulesAccurateCloud
                    //   ->FuncOpenmoduleAccurateCloudSaveSalesOrders(
                    //       'SO.'.$order_id[0],
                    //       $dataARRXCUSTOMER[0],
                    //       $dataARRXITEMTRANSPORT[0],
                    //       $this->datenow,
                    //       // $AccurateCloudSalesQuotation->original,
                    //       $dataHARGA[0],
                    //       $dataARRXQTITY[0]
                    // );

                  /**
                   * Update stock inside detail item SO [fix]
                   */
                  // self::getSONUMBER($AccurateCloudSalesOrders->original, "PO123", "testing barang", $dataARRXQTITY[0]);
                          
                  
              endif;

                  if ($status == "2"):

                        $fetch_data = $tc->whereIn('id', [$index])->with(['customers','itemtransports.masteritemtc'])->get();

                        foreach($fetch_data as $key => $thisDataTransports){

                            $order_id[] = $thisDataTransports->order_id; 
                            $dataARRXCUSTOMER[] = $thisDataTransports->customers->itemID_accurate; 
                            $dataARRXITEMTRANSPORT[] = $thisDataTransports->itemtransports->masteritemtc->itemID_accurate; 
                            $SalesQuotationNumber[] = $thisDataTransports->recovery_SQ;
                            $dataARRXQTITY[] = $thisDataTransports->quantity;
                            $dataHARGA[] = $thisDataTransports->harga;

                        }

                        $AccurateCloud = $this->openModulesAccurateCloud
                          ->FuncOpenmoduleAccurateCloudSaveSalesOrders(
                              $dataARRXCUSTOMER[0],
                              $dataARRXITEMTRANSPORT[0],
                              $this->datenow,
                              $SalesQuotationNumber[0],
                              $dataHARGA[0],
                              $dataARRXQTITY[0]
                        );

                        $tc->whereIn('id', $idToArray)->update(

                            [
                              'salesOrders_cloud' => substr($AccurateCloud->original,0,2).'.'.$order_id[0],
                              'recovery_SO' => $AccurateCloud->original
                            ]

                        );

                        $orders_id = $tc->whereIn('id', [$index])->first();

                    connectify('success', 'Accurate cloud berpesan', 'Kode Transaksi: '.$orders_id->order_id.' berhasil membuat dokumen pemesanan penjualan pada code SO: '.$AccurateCloud->original.' berhasil dibuat.');

                  endif;



                  if ($status == "4"):

                        $fetch_data = $tc->whereIn('id', [$index])->with(['customers','itemtransports.masteritemtc'])->get();

                        foreach($fetch_data as $key => $thisDataTransports){

                            $order_id[] = $thisDataTransports->order_id; 
                            $dataARRXCUSTOMER[] = $thisDataTransports->customers->itemID_accurate; 
                            $dataARRXITEMTRANSPORT[] = $thisDataTransports->itemtransports->masteritemtc->itemID_accurate; 
                            $SalesQuotationNumber[] = $thisDataTransports->recovery_SQ;
                            $SalesOrdersNumber[] = $thisDataTransports->recovery_SO;
                            $dataARRXQTITYS[] = $thisDataTransports->quantity;
                            $dataHARGAS[] = $thisDataTransports->harga;
                            $dataARRXITEMTRANSPORTITEMUNITS[] = $thisDataTransports->itemtransports->unit;

                        }

                        $AccurateCloud = $this->openModulesAccurateCloud
                          ->FuncOpenmoduleAccurateCloudSaveDeliveryOrders(
                              $dataARRXCUSTOMER[0],
                              $this->datenow,
                              $dataARRXITEMTRANSPORT[0],
                              $SalesQuotationNumber[0],
                              $SalesOrdersNumber[0],
                              $dataARRXITEMTRANSPORTITEMUNITS[0],
                              $dataARRXQTITYS[0],
                              $dataHARGAS[0]
                        );

                      $tc->whereIn('id', $idToArray)->update(
                        
                          [
                            'deliveryOrders_cloud' => substr($AccurateCloud->original,0,2).'.'.$order_id[0],
                            'recovery_DO' => $AccurateCloud->original
                          ]

                        );

                        $orders_id = $tc->whereIn('id', [$index])->first();

                    connectify('success', 'Accurate cloud berpesan', 'Kode Transaksi: '.$orders_id->order_id.' berhasil membuat dokumen pengiriman pesanan pada code DO: '.$AccurateCloud->original.' berhasil dibuat.');

                  endif;



                  if ($status == "3"):

                    $fetch_data = $tc->whereIn('id', [$index])->with(['customers','itemtransports.masteritemtc'])->get();

                    foreach($fetch_data as $key => $thisDataTransports){

                        $order_id[] = $thisDataTransports->order_id; 
                        $dataARRXCUSTOMERss[] = $thisDataTransports->customers->itemID_accurate;
                        $dataARRXITEMTRANSPORTX[] = $thisDataTransports->itemtransports->masteritemtc->itemID_accurate;
                        $SalesQuotationNumberdgs[] = $thisDataTransports->recovery_SQ;
                        $SalesOrdersNumberxx[] = $thisDataTransports->recovery_SO;
                        $DeliveryOrdersNumbedr[] = $thisDataTransports->recovery_DO;
                        $dataHARGAS[] = $thisDataTransports->harga;
                        $dataARRXQTITYS[] = $thisDataTransports->quantity;
                        $dataARRXITEMTRANSPORTITEMUNITS[] = $thisDataTransports->itemtransports->unit;

                      }
                      
                    $AccurateCloud = $this->openModulesAccurateCloud
                      ->FuncOpenmoduleAccurateCloudSaveSalesInvoice(
                          $dataARRXCUSTOMERss[0],
                          $dataARRXITEMTRANSPORTX[0],
                          $SalesOrdersNumberxx[0],
                          "false",
                          $this->datenow,
                          "",
                          $this->datenow,
                          $SalesOrdersNumberxx[0],
                          $SalesQuotationNumberdgs[0],
                          $DeliveryOrdersNumbedr[0],
                          $dataHARGAS[0],
                          $dataARRXQTITYS[0],
                          $dataARRXITEMTRANSPORTITEMUNITS[0]
                    );

                      $tc->whereIn('id', $idToArray)->update(
                          
                            [
                              'salesInvoice_cloud' => substr($AccurateCloud->original,0,2).'.'.$order_id[0],
                              'recovery_SI' => $AccurateCloud->original
                            ]

                        );

                    $orders_id = $tc->whereIn('id', [$index])->first();

                  connectify('success', 'Accurate cloud berpesan', 'Kode Transaksi: '.$orders_id->order_id.' berhasil membuat dokumen invoice pada code SI: '.$AccurateCloud->original.' berhasil dibuat.');

              endif;


              
              if ($status == "7"):

                $fetch_data = $tc->whereIn('id', [$index])->with(['customers','itemtransports.masteritemtc'])->get();

                foreach($fetch_data as $key => $thisDataTransports){

                    $order_id[] = $thisDataTransports->order_id;
                    $dataCustomer[] = $thisDataTransports->customers->itemID_accurate;
                    $totalPembayaran[] = $thisDataTransports->total_cost;
                    $NoInvoice[] = $thisDataTransports->recovery_SI;

                  }
                  
                      $AccurateCloud = $this->openModulesAccurateCloud
                          ->FuncOpenmoduleAccurateCloudSaveSalesReceipt(
                              "110102",
                              $totalPembayaran[0],
                              $dataCustomer[0],
                              $NoInvoice[0],
                              $totalPembayaran[0],
                              $this->datenow
                        );

                      $tc->whereIn('id', $idToArray)->update(

                            [
                              'salesReceipt_cloud' => substr($AccurateCloud->original,0,2).'.'.$order_id[0],
                              'recovery_ReceiptPayment' => $AccurateCloud->original
                            ]

                        );

                    $orders_id = $tc->whereIn('id', [$index])->first();
                    
                  connectify('success', 'Accurate cloud berpesan', 'Kode Transaksi: '.$orders_id->order_id.' berhasil mengupdate status invoice: '.$NoInvoice[0].' penerimaan pada code SI: '.$AccurateCloud->original.' telah lunas.');

              endif;

            foreach($idToLogOrderIdArray as $oo =>$arrvitemidx) {

                    $data_order[] = [
                        'user_id' => Auth::User()->id,
                        'order_id' => $arrvitemidx,
                        'status' => $request->update_status_trnports,
                        'datetime' => Carbon::now(),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];

                  }

                  $oh->insert($data_order);

                $order_id = $tc->whereIn('id', [$index])->first();

            // return redirect()->back()->with('success','No order: '.$order_id->order_id.' berhasil melakukan transaksi dan diteruskan mengupdate data di accurate cloud.');


          }
                catch (handlingAPIAccurateCloud $handlingApi) {

                        swal()
                            ->toast()
                            ->autoclose(60000)
                                ->message("Error API Accurate Cloud \r\n", '"'.$handlingApi->getResponse()->getBody()->getContents(). '"', 'error');

                    return redirect()->route('transport.static', session()->get('id'));

            }

      }

      public function updated_status_order_idx(Exports_list $exp, Order_history $oh, Warehouse_order $whs, Request $request, $index)
      {
        
          $idToArray = explode(",",$index);
          $tempArray = array();
            
            foreach($idToArray as $key=>$value) {
              
                $tempArray[$key] = $value;

            }

            $idToArray = $tempArray;

            $idToLogOrderIdArray = $whs->find([$idToArray]);


            foreach($idToLogOrderIdArray as $keyx=>$value) {
              
              $arrayorderlog[$keyx] = $value->order_id;

            }

            $idToLogOrderIdArray = $arrayorderlog;

            foreach($idToLogOrderIdArray as $oo =>$arrvitemidx) {

              $data_order[] = [
                  'user_id' => Auth::User()->id,
                  'order_id' => $arrvitemidx,
                  'status' => $request->updated_status_warehouse,
                  'datetime' => Carbon::now(),
                  'created_at' => Carbon::now(),
                  'updated_at' => Carbon::now(),
              ];

            }

            $oh->insert($data_order);

            $whs->whereIn('id',$idToArray)->update(['status_order_id' => $request->updated_status_warehouse]);

            return back();
            
      }

      public function updated_status_order_idasdasdx(Exports_list $exp, Warehouse_order $whs, Request $request, $index, $idwhs)
      {
       
        $idToArray = explode(",",$idwhs);
        $tempArray = array();

        $array_search_status = array();
        $arrayorderlog = array();
        
            foreach($idToArray as $key=>$value) {
              
                $tempArray[$key] = $value;

            }
        
        $idToArray = $tempArray;

        $warehouseTolistsddasdx = $whs->with('warehouse_o_status')->whereIn('id',$idToArray)->get();

        foreach($warehouseTolistsddasdx as $key=>$value) {
              
          $array_search_status[$key] = $value->status_order_id;
      
              
          }

          $warehouseTolistsddasdx = $array_search_status;

        
              $sdxcds = $whs->with('warehouse_o_status')->whereIn('status_order_id',$warehouseTolistsddasdx)->get();

                      foreach($sdxcds as $key=>$value) {
              
                        if ($value->status_order_id==2) {
                          # code...
                          $whs->whereIn('id',$idToArray)->where('status_order_id','=',2)->first()->update(['status_order_id' => 6]);
              
                        } 
              
                        if ($value->status_order_id==7) {
                          # code...
                          $whs->whereIn('id',$idToArray)->where('status_order_id','=',7)->first()->update(['status_order_id' => 3]);
              
              
                        }
              
                        if ($value->status_order_id==6) {
                          # code...
                          $whs->whereIn('id',$idToArray)->where('status_order_id','=',6)->first()->update(['status_order_id' => 7]);
              
                        }
              
                        if ($value->status_order_id==3) {
                          # code...
                          $whs->whereIn('id',$idToArray)->where('status_order_id','=',3)->first()->update(['status_order_id' => 8]);
                          
                        } 
              
                        if ($value->status_order_id==8) {
                          # code...
              
                        } 
              
                        if ($value->status_order_id==1) {
                          # code...
                          $whs->whereIn('id',$idToArray)->where('status_order_id','=',1)->first()->update(['status_order_id' => 2]);
              
                        } 
              
                        if ($value->status_order_id==4) {
                          # code...
                            return false;
                        } 
              
                        if ($value->status_order_id==5) {
                          # code...
                          return false;
              
                        }
              
                  
                      }

                      $dor = $exp->findOrFail($index);
                      $dor->status_download = "1";
                      $infod = $sdasd = $dor->save();

                      $idToLogOrderIdArray = $whs->whereIn('id',$idToArray)->get();

                      foreach($idToLogOrderIdArray as $keyx=>$value) {
                        
                        $arrayorderlog[$keyx] = $value->order_id;
                
                      }

                      $idToLogOrderIdArray = $arrayorderlog;

                      $exploit_array = implode(",", $idToLogOrderIdArray);
                      $reverse = explode(",", $exploit_array);

                          foreach($reverse as $kunci =>$arrvitemidx) {

                            $data_order[] = [
                                'user_id' => Auth::User()->id,
                                'order_id' => $arrvitemidx,
                                'status' => $request->updated_status_warehouse,
                                'datetime' => Carbon::now(),
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ];

                          }

                      Order_history::insert($data_order);

          return back();

      }

        public function find_show_transport_idx(Transport_orders $tc, Request $request, $id)
        {

            $transportList = $tc->with('cek_status_transaction')->where('id',$id)->first();
    
            return response()->json($transportList);
          
        }
      
            public function updated_status_order_idx_tc(Transport_orders $tc, Request $request, $index)
            {

              $transportList = $tc->where('id',$index)->first();
              $transportList->status_order_id = $request->updated_status_transport;
              $transportList->save();
      
              return back();

            }

      public function show_it_isi_xml($branch_id, Warehouse_order $whs, Exports_list $export_list, $id){

          $data_results = $export_list->where('fieldname',$id)->first();
          $json = $data_results->json_file;
          $table_code = $data_results->id_table;
          $warehouseTolist = $whs->with('warehouse_o_status','customers_warehouse','sub_service.remarks','users')
          ->whereIn('id', $json)->get();

          $APIs = $this->APIaccurateimport::callbackme();
          $responsecallbackme = json_decode($APIs->getContent(), true);

          // $warehouseTolist = $whs->with('warehouse_o_status','customers_warehouse','sub_service.remarks','users')
          // ->whereIn('id', $json)->get();
          $warehouseTolist = $whs->with('warehouse_o_status','customers_warehouse','sub_service.remarks','users')->where(function (Builder $query) use($json) {
            return $query->whereIn('id', $json);
          })->get();
          
          if($warehouseTolist->isEmpty()){
              swal()
                ->toast()
                  ->autoclose(9000)
                    ->message("Security detection", "Branch changes are detected in the transaction details!", 'info');
              return redirect()->route('exports.static', session()->get('id'));
          }

          $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
          $alert_items = Item::where('flag',0)->get();
          $data_table_xml = Exports_list::where('fieldname', $id)->first();
          // dd($data_table_xml);
        $data_transport = Transport_orders::with('customers')->whereIn('id', $json)->get();

          $data_customer_transport_sys_alerts = Vendor_item_transports::with('vendors',
          'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
          $prefix = Company_branchs::branchwarehouse($this->rest->session()->get('id'))->first();
          $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
                    'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
          
          session(['data_xml' => $id]);
          return view('admin.warehouse.xml_files_details.data_xml',[
              'menu'=>'XML Files',
              'choosen_user_with_branch' => $this->rest->session()->get('id'),
              'some' => $this->rest->session()->get('id'),
              'api_v1' => $responsecallbackme['api_v1'],
              'api_v2' => $responsecallbackme['api_v2'],
              'alert_customers'=> $alert_customers,
              'system_alert_item_customer' => $data_item_alert_sys_allows0,
              'system_alert_item_vendor' => $data_customer_transport_sys_alerts,
              'alert_items'=> $alert_items])->with(compact('data_table_xml','warehouse_o_status','trashlist',
              'warehouseTolist','id_auto','prefix','date_now','customers_warehouse','sub_service','data_transport')
            );
      
      }

      public function display_date_range_with_accounting(Request $request)
      {
          # code...
          $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
          $alert_items = Item::where('flag',0)->get();
          $date_now = Carbon::now()->format('Y-m-d');
          $system_alert_item_customer = Customer_item_transports::with('customers',
          'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
          $warehouseTolist = Warehouse_order::with('warehouse_o_status',
          'customers_warehouse','sub_service.remarks')->where('company_branch_id', $this->rest->session()->get('id'))
          ->whereBetween(
            'start_date',
            [
                $request->get('datepickerfrom'),
                $request->get('datepickerto')
            ]
          )->get();
          $dates = $warehouseTolist->pluck('start_date')->toArray();
          $prefix = Company_branchs::branchwarehouse($this->rest->session()->get('id'))->first();
  
          $system_alert_item_vendor = Vendor_item_transports::with('vendors',
          'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
          $id_auto = 1;
          $trashlist = Warehouse_order::with('customers_warehouse','sub_service.remarks')
                                          ->onlyTrashed()
                                            ->get();

                                            $APIs = $this->APIaccurateimport::callbackme();
                                            $responsecallbackme = json_decode($APIs->getContent(), true);

            return view('admin.accounting.list_order_status_warehouse',[
                'menu'=>'Warehouse Order List','system_alert_item_vendor' => $system_alert_item_vendor,
                'choosen_user_with_branch' => $this->rest->session()->get('id'),
                'some' => $this->rest->session()->get('id'),
                'api_v1' => $responsecallbackme['api_v1'],
                'api_v2' => $responsecallbackme['api_v2']])->with(compact('warehouse_o_status','trashlist',
                'warehouseTolist','alert_items','prefix','system_alert_item_customer','system_alert_item_vendor ','alert_customers',
                'id_auto','date_now','customers_warehouse','sub_service')
              );
  
              return view('admin.layouts.sidebar',compact('alert_items','alert_customers')
            );
  
      }

      public function display_date_range_with_accounting_transport(Request $request)
      {
          # code...
          $datepickerfrom = $request->flash('request',$request);
          $datepickerto = $request->flash('request',$request);
          $system_alert_item_vendor = Vendor_item_transports::with('vendors',
          'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
          $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
          $alert_items = Item::where('flag',0)->get();
          $date_now = Carbon::now()->format('Y-m-d');
          $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
          'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
          $prefix = Company_branchs::branchwarehouse($request->session()->get('id'))->first();
          $data_transport = Transport_orders::with('cek_status_transaction','customers')
          ->whereBetween(
            'created_at',
            [
                $request->get('datepickerfrom'),
                $request->get('datepickerto')
            ]
          )->get();
  
              $dates = $data_transport->pluck('start_date')->toArray();
              $id_auto = 1;
  
              $fetch_izzy = dbcheck::where('check_is','=','api_izzy')->get();
  
              foreach ($fetch_izzy as $value) {
                  # code...
                  $fetchArrays[] = $value->check_is;
              } 
  
              if(isset($fetchArrays) != null){
                  $operations_api_izzy_is_true_v1 = dbcheck::where('check_is','=','api_izzy')->get();
  
                  foreach ($operations_api_izzy_is_true_v1 as $operationz) {
                      # code...
                      $fetchArray1 = $operationz->operation;
                  } 
  
                  $operations_api_izzy_is_true_v2 = dbcheck::where('check_is','=','api_accurate')->get();
                  
                  foreach ($operations_api_izzy_is_true_v2 as $operations) {
                      # code...
                      $fetchArray2 = $operations->operation;
                  } 
  
              } 
  
              return view('admin.accounting.list_order_status_transport',[
                'menu'=>'Transport Order List',
                'alert_items'=> $alert_items,
                'choosen_user_with_branch' => $this->rest->session()->get('id'),
                'some' => $this->rest->session()->get('id'),
                'api_v1' => $fetchArray1,
                'api_v2' => $fetchArray2,
                'system_alert_item_vendor' => $system_alert_item_vendor,
                'system_alert_item_customer' => $data_item_alert_sys_allows0,
                'alert_customers'=> $alert_customers])->with(compact('datepickerfrom','datepickerto','prefix','data_transport')
            );
              
      }

      function xml_files_transport($branch_id, Request $request, Transport_orders $tc){
      
        if ($request->has('check_data_transport_id')) {
        $data_transport = Transport_orders::with('customers','company_branch','cek_status_transaction','itemtransports')
        ->find($request->input('check_data_transport_id'));
        $id = Exports_list::select('id')->max('id');
            $increment_ex = $id+1;
              if ($id==null) {
                # code...
                $generate_exports = (str_repeat(Carbon::now()->format('dmy').'0', 2-strlen($increment_ex))). $increment_ex;
              }
              if ($id >= 1 && $id < 10) {
                $generate_exports = (str_repeat(Carbon::now()->format('dmy').'0', 2-strlen($increment_ex))). $increment_ex;
              }
               if ($id >= 9 && $id < 101) {
                $generate_exports = (str_repeat(Carbon::now()->format('dmy').'0', 3-strlen($increment_ex))). $increment_ex;
                }
              if ($id >= 99 && $id < 100) {
              $generate_exports = (str_repeat(Carbon::now()->format('dmy').'0', 4-strlen($increment_ex))). $increment_ex;
              } 
            if ($id >= 100 && $id < 1000) {
              $generate_exports = (str_repeat(Carbon::now()->format('dmy').'0', 4-strlen($increment_ex))). $increment_ex;
            }
              if ($id >= 999 && $id < 10000) {
                $generate_exports = (str_repeat(Carbon::now()->format('dmy').'0', 5-strlen($increment_ex))). $increment_ex;
              }     
                if ($id >= 9999 && $id < 100000) {
                  $generate_exports = (str_repeat(Carbon::now()->format('dmy').'0', 6-strlen($increment_ex))). $increment_ex;
                }
              if (ob_get_contents()) ob_end_clean();
            flush();
          $time = Carbon::now()->format('dmy');
            $response = response()->view('xml_files.xml_tc',[
              'transport_orders' => $data_transport,
              'SODATE' => $time
            ])->getContent();
              $test = Storage::disk('public')->put("$generate_exports.xml",$response);
                if ($test!==false) {
                  # code...
                  $StoragePath  = Storage::disk('public')->getDriver()->getAdapter()->applyPathPrefix("$generate_exports.xml");
                  $file = new Exports_list();
                  $file->path = $StoragePath;
                  $file->fieldname = "$generate_exports.xml";
                  $file->company_branch_id = $this->rest->session()->get('id');
                  $file->user_by = Auth::User()->name;
                  $file->json_file = $request->input('check_data_transport_id');
                  $file->id_table = 1;

                  $file->save();

                  foreach ($data_transport as $key => $shipmnt) {
                    # code...
                    $datatcx = $shipmnt->cek_status_transaction->status_name;
                    
                  }
      
                      if($datatcx == "done"){
                        $data_transportsx = Transport_orders::whereIn('id',$request->input('check_data_transport_id'));
                          $data_transportsx->update(
                              [
                                'status_order_id' => 4
                              ]
                          );

                          $idToLogOrderIdArray = $tc->find([$request->input('check_data_transport_id')]);


                          foreach($idToLogOrderIdArray as $keyx=>$value) {
                            
                            $arrayorderlog[$keyx] = $value->order_id;
              
                          }
              
                          $idToLogOrderIdArray = $arrayorderlog;
              
                          foreach($idToLogOrderIdArray as $oo =>$arrvitemidx) {
              
                              $data_order[] = [
                                  'user_id' => Auth::User()->id,
                                  'order_id' => $arrvitemidx,
                                  'status' => 4,
                                  'datetime' => Carbon::now(),
                                  'created_at' => Carbon::now(),
                                  'updated_at' => Carbon::now(),
                              ];
                
                            }
              
                          TrackShipments::insert($data_order);

                      }

                      if($datatcx == "new"){
                        $data_transportsx = Transport_orders::whereIn('id',$request->input('check_data_transport_id'));
                          $data_transportsx->update(
                              [
                                'status_order_id' => 6
                              ]
                          );

                          $idToLogOrderIdArray = $tc->find([$request->input('check_data_transport_id')]);


                          foreach($idToLogOrderIdArray as $keyx=>$value) {
                            
                            $arrayorderlog[$keyx] = $value->order_id;
              
                          }
              
                          $idToLogOrderIdArray = $arrayorderlog;
              
                          foreach($idToLogOrderIdArray as $oo =>$arrvitemidx) {
              
                              $data_order[] = [
                                  'user_id' => Auth::User()->id,
                                  'order_id' => $arrvitemidx,
                                  'status' => 6,
                                  'datetime' => Carbon::now(),
                                  'created_at' => Carbon::now(),
                                  'updated_at' => Carbon::now(),
                              ];
                
                            }
              
                          TrackShipments::insert($data_order);

                      }
      
                      if($datatcx == "draft"){
                        $data_transportdx = Transport_orders::whereIn('id',$request->input('check_data_transport_id'));
                          $data_transportdx->update(
                              [
                                'status_order_id' => 8
                              ]
                          );

                          $idToLogOrderIdArray = $tc->find([$request->input('check_data_transport_id')]);


                          foreach($idToLogOrderIdArray as $keyx=>$value) {
                            
                            $arrayorderlog[$keyx] = $value->order_id;
              
                          }
              
                          $idToLogOrderIdArray = $arrayorderlog;
              
                          foreach($idToLogOrderIdArray as $oo =>$arrvitemidx) {
              
                              $data_order[] = [
                                  'user_id' => Auth::User()->id,
                                  'order_id' => $arrvitemidx,
                                  'status' => 8,
                                  'datetime' => Carbon::now(),
                                  'created_at' => Carbon::now(),
                                  'updated_at' => Carbon::now(),
                              ];
                
                            }
              
                          TrackShipments::insert($data_order);

                      }

                      if($datatcx == "upload"){
                        $data_transportdx = Transport_orders::whereIn('id',$request->input('check_data_transport_id'));
                          $data_transportdx->update(
                              [
                                'status_order_id' => 2
                              ]
                          );

                          $idToLogOrderIdArray = $tc->find([$request->input('check_data_transport_id')]);


                          foreach($idToLogOrderIdArray as $keyx=>$value) {
                            
                            $arrayorderlog[$keyx] = $value->order_id;
              
                          }
              
                          $idToLogOrderIdArray = $arrayorderlog;
              
                          foreach($idToLogOrderIdArray as $oo =>$arrvitemidx) {
              
                              $data_order[] = [
                                  'user_id' => Auth::User()->id,
                                  'order_id' => $arrvitemidx,
                                  'status' => 2,
                                  'datetime' => Carbon::now(),
                                  'created_at' => Carbon::now(),
                                  'updated_at' => Carbon::now(),
                              ];
                
                            }
              
                          TrackShipments::insert($data_order);
                          
                      }

                      if($datatcx == "proses"){
                        $data_transportdx = Transport_orders::whereIn('id',$request->input('check_data_transport_id'));
                          $data_transportdx->update(
                              [
                                'status_order_id' => 2
                              ]
                          );

                          $idToLogOrderIdArray = $tc->find([$request->input('check_data_transport_id')]);

                          foreach($idToLogOrderIdArray as $keyx=>$value) {
                            
                            $arrayorderlog[$keyx] = $value->order_id;
              
                          }
              
                          $idToLogOrderIdArray = $arrayorderlog;
              
                          foreach($idToLogOrderIdArray as $oo =>$arrvitemidx) {
              
                              $data_order[] = [
                                  'user_id' => Auth::User()->id,
                                  'order_id' => $arrvitemidx,
                                  'status' => 2,
                                  'datetime' => Carbon::now(),
                                  'created_at' => Carbon::now(),
                                  'updated_at' => Carbon::now(),
                              ];
                
                            }
              
                            TrackShipments::insert($data_order);
                      }
  
                  return redirect()->back()->withSuccess("export berhasil dengan nama file:$generate_exports.xml");
                
                } 
                    else {
    
                        return false;
    
                  }
  
              return redirect()->back()->withSuccess("export berhasil dengan nama file:$generate_exports.xml");
          }
            else {
            
                return redirect()->back()->with("error","[ TRANSPORT ] Maaf anda belum memilih file, silahkan check list file pada tabel yang tersedia!");
  
            }
  
      }

      function xml_perfiles($branch_id, $index_order_id){
      
        $warehouseTolist = Warehouse_order::with('company_branch','sales_name_whs','item_t','warehouse_o_status','sub_service.item','customers_warehouse','sub_service.remarks')
            ->find($index_order_id);
            $id = Exports_list::select('id')->max('id');
            $increment_ex = $id+1;
            if ($id==null) {
              # code...
              $generate_exports = (str_repeat(Carbon::now()->format('dmy').'0', 2-strlen($increment_ex))). $increment_ex;
            }
            if ($id >= 1 && $id < 10) {
              $generate_exports = (str_repeat(Carbon::now()->format('dmy').'0', 2-strlen($increment_ex))). $increment_ex;
            }
             if ($id >= 9 && $id < 101) {
              $generate_exports = (str_repeat(Carbon::now()->format('dmy').'0', 3-strlen($increment_ex))). $increment_ex;
              }
            if ($id >= 99 && $id < 100) {
            $generate_exports = (str_repeat(Carbon::now()->format('dmy').'0', 4-strlen($increment_ex))). $increment_ex;
            } 
          if ($id >= 100 && $id < 1000) {
            $generate_exports = (str_repeat(Carbon::now()->format('dmy').'0', 4-strlen($increment_ex))). $increment_ex;
          }
            if ($id >= 999 && $id < 10000) {
              $generate_exports = (str_repeat(Carbon::now()->format('dmy').'0', 5-strlen($increment_ex))). $increment_ex;
            }     
              if ($id >= 9999 && $id < 100000) {
                $generate_exports = (str_repeat(Carbon::now()->format('dmy').'0', 6-strlen($increment_ex))). $increment_ex;
              }
          if (ob_get_contents()) ob_end_clean();
          flush();
        $time = Carbon::now()->format('dmy');
          $response = response()->view('xml_files.xml_perfiles',[
            'warehouse_order' => $warehouseTolist,
            'SODATE' => $time        
          ])->getContent();
            $test = Storage::disk('public')->put("$generate_exports.xml",$response);
              if ($test!==false) {
                # code...
                $StoragePath  = Storage::disk('public')->getDriver()->getAdapter()->applyPathPrefix("$generate_exports.xml");
                $file = new Exports_list();
                $file->path = $StoragePath;
                $file->fieldname = "$generate_exports.xml";
                $file->user_by = Auth::User()->name;
                $file->company_branch_id = $this->rest->session()->get('id');
                $file->json_file = array($index_order_id);
                $file->id_table = 0;
                $file->save();
                    $index = $warehouseTolist['status_order_id'];
                        switch($index){

                            case "1":
                                    $idToLogOrderIdArray = Warehouse_order::find([$index_order_id]);
                                    $idToLogOrderIdArray->first()->update(['status_order_id' => 2]);
                                      foreach($idToLogOrderIdArray as $keyx=>$value) {
                                          
                                          $arrayorderlog[$keyx] = $value->order_id;
                                
                                      }
                                  
                                        $idToLogOrderIdArray = $arrayorderlog;
                      
                                          foreach($idToLogOrderIdArray as $oo =>$arrvitemidx) {
                      
                                            $data_order[] = [
                                                'user_id' => Auth::User()->id,
                                                'order_id' => $arrvitemidx,
                                                'status' => 2,
                                                'datetime' => Carbon::now(),
                                                'created_at' => Carbon::now(),
                                                'updated_at' => Carbon::now(),
                                            ];
                                  
                                          }

                                      Order_history::insert($data_order);
                      
                                break;
                            case "2":

                                $idToLogOrderIdArray = Warehouse_order::find([$index_order_id]);
                                $idToLogOrderIdArray->first()->update(['status_order_id' => 6]);

                                  foreach($idToLogOrderIdArray as $keyx=>$value) {
                                      
                                      $arrayorderlog[$keyx] = $value->order_id;
                            
                                  }
                              
                                      $idToLogOrderIdArray = $arrayorderlog;
                  
                                      foreach($idToLogOrderIdArray as $oo =>$arrvitemidx) {
                  
                                        $data_order[] = [
                                            'user_id' => Auth::User()->id,
                                            'order_id' => $arrvitemidx,
                                            'status' => 6,
                                            'datetime' => Carbon::now(),
                                            'created_at' => Carbon::now(),
                                            'updated_at' => Carbon::now(),
                                        ];
                              
                                      }

                                  Order_history::insert($data_order);

                                break;
                            case "3":

                            $idToLogOrderIdArray = Warehouse_order::find([$index_order_id]);
                            $idToLogOrderIdArray->first()->update(['status_order_id' => 3]);

                              foreach($idToLogOrderIdArray as $keyx=>$value) {
                                  
                                  $arrayorderlog[$keyx] = $value->order_id;
                        
                              }
                          
                                  $idToLogOrderIdArray = $arrayorderlog;
              
                                  foreach($idToLogOrderIdArray as $oo =>$arrvitemidx) {
              
                                    $data_order[] = [
                                        'user_id' => Auth::User()->id,
                                        'order_id' => $arrvitemidx,
                                        'status' => 3,
                                        'datetime' => Carbon::now(),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                    ];
                          
                                  }

                                    Order_history::insert($data_order);
                              
                                break;
                            case "4":

                              $idToLogOrderIdArray = Warehouse_order::find([$index_order_id]);
                                  
                                foreach($idToLogOrderIdArray as $keyx=>$value) {
                                    
                                    $arrayorderlog[$keyx] = $value->order_id;
                          
                                }
                            
                                    $idToLogOrderIdArray = $arrayorderlog;
                
                                    foreach($idToLogOrderIdArray as $oo =>$arrvitemidx) {
                
                                      $data_order[] = [
                                          'user_id' => Auth::User()->id,
                                          'order_id' => $arrvitemidx,
                                          'status' => 4,
                                          'datetime' => Carbon::now(),
                                          'created_at' => Carbon::now(),
                                          'updated_at' => Carbon::now(),
                                      ];
                            
                                    }

                                  Order_history::insert($data_order);

                                break; 
                            case "5":
                            $idToLogOrderIdArray = Warehouse_order::find([$index_order_id]);

                              foreach($idToLogOrderIdArray as $keyx=>$value) {
                                  
                                  $arrayorderlog[$keyx] = $value->order_id;
                        
                              }
                          
                                  $idToLogOrderIdArray = $arrayorderlog;
              
                                  foreach($idToLogOrderIdArray as $oo =>$arrvitemidx) {
              
                                    $data_order[] = [
                                        'user_id' => Auth::User()->id,
                                        'order_id' => $arrvitemidx,
                                        'status' => 5,
                                        'datetime' => Carbon::now(),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                    ];
                          
                                  }
                                  
                                  Order_history::insert($data_order);
                                
                                break;
                            case "6":

                            $idToLogOrderIdArray = Warehouse_order::find([$index_order_id]);
                            $idToLogOrderIdArray->first()->update(['status_order_id' => 2]);

                              foreach($idToLogOrderIdArray as $keyx=>$value) {
                                  
                                  $arrayorderlog[$keyx] = $value->order_id;
                        
                              }
                          
                                  $idToLogOrderIdArray = $arrayorderlog;
              
                                  foreach($idToLogOrderIdArray as $oo =>$arrvitemidx) {
              
                                    $data_order[] = [
                                        'user_id' => Auth::User()->id,
                                        'order_id' => $arrvitemidx,
                                        'status' => 2,
                                        'datetime' => Carbon::now(),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                    ];
                          
                                  }

                                  Order_history::insert($data_order);
                             
                              break;
                            case "7":

                                    $idToLogOrderIdArray = Warehouse_order::find([$index_order_id]);
                                    $idToLogOrderIdArray->first()->update(['status_order_id' => 8]);

                                      foreach($idToLogOrderIdArray as $keyx=>$value) {
                                          
                                          $arrayorderlog[$keyx] = $value->order_id;
                                
                                      }
                                  
                                          $idToLogOrderIdArray = $arrayorderlog;
                      
                                          foreach($idToLogOrderIdArray as $oo =>$arrvitemidx) {
                      
                                            $data_order[] = [
                                                'user_id' => Auth::User()->id,
                                                'order_id' => $arrvitemidx,
                                                'status' => 8,
                                                'datetime' => Carbon::now(),
                                                'created_at' => Carbon::now(),
                                                'updated_at' => Carbon::now(),
                                            ];
                                  
                                          }
                                      Order_history::insert($data_order);
                                break;    
                            case "8":

                            $idToLogOrderIdArray = Warehouse_order::find([$index_order_id]);
                            $idToLogOrderIdArray->first()->update(['status_order_id' => 4]);

                              foreach($idToLogOrderIdArray as $keyx=>$value) {
                                  
                                  $arrayorderlog[$keyx] = $value->order_id;
                        
                              }
                          
                                  $idToLogOrderIdArray = $arrayorderlog;
              
                                  foreach($idToLogOrderIdArray as $oo =>$arrvitemidx) {
              
                                    $data_order[] = [
                                        'user_id' => Auth::User()->id,
                                        'order_id' => $arrvitemidx,
                                        'status' => 4,
                                        'datetime' => Carbon::now(),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                    ];
                          
                                  }
                                
                                  Order_history::insert($data_order);
                                
                                break;
                            default:
                                echo "No information available";
                            break;
                    }

                  session(['indexorderid'=> $index_order_id]);

              return redirect()->back()->withSuccess("Your order in process, Export berhasil dengan nama file: $generate_exports.xml");

        } 
            else {
            
                return redirect()->back()->with("error","Terjadi Kesalahan, report developer.");

          }

    }


      function xml_perfiles_transport__($branch_id, $index_transport_id, Transport_orders $tc){
     
          $data_transport = Transport_orders::with('customers','company_branch','cek_status_transaction')->whereIn('id',[$index_transport_id])->get();
          // dd($data_transport);die;
            
          $id = Exports_list::select('id')->max('id');
          $increment_ex = $id+1;
          
          if ($id==null) {
                # code...
                $generate_exports = (str_repeat(Carbon::now()->format('dmy').'0', 2-strlen($increment_ex))). $increment_ex;
              }
              if ($id >= 1 && $id < 10) {
                $generate_exports = (str_repeat(Carbon::now()->format('dmy').'0', 2-strlen($increment_ex))). $increment_ex;
              }
              if ($id >= 9 && $id < 101) {
                $generate_exports = (str_repeat(Carbon::now()->format('dmy').'0', 3-strlen($increment_ex))). $increment_ex;
                }
              if ($id >= 99 && $id < 100) {
              $generate_exports = (str_repeat(Carbon::now()->format('dmy').'0', 4-strlen($increment_ex))). $increment_ex;
              } 
            if ($id >= 100 && $id < 1000) {
              $generate_exports = (str_repeat(Carbon::now()->format('dmy').'0', 4-strlen($increment_ex))). $increment_ex;
            }
              if ($id >= 999 && $id < 10000) {
                $generate_exports = (str_repeat(Carbon::now()->format('dmy').'0', 5-strlen($increment_ex))). $increment_ex;
              }     
                if ($id >= 9999 && $id < 100000) {
                  $generate_exports = (str_repeat(Carbon::now()->format('dmy').'0', 6-strlen($increment_ex))). $increment_ex;
                }
                
            if (ob_get_contents()) ob_end_clean();
              flush();

                    $time = Carbon::now()->format('dmy');
                      $response = response()->view('xml_files.xml_tc',[
                        'transport_orders' => $data_transport,
                        'SODATE' => $time
                      ])->getContent();

              $test = Storage::disk('public')->put("$generate_exports.xml",$response);
              if ($test!==false) {
                # code...
                $StoragePath  = Storage::disk('public')->getDriver()->getAdapter()->applyPathPrefix("$generate_exports.xml");
                $file = new Exports_list();
                $file->path = $StoragePath;
                $file->fieldname = "$generate_exports.xml";
                $file->company_branch_id = $this->rest->session()->get('id');
                $file->user_by = Auth::User()->name;
                $file->json_file = array($index_transport_id);
                $file->id_table = 1;

                $file->save();

                foreach ($data_transport as $key => $shipmnt) {
                  # code...
                  $datatcx = $shipmnt->cek_status_transaction->status_name;
                  
                }

                    if($datatcx == "done"){
                      $data_transportsdxc = Transport_orders::find($index_transport_id);
                        $data_transportsdxc->update(
                            [
                              'status_order_id' => 4
                            ]
                        );

                        $idToLogOrderIdArray = $tc->find([$index_transport_id]);

                        foreach($idToLogOrderIdArray as $keyx=>$value) {
                          
                          $arrayorderlog[$keyx] = $value->order_id;
            
                        }
            
                        $idToLogOrderIdArray = $arrayorderlog;
            
                        foreach($idToLogOrderIdArray as $oo =>$arrvitemidx) {
            
                            $data_order[] = [
                                'user_id' => Auth::User()->id,
                                'order_id' => $arrvitemidx,
                                'status' => 4,
                                'datetime' => Carbon::now(),
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ];
              
                          }
            
                        TrackShipments::insert($data_order);

                    }

                    if($datatcx == "new"){
                      $data_transportxcx = Transport_orders::find($index_transport_id);
                        $data_transportxcx->update(
                            [
                              'status_order_id' => 6
                            ]
                        );

                        $idToLogOrderIdArray = $tc->find([$index_transport_id]);

                        foreach($idToLogOrderIdArray as $keyx=>$value) {
                          
                          $arrayorderlog[$keyx] = $value->order_id;
            
                        }
            
                        $idToLogOrderIdArray = $arrayorderlog;
            
                        foreach($idToLogOrderIdArray as $oo =>$arrvitemidx) {
            
                            $data_order[] = [
                                'user_id' => Auth::User()->id,
                                'order_id' => $arrvitemidx,
                                'status' => 6,
                                'datetime' => Carbon::now(),
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ];
              
                          }
            
                        TrackShipments::insert($data_order);

                    }

                      if($datatcx == "draft"){
                        $data_transportxcx = Transport_orders::find($index_transport_id);
                          $data_transportxcx->update(
                              [
                                'status_order_id' => 8
                              ]
                          );

                        $idToLogOrderIdArray = $tc->find([$index_transport_id]);

                        foreach($idToLogOrderIdArray as $keyx=>$value) {
                          
                          $arrayorderlog[$keyx] = $value->order_id;
            
                        }
            
                        $idToLogOrderIdArray = $arrayorderlog;
            
                        foreach($idToLogOrderIdArray as $oo =>$arrvitemidx) {
            
                            $data_order[] = [
                                'user_id' => Auth::User()->id,
                                'order_id' => $arrvitemidx,
                                'status' => 8,
                                'datetime' => Carbon::now(),
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ];
              
                          }
            
                        TrackShipments::insert($data_order);

                      }

                      if($datatcx == "upload"){
                        $data_transportxcx = Transport_orders::find($index_transport_id);
                          $data_transportxcx->update(
                              [
                                'status_order_id' => 2
                              ]
                          );

                        $idToLogOrderIdArray = $tc->find([$index_transport_id]);

                        foreach($idToLogOrderIdArray as $keyx=>$value) {
                          
                          $arrayorderlog[$keyx] = $value->order_id;
            
                        }
            
                        $idToLogOrderIdArray = $arrayorderlog;
            
                        foreach($idToLogOrderIdArray as $oo =>$arrvitemidx) {
            
                            $data_order[] = [
                                'user_id' => Auth::User()->id,
                                'order_id' => $arrvitemidx,
                                'status' => 2,
                                'datetime' => Carbon::now(),
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ];
              
                          }
            
                        TrackShipments::insert($data_order);

                      }

                      if($datatcx == "proses"){
                        $data_transportxcx = Transport_orders::find($index_transport_id);
                          $data_transportxcx->update(
                              [
                                'status_order_id' => 2
                              ]
                          );

                          $idToLogOrderIdArray = $tc->find([$index_transport_id]);

                          foreach($idToLogOrderIdArray as $keyx=>$value) {
                            
                            $arrayorderlog[$keyx] = $value->order_id;
              
                          }
              
                          $idToLogOrderIdArray = $arrayorderlog;
              
                          foreach($idToLogOrderIdArray as $oo =>$arrvitemidx) {
              
                              $data_order[] = [
                                  'user_id' => Auth::User()->id,
                                  'order_id' => $arrvitemidx,
                                  'status' => 2,
                                  'datetime' => Carbon::now(),
                                  'created_at' => Carbon::now(),
                                  'updated_at' => Carbon::now(),
                              ];
                
                            }
              
                          TrackShipments::insert($data_order);

                      }

                  return redirect()->route('acctc.static', session()->get('id'))->with('success','Data berhasil di export.');
              
              } 
                  else {
  
                    return redirect()->back()->with("error","[ TRANSPORT ] Maaf anda belum memilih perfile, silahkan check list file pada tabel yang tersedia!");
  
              }

          return redirect()->back()->withSuccess("export berhasil dengan nama file:$generate_exports.xml");

      }

}