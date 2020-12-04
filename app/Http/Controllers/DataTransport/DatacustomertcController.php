<?php

namespace warehouse\Http\Controllers\DataTransport;

use Auth;
use SWAL;
use GuzzleHttp\Client;
use warehouse\Models\City;
use warehouse\Models\Item;
use warehouse\Models\Moda;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use phpseclib\Crypt\Random;
use Illuminate\Http\Request;
use warehouse\Models\Customer;
use GuzzleHttp\Promise\Promise;
use warehouse\Models\Sub_service;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use warehouse\Models\Ship_categorie;
use Illuminate\Support\Facades\Crypt;
use warehouse\Models\Company_branchs;
use Illuminate\Support\Carbon as Carbon;
use warehouse\Http\Controllers\Controller;
use warehouse\Models\MasterItemTransportX;
use warehouse\Models\Vendor_item_transports;
use warehouse\Repositories\AccurateCloudRepos;
use warehouse\Http\Controllers\Helper\RandomString;
use warehouse\Http\Controllers\TestGenerator\CallSignature;
use warehouse\Http\Controllers\Services\AccuratecloudInterface;
use warehouse\Http\Controllers\ManagementController as RESTAPIs;
use warehouse\Models\Item_transport as Customer_item_transports;
use warehouse\Http\Controllers\Helper\TraitSyncUpdateDataAccurateCloud;
use warehouse\Http\Controllers\API\integrationAPIController as integrations;

class DatacustomertcController extends Controller
{
    use CallSignature, TraitSyncUpdateDataAccurateCloud;

    protected $itemcustomertc;
    protected $rest;
    protected $apis;
    protected $service;
    protected $session;
    protected $date;
    protected $itemcustomers;
    private $codes;
    protected $callFromDataCustomer;

    public function __construct($services = 'INVENTORY', AccurateCloudRepos $callTraitsSyncAccurateCloud , RESTAPIs $apicustomeritemtc, MasterItemTransportX $itemCustomer ,Request $REST, integrations $APIs, AccuratecloudInterface $APInterfacecloud)
    {
        $this->middleware(['verified']);
        $this->itemcustomertc = $apicustomeritemtc;
        $this->codes = new RandomString();
        $this->rest = $REST;
        $this->callFromDataCustomer = $callTraitsSyncAccurateCloud;
        $this->service = $services;
        $this->itemcustomers = $itemCustomer;
        $this->apis = $APIs;
        $this->session = "31d26482-94b7-44e1-8303-e31945f422d7";
        $this->date = gmdate('Y-m-d\TH:i:s\Z');
        $this->openModulesAccurateCloud = $APInterfacecloud;

    }

    public function load_city(Request $request){

            $cari = $request->q;
            $data = City::with('province')->where('name', 'LIKE', "%$cari%")->get();
            // dd($data);
            foreach ($data as $query) {
               $results[] = ['value' => $query];
             }
         
            return response()->json($data);
            
    }

    public function load_subservices(Request $request){


        $user = Auth::User()->roles;
        $datauser = array();
        foreach ($user as $key => $value) {
          # code...
          $datauser = $value->name;

        }

        // if ($datauser=="3PL[OPRASONAL][TC]") {
        //     # code...
        //     $cari = $request->q;
                        
        //     $data = sub_service::select('id','name')->where('prefix','=','T')->where('name','LIKE', "%$cari%")->get();
        //     // dd($data);
        //         foreach ($data as $query) {
                
        //             $results[] = ['value' => $query];
                
        //         }
        
        //     return response()->json($data);
        
        // }

        // if ($datauser=="3PL[OPRASONAL][TC][WHS]") {
        //     # code...
        //     $cari = $request->q;
                        
        //     $data = sub_service::select('id','name')->where('name','LIKE', "%$cari%")->get();
        //     // dd($data);
        //         foreach ($data as $query) {
                
        //             $results[] = ['value' => $query];
                
        //         }
        
        //     return response()->json($data);
        
        // }

        
        if (Gate::allows('superusers') || Gate::allows('developer') || Gate::allows('transport')) {
            # code...
        // if ($request->has('q')) {
            $cari = $request->q;
            // $data = Sub_service::select('id', 'name')->where('name', 'LIKE', "%$cari%")->where('prefix','W')->get();
            $data = Sub_service::select('id', 'name')->where('name', 'LIKE', "%$cari%")->whereIn('prefix',['T'])->get();
            // foreach ($data as $query) {
            //    $results[] = ['value' => $query->industry ];
            //  }
            return response()->json($data);
        // }
        }

        // if ($datauser=="administrator") {
        //     # code...
        //     $cari = $request->q;

        //     $data = sub_service::select('id','name')->where('prefix','=','T')->where('name','LIKE',"%$cari%")->get();
        //     // dd($data);
        //         foreach ($data as $query) {
                
        //             $results[] = ['value' => $query];
                
        //         }
        
        //     return response()->json($data);
     
        // } 


    }

    public function loaded_idx_service(Request $request,$service_idx){

        $oper = Auth::User()->roles;
        foreach ($oper as $key => $sc) {
            # code...
            $arr[] = $sc->name;

           foreach ($arr as $key => $value) {
               # code...
                if (Gate::allows('superusers') || Gate::allows('developer') || Gate::allows('transport') || Gate::allows('warehouse') || Gate::allows('accounting')) {
                    # code...
                    $data = sub_service::select('id','name')->where('id',$service_idx)->get();
                    // dd($data);
                       foreach ($data as $query) {
                       
                           $results[] = ['value' => $query];
                       
                       }
               
                   return response()->json($data);
                
                }
            //    if ($value=="administrator") {
            //        # code...
            //        $data = sub_service::select('id','name')->where('prefix','=','T')->where('id',$service_idx)->get();
            //        // dd($data);
            //            foreach ($data as $query) {
                       
            //                $results[] = ['value' => $query];
                       
            //            }
               
            //        return response()->json($data);
            
            //    } 
                    if ($value=="3PL - BANDUNG TRANSPORT") {
                        # code...
                                $data = sub_service::select('id','name')->where('prefix','=','T')->where('id',$service_idx)->get();
                                // dd($data);
                                    foreach ($data as $query) {
                                    
                                        $results[] = ['value' => $query];
                                    
                                    }
                            
                                return response()->json($data);
                    
                        } 
                            else {
                                
                                return false;
                    }

                }

        }

    }

    public function load_mods(Request $request){

        // if ($request->has('q')) {
            $cari = $request->q;
            $data = Moda::select('id','name')->where('name', 'LIKE', "%$cari%")->get();
            foreach ($data as $query) {
               $results[] = ['value' => $query];
             }
         
            return response()->json($data);

        // }

    }

    public function loaded_modas_idx($modid){

        $data = Moda::select('id','name')->where('id',$modid)->get();
            foreach ($data as $query) {
               $results[] = ['value' => $query];
             }
         
        return response()->json($data);

    }

    public function load_shipmentCatgry(Request $request){

        // if ($request->has('q')) {
            $cari = $request->q;
            $data = Ship_categorie::select('id','nama')->where('nama', 'LIKE', "%$cari%")->get();
            foreach ($data as $query) {
               $results[] = ['value' => $query];
             }
         
            return response()->json($data);

        // }

    }

    public function loaded_shipment_category($shipments){

        $data = Ship_categorie::select('id','nama')->where('id',$shipments)->get();
        foreach ($data as $query) {
            $results[] = ['value' => $query];
            }
        
        return response()->json($data);

    }

    public function SearchloadResultsCustomer(Request $request){

        $APIs = $this->apis::callstaticfunction();
 
        $jsonArray = json_decode($APIs->getContent(), true);
        
            foreach((array)$jsonArray as $key => $indexing){
    
                $testing[$key] = $indexing;
    
            }
    
                if ($testing[0]['check_is'] == "api_izzy") {
    
                    if ($testing[0]['operation'] == "true") {
                        $client = new Client();
                        $response = $client->get('http://your.api.vendor.com/customer/v1/project',
                            [  'headers' => [
                                    'Content-Type' => 'application/x-www-form-urlencoded',
                                    'X-IzzyTransport-Token' => 'a7b96913b5b1d66bed4ffdb9b04c075f19047eb3.1603097547',
                                    'Accept' => 'application/json'],
                                    'query' => ['limit' => '10',
                                                'page' => '1'
                                ]
                            ]
                        );
    
                        $jsonArray = json_decode($response->getBody(), true);
                        $data_array = $jsonArray['Projects'];
                        $domps = array();
                        foreach($data_array as $dump) {
                            $domps[] = $dump['name'];
                        }
                        $cari = $request->q;
                        $data = Customer::with('city')->whereIn('name', $domps)->where('name', 'LIKE', "%$cari%")->get();
                        return response()->json($data);
    
                    }
    
                    if ($testing[0]['operation'] == "false") {
                        $cari = $request->q;

                            $data = Customer::with('city')->where('name', 'LIKE', "%$cari%")->first();

                            foreach ($data as $query) {
                                $results[] = ['value' => $query];
                              }
    
                        return response()->json($data);
                    }
                    
            }

    }

    public function load_customer(Request $request){

        // if ($request->has('q')) {

            $APIs = $this->apis::callstaticfunction();
 
            $jsonArray = json_decode($APIs->getContent(), true);
          
            foreach((array)$jsonArray as $key => $indexing){
    
                $testing[$key] = $indexing;
    
            }
    
                if ($testing[0]['check_is'] == "api_izzy") {
    
                    if ($testing[0]['operation'] == "true") {
                        $client = new Client();
                        $response = $client->get('http://your.api.vendor.com/customer/v1/project',
                            [  'headers' => [
                                    'Content-Type' => 'application/x-www-form-urlencoded',
                                    'X-IzzyTransport-Token' => 'a7b96913b5b1d66bed4ffdb9b04c075f19047eb3.1603097547',
                                    'Accept' => 'application/json'],
                                    'query' => ['limit' => '10',
                                                'page' => '1'
                                ]
                            ]
                        );
    
                        $jsonArray = json_decode($response->getBody(), true);
                        $data_array = $jsonArray['Projects'];
                        $domps = array();
                        foreach($data_array as $dump) {
                            $domps[] = $dump['name'];
                        }
                        $cari = $request->q;
                        $data = Customer::with('city')->whereIn('name', $domps)->where('name', 'LIKE', "%$cari%")->get();
                        return response()->json($data);
    
                    }
    
                    if ($testing[0]['operation'] == "false") {
                        $cari = $request->q;

                            $data = Customer::with('city')->where('name', 'LIKE', "%$cari%")->get();

                            foreach($data as $key => $data_ds){
                                    // $data_ds['name'] = "PUBLISH";
                                    $dataSet[] = $data_ds;
                            }
    
                            return response()->json($dataSet);
                            // $getCloudAccurate = $this->openModulesAccurateCloud
                            //         ->FuncOpenmoduleAccurateCloudAllMasterCustomerList(
                            //             $this->session,
                            //             $this->fields,
                            //             $this->date
                            //         )
                            //     ;
                    
                            // return response()->json($getCloudAccurate->original["d"]);
                    }
                      
                    
                }
                
            // $cari = $request->q;
            // $data = Customer::select('id','name')->where('name', 'LIKE', "%$cari%")->get();
            // // dd($data);
            // foreach ($data as $query) {
            //    $results[] = ['value' => $query];
            //  }

            // $array = Arr::add($data, 'id',100);

         
            // dd($array);

        // }

    }

    public function load_auto_move_cty($indexid){

            $data = City::where('id',$indexid)->get();
            // dd($data);
            foreach ($data as $query) {
               $results[] = ['value' => $query];
             }
         
            return response()->json($data);


    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($branch_id)
    {
        $alert_items = Item::where('flag',0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $data_customer_transport = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination','users','sub_services')
        ->whereIn('branch_item', [Auth::User()->oauth_accurate_company])->get();
        // dd(Auth::User()->oauth_accurate_company);
       
        $cstm = Customer::all();
        $shc = Ship_categorie::all();
        $Mds = Moda::all();
        $cstomers = Customer::all();
        $Cty = City::all();

        $id = Customer_item_transports::select('id')->max('id');
        $YM = Carbon::Now()->format('my');
        $latest_idx_jbs = Customer_item_transports::latest()->first();
        $prefix = Company_branchs::globalmaster($branch_id)->first();
        $jobs = $id+1;
        $jincrement_idx = $jobs;
        
        if ($id==null) {
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 2-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 2-strlen($jincrement_idx))). $jincrement_idx;
        }
        elseif ($id == 1){
                $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 2-strlen($jincrement_idx))). $jincrement_idx;
                $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 2-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id > 1 && $id < 9 ){
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 2-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 2-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id == 9){
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 3-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 2-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id == 10) {
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 3-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 3-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id > 10 && $id < 99) {
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 3-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 3-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id == 99) {
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 4-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 3-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id == 100) {
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 4-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 4-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id > 100 && $id < 999) {
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 4-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 4-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id === 999) {
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 5-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 4-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id === 1000) {
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 5-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 5-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id > 1000 && $id < 9999) {
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 5-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 5-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id == 9999) {
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 6-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 5-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id == 10000) {
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 6-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 6-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }

        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $data_customer_transport_sys_alerts = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $prefix = Company_branchs::globalmaster($branch_id)->first();
        $APIs = $this->itemcustomertc::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);
        return view('admin.master_transport.tcdata_customer_transport',[
            'menu'=>'Customer Transport List',
            'alert_items' => $alert_items,
            'choosen_user_with_branch' => $branch_id,
            'some' => $branch_id,
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2'],
            'system_alert_item_vendor' => $data_customer_transport_sys_alerts,
            'system_alert_item_customer' => $data_item_alert_sys_allows0,
            'alert_customers' => $alert_customers]
        )->with(compact('jobs_order_idx','shc',
                'cstm','Cty','cstomers','data_customer_transport',
                'Mds','prefix')
            );

    }

    public function update_alert_item_customer_tc($id)
    {
        $tbicustomerlist = Customer_item_transports::find($id);
        $tbicustomerlist->flag = Request('flag');
        $tbicustomerlist->save();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //do something else what do you want..
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $itemCustomer = $this->itemcustomers
            ->with('item_transport_customer')
                ->get(); //instead model item_transport
            
            if($itemCustomer->isEmpty()){

                $project = ($this->rest->customerx=="null") 
                ? NULL 
                : $this->rest->customerx;

                $sixdigit = $this->codes->generate_uuid();
                $master_code = substr($sixdigit, strlen($sixdigit) - 6, strlen($sixdigit));

                    $item = MasterItemTransportX::updateOrCreate(
                    array(
                            'item_code' => strtoupper($master_code),
                            'origin' => $request->originx,
                            'destination' => $request->destination_x,
                            'userid' => Auth::User()->id,
                            'ship_category' => $request->shipmentx,
                            'itemovdesc' => $request->itemovdesc,
                            'unit' => $request->unit,
                            'sub_service_id' => $request->sub_service_id,
                            'moda' => $request->moda_x,
                            'customer_id' => $project,
                            'flag' => 0
                        )
                    );
                                
                    $item->save();
                        
                            $itemTransports = New Customer_item_transports();
                            $itemTransports->item_code = $request->itemcode;
                            $itemTransports->customer_id = $project;
                            $itemTransports->branch_item = Auth::User()->oauth_accurate_company;
                            $itemTransports->referenceID = $item->id;
                            $itemTransports->sub_service_id = $request->sub_service_id;
                            $itemTransports->itemovdesc = $this->rest->itemovdesc;
                            $itemTransports->ship_category = $request->shipmentx;
                            $itemTransports->moda = $request->moda_x;
                            $itemTransports->usersid = Auth::User()->id;
                            $itemTransports->origin = $request->originx;
                            $itemTransports->destination = $request->destination_x;
                            $itemTransports->price = $request->price;
                            $itemTransports->unit = $request->unit;
                            $itemTransports->save();
                              
                            $getCloudAccurate = $this->openModulesAccurateCloud
                            ->FuncOpenmoduleAccurateCloudSaveItemBarangjasa__(
                                $itemTransports->itemovdesc,
                                $this->service, 
                                $this->date,
                                $item->item_code,
                                $request->unit

                            )
                        ;
                        $itemTransports->itemID_accurate = $getCloudAccurate->original;
                        $item->itemID_accurate = $getCloudAccurate->original;

                    $item->save();
                $itemTransports->save();
                $customer = Customer_item_transports::with('customers')->whereIn('customer_id',[$this->rest->customerx])->first();
                $issetCustomer = isset($customer->customers->name) ? $customer->customers->name :"PUBLISH";

            connectify('success', 'Accurate cloud berpesan', 'Kode Transaksi: '.$issetCustomer.' berhasil membuat item [barang & jasa] customer code: '.$getCloudAccurate->original.' berhasil dibuat.');


            } 
                else
                        {    
                            $originID = array();


                            foreach($itemCustomer as $sdasd => $fetchdatOfFields){

                                $selfbacktoHack[] = $fetchdatOfFields;
                             
                                foreach($fetchdatOfFields['item_transport_customer'] as $looprows){
                                   
                                    $sub_serviceID[] = $looprows->sub_service_id;
                                    $originID[] = $looprows->origin;
                                    $destinationID[] = $looprows->destination;
                                    $ship_categoryID[] = $looprows->ship_category;
                                    $modaID[] = $looprows->moda;
                                    $UNITS[] = $looprows->unit;

                                }

                                $dataTableMasterItemTransport_Subservice[] = $sub_serviceID; //master item transport
                                $dataTableMasterItemTransport_Origin[] = $originID; //master item transport
                                $dataTableMasterItemTransport_Destination[] = $destinationID; //master item transport
                                $dataTableMasterItemTransport_Ship_category[] = $ship_categoryID; //master item transport
                                $dataTableMasterItemTransport_MODAS[] = $modaID; //master item transport
                                $dataTableMasterItemTransport_UNITS[] = $UNITS; //master item transport

                                $dataTableItemTransport_Subservice[] = $fetchdatOfFields->sub_service_id; //master item customer of transaction instead master item transport
                                $dataTableItemTransport_origin[] = $fetchdatOfFields->origin; //master item customer of transaction instead master item transport
                                $dataTableItemTransport_Destination[] = $fetchdatOfFields->destination; //master item customer of transaction instead master item transport
                                $dataTableItemTransport_Ship_category[] = $fetchdatOfFields->ship_category; //master item customer of transaction instead master item transport
                                $dataTableItemTransport_Modas[] = $fetchdatOfFields->moda; //master item customer of transaction instead master item transport
                                $dataTableItemTransport_Unit[] = $fetchdatOfFields->unit; //master item customer of transaction instead master item transport
                            }

                            $CollectCallbackQuerys = collect([$selfbacktoHack]);

                            $SubServiceInsteadOfMasterItemTransportsA = collect([$dataTableItemTransport_Subservice]);
                            $SubServiceInsteadOfMasterItemTransportsB = collect([$dataTableItemTransport_origin]);
                            $SubServiceInsteadOfMasterItemTransportsC = collect([$dataTableItemTransport_Destination]);
                            $SubServiceInsteadOfMasterItemTransportsD = collect([$dataTableItemTransport_Ship_category]);
                            $SubServiceInsteadOfMasterItemTransportsE = collect([$dataTableItemTransport_Modas]);
                            $SubServiceInsteadOfMasterItemTransportsF = collect([$dataTableItemTransport_Unit]);

                             $SubServiceInsteadOfItemTransportsA = collect([$dataTableMasterItemTransport_Subservice]);
                             $SubServiceInsteadOfItemTransportsB = collect([$dataTableMasterItemTransport_Origin]);
                             $SubServiceInsteadOfItemTransportsC = collect([$dataTableMasterItemTransport_Destination]);
                             $SubServiceInsteadOfItemTransportsD = collect([$dataTableMasterItemTransport_Ship_category]);
                             $SubServiceInsteadOfItemTransportsE = collect([$dataTableMasterItemTransport_MODAS]);
                             $SubServiceInsteadOfItemTransportsF = collect([$dataTableMasterItemTransport_UNITS]);

                            // you can testing $resultsQuery->masteritemtc instead of $itemCustomer;
                            $CollectCallbackQuerys->map(function ($resultsQuery) use ($request,

                                    $SubServiceInsteadOfMasterItemTransportsA,
                                    $SubServiceInsteadOfMasterItemTransportsB,
                                    $SubServiceInsteadOfMasterItemTransportsC,
                                    $SubServiceInsteadOfMasterItemTransportsD,
                                    $SubServiceInsteadOfMasterItemTransportsE,
                                    $SubServiceInsteadOfMasterItemTransportsF
                             
                             ) {

                    if(in_array($request->destination_x, $SubServiceInsteadOfMasterItemTransportsC[0]) && in_array($request->originx, $SubServiceInsteadOfMasterItemTransportsB[0]) && in_array($request->sub_service_id, $SubServiceInsteadOfMasterItemTransportsA[0]) && in_array($request->shipmentx, $SubServiceInsteadOfMasterItemTransportsD[0]) && in_array($request->moda_x, $SubServiceInsteadOfMasterItemTransportsE[0]) && in_array($request->unit, $SubServiceInsteadOfMasterItemTransportsF[0])){
                            
                            $dataItem = MasterItemTransportX::
                                            when($request->has('sub_service_id') && $request->has('originx') && $request->has('destination_x') && $request->has('shipmentx') && $request->has('moda_x') && $request->has('unit'), function ($que) use ($request){
                                                return $que->where('sub_service_id','=',$request->sub_service_id)
                                                            ->where('origin', '=',$request->originx)
                                                            ->where('ship_category', '=',$request->shipmentx)
                                                            ->where('moda', '=',$request->moda_x)
                                                            ->where('unit', '=',$request->unit)
                                                            ->where('destination','=', $request->destination_x);
                                            }   
                                        )

                                    ->first()
                                ;

                            } 
                                else {
                                    
                                    $dataItem = false;

                            }

                                if($dataItem == false) {

                                    $project = ($this->rest->customerx=="null") 
                                    ? NULL 
                                    : $this->rest->customerx;
                        
                                    $sixdigit = $this->codes->generate_uuid();
                                    $master_code = substr($sixdigit, strlen($sixdigit) - 6, strlen($sixdigit));

                                            $item = MasterItemTransportX::updateOrCreate(
                                                        array(
                                                                'item_code' => strtoupper($master_code),
                                                                'origin' => $request->originx,
                                                                'destination' => $request->destination_x,
                                                                'userid' => Auth::User()->id,
                                                                'ship_category' => $request->shipmentx,
                                                                'itemovdesc' => $request->itemovdesc,
                                                                'unit' => $request->unit,
                                                                'sub_service_id' => $request->sub_service_id,
                                                                'moda' => $request->moda_x,
                                                                'customer_id' => $project,
                                                                'flag'   => 0
                                                            )
                                                    );
                                                    
                                        $item->save();

                                            $itemTransports = New Customer_item_transports();
                                            $itemTransports->item_code = $request->itemcode;
                                            $itemTransports->customer_id = $project;
                                            $itemTransports->branch_item = Auth::User()->oauth_accurate_company;
                                            $itemTransports->referenceID = $item->id;
                                            $itemTransports->sub_service_id = $request->sub_service_id;
                                            $itemTransports->itemovdesc = $this->rest->itemovdesc;
                                            $itemTransports->ship_category = $request->shipmentx;
                                            $itemTransports->moda = $request->moda_x;
                                            $itemTransports->usersid = Auth::User()->id;
                                            $itemTransports->origin = $request->originx;
                                            $itemTransports->destination = $request->destination_x;
                                            $itemTransports->price = $request->price;
                                            $itemTransports->unit = $request->unit;
                                            $itemTransports->save();

                                                $getCloudAccurate = $this->openModulesAccurateCloud
                                                    ->FuncOpenmoduleAccurateCloudSaveItemBarangjasa__(
                                                        $itemTransports->itemovdesc,
                                                        $this->service, 
                                                        $this->date,
                                                        $item->item_code,
                                                        $request->unit
                                                    )
                                                ;
                                                
                                                $itemTransports->itemID_accurate = $getCloudAccurate->original;
                                            $item->itemID_accurate = $getCloudAccurate->original;
                    
                                        $item->save();
                                    $itemTransports->save();
                                    $customer = Customer_item_transports::with('customers')->whereIn('customer_id',[$this->rest->customerx])->first();

                                    $issetCustomer = isset($customer->customers->name) ? $customer->customers->name :"PUBLISH";

                                    connectify('success', 'Accurate cloud berpesan', 'Kode Transaksi: '.$issetCustomer.' berhasil membuat item [barang & jasa] customer code: '.$getCloudAccurate->original.' berhasil dibuat.');

                                } 
                                    else 
                                            {

                                                $project = ($this->rest->customerx=="null") 
                                                ? NULL 
                                                : $this->rest->customerx
                                                ;

                                                $itemTransports = New Customer_item_transports();

                                                    $fetchMasterItemID = MasterItemTransportX::
                                                        when($request->has('sub_service_id') && $request->has('originx') && $request->has('destination_x') && $request->has('shipmentx') && $request->has('moda_x') && $request->has('unit'), function ($que) use ($request){
                                                            return $que->where('sub_service_id','=',$request->sub_service_id)
                                                                        ->where('origin', '=',$request->originx)
                                                                        ->where('ship_category', '=',$request->shipmentx)
                                                                        ->where('moda', '=',$request->moda_x)
                                                                        ->where('unit', '=',$request->unit)
                                                                        ->where('destination','=', $request->destination_x); 
                                                            }   
                                                        )

                                                    ->first()
                                                ;

                                                $itemTransports->item_code = $request->itemcode;
                                                $itemTransports->customer_id = $project;
                                                $itemTransports->branch_item = Auth::User()->oauth_accurate_company;
                                                $itemTransports->referenceID = $fetchMasterItemID->id;
                                                $itemTransports->sub_service_id = $request->sub_service_id;
                                                $itemTransports->itemovdesc = $this->rest->itemovdesc;
                                                $itemTransports->ship_category = $request->shipmentx;
                                                $itemTransports->moda = $request->moda_x;
                                                $itemTransports->usersid = Auth::User()->id;
                                                $itemTransports->origin = $request->originx;
                                                $itemTransports->destination = $request->destination_x;
                                                $itemTransports->price = $request->price;
                                                $itemTransports->unit = $request->unit;
                                                $itemTransports->itemID_accurate = $fetchMasterItemID->itemID_accurate;

                                        $itemTransports->save();
                                        $customer = Customer_item_transports::with('customers')->whereIn('customer_id',[$this->rest->customerx])->first();
                                        $issetCustomer = isset($customer->customers->name) ? $customer->customers->name :"PUBLISH";

                                        connectify('success', 'Accurate cloud berpesan', 'Kode Transaksi: '.$issetCustomer.' berhasil membuat item [barang & jasa] customer code: '.$fetchMasterItemID->itemID_accurate.' berhasil dibuat.');
                        
                                    }
                                }
                            )
                        ;
                }
                
            return redirect()->back()->withSuccess("Data master item customer berhasil ditambahkan.");

    }

    public function alert_itemcustomerlist($branch_id)
    {
        $alert_items = Item::where('flag',0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $data_customer_transport = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $data_customer_transport_sys_alerts = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $prefix = Company_branchs::globalmaster($branch_id)->first();
        $APIs = $this->itemcustomertc::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);
        if ($data_customer_transport->isEmpty()){
            #do something else..
            return redirect('/data-customer-tc-list')->with('success','good job, now you have all items that can be used to make orders.');
            }
              else {
                    return view('admin.master_transport.system_alert_item_transports.system_itemcustomerlist',
                            [
                                'menu' => 'System Item Customer Transport List',
                                'alert_items' => $alert_items,
                                'choosen_user_with_branch' => $this->rest->session()->get('id'),
                                'some' => $this->rest->session()->get('id'),
                                'api_v1' => $responsecallbackme['api_v1'],
                                'api_v2' => $responsecallbackme['api_v2'],
                                'system_alert_item_vendor' => $data_customer_transport_sys_alerts,
                                'alert_customers' => $alert_customers,
                                'system_alert_item_customer' => $data_customer_transport
                            ]
                        )
                    ->with(compact('data_customer_transport','prefix','item_id','sub_service','itemno'
                )
            );
        }

    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($branch_id, $id)
    {
        $decrypts= Crypt::decrypt($id);
        $sub_service = Sub_service::all();
        $cstm = Customer::all();
        $shc = Ship_categorie::all();
        $Mds = Moda::all();
        $cstomers = Customer::all();
        $Cty = City::all();
        session(['item_id_customer' => $id]);
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $data_customer_transport_sys_alerts = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $find_i_customer = Customer_item_transports::findOrFail($decrypts);
        $prefix = Company_branchs::globalmaster(Auth::User()->oauth_accurate_company)->first();
        $alert_items = Item::where('flag',0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $APIs = $this->itemcustomertc::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);
        
        /**
        * @return [getting data from total saldo item barang dan jasa]
        */
        $pulltotalUnit1Quantity = $this->getSyncBarangJasa(
                                                                $find_i_customer->itemID_accurate,
                                                                $this->GeneratorFetchJustTime()->getOriginalContent()['_ts']
                                                        );
        $CekSatuanBarang = $this->getSyncSatuanBarangJasa(
                                                                $find_i_customer->itemID_accurate,
                                                                $this->GeneratorFetchJustTime()->getOriginalContent()['_ts']
                                                        );
        return view('admin.master_transport.update_form_item_customer',[
            'menu'=>'Customer Transport Edit',
            'alert_items' => $alert_items,
            'choosen_user_with_branch' => $this->rest->session()->get('id'),
            'some' => $this->rest->session()->get('id'),
            'pulltotalUnit1Quantity' => (int) $pulltotalUnit1Quantity,
            'CekSatuanBarang' => $CekSatuanBarang,
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2'],
            'system_alert_item_vendor' => $data_customer_transport_sys_alerts,
            'system_alert_item_customer' => $data_item_alert_sys_allows0,
            'alert_customers' => $alert_customers]
        )->with(compact('find_i_customer','cstm','shc','prefix','Mds','cstomers','Cty','sub_service'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $find_i_customer = Customer_item_transports::findOrFail($id);
        $alert_items = Item::where('flag',0)->get();
        $APIs = $this->itemcustomertc::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        return view('admin.master_transport.update_form_item_customer',[   
                    'api_v1' => $responsecallbackme['api_v1'],
                    'api_v2' => $responsecallbackme['api_v2'],
                    'menu'=>'Customer Transport Edit',
                    'choosen_user_with_branch' => $this->rest->session()->get('id'),
                    'some' => $this->rest->session()->get('id'),
                    'alert_items' => $alert_items,
                    'alert_customers' => $alert_customers
                ]

            )
        ->with(compact('find_i_customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateDataItemCustomers(Request $request, $branch_id, $id)
    {
        
        $item = Customer_item_transports::findOrFail($id);
        $item->customer_id = $request->input('customerx');
        $item->item_code = $request->input('itemcode');
        $item->sub_service_id = $request->input('sub_service_id');
        $item->ship_category = $request->input('shipmentx');
        $item->moda = $request->input('moda_x');
        $item->origin = $request->input('originx');
        $item->destination = $request->input('destination_x');
        $item->unit = $request->input('unit');
        $item->itemovdesc = $request->input('itemovdesc');
        $item->qty = $request->input('qty');
        $item->price = $request->input('price');
        $item->save();

        $itemID_accurate = $item->itemID_accurate;
        $Qty = $item->qty;
        $Cost = $item->price;

        $UpdateBarangjasa = new Promise(
            function () use (&$UpdateBarangjasa, &$itemID_accurate, &$Qty, &$Cost) {
                $UpdateBarangjasa->resolve($this->MasterUpdateSyncBarangJasa($itemID_accurate, $Qty, $Cost));

            },

            function ($ex) {
                $UpdateBarangjasa->reject($ex);
            }
        );

        $UpdatePromise = $UpdateBarangjasa->wait()->original["d"][0];

        return response()->json(
                                    [
                                        'idAccurateCloud' => $item->itemID_accurate,
                                        'totalQuantity' => $item->qty,
                                        'nameItem' => $item->itemovdesc,
                                        'response' => $UpdatePromise
                                    ]
                                )
                            ;
        
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
}
