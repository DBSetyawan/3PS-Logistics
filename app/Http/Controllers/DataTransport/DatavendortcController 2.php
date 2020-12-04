<?php

namespace warehouse\Http\Controllers\DataTransport;

use Auth;
use warehouse\Models\City;
use warehouse\Models\Item;
use warehouse\Models\Moda;
use Illuminate\Http\Request;
use warehouse\Models\Vendor;
use warehouse\Models\Customer;
use GuzzleHttp\Promise\Promise;
use warehouse\Models\Sub_service;
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

class DatavendortcController extends Controller
{

    use TraitSyncUpdateDataAccurateCloud, CallSignature;
    
    protected $apivendorlistitem;
    private $rest;
    private $codes;
    protected $service;
    protected $itemvendors;
    protected $callFromDataVendor;
    protected $callFromDataCustomer;
    protected $session;
    protected $date;

    public function __construct(AccurateCloudRepos $callTraitsSyncAccurateCloud,
    RESTAPIs $apitemvendor, $services = 'INVENTORY' , MasterItemTransportX $itemVendor,
    Request $REST, AccuratecloudInterface $APInterfacecloud
    )
        {

            $this->middleware(['BlockedBeforeSettingUser','verified','permission:developer|superusers|transport|warehouse']);
            $this->apivendorlistitem = $apitemvendor;
            $this->itemvendors = $itemVendor;
            $this->callFromDataCustomer = $callTraitsSyncAccurateCloud;
            $this->rest = $REST;
            $this->callFromDataVendor = $callTraitsSyncAccurateCloud;
            $this->service = $services;
            $this->codes = new RandomString();
            $this->session = "31d26482-94b7-44e1-8303-e31945f422d7";
            $this->date = gmdate('Y-m-d\TH:i:s\Z');
            $this->openModulesAccurateCloud = $APInterfacecloud;

        }

    public function load_vendor(Request $request){

            $cari = $request->q;
            $data = Vendor::select('id','company_name')->where('company_name', 'LIKE', "%$cari%")->get();
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

        $APIs = $this->apivendorlistitem::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);
        $alert_items = Item::where('flag',0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $data_vendor_transport = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination','users','sub_services')->get();
        // dd($data_vendor_transport);die;
        $sub_service = Sub_service::all();
        $cstm = Vendor::all();
        $shc = Ship_categorie::all();
        $idx_item_vendor = 0;
        $find_it_tcvendor = Vendor::where('id',$idx_item_vendor)->first();

        $Mds = Moda::all();
        $Cty = City::all();
        $data_customer_transport_sys_alerts = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $id = Vendor_item_transports::select('id')->max('id');
        $YM = Carbon::Now()->format('my');
        $latest_idx_jbs = Vendor_item_transports::latest()->first();
        $prefix = Company_branchs::globalmaster($branch_id)->first();

        $jobs = $id+1;
        $jincrement_idx = $jobs;
        
        if ($id==null) {
            $jobs_order_idx = (str_repeat("V1T".$prefix->prefix."TR".$YM.'00', 2-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("V1T".$prefix->prefix."TR".$YM.'00', 2-strlen($jincrement_idx))). $jincrement_idx;
        }
        elseif ($id == 1){
                $jobs_order_idx = (str_repeat("V1T".$prefix->prefix."TR".$YM.'00', 2-strlen($jincrement_idx))). $jincrement_idx;
                $jobs_idx_latest = (str_repeat("V1T".$prefix->prefix."TR".$YM.'00', 2-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id > 1 && $id < 9 ){
            $jobs_order_idx = (str_repeat("V1T".$prefix->prefix."TR".$YM.'00', 2-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("V1T".$prefix->prefix."TR".$YM.'00', 2-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id == 9){
            $jobs_order_idx = (str_repeat("V1T".$prefix->prefix."TR".$YM.'00', 3-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("V1T".$prefix->prefix."TR".$YM.'00', 2-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id == 10) {
            $jobs_order_idx = (str_repeat("V1T".$prefix->prefix."TR".$YM.'00', 3-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("V1T".$prefix->prefix."TR".$YM.'00', 3-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id > 10 && $id < 99) {
            $jobs_order_idx = (str_repeat("V1T".$prefix->prefix."TR".$YM.'00', 3-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("V1T".$prefix->prefix."TR".$YM.'00', 3-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id == 99) {
            $jobs_order_idx = (str_repeat("V1T".$prefix->prefix."TR".$YM.'00', 4-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("V1T".$prefix->prefix."TR".$YM.'00', 3-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id == 100) {
            $jobs_order_idx = (str_repeat("V1T".$prefix->prefix."TR".$YM.'00', 4-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("V1T".$prefix->prefix."TR".$YM.'00', 4-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id > 100 && $id < 999) {
            $jobs_order_idx = (str_repeat("V1T".$prefix->prefix."TR".$YM.'00', 4-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("V1T".$prefix->prefix."TR".$YM.'00', 4-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id === 999) {
            $jobs_order_idx = (str_repeat("V1T".$prefix->prefix."TR".$YM.'00', 5-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("V1T".$prefix->prefix."TR".$YM.'00', 4-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id === 1000) {
            $jobs_order_idx = (str_repeat("V1T".$prefix->prefix."TR".$YM.'00', 5-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("V1T".$prefix->prefix."TR".$YM.'00', 5-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id > 1000 && $id < 9999) {
            $jobs_order_idx = (str_repeat("V1T".$prefix->prefix."TR".$YM.'00', 5-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("V1T".$prefix->prefix."TR".$YM.'00', 5-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id == 9999) {
            $jobs_order_idx = (str_repeat("V1T".$prefix->prefix."TR".$YM.'00', 6-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("V1T".$prefix->prefix."TR".$YM.'00', 5-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id == 10000) {
            $jobs_order_idx = (str_repeat("V1T".$prefix->prefix."TR".$YM.'00', 6-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("V1T".$prefix->prefix."TR".$YM.'00', 6-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }

        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();

        return view('admin.master_transport.tcdata_vendor_transport',[
            'menu'=>'Vendor Transport List',
            'choosen_user_with_branch' => $branch_id,
            'some' => $branch_id,
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2'],
            'system_alert_item_vendor' => $data_customer_transport_sys_alerts,
            'alert_items' => $alert_items,
            'system_alert_item_customer' => $data_item_alert_sys_allows0,
            'alert_customers' => $alert_customers],
            compact('find_it_tcvendor','prefix','jobs_order_idx','shc','cstm','Cty','data_vendor_transport','Mds','sub_service')
        );

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

        $itemVendors = $this->itemvendors
            ->with('item_transport_vendor')
                ->get(); //instead model item_transport
                
                if($itemVendors->isEmpty()){

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
                                'vendor_id' => $request->vendorx,
                                'flag' => 0
                            )
                        );
                                    
                        $item->save();

                            $itemTransports = New Vendor_item_transports();
                            $itemTransports->item_code = $request->itemcode;
                            $itemTransports->vendor_id = $request->vendorx;
                            $itemTransports->referenceID = $item->id;
                            $itemTransports->sub_service_id = $request->sub_service_id;
                            $itemTransports->itemovdesc = $request->itemovdesc;
                            $itemTransports->ship_category = $request->shipmentx;
                            $itemTransports->moda = $request->moda_x;
                            $itemTransports->origin = $request->originx;
                            $itemTransports->usersid = Auth::User()->id;
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
                                        $this->rest->unit
                                    )
                                ;
                            
                            $itemTransports->itemID_accurate = $getCloudAccurate->original;
                            $item->itemID_accurate = $getCloudAccurate->original;

                    $item->save();
                    $itemTransports->save();

                    $vendorName = Vendor_item_transports::with('vendors')->first();
                    connectify('success', 'Accurate cloud berpesan', 'Kode Transaksi: '.$vendorName->vendors->director.' berhasil membuat item [barang & jasa] pemasok code: '.$getCloudAccurate->original.' berhasil dibuat.');

                } 
                    else 
                            {    

                                foreach($itemVendors as $fetchdatOfFields){
                                    // DefineALLObjectsModels
                                    $selfbacktoHack[] = $fetchdatOfFields;
                        
                                    //table item transport
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
                                else 
                                    
                                    {
                                        $dataItem = false;
                                    }
                        
                                    if($dataItem == false) {

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
                                                                'vendor_id' => $request->vendorx,
                                                                'flag' => 0
                                                            )
                                                    );
                                                        
                                            $item->save();
                                                        
                                                $itemTransports = New Vendor_item_transports();
                                                $itemTransports->item_code = $request->itemcode;
                                                $itemTransports->vendor_id = $request->vendorx;
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
                                                            $this->rest->unit
                                                        )
                                                    ;

                                                    $itemTransports->itemID_accurate = $getCloudAccurate->original;
                                                $item->itemID_accurate = $getCloudAccurate->original;
                        
                                            $item->save();
                                        $itemTransports->save();
                                        $vendorName = Vendor_item_transports::with('vendors')->first();

                                        connectify('success', 'Accurate cloud berpesan', 'Kode Transaksi: '.$vendorName->vendors->director.' berhasil membuat item [barang & jasa] pemasok code: '.$getCloudAccurate->original.' berhasil dibuat.');

                                    } 
                                        else {

                                            $itemTransports = New Vendor_item_transports();

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
                                                $itemTransports->vendor_id = $request->vendorx;
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
                                            $vendorName = Vendor_item_transports::with('vendors')->first();

                                        connectify('success', 'Accurate cloud berpesan', 'Kode Transaksi: '.$vendorName->vendors->director.' berhasil membuat item [barang & jasa] customer code: '.$fetchMasterItemID->itemID_accurate.' berhasil dibuat.');
                
                                    }
                                }
                            )
                        ;
                    }

            return redirect()->back()->withSuccess("Data master item vendor berhasil ditambahkan.");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($branch_id, Vendor_item_transports $viote, $id)
    {
        $decrypts = Crypt::decrypt($id);
        $sub_service = Sub_service::all();
        $cstm = Customer::all();
        $shc = Ship_categorie::all();
        $Mds = Moda::all();
        $cstomers = Customer::all();
        $vendors = Vendor::all();
        $Cty = City::all();
        $APIs = $this->apivendorlistitem::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);
        $data_customer_transport_sys_alerts = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $find_i_customer = $viote->findOrFail($decrypts);
        $prefix = Company_branchs::globalmaster(session()->get('id'))->first();

        $alert_items = Item::where('flag',0)->get();
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();

         /**
        * @return [getting data from total saldo item barang dan jasa]
        */
        $pulltotalUnit1Quantity = $this->getSyncBarangJasa(
                                                            $find_i_customer->itemID_accurate,
                                                            $this->GeneratorFetchJustTime()->getOriginalContent()['_ts']
                                                        );
                                                        // dd((int)$pulltotalUnit1Quantity);
        $CekSatuanBarang = $this->getSyncSatuanBarangJasa(
                                                            $find_i_customer->itemID_accurate,
                                                            $this->GeneratorFetchJustTime()->getOriginalContent()['_ts']
                                                        );
        session(['detail_data_item_V'=> $id ]);
        return view('admin.master_transport.update_form_item_vendor',[
            'menu'=>'Vendor Transport Edit',
            'alert_items' => $alert_items,
            'choosen_user_with_branch' => $this->rest->session()->get('id'),
            'some' => $this->rest->session()->get('id'),
            'system_alert_item_vendor' => $data_customer_transport_sys_alerts,
            'pulltotalUnit1Quantity' => (int) $pulltotalUnit1Quantity,
            'CekSatuanBarang' => $CekSatuanBarang,
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2'],
            'system_alert_item_customer' => $data_item_alert_sys_allows0,
            'alert_customers' => $alert_customers]
        )->with(compact('vendors','find_i_customer','prefix','cstm','shc','Mds','cstomers','Cty','sub_service'));
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

    public function alert_itemvendorlist($branch_id)
    {
        $alert_items = Item::where('flag',0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $data_customer_transport_sys_alerts = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $data_customer_transport = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $prefix = Company_branchs::globalmaster($branch_id)->first();
        $APIs = $this->apivendorlistitem::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);
        if ($data_customer_transport_sys_alerts->isEmpty()){
            #do something else..
            // return redirect('/data-vendor-tc-list')->with('success','good job, now you have all items that can be used to make orders.');
            return redirect('/home')->with('success','good job, now you have all items that can be used to make orders.');
            }
              else {
                    return view('admin.master_transport.system_alert_item_transports.system_itemvendorlist',
                            [
                                'menu' => 'System Item Vendor List',
                                'alert_items' => $alert_items,
                                'system_alert_item_vendor' => $data_customer_transport_sys_alerts,
                                'alert_customers' => $alert_customers,
                                'choosen_user_with_branch' => $this->rest->session()->get('id'),
                                'some' => $this->rest->session()->get('id'),
                                'api_v1' => $responsecallbackme['api_v1'],
                                'api_v2' => $responsecallbackme['api_v2'],
                                'system_alert_item_customer' => $data_customer_transport
                            ]
                        )
                    ->with(compact('data_customer_transport_sys_alerts','prefix','system_alert_item_customer','item_id','sub_service','itemno'
                )
            );
        }

    }

    public function update_alert_item_vendor_tc($id)
    {
        $tbicustomerlist = Vendor_item_transports::find($id);
        $tbicustomerlist->flag = Request('flag');
        $tbicustomerlist->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateSyncDataVendor(Request $request, $branch_id, $id)
    {
        // dd($request->all());die;
        $item = Vendor_item_transports::findOrFail($id);
        $item->vendor_id = $request->vendorx;
        $item->item_code = $request->itemcode;
        $item->sub_service_id = $request->sub_service_id;
        $item->ship_category = $request->shipmentx;
        $item->moda = $request->moda_x;
        $item->origin = $request->originx;
        $item->destination = $request->destination_x;
        $item->unit = $request->unit;
        $item->itemovdesc = $request->itemovdesc;
        $item->price = $request->price;
        $item->qty = $request->qty;
        $item->save();

        $itemID_accurate = $item->itemID_accurate;
        $Qty = $item->qty;
        $Cost = $item->price;

        $UpdateBarangjasa = new Promise(
            function () use (&$UpdateBarangjasa, &$itemID_accurate, &$Qty, &$Cost) {
                $UpdateBarangjasa->resolve($this->MasterUpdateSyncBarangJasaV($itemID_accurate, $Qty, $Cost));
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
