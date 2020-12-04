<?php

namespace warehouse\Http\Controllers\vendor;

use Auth;
use Session;
use Validator;
use GuzzleHttp\Client;
use warehouse\Models\City;
use warehouse\Models\Item;
use warehouse\Models\Moda;
use Illuminate\Http\Request;
use warehouse\Models\Vendor;
use Illuminate\Http\Response;
use warehouse\Models\Customer;
use warehouse\Models\District;
use warehouse\Models\Province;
use GuzzleHttp\Promise\Promise;
use warehouse\Models\Industrys;
use warehouse\Models\Vendorrate;
use warehouse\Models\Sub_service;
use warehouse\Models\Vendor_pics;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use warehouse\Models\Vendor_status;
use Illuminate\App\Http\Controllers;
use Illuminate\Routing\UrlGenerator;
use warehouse\Models\Ship_categorie;
use Illuminate\Support\Facades\Crypt;
use warehouse\Models\Company_branchs;
use warehouse\Models\Vendorrate_truck;
use Illuminate\Support\Carbon as Carbon;
use warehouse\Http\Controllers\Controller;
use warehouse\Models\Vendorrate_minweight;
use warehouse\Models\Vendorrate_nextweight;
use warehouse\Models\Vendor_item_transports;
use warehouse\Repositories\AccurateCloudRepos;
use warehouse\Http\Controllers\Services\AccuratecloudInterface;
use warehouse\Http\Controllers\ManagementController as RESTAPIs;
use warehouse\Http\Requests\Vendor_validation\vendorsValidation;
use warehouse\Models\Item_transport as Customer_item_transports;
use warehouse\Http\Controllers\Helper\TraitSyncUpdateDataAccurateCloud;
use warehouse\Http\Controllers\API\integrationAPIController as APIINTEGRATIONS;

class VendorController extends Controller
{
    use TraitSyncUpdateDataAccurateCloud;
    
    protected $apivendors;
    protected $integrations;
    private $rest;
    private $prv;
    private $theCity;
    private $date;
    private $datenow;
    protected $callVsignRepos;
    private $session;
    private $openModulesAccurateCloud;

    public function __construct(
                                    RESTAPIs $apirestvendor, 
                                    APIINTEGRATIONS $apintegrations,
                                    City $cities,
                                    Province $provinsi,
                                    Request $REST,
                                    AccuratecloudInterface $APInterfacecloud,
                                    AccurateCloudRepos $Vsign
                                )
    {
        $this->middleware(['verified','BlockedBeforeSettingUser','role:3PL - SURABAYA WAREHOUSE|super_users|administrator|3PL - BANDUNG TRANSPORT']);
        $this->apivendors = $apirestvendor;
        $this->rest = $REST;
        $this->callVsignRepos = $Vsign;
        $this->theCity = $cities;
        $this->prv = $provinsi;
        $this->integrations = $apintegrations;

        $this->session = "31d26482-94b7-44e1-8303-e31945f422d7";
        $this->date = gmdate('Y-m-d\TH:i:s\Z');
        $this->datenow = date('d/m/Y');
        $this->openModulesAccurateCloud = $APInterfacecloud;
    }
    
    public function loadData(Request $request)
    {
          $cari = $request->q;
          $data = Industrys::select('id', 'industry')->where('industry', 'LIKE', "%$cari%")->get();
          // foreach ($data as $query) {
          //    $results[] = ['value' => $query->industry ];
          //  }
          return response()->json($data);

    }

    public function sercingbrnch(Request $request)
    {
        if ($request->has('q')) {
          $cari = $request->q;
          $data = Industrys::select('id', 'industry')->where('industry', 'LIKE', "%$cari%")->get();
          // foreach ($data as $query) {
          //    $results[] = ['value' => $query->industry ];
          //  }
          return response()->json($data);
        }

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($branch_id)
    {
      $trashlist = Vendor::with('city','industry','status')->onlyTrashed()
                ->get();
      $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
      $prefix = Company_branchs::globalmaster(Auth::User()->company_branch_id)->first();
        $alert_items = Item::where('flag',0)->get();
        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $system_alert_item_customer = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        // $vst = Vendor::with('city','industry','status','check_users_permissions')->where('users_permissions', Auth::User()->id)->get();
        $vst = Vendor::with('city','industry','status','check_users_permissions')->whereIn('users_company_id', [session()->get('company_id')])->get();
        $APIs = $this->apivendors::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);
        $YM = Carbon::Now()->format('dmy');
                
        $random_match_id = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $project_id = $YM.$random_match_id;
        $vendorsx = 'VD'.$project_id.Vendor::select('id')->max('id');
        
        $tgl = Carbon::Now()->format('dmy');
        $random_match_idx = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $project_idx = $tgl.$random_match_idx;
        $count = '1';
            $posts = Vendor::groupBy('id')
                        ->where('id',$count)->get();
            $counterID = count($posts)+1;

        $generaterandomID = 'VD'.$project_idx.$counterID;
        $generateUNIQUE = $generaterandomID;

    $vendorssIID = $vendorsx;
        return view('admin.vendor.vendorlist', [
            'menu' => 'Vendor List',
            'choosen_user_with_branch' => $this->rest->session()->get('id'),
            'some' => $this->rest->session()->get('id'),
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2']])->with(compact('alert_items','prefix',
            'system_alert_item_vendor','vst','trashlist','generateUNIQUE','alert_customers','system_alert_item_customer','vendorssIID'));

    }

    public function trash_vendors(){
      $trashlist = Vendor::with('city','industry','status')->onlyTrashed()
                ->get();
      // dd($trashlist);
      return view ('admin.vendor.trash_vendor.trashvendorlist',[
          'menu' => 'Trash Vendors List'])->with(compact('trashlist'));

    }

    public function restoreall_vendor(){
      $trashlist = Vendor::onlyTrashed()
                ->restore();
      return redirect('trash_vendors')->with('success','Data has been restored.');
    }

    public function restored_vendors($id)
    {
      Vendor::withTrashed()->find($id)->restore();
      return redirect('trash_vendors')->with('success','Data has been restored.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($branch_id)
    {
      $vendors = Vendor::withTrashed()->select('id')->max('id');
      if (is_null($vendors)) {
        $vendors = 'VD001';
        $id_vendors = '1';
      } else {
          //id vendor_id
          $id = Vendor::withTrashed()->select('id')->max('id');
          $vds = $id+1;
          $vendors = $vds;

          //id vendors
          $ids = Vendor::withTrashed()->select('id')->max('id');
          // $str = substr($ids,-1);
          $vds = $ids+1;
          $id_vendors = $vds;

          /** menggunakan id dynamic dengan str_repeat id 001 - 010 - 100 */
     
      }
    //   return $vendorss;
      // dd($vendorss);
      $vendorss = 'VD'.(str_repeat('00', 2-strlen($id_vendors))). $id_vendors;
      $prefix = Company_branchs::globalmaster(Auth::User()->company_branch_id)->first();
      $system_alert_item_vendor = Vendor_item_transports::with('vendors',
      'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
      $system_alert_item_customer = Customer_item_transports::with('customers',
      'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
      $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
      $alert_items = Item::where('flag',0)->get();
      $city = City::all();
      $APIs = $this->apivendors::callbackme();
      $responsecallbackme = json_decode($APIs->getContent(), true);

        return view ('admin.vendor.vendorregistration',[
            'menu' => 'Vendor Registration',
            'choosen_user_with_branch' => $this->rest->session()->get('id'),
            'some' => $this->rest->session()->get('id'),
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2']])->with(compact('vendorss','city','prefix',
            'vendors','id_vendors','system_alert_item_vendor','alert_customers','alert_items','system_alert_item_customer'));
    }

    public function showitiditemvendortc($branch_id, $idx_item_vendor){
        
        $decrypts= Crypt::decrypt($idx_item_vendor);
        $alert_items = Item::where('flag',0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
       
        $cstm = Vendor::all();
        $find_it_tcvendor = Vendor::where('id',$decrypts)->first();
        if ($find_it_tcvendor == null) {
            # code...
            $find_it_tcvendor = Vendor::all();

        } else {
            # code...
            $find_it_tcvendor = Vendor::where('id',$decrypts)->first();

        }
        $shc = Ship_categorie::all();
        $Mds = Moda::all();
        $cstomers = Customer::all();
      

        $Cty = City::all();

        $id = Customer_item_transports::select('id')->max('id');
        $YM = Carbon::Now()->format('my');
        $latest_idx_jbs = Customer_item_transports::latest()->first();
        $prefix = Company_branchs::globalmaster(Auth::User()->company_branch_id)->first();
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
        $data_vendor_transport = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->get();
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $data_customer_transport_sys_alerts = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $prefix = Company_branchs::globalmaster($branch_id)->first();

        $APIs = $this->apivendors::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);

        session(['idx_item_vendor'=> $id ]);
        return view('admin.master_transport.automically_vendor_transport',[
            'menu'=>'Vendor Transport List',
            'alert_items' => $alert_items,
            'choosen_user_with_branch' => $this->rest->session()->get('id'),
            'some' => $this->rest->session()->get('id'),
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2'],
            'system_alert_item_vendor' => $data_customer_transport_sys_alerts,
            'system_alert_item_customer' => $data_item_alert_sys_allows0,
            'alert_customers' => $alert_customers]
        )->with(compact('jobs_order_idx','sub_service_not_dev','shc',
                'cstm','Cty','cstomers','data_customer_transport','prefix',
                'Mds','sub_service','find_it_tcvendor','data_vendor_transport')
            );

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        
        $APIs = $this->integrations::callstaticfunction();

            foreach((array)$APIs as $key => $detected){

                $how_working[] = $detected;

            }
 
        $jsonArray = json_decode($APIs->getContent(), true);

            foreach((array)$jsonArray as $key => $indexing){

                $testing[$key] = $indexing;

            }

        if ($testing[0]['check_is'] == "api_izzy") {

            if ($testing[0]['operation'] == "true") {

                unset($request['_method']);
                unset($request['_token']);
                $client = new Client(['auth' => ['samsunguser', 'asdf123']]);
                
                $response = $client->post('http://your.api.vendor.com/customer/v1/vendor/new', [
                        'headers' => [
                            'Content-Type' => 'application/x-www-form-urlencoded',
                            'X-IzzyTransport-Token' => 'a7b96913b5b1d66bed4ffdb9b04c075f19047eb3.1603097547',
                            'Accept' => 'application/json'
                        ],
                            'form_params' => [
                                've[code]' => $request->vendorid,
                                've[name]' => $request->director,
                                've[address]' => $request->address,
                                've[city]' => $request->kota,
                                've[state]' => 'indonesia',
                                've[country]' => 'indonesia',
                                've[zip]' => $request->zip_code,
                                've[contact]' => $request->tax_phone,
                                've[phone]' => $request->phone,
                                've[email]' => $request->email,
                            ]
                        ]
                    );

                    $this->validate($request, 
                            ['company_name' => 'required','director'=>'required',
                                'since'=>'required|min:4','type_of_business'=>'required',
                                'tax_no'=>'required', 'address'=>'required',
                                'tax_address'=>'required', 'phone'=>'required',
                                'tax_city'=>'required', 'tax_phone'=>'required',
                                'kota'=>'required',
                                'email'=>'required|email|unique:users', 'nama_pic'=>'required',
                                'title_name_pic'=>'required', 'no_pic'=>'required',
                                'bank_name'=>'required','zip_code'=>'required', 'norek'=>'required', 'an_bank'=>'required',
                                'term_of_payment'=>'required'
                            ]);

                            Vendor::create([
                                'company_name' => $request->company_name,
                                'director' => $request->director,
                                'vendor_id' => $request->vendorid,
                                'zip_code' => $request->zip_code,
                                'status_id' => $request->statusid,
                                'industry_id' => $request->type_of_business,
                                'city_id' => $request->kota,
                                'since' => $request->since,
                                'address' => $request->address,
                                'tax_no' => $request->tax_no,
                                'tax_address' => $request->tax_address,
                                'tax_city' => $request->tax_city,
                                'tax_phone' => $request->tax_phone,
                                'tax_fax' => $request->tax_fax,
                                'phone' => $request->phone,
                                'fax' => $request->fax,
                                'email' => $request->email,
                                'users_permissions' => Auth::User()->id,
                                'users_company_id' => session()->get('company_id'),
                                'website' => $request->website,
                                'nama_pic' => $request->nama_pic,
                                'title_name_pic' => $request->title_name_pic,
                                'no_pic' => $request->no_pic,
                                'bank_name' => $request->bank_name,
                                'norek' => $request->norek,
                                'an_bank' => $request->an_bank,
                                'term_of_payment' => $request->term_of_payment,
                            ]);

                            Vendor_pics::create([
                                'vendor_id' => $request->id_v,
                                'vendor_pic_status_id' => $request->statusid
                            ]);
            
            
                return redirect()->route('master.vendor.list')->with('success', 'Information has been added');

            }

            if ($testing[0]['operation'] == "false") {
                
                $this->validate($request, 
                    ['company_name' => 'required','director'=>'required',
                        'since'=>'required|min:4','type_of_business'=>'required',
                        'tax_no'=>'required', 'address'=>'required',
                        'tax_address'=>'required', 'phone'=>'required',
                        'tax_city'=>'required', 'tax_phone'=>'required',
                        'kota'=>'required',
                        'email'=>'required|email|unique:users', 'nama_pic'=>'required',
                        'title_name_pic'=>'required', 'no_pic'=>'required',
                        'bank_name'=>'required','zip_code'=>'required', 'norek'=>'required', 'an_bank'=>'required',
                        'term_of_payment'=>'required'
                    ]);

                            Vendor::create([
                                'company_name' => $request->company_name,
                                'director' => $request->director,
                                'vendor_id' => $request->vendorid,
                                'zip_code' => $request->zip_code,
                                'status_id' => $request->statusid,
                                'industry_id' => $request->type_of_business,
                                'city_id' => $request->kota,
                                'since' => $request->since,
                                'address' => $request->address,
                                'tax_no' => $request->tax_no,
                                'tax_address' => $request->tax_address,
                                'tax_city' => $request->tax_city,
                                'tax_phone' => $request->tax_phone,
                                'tax_fax' => $request->tax_fax,
                                'phone' => $request->phone,
                                'fax' => $request->fax,
                                'email' => $request->email,
                                'users_permissions' => Auth::User()->id,
                                'users_company_id' => session()->get('company_id'),
                                'website' => $request->website,
                                'nama_pic' => $request->nama_pic,
                                'title_name_pic' => $request->title_name_pic,
                                'no_pic' => $request->no_pic,
                                'bank_name' => $request->bank_name,
                                'norek' => $request->norek,
                                'an_bank' => $request->an_bank,
                                'term_of_payment' => $request->term_of_payment,
                            ]);

                        Vendor_pics::create([
                            'vendor_id' => $request->id_v,
                            'vendor_pic_status_id' => $request->statusid
                        ]);

                return redirect()->route('master.vendor.list', session()->get('id'))->with('success', 'Information has been added');
                            
            }

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
        // $vendorrate_truck = Vendorrate::with('vendorrate_trucks.originable')->get();
        // dd($vendorrate_truck);
        // $vendorrate_trucks = Vendorrate::with('sub_services.vendorrate_trucks.destinationable')->find($id);
        // $subservice = Vendorrate::with('sub_services')->get();
        // $vendor = Vendorrate::with('vendors')->find($id);
        
        // dd($vendorrate_truck);

        // $vendorrate_nextweight = Vendorrate::with('vendorrate_nextweight')->find(1);
        // $vendorrate_minweight = Vendorrate::with('vendorrate_minweight')->find(1);
        // $check_model_city = Vendorrate_truck::where('originable_type','=','App\Models\City')->get();
        // $check_model_district = Vendorrate_truck::select('destinationable_id')->where('originable_type','=','App\Models\District')->get();

        // if ($check_model_city == true) {
        //     # code...
        //     echo "true";
        //     // $vendorrates = Vendorrate_truck::find($id);
        //     dd($check_model_city);

        //     $kota = Vendorrate_truck::select('originable_id')->find($check_model_city);
        //     dd($kota->originable_id);
        //     $check_model_city_fetch = City::Select('name')->find($kota);
        //     // dd($check_model_city_fetch);
            
        //     // $vendorrates = Vendorrate_truck::find($id);
        //     // $kecamatan = Vendorrate_truck::select('destinationable_id')->find($id);
        //     // dd($kecamatan);
        //     // $check_model_district_fetch = District::Select('name')->find($kecamatan);
        // } else {
            
        //     // $vendorrates = Vendorrate::with('Vendorrate_trucks')->find($id);
        //     // $kota = Vendorrate_truck::select('destinationable_id')->find($id);
        //     // $check_model_dynamic_polimoprhsym = District::Select('name')->find($kota);
        //     // dd($check_model_dynamic_polimoprhsym);
        // }
       
        // die();
        $decrypts= Crypt::decrypt($id);
        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $vst = Vendor::with('city','industry','status','vendor_pics')->find($decrypts);
        $vstatus = Vendor_status::all();
        $city = City::all();
        $system_alert_item_customer = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $vp = Vendor::with('vendor_pics')->find($decrypts);
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $alert_items = Item::where('flag',0)->get();
        $prefix = Company_branchs::globalmaster($branch_id)->first();
         // show the view and pass the vendors to it

         $APIs = $this->apivendors::callbackme();
         $responsecallbackme = json_decode($APIs->getContent(), true);

         session(['id_master_vendor' => $id ]);
         return view('admin.vendor.editregistration', [
                    'menu' => 'Vendor Edit',
                    'alert_items' => $alert_items,
                    'choosen_user_with_branch' => $this->rest->session()->get('id'),
                    'some' => $this->rest->session()->get('id'),
                    'api_v1' => $responsecallbackme['api_v1'],
                    'api_v2' => $responsecallbackme['api_v2'],
                    'system_alert_item_vendor' => $system_alert_item_vendor,
                    'system_alert_item_customer' => $system_alert_item_customer,
                    'alert_customers' => $alert_customers,
                    'prefix' => $prefix
                ]
             )
             ->with(compact('vendor','subservice','sub_services',
                'vendorrate_trucks','vendorrate_trucks','originable','vendorrate_truck','vpicstatus',
                'vst','city','vendor','alert_items','alert_customers','vp','vstatus','vendor_pics'
            )
        );

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){

            $vst = Vendor::with('city','industry','status','vendor_pic')->find($id);
            $vstatus = Vendor_status::all();
            $city = City::all();
            $vp = Vendor::with('vendor_pics')->find($id);
            $APIs = $this->apivendors::callbackme();
            $responsecallbackme = json_decode($APIs->getContent(), true);
             // show the view and pass the vendors to it
             return view('admin.vendor.editregistration', [
                 'menu' => 'Vendor Edit',
                 'api_v1' => $responsecallbackme['api_v1'],
                 'api_v2' => $responsecallbackme['api_v2']])->with(compact('vst','city','vendor','vp','vstatus','vendor_pic'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePemasok(Request $request, $branch_id, $id)
    {
    //   dd($request->all());die;
      // $vendorpic = Vendor_pics::find($id);
       // $vendor = Vendor::find($id);
       // $vst = Vendor::with('city','industry','status')->find($id);
       //    $city = City::all();
       $vst = Vendor::with('city','industry','status','vendor_pics')->findOrFail($id);
        
       $vst->company_name = $request->company_name;
       $vst->director = $request->director;
       $vst->status_id = $request->status_id;
       $vst->industry_id = $request->type_of_business;
       $vst->since = $request->since;
       $vst->tax_no = $request->no_npwp;
       $vst->tax_address = $request->tax_address;
       $vst->tax_city = $request->tax_city;
       $vst->tax_phone = $request->tax_phone;
       $vst->tax_fax = $request->tax_fax;
       $vst->address = $request->addressOPS;
       $vst->city_id = $request->cityOPS;
       $vst->phone = $request->phoneOPS;
       $vst->fax = $request->faxOPS;
       $vst->email = $request->opsemail;
       $vst->website = $request->opsemail;
       $vst->bank_name = $request->bank_name;
       $vst->an_bank = $request->an_bank;
       $vst->norek = $request->norek;
       $vst->term_of_payment = $request->term_of_payment;
       $vst->save();

       $id = $vst->itemID_accurate;
       $pelanggan = $vst->company_name;

       $pemasok = new Promise(
           function () use (&$pemasok, &$id, &$pelanggan) {
               $pemasok->resolve($this->UpdateSynCPemasok($id, $pelanggan));
           },
           function ($x) {
               $pemasok->reject($x);
           }
       );
       
       $pemasok->wait();

       return response()->json(['res'=> $pemasok->wait()->original.' berhasil diupdate diaccurate.' ]);
       
       // return redirect('admin.vendor.editregistration', [
       //     'menu' => 'Vendor Edit'])->with('success', 'Information has been updated!');
       // flash('Information has been updated.')->success();

    //    $vst = Vendor::with('city','industry','status','vendor_pics')->find($id);
    //    $vstatus = Vendor_status::all();
    //    $city = City::all();
    //    $vp = Vendor::with('vendor_pics')->find($id);
    //    $prefix = Company_branchs::globalmaster(Auth::User()->company_branch_id)->first();
    //    $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
    //    $system_alert_item_customer = Customer_item_transports::with('customers',
    //    'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
    //    $alert_items = Item::where('flag',0)->get();
    //    $APIs = $this->apivendors::callbackme();
    //    $responsecallbackme = json_decode($APIs->getContent(), true);
    //     return view('admin.vendor.editregistration', [
    //             'menu' => 'Vendor Edit',
    //             'choosen_user_with_branch' => $this->rest->session()->get('id'),
    //             'some' => $this->rest->session()->get('id'),
    //             'api_v1' => $responsecallbackme['api_v1'],
    //             'api_v2' => $responsecallbackme['api_v2'],
    //             'alert_customers' => $alert_customers,
    //             'alert_items' => $alert_items,
    //             'system_alert_item_customer' => $system_alert_item_customer
    //             ]
    //         )
    //     ->with(compact('prefix','vpicstatus','vst','city','vendor','vp','vstatus','vendor_pics'));
    //    // return redirect('updated')->with('success', 'Information has been updated!');

    }

    public function viewregis() {

        $vst = Vendor::with('city','industry','status')->get();
        return view('admin.vendor.vendorlist', [
            'menu' => 'Vendor List'])->with(compact('vendor','city','vst'));

    }


    public function loadDataCity(Request $request)
    {
        // if ($request->has('q')) {
          $cari = $request->q;
          $data = City::select('id', 'name')->where('name', 'LIKE', "%$cari%")->get();
          // foreach ($data as $query) {
          //    $results[] = ['value' => $query->industry ];
          //  }
          return response()->json($data);
        // }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $query_checks = Vendorrate::where('vendor_id',$id)->first();
        // dd($query_checks);
        if ($query_checks !== null) {
            # code...
            return redirect()->back()->withErrors('maaf anda tidak bisa menghapus data ini, karena data ini telah melakukan transaksi di proses lain.')->withInput();
            // echo "maaf anda tidak bisa menghapus data ini, karena data ini telah melakukan transaksi di proses lain.";
        } else {
                $vendor = Vendor::findOrFail($id)->delete();
                // flash('Information has been deleted.')->success();
                return redirect('vendorlist')->with('success', 'Information has been deleted!');
               
        }

    }

    public function saved_vendorOfTransport(Request $request, vendorsValidation $rest)
    {
        
        $messages = [
            'required' => 'Maaf, :attribute ini harus wajib diisi',
        ];
        // $this->validate($request, [
          
        //     'ops_email'=>'required|email|unique:users',
           
        // ]);
        
        $validator = Validator::make($rest->all(), $messages);
        
        if ($validator->fails()) {
            
            if($request->ajax())
            {
                return response()->json([
                    'success' => false,
                    'exception' => $validator->errors()->all(),
                    'errors' => $validator->getMessageBag()->toArray()
                ], 422);
            }

            $this->throwValidationException(

                $request, $validator

            );

        }

        $fetchCity = $this->theCity->findOrFail($this->rest->PNGHcty);
        $fetchProvince = $this->prv->findOrFail($this->rest->pengihanPRV);

            $getCloudAccurate = $this->openModulesAccurateCloud
                ->FuncOpenmoduleAccurateCloudSaveVendor(
                    $this->rest->project,
                    $this->rest->project,
                    $this->rest->tahun,
                    $this->rest->ops_email,
                    $this->rest->ops_phone,
                    $this->rest->ops_phone,
                    $this->rest->ops_webs,
                    $this->rest->ops_fax,
                    $this->rest->PNGHN_alamat,
                    $fetchCity->name,
                    $this->rest->ops_kodepos,
                    $fetchProvince->name,
                    "INDONESIA",
                    $this->rest->ops_phone,
                    $this->rest->tax_no,
                    $this->rest->CustomertaxType
                )
            ;
            
        $YM = Carbon::Now()->format('dmy');
        $random_match_id = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $project_id = $YM.$random_match_id;
        $APIs = $this->integrations::callstaticfunction();

        foreach((array)$APIs as $key => $detected){

            $how_working[] = $detected;

        }

            $jsonArray = json_decode($APIs->getContent(), true);
  
                foreach((array)$jsonArray as $key => $indexing){

                    $testing[$key] = $indexing;

                }

            //     $YM = Carbon::Now()->format('dmy');
                
            //     $random_match_id = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
            //     $project_id = $YM.$random_match_id;
            //     $vendorsx = 'VD'.$project_id.Vendor::select('id')->max('id');
               
            // $vendorssIID = $vendorsx;

            $tgl = Carbon::Now()->format('dmy');
            $random_match_idx = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
            $project_idx = $tgl.$random_match_idx;
            $count = '1';
                $posts = Vendor::groupBy('id')
                            ->where('id',$count)->get();
                $counterID = count($posts)+1;

            $generaterandomID = 'VD'.$project_idx.$counterID;
            $generateUNIQUE = $generaterandomID;

    if ($testing[0]['check_is'] == "api_izzy") {
// dd($request->ops_email);die;
        if ($testing[0]['operation'] == "true") {
            
            unset($request['_method']);
                unset($request['_token']);
                    $client = new Client(['auth' => ['samsunguser', 'asdf123']]);
                    
                    $response = $client->post('http://your.api.vendor.com/customer/v1/vendor/new', [
                        'headers' => [
                            'Content-Type' => 'application/x-www-form-urlencoded',
                            'X-IzzyTransport-Token' => 'a7b96913b5b1d66bed4ffdb9b04c075f19047eb3.1603097547',
                            'Accept' => 'application/json'
                        ],
                            'form_params' => [
                                've[code]' => $generateUNIQUE,
                                've[name]' => $request->project,
                                've[address]' => $request->PNGHN_alamat,
                                've[city]' => $request->ops_kota,
                                've[state]' => 'indonesia',
                                've[country]' => 'indonesia',
                                've[zip]' => $request->ops_kodepos,
                                've[contact]' => $request->ops_fax,
                                've[phone]' => $request->ops_phone,
                                've[email]' => $request->ops_email
                            ]
                        ]
                    );
                
                    $jsonArray = json_decode($response->getBody()->getContents(), true);


                    $vendorid = Vendor::create([
                        'company_name' => $request->project,
                        'director' => $request->direktur,
                        'vendor_id' => $generateUNIQUE,
                        'project_id' => $jsonArray['Vendor']['id'], //this added response id project with new vendor with API izzy
                        'status_id' => 1,
                        'industry_id' => $request->tipe_bisnis,
                        'city_id' => $request->ops_kota,
                        'since' => $request->tahun,
                        'address' => $request->alamat,
                        'tax_no' => $request->tax_nomor,
                        'tax_address' => $request->tax_alamat,
                        'tax_city' => $request->tax_kota,
                        'tax_phone' => $request->tax_telephone,
                        'tax_fax' => $request->tax_faxs,
                        'phone' => $request->ops_phone,
                        'fax' => $request->ops_fax,
                        'email' => $request->ops_email,
                        'users_permissions' => Auth::User()->id,
                        'users_company_id' => session()->get('company_id'),
                        'website' => $request->ops_webs,
                        'bank_name' => $request->nama_bank,
                        'norek' => $request->nomor_rekening,
                        'an_bank' => $request->atas_nama_bank,
                        'term_of_payment' => $request->kebijakan_pembayaran,
                        'PNGHN_alamat' => $this->rest->PNGHN_alamat, 
                        'PNGHN_city' => $this->rest->PNGHcty, 
                        'PNGHN_province' => $this->rest->pengihanPRV, 
                        'PNGHN_country' => 'INDONESIA', 
                        'vendorTaxType' => $this->rest->CustomertaxType, 
                        'itemID_accurate' => $getCloudAccurate->original
                    ]);

                    Vendor_pics::create([
                        'vendor_id' => $vendorid->id,
                        'vendor_pic_status_id' => 1
                    ]);

                    connectify('success', 'Accurate cloud berpesan', 'Pemasok '.$vendorid->company_name.' dengan Code: '.$getCloudAccurate->original.' berhasil dibuat di acccurate cloud');
                
                return;
            }
        
        }

        if ($testing[0]['check_is'] == "api_izzy") {
        
            if ($testing[0]['operation'] == "false") {
                
                    $vendorid = Vendor::create([
                            'company_name' => $request->project,
                            'director' => $request->direktur,
                            'vendor_id' => $vendorssIID,
                            'project_id' => $generateUNIQUE, //this added response id project with new vendor with API izzy
                            'status_id' => 1,
                            'industry_id' => $request->tipe_bisnis,
                            'city_id' => $request->ops_kota,
                            'since' => $request->tahun,
                            'address' => $request->alamat,
                            'tax_no' => $request->tax_nomor,
                            'tax_address' => $request->tax_alamat,
                            'tax_city' => $request->tax_kota,
                            'tax_phone' => $request->tax_telephone,
                            'tax_fax' => $request->tax_faxs,
                            'phone' => $request->ops_phone,
                            'fax' => $request->ops_fax,
                            'email' => $request->ops_email,
                            'users_permissions' => Auth::User()->id,
                            'users_company_id' => session()->get('company_id'),
                            'website' => $request->ops_webs,
                            'bank_name' => $request->nama_bank,
                            'norek' => $request->nomor_rekening,
                            'an_bank' => $request->atas_nama_bank,
                            'term_of_payment' => $request->kebijakan_pembayaran,
                            'PNGHN_alamat' => $this->rest->PNGHN_alamat, 
                            'PNGHN_city' => $this->rest->PNGHcty, 
                            'PNGHN_province' => $this->rest->pengihanPRV, 
                            'PNGHN_country' => 'INDONESIA', 
                            'vendorTaxType' => $this->rest->CustomertaxType, 
                            'itemID_accurate' => $getCloudAccurate->original
                    ]);

                    Vendor_pics::create([
                        'vendor_id' => $vendorid->id,
                        'vendor_pic_status_id' => 1
                    ]
                );

                connectify('success', 'Accurate cloud berpesan', 'Pemasok '.$vendorid->company_name.' dengan Code: '.$getCloudAccurate->original.' berhasil dibuat di acccurate cloud');
                
                return;

            }
        
        }

    }

    public function TipePajakAccurateCloud()
    {
        $foo = [];

            array_push($foo, (object)[
                    'id'=>'IMPORT_BKP',
                    'name'=>'Impor BKP'
                ], (object)[
                    'id'=>'IMPORT_BKP_TDKWJD',
                    'name'=>'Impor BKP Tidak Berwujud'
                ], (object)[
                    'id'=>'JKP_PABEAN',
                    'name'=>'JKP Luar Pabean'
                ], (object)[
                    'id'=>'PJK_MASUKAN_TDKDIKREDITKAN_BENDAHARA',
                    'name'=>'Pajak Masukan tidak dapat dikreditkan - Pemungut Bendahara'
                ],(object)[
                    'id'=>'PJK_MASUKAN_TDKDIKREDITKAN_BKN_PPN',
                    'name'=>'Pajak Masukan tidak dapat dikreditkan - Bukan Pemungut PPN'
                ],(object)[
                    'id'=>'PJK_MASUKAN_TDKDIKREDITKAN_DPP',
                    'name'=>'Pajak Masukan tidak dapat dikreditkan - DPP Nilai Lain'
                ],(object)[
                    'id'=>'PJK_MASUKAN_TDKDIKREDITKAN_PENYRHN_AKTIVA',
                    'name'=>'Pajak Masukan tidak dapat dikreditkan - Penyerahan Aset'
                ],(object)[
                    'id'=>'PJK_MASUKAN_TDKDIKREDITKAN_PENYRHN_LAIN',
                    'name'=>'Pajak Masukan tidak dapat dikreditkan - Penyerahan Lainnya'
                ],(object)[
                    'id'=>'PJK_MASUKAN_TDKDIKREDITKAN_PPN',
                    'name'=>'Pajak Masukan tidak dapat dikreditkan - Pemungut PPN'
                ],(object)[
                    'id'=>'PJK_MASUKAN_TDKDIKREDITKAN_PPN_DIBEBASKAN',
                    'name'=>'Pajak Masukan tidak dapat dikreditkan - PPN Dibebaskan'
                ],(object)[
                    'id'=>'PJK_MASUKAN_TDKDIKREDITKAN_PPN_TIDAKDIPUNGUT',
                    'name'=>'Pajak Masukan tidak dapat dikreditkan - PPN Tidak Dipungut'
                ],(object)[
                    'id'=>'PRLHNDLMNEGERI_BKN_PPN',
                    'name'=>'Perolehan Dalam Negeri - Bukan Pemungut PPN'
                ],(object)[
                    'id'=>'PRLHNDLMNEGERI_DPP',
                    'name'=>'Perolehan Dalam Negeri - DPP Nilai Lain'
                ],(object)[
                    'id'=>'PRLHNDLMNEGERI_PENYRHN_AKTIVA',
                    'name'=>'Perolehan Dalam Negeri - Penyerahan Aset'
                ],(object)[
                    'id'=>'PRLHNDLMNEGERI_PENYRHN_LAIN',
                    'name'=>'Perolehan Dalam Negeri - Penyerahan Lainnya'
                ],(object)[
                    'id'=>'PRLHNDLMNEGERI_PPN',
                    'name'=>'Perolehan Dalam Negeri - Pemungut PPN'
                ]);

        return response()->json($foo);
    
    }

}
