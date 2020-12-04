<?php

namespace warehouse\Http\Controllers\transport;

use PDF;
use Auth;
use Validator;
use Carbon\Carbon;
use GuzzleHttp\Client;
use warehouse\Models\City;
use warehouse\Models\Item;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use warehouse\Models\Vendor;
use warehouse\Models\Customer;
use GuzzleHttp\Promise\Promise;
use warehouse\Models\Moda as MD;
use Illuminate\Http\JsonResponse;
use warehouse\Models\Sub_service;
use Illuminate\Support\Collection;
use warehouse\Models\Address_book;
use GuzzleHttp\Promise\EachPromise;
use warehouse\Models\Customer_pics;
use warehouse\Models\City as origin;
use warehouse\Models\Item_transport;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use warehouse\Models\Company_branchs;
use warehouse\Models\Transport_orders;
use CodeItNow\BarcodeBundle\Utils\QrCode;
use Illuminate\Database\Eloquent\Builder;
use warehouse\Models\City as destination;
use warehouse\Http\Controllers\Controller;
use warehouse\Models\MasterItemTransportX;
use warehouse\Models\Vendor_item_transports;
use warehouse\Models\Jobs_transaction_detail;
use warehouse\Models\APIintractive as dbcheck;
use warehouse\Repositories\AccurateCloudRepos;
use GuzzleHttp\Psr7\Response as Guzzleresponse;
use warehouse\Http\Controllers\Helper\RandomString;
use warehouse\Models\Batchs_transaction_item_customer;
use warehouse\Models\Address_book as origin_address_book;
use warehouse\Http\Controllers\accurate\AccurateController;
use warehouse\Models\Address_book as destination_address_book;
use warehouse\Http\Controllers\Services\AccuratecloudInterface;
use warehouse\Models\Order_transport_history as TrackShipments;
use warehouse\Models\Item_transport as Customer_item_transports;
use warehouse\Http\Controllers\Services\Apiopentransactioninterface;
use Closure;
use GuzzleHttp\HandlerStack;
use React\EventLoop\Factory;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Promise\RejectedPromise;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Handler\CurlMultiHandler;
use GuzzleHttp\Exception\RequestException;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
use warehouse\Http\Controllers\Helper\TraitSyncUpdateDataAccurateCloud;
use warehouse\Http\Controllers\API\integrationAPIController as RESTAPIs;
use warehouse\Http\Requests\TransportOrder_validation\RequestUpdateDetailsTransport;
use warehouse\Http\Requests\TransportOrder_validation\RequestTransportOrdersValidation;

class TransportController extends Controller
{
    use TraitSyncUpdateDataAccurateCloud;
    
    protected $APIntegration;
    protected $json;
    private $transport;
    private $fields;
    protected $pull_branch;
    private $Apiopentransaction;
    private $origin_address;
    private $destination_address;
    protected $cityO;
    protected $cityD;

    private $codes;
    private $service;
    protected $itemcustomers;
    protected $itemvendors;

    protected $openModulesAccurateCloud;
    protected $session;
    protected $date;
    protected $datenow;
    protected $sync;
    protected $CallAccurate;

    public function __construct(
                                    AccurateCloudRepos $AccurateCloud,
                                    origin $city_origin,
                                    Promise $proms,
                                    AccuratecloudInterface $APInterfacecloud,
                                    destination $city_destination,
                                    Apiopentransactioninterface $APIs,
                                    RESTAPIs $API, Request $reqtc,
                                    origin_address_book $origin, destination_address_book $destination,
                                    $field = 'id,name,no',
                                    MasterItemTransportX $itemCustomer,
                                    MasterItemTransportX $itemVendor,
                                    $services = 'INVENTORY'
        )
            {
                $this->middleware(
                                    [
                                        'verified','BlockedBeforeSettingUser','permission:superusers|developer|transport'
                            ]
                    )
                ;

                $this->APIntegration = $API;
                $this->CallAccurate = $AccurateCloud;
                $this->sync = $proms;
                $this->pull_branch = $reqtc;
                $this->transport = New Transport_orders;
                $this->posts = $reqtc;
                $this->Apiopentransaction = $APIs;
                $this->origin_address = $origin;
                $this->destination_address = $destination;
                $this->cityO = $city_origin;
                $this->cityD = $city_destination;
                $this->fields = $field;
                $this->service = $services;
                $this->itemcustomers = $itemCustomer;
                $this->itemvendors = $itemVendor;
                $this->codes = new RandomString();

                $this->session = "31d26482-94b7-44e1-8303-e31945f422d7";
                $this->date = gmdate('Y-m-d\TH:i:s\Z');
                $this->datenow = date('d/m/Y');
                $this->openModulesAccurateCloud = $APInterfacecloud;

    }

    public function me(){
        return $this->GetallListDBAccurateCloud();
    }

    public function load_city(Request $request)
    {
    //   if ($request->has('q')) {
        $cari = $request->q;
        $data = City::select('id','name')->where('name', 'LIKE', "%$cari%")->get();
        // dd($data);
        foreach ($data as $query) {
           $results[] = ['value' => $query->branch];
         }
        return response()->json($data);
    //   }
    }

    public function load_city_by_id(Request $request, $id)
    {
    //   if ($request->has('q')) {
        $data = City::find($id);
        return response()->json($data);
    //   }
    }

    public function load_address_book($id)
    {
      $data = Address_book::where('city_id', $id)->get();

      foreach ($data as $query) {
          $results[] = ['value' => $query ];
        }
      return response()->json($data);
    }
    

    public function load_address_book_with_customers($id)
    {
      $data = Address_book::with('citys')->where('id', $id)->groupBy('name')->get();

      foreach ($data as $query) {
          $results[] = ['value' => $query ];
        }
      return response()->json($data);
    }

    public function load_address_book_with_customersx($id)
    {
      $data = Address_book::with('citys')->where('id', $id)->get();
      foreach ($data as $query) {
          $results[] = ['value' => $query ];
        }
      return response()->json($data);
    }

    public function load_item_transport(Request $request)
    {
      $cari = $request->load;
      $data = Item_transport::where('itemovdesc', 'LIKE', "%$cari%")->get();

      foreach ($data as $query) {
          $results[] = ['value' => $query ];
        }
      return response()->json($data);
    }

    public function saveAddressBookForms(){

        $fetch_customer_id = $this->posts->input('customers');

        $destination_name = $this->posts->input('destination_name');
        $origin_name = $this->posts->input('origin_name');

        $origin_city = $this->posts->input('origin_city');
        $destination_city = $this->posts->input('destination_city');

        $origin_detail = $this->posts->input('origin_detail');
        $destination_detail = $this->posts->input('destination_detail');

        $origin_contacts = $this->posts->input('origin_contacts');
        $destination_contacts = $this->posts->input('destination_contacts');

        $origin_add_boo = $this->posts->input('origin_add_boo');
        $destination_add_boo = $this->posts->input('destination_add_boo');

        $origin_fone = $this->posts->input('origin_fone');
        $destination_fone = $this->posts->input('destination_fone');

        $destination_pic = $this->posts->input('destination_pic');
        $origin_pic = $this->posts->input('origin_pic');

        $data_origin = [
            'customer_id' => $fetch_customer_id,
            'users_company_id' => session()->get('company_id'),
            'name' => $origin_name,
            'city_id' => $origin_city,
            'details' => $origin_detail,
            'address' => $origin_add_boo,
            'contact' => $origin_contacts,
            'phone' => $origin_fone,
            'pic_phone_origin' => $origin_fone,
            'pic_name_origin' => $origin_pic
        ];

        foreach($data_origin as $key =>$arrdataorigin) {
            
            $data_origin[$key] = $arrdataorigin;
           
        }
        
        $this->origin_address->updateOrCreate([
            'customer_id' => $data_origin['customer_id'],
            'usersid' => Auth::User()->id,
            'users_company_id' => session()->get('company_id'),
            'name' => $data_origin['name'],
            'city_id' => $data_origin['city_id'],
            'details' => $data_origin['name'],
            // 'details' => $data_origin['details'],
            'address' => $data_origin['address'],
            // 'contact' => $data_origin['contact'],
            'contact' => $data_origin['phone'],
            'phone' => $data_origin['phone'],
            'pic_phone_origin' => $data_origin['pic_phone_origin'],
            'pic_name_origin' => $data_origin['pic_name_origin']
        ]);

        //     $data_destination = [
        //         'customer_id' => $fetch_customer_id,
        //         'users_company_id' => session()->get('company_id'),
        //         'name' => $destination_name,
        //         'city_id' => $destination_city,
        //         'details' => $destination_detail,
        //         'address' => $destination_add_boo,
        //         'contact' => $destination_contacts,
        //         'phone' => $destination_fone,
        //         'pic_phone_destination' => $destination_fone,
        //         'pic_name_destination' => $destination_pic
        //     ];

        // foreach($data_destination as $key =>$arrdatadestination) {

        //     $data_destination[$key] = $arrdatadestination;
           
        // }

        //     $this->destination_address->updateOrCreate([
        //         'customer_id' => $data_destination['customer_id'],
        //         'usersid' => Auth::User()->id,
        //         'users_company_id' => session()->get('company_id'),
        //         'name' => $data_destination['name'],
        //         'city_id' => $data_destination['city_id'],
        //         'details' => $data_destination['name'],
        //         // 'details' => $data_destination['details'],
        //         'address' => $data_destination['address'],
        //         // 'contact' => $data_destination['contact'],
        //         'contact' => $data_destination['phone'],
        //         'phone' => $data_destination['phone'],
        //         'pic_phone_destination' => $data_destination['pic_phone_destination'],
        //         'pic_name_destination' => $data_destination['pic_name_destination']
        //     ]);

        return response()->json(['success' => 'Data address book berhasil disimpan']);

    }

    public function address_common($id)
    {
      $data = Address_book::where('id', '=',$id)->get();
      foreach ($data as $query) {
          $results[] = ['value' => $query ];
        }
      return response()->json($data);
    }

    public function address_by_item_transport($id)
    {
      $data = Address_book::where('city_id','=', $id)->get();
      foreach ($data as $query) {
          $results[] = ['value' => $query ];
        }
      return response()->json($data);
    }

    //dev load s - m
    public function sub_service_exc_moda($id)
    {
      $data = MD::where('sub_service_id_fk','=', $id)->get();
      foreach ($data as $query) {
          $results[] = ['value' => $query ];
        }
      return response()->json($data);
    }

    public function address_book_with_customer_id($id)
    {

        $cari = $this->posts->q;

        $data = Address_book::where('customer_id','=', $id)->where('name', 'LIKE', "%$cari%")->groupBy('name')->get();
        foreach ($data as $query) {

            $results[] = ['value' => $query ];
        }
        
        return response()->json($data);

    }

    public function search_if_selected_value_origin($origin_id, $customer_id)
    {
        $cari = $this->posts->q;
        
        $data = Address_book::where('customer_id', $customer_id)
        ->where('id','<>', $origin_id)->where('name','LIKE', "%$cari%")->groupBy('name')->get();

        foreach ($data as $query) {

            $results[] = ['value' => $query ];

        }

        return response()->json($data);

    }

    public function search_if_selected_value_destination($destination_id, $customer_id)
    {
        $cari = $this->posts->q;
        $data = Address_book::where('customer_id', $customer_id)
        ->where('id','<>', $destination_id)->where('name','LIKE', "%$cari%")->groupBy('name')->get();
        foreach ($data as $query) {
            $results[] = ['value' => $query ];
        }
        return response()->json($data);

    }

    public function serch_item_tcs_with_saved_origin($id)
    {
      $data = Item_transport::where('origin','=', $id)->get();
        foreach ($data as $query) {
          $results[] = ['value' => $query ];
        }
      return response()->json($data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {

        // $checkStatusShipment = $this->transport->whereIn('status_order_id', [2])->first();
        // dd($checkStatusShipment['status_order_id']);die;
        $alert_items = Item::where('flag',0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $company_branch_with_role_branch = json_decode($id, true);
        $data_transport = Transport_orders::latest()->with(
                            'customers','addressRelatsOrigins.citys','addressRelatsDestinations.citys',
                            'job_transaction_details.job_transports_normalize','job_transaction_ones.job_transports.status_vendor_jobs'
                    )
                    ->whereIn('by_users', [Auth::User()->oauth_accurate_company])
                        ->get()
        ;
        // dd($asdasdasd);
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $prefix = Company_branchs::branchwarehouse($this->pull_branch->session()->get('id'))->first();

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

        return view('admin.transport.transport_orderlist',[
            'menu'=>'Transport Order List',
            'system_alert_item_customer' => $data_item_alert_sys_allows0,
            'alert_items' => $alert_items,
            'choosen_user_with_branch' => $this->pull_branch->session()->get('id'),
            'some' => $this->pull_branch->session()->get('id'),
            'system_alert_item_vendor' => $system_alert_item_vendor,
            'api_v1' => $fetchArray1,
            'api_v2' => $fetchArray2,
            'alert_customers' => $alert_customers]
        )->with(compact('data_transport','prefix'));

    }

    public function display_date_range($branch_id, Request $request)
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

          return view('admin.transport.transport_orderlist',[
              'menu'=>'Transport Order List',
              'alert_items'=> $alert_items,
              'choosen_user_with_branch' => $this->pull_branch->session()->get('id'),
              'some' => $this->pull_branch->session()->get('id'),
              'api_v1' => $fetchArray1,
              'api_v2' => $fetchArray2,
              'system_alert_item_vendor' => $system_alert_item_vendor,
              'system_alert_item_customer' => $data_item_alert_sys_allows0,
              'alert_customers'=> $alert_customers])->with(compact('datepickerfrom','datepickerto','prefix','data_transport')
          );
            
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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


        try
            {
                $client = new Client();
                $response = $client->get('http://your.api.vendor.com/customer/v1/project',
                    [  'headers' => [
                            'Content-Type' => 'application/x-www-form-urlencoded',
                            'X-IzzyTransport-Token' => 'a7b96913b5b1d66bed4ffdb9b04c075f19047eb3.1603097547',
                            'Accept' => 'application/json'],
                            'query' => ['limit' => '10',
                                        'page' => '30'
                        ]
                    ]
                );
                 $data_array= array();
                        $jsonArray = json_decode($response->getBody(), true);
                        $data_array = $jsonArray['Projects'];
                        // $latest_idx_jbs = Customer_item_transports::latest()->first();
                        $latest_idx_jbs = Customer::latest()->first();
                        $data_city = City::all(); 
                        $alert_items = Item::where('flag',0)->get();
                        $brnchs = Company_branchs::all();
                        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
                        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
                        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
                        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
                        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
                        $prefix = Company_branchs::branchwarehouse($this->pull_branch->session()->get('id'))->first();
                        $id = Customer::select('id')->max('id');
                        $jobs = $id+1;
                        $jincrement_idx = $jobs;
                        $YM = Carbon::Now()->format('my');

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

                    $request_branchs = $this->Apiopentransaction->getBranchIdWithdynamicChoosenBrach($this->pull_branch->session()->get('id'));

                        return view ('admin.transport.transport_order.transport_form_orderlist',[
                            'menu' => 'Transport Form Order Registration',
                            'alert_items' => $alert_items,
                            'request_branchs' => $request_branchs,
                            'choosen_user_with_branch' => $this->pull_branch->session()->get('id'),
                            'some' => $this->pull_branch->session()->get('id'),
                            'system_alert_item_vendor' => $system_alert_item_vendor,
                            'system_alert_item_customer' => $data_item_alert_sys_allows0,
                            'alert_customers' => $alert_customers,
                            'api_v1' => $fetchArray1,
                            'api_v2' => $fetchArray2
                            ])->with(compact('data_city','brnchs','data_array','prefix','jobs_order_idx')
                        );

            } catch (\GuzzleHttp\Exception\ClientException $e) {

                return $e->getResponse()
                        ->getBody()
                        ->getContents();
            
            }
     
    }

    protected function generateID(){
        
        $id = Customer_item_transports::select('id')->max('id');
        $jobs = $id+1;
        $latest_idx_jbs = Customer::latest()->first();
        $jincrement_idx = $jobs;
        $YM = Carbon::Now()->format('my');
        $prefix = Company_branchs::branchwarehouse($this->pull_branch->session()->get('id'))->first();


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

        return $jobs_order_idx;

    }

    
    public function add_item_ajax($branch_id, Request $request){

        $minimumKategori_2 = (Int)$request->get('Qtyminimum'); 

        $minimumKategori_3 = (Int)$request->get('qtyPERTAMA'); 
        $RatePertamaKategori_3 = (Int)$request->get('RatePertama'); 

        if(!$minimumKategori_2){
            $dataminimum = $minimumKategori_3; 
                } else {
            $dataminimum = $minimumKategori_2;  
        }
        // $RateSelanjutnyaKategori_3 = (Int)$request->get('RateSelanjutnya'); 
        $collectdata = collect(['itemMinimumQty' =>$dataminimum, 'rateKgFirst' => $RatePertamaKategori_3]);
        $ETA_ = $request->get('eta_');
        $ETD_ = $request->get('_etd');

        // testing queue
    //     $project = ($request->get('Reqcustomer')=="null")
    //     ? NULL 
    //     : $request->get('Reqcustomer');
    //     $sixdigit = Crypt::encryptString( $this->codes->generate_uuid() );
    //     $master_code = strtoupper(trim(substr($sixdigit, strlen($sixdigit) - 6, strlen($sixdigit)),'=').'-'.Str::random(6));

    //     $getCloudAccurate = $this->openModulesAccurateCloud
    //     ->FuncOpenmoduleAccurateCloudSaveItemBarangjasa__(
    //         $request->get('Reqitemovdesc'),
    //         $this->service, 
    //         $this->date,
    //         $master_code,
    //         $request->get('Requnit')
    //     )
    // ;
    //         $callback_response = $getCloudAccurate->getData("+");
            
    //         $check_process = isset($callback_response) ? $callback_response : false;
    //         // dd($check_process);die;
    //         if(empty($check_process)){
    //             dd("kosonng");
    //         } else {
    //             dd("tidak kosong");

    //         }
    //     die;
// dd();die;
        //     $getCloudAccurate = $this->openModulesAccurateCloud
        //         ->FuncOpenmoduleAccurateCloudSaveItemBarangjasa__(
        //             $this->session, //defaults
        //             $this->posts->Reqitemovdesc, //from request
        //             'SERVICE', //from request
        //             $this->date, //defaults
        //             $jobs_order_idx //request
        //         )
        //     ;

        //     $item_customers = Customer_item_transports::create([
        //         'item_code' => $jobs_order_idx,
        //         'itemID_accurate' => $getCloudAccurate->original,
        //         'customer_id' => $request->get('Reqcustomer'),
        //         'sub_service_id' => $request->get('Reqsubservice'),
        //         'itemovdesc' => $request->get('Reqitemovdesc'),
        //         'ship_category' => $request->get('Reqshipment_category'),
        //         'usersid' => Auth::user()->id,
        //         'moda' => $request->get('Reqmoda'),
        //         'origin' => $request->get('Reqorigin'),
        //         'destination' => $request->get('Reqdestination'),
        //         'price' => $request->get('Reqprice'),
        //         'unit' => $request->get('Requnit')
        //     ]);

        // return response()->json(
        //     [
        //         'city_id' => $request->get('Reqshipment_category'),
        //         'code_autogenerate' => $jobs_order_idx
        //         // 'id' => $item_customers->id,
        //         // 'destination_id' => $request->get('Reqdestination')
        //     ]
        // );
        $itemCustomer = $this->itemcustomers
        ->with('item_transport_customer')
            ->get(); //instead model item_transport
        
        if($itemCustomer->isEmpty())
            
            {

                $loop = Factory::create();

                    $handler = new CurlMultiHandler();
                    $timer = $loop->addPeriodicTimer(1, \Closure::bind(function () use (&$timer) {
                            $this->tick();
                            if (empty($this->handles) && \GuzzleHttp\Promise\queue()->isEmpty()) {
                                $timer->cancel();
                            }
                        }, $handler, $handler)
                    );

                $loop->run();

                $project = ($request->get('Reqcustomer')=="null")
                ? NULL 
                : $request->get('Reqcustomer');
                $sixdigit = Crypt::encryptString( $this->codes->generate_uuid() );
                $master_code = strtoupper(trim(substr($sixdigit, strlen($sixdigit) - 6, strlen($sixdigit)),'=').'-'.Str::random(6));

                    $getCloudAccurate = $this->openModulesAccurateCloud
                        ->FuncOpenmoduleAccurateCloudSaveItemBarangjasa__(
                            $request->get('Reqitemovdesc'),
                            $this->service, 
                            $this->date,
                            $master_code,
                            $request->get('Requnit')
                        )
                    ;

                $callback_response = $getCloudAccurate->getData("+");

                $checkIfEmptyprocess = isset($callback_response) ? $callback_response : false;

                if(empty($checkIfEmptyprocess)){

                    echo json_encode(
                        array('status_SyncAccurate'=> "false"),
                        JSON_PRETTY_PRINT
                    );

                } 
                    else {

                            $item = MasterItemTransportX::updateOrCreate(
                                    [
                                        'item_code' => $master_code,
                                        'origin' => $request->get('Reqorigin'),
                                        'destination' => $request->get('Reqdestination'),
                                        'userid' => Auth::User()->id,
                                        'ship_category' => $request->get('Reqshipment_category'),
                                        'itemovdesc' => $request->get('Reqitemovdesc'),
                                        'unit' => $request->get('Requnit'),
                                        'sub_service_id' => $request->get('Reqsubservice'),
                                        'moda' => $request->get('Reqmoda'),
                                        'customer_id' => $project,
                                        'itemID_accurate' => $checkIfEmptyprocess["r"]["no"],
                                        'itemIDaccurate' => $checkIfEmptyprocess["r"]["id"],
                                        'flag' => 0
                                    ]
                            );
                                        
                            $item->save();
            
                            $itemTransports = New Customer_item_transports();
                            $itemTransports->branch_item = Auth::User()->oauth_accurate_company;
                            $itemTransports->item_code = $item->itemID_accurate;
                            $itemTransports->customer_id = $item->customer_id;
                            $itemTransports->referenceID = $item->id;
                            $itemTransports->sub_service_id = $item->sub_service_id;
                            $itemTransports->itemovdesc = $item->itemovdesc;
                            $itemTransports->ship_category = $item->ship_category;
                            $itemTransports->moda = $item->moda;
                            $itemTransports->usersid = Auth::User()->id;
                            $itemTransports->origin = $item->origin;
                            $itemTransports->destination = $item->destination;
                            $itemTransports->price = $request->get('Reqprice') === null ? $request->get('RatePertama') : $request->get('Reqprice');
                            $itemTransports->unit = $item->unit;
                            $itemTransports->batch_itemCustomer = $collectdata;
                            $itemTransports->itemID_accurate = $checkIfEmptyprocess["r"]["no"];
                            $itemTransports->save();

                            echo json_encode(
                                array('status_SyncAccurate'=> "true"),
                                JSON_PRETTY_PRINT
                            );
                 }
    
        } 
            else
                    {    
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

                            $dataTableItemTransport_Subservice[] = $fetchdatOfFields->sub_service_id; //master item customer of transaction instead master item transport
                            $dataTableItemTransport_origin[] = $fetchdatOfFields->origin; //master item customer of transaction instead master item transport
                            $dataTableItemTransport_Destination[] = $fetchdatOfFields->destination; //master item customer of transaction instead master item transport
                            $dataTableItemTransport_Ship_category[] = $fetchdatOfFields->ship_category; //master item customer of transaction instead master item transport
                            $dataTableItemTransport_Modas[] = $fetchdatOfFields->moda; //master item customer of transaction instead master item transport
                            $dataTableItemTransport_Unit[] = $fetchdatOfFields->unit; //master item customer of transaction instead master item transport
                            $dataTableItemTransport_itemovdesc[] = $fetchdatOfFields->itemovdesc; //master item customer of transaction instead master item transport
                        }

                        $CollectCallbackQuerys = collect([$selfbacktoHack]);

                        $SubServiceInsteadOfMasterItemTransportsA = collect([$dataTableItemTransport_Subservice]);
                        $SubServiceInsteadOfMasterItemTransportsB = collect([$dataTableItemTransport_origin]);
                        $SubServiceInsteadOfMasterItemTransportsC = collect([$dataTableItemTransport_Destination]);
                        $SubServiceInsteadOfMasterItemTransportsD = collect([$dataTableItemTransport_Ship_category]);
                        $SubServiceInsteadOfMasterItemTransportsE = collect([$dataTableItemTransport_Modas]);
                        $SubServiceInsteadOfMasterItemTransportsF = collect([$dataTableItemTransport_Unit]);
                        $SubServiceInsteadOfMasterItemTransportsG = collect([$dataTableItemTransport_itemovdesc]);

                        $CollectCallbackQuerys->map(function ($resultsQuery) use ($request, $collectdata,

                                $SubServiceInsteadOfMasterItemTransportsA,
                                $SubServiceInsteadOfMasterItemTransportsB,
                                $SubServiceInsteadOfMasterItemTransportsC,
                                $SubServiceInsteadOfMasterItemTransportsD,
                                $SubServiceInsteadOfMasterItemTransportsE,
                                $SubServiceInsteadOfMasterItemTransportsF,
                                $SubServiceInsteadOfMasterItemTransportsG
                         
                         ) {

                if(in_array($request->get('Reqitemovdesc'), $SubServiceInsteadOfMasterItemTransportsG[0]) && in_array($request->get('Reqdestination'), $SubServiceInsteadOfMasterItemTransportsC[0]) && in_array($request->get('Reqorigin'), $SubServiceInsteadOfMasterItemTransportsB[0]) && in_array($request->get('Reqsubservice'), $SubServiceInsteadOfMasterItemTransportsA[0]) && in_array($request->get('Reqshipment_category'), $SubServiceInsteadOfMasterItemTransportsD[0]) && in_array($request->get('Reqmoda'), $SubServiceInsteadOfMasterItemTransportsE[0]) && in_array($request->get('Requnit'), $SubServiceInsteadOfMasterItemTransportsF[0])){
                        
                        $dataItem = MasterItemTransportX::
                                        when($request->has('Reqitemovdesc') && $request->has('Reqsubservice') && $request->has('Reqorigin') && $request->has('Reqdestination') && $request->has('Reqshipment_category') && $request->has('Reqmoda') && $request->has('Requnit'), function ($que) use ($request){
                                            return $que->where('sub_service_id','=',$request->get('Reqsubservice'))
                                                        // ->where('customer_id','=', $project)
                                                        ->where('origin', '=',$request->get('Reqorigin'))
                                                        ->where('ship_category', '=',$request->get('Reqshipment_category'))
                                                        ->where('moda', '=',$request->get('Reqmoda'))
                                                        ->where('unit', '=',$request->get('Requnit'))
                                                        ->whereIn('itemovdesc', [$request->get('Reqitemovdesc')])
                                                        ->where('destination','=', $request->get('Reqdestination'));
                                        }   
                                    )

                                ->first()
                            ;

                    } 
                            else {
                                
                                $dataItem = null;

                        }
                        
                        // dd($dataItem);die;

                            //by default: secara sistem akan melakukan pengecekkan data yanb diterima oleh client apakah ada atau tidak[tidak]
                if(is_null($dataItem)) {

                                $project = ($request->get('Reqcustomer')=="null")
                                ? NULL 
                                : $request->get('Reqcustomer');
                                $sixdigit = Crypt::encryptString( $this->codes->generate_uuid() );
                                $master_code = strtoupper(trim(substr($sixdigit, strlen($sixdigit) - 6, strlen($sixdigit)),'=').'-'.Str::random(6));
                                
                                // $getCloudAccurate = $this->openModulesAccurateCloud
                                //                         ->FuncOpenmoduleAccurateCloudSaveItemBarangjasa__(
                                //                             $request->get('Reqitemovdesc'),
                                //                             $this->service, 
                                //                             $this->date,
                                //                             $master_code,
                                //                             $request->get('Requnit')
                                //                         )
                                //                     ;

                                //     $check_process = isset($getCloudAccurate->original) ? $getCloudAccurate->original : false;

                                    // if($check_process == false){

                                    //     echo json_encode(
                                    //        array('status_SyncAccurate'=> "false"),
                                    //        JSON_PRETTY_PRINT
                                    //    );

                                    // }
                                    //     else
                                    //             {

                                    $project = ($request->get('Reqcustomer')=="null")
                                    ? NULL 
                                    : $request->get('Reqcustomer');
                                    
                                    $sixdigit = Crypt::encryptString( $this->codes->generate_uuid() );
                                    $master_code = strtoupper(trim(substr($sixdigit, strlen($sixdigit) - 6, strlen($sixdigit)),'=').'-'.Str::random(6));
                                    // $getCloudAccurate = $this->openModulesAccurateCloud
                                    //     ->FuncOpenmoduleAccurateCloudSaveItemBarangjasa__(
                                    //         $request->get('Reqitemovdesc'),
                                    //         $this->service, 
                                    //         $this->date,
                                    //         $master_code,
                                    //         $request->get('Requnit')
                                    //     )
                                    // ;

                                    // $checkIfDataSame = isset($getCloudAccurate->original) ? $getCloudAccurate->original : false;
                                    
                                    // if($checkIfDataSame == false){

                                    //     echo json_encode(
                                    //         array('status_SyncAccurate'=> "false"),
                                    //         JSON_PRETTY_PRINT
                                    //     );

                                    //     echo json_encode(
                                    //         array('data_internal'=> "maaf ada data yang tidak sinkron dengan accurate."),
                                    //         JSON_PRETTY_PRINT
                                    //     );
                        
                                    // } 
                                    //     else {

                                    $fetchMasterItemID = Customer_item_transports::where([
                                            'customer_id' => $project,
                                            'branch_item' => Auth::User()->oauth_accurate_company,
                                            'sub_service_id' => $request->get('Reqsubservice'),
                                            'ship_category' => $request->get('Reqshipment_category'),
                                            'moda' => $request->get('Reqmoda'),
                                            'origin' => $request->get('Reqorigin'),
                                            'unit' => $request->get('Requnit'),
                                            // 'price' => $request->get('Reqprice'),
                                            'price' => (Int)  $request->get('Reqprice') === null ? $request->get('RatePertama') : $request->get('Reqprice'),
                                            'itemovdesc' => $request->get('Reqitemovdesc')
                                    ])->first();
                                    
                                    $destination = $request->get('Reqdestination');
                                    $subservice = $request->get('Reqsubservice');
                                    $shipment_category = $request->get('Reqshipment_category');
                                    $moda = $request->get('Reqmoda');
                                    $origin = $request->get('Reqorigin');
                                    $unit = $request->get('Requnit');
                                    $price = $request->get('Reqprice');
                                    $itemovdesc = $request->get('Reqitemovdesc');

                                // jika data tidak sama fetchMasterItemID == null
                                if(is_null($fetchMasterItemID)){

                                    $item = MasterItemTransportX::UpdateOrInserted(
                                        [
                                            'itemovdesc' => $itemovdesc
                                        ],
                                            [
                                                'item_code' => $master_code,
                                                'origin' => $origin,
                                                'destination' => $destination,
                                                'userid' => Auth::User()->id,
                                                'ship_category' => $shipment_category,
                                                'itemovdesc' => $itemovdesc,
                                                'unit' => $unit,
                                                'sub_service_id' => $subservice,
                                                'moda' => $moda,
                                                // 'price' => (Int) $request->get('RatePertama'),
                                                'price' => (Int)  $request->get('Reqprice') === null ? $request->get('RatePertama') : $request->get('Reqprice'),
                                                'customer_id' => $project,
                                                'itemID_accurate' => $master_code,
                                                'flag'   => 12
                                            ]
                                    );

                                    Customer_item_transports::UpdateOrInserted(
                                        [
                                            'itemovdesc' => $itemovdesc
                                        ],
                                            [
                                                'referenceID' => $item->id,
                                                'branch_item' => Auth::User()->oauth_accurate_company,
                                                'item_code' => $item->item_code,
                                                'origin' => $item->origin,
                                                'destination' => $item->destination,
                                                'usersid' => Auth::User()->id,
                                                'ship_category' => $item->ship_category,
                                                'itemovdesc' => $item->itemovdesc,
                                                'unit' => $item->unit,
                                                'sub_service_id' => $item->sub_service_id,
                                                'moda' => $item->moda,
                                                'batch_itemCustomer' => $collectdata,
                                                'price' => (Int)  $request->get('Reqprice') === null ? $request->get('RatePertama') : $request->get('Reqprice'),
                                                'customer_id' => $item->customer_id,
                                                'itemID_accurate' => $item->itemID_accurate,
                                                'flag'   => 34
                                            ]
                                        )
                                    ;

                                      
                                    if(is_null($project)){

                                        $itemCode = $item->itemID_accurate;
                                        $harga = $request->get('Reqprice');
                                        $name = $request->get('Reqitemovdesc');
                                        
                                            $barangJasa__ = new Promise(
                                                            function () use (&$barangJasa__, &$itemCode, &$dataminimum, &$harga, &$name) {
                                                                $barangJasa__->resolve($this->UpdateSyncBarangJasaCustomer($itemCode, $dataminimum, $harga, $name));
                                
                                                            },
                                                            function ($ex) {
                                                                $barangJasa__->reject($ex);
                                                            }
                                                        );
                                                                    
                                                $promise = $barangJasa__->wait()->original;
                                        
                                        
                                        if($promise["s"] == false){

                                                $getCloudAccurate = $this->openModulesAccurateCloud
                                                    ->FuncOpenmoduleAccurateCloudSaveItemBarangjasa__(
                                                        $request->get('Reqitemovdesc'),
                                                        $this->service, 
                                                        $this->date,
                                                        $itemCode,
                                                        $request->get('Requnit')
                                                    )
                                                ;
                                                        
                                                $callback_response = $getCloudAccurate->getData("+");

                                                    $check_process = isset($callback_response) ? $callback_response : false;
    
                                                        if(empty($check_process)){

                                                            $barangJasa__ = new Promise(
                                                                function () use (&$barangJasa__, &$itemCode, &$dataminimum, &$harga, &$name) {
                                                                    $barangJasa__->resolve($this->UpdateSyncBarangJasaCustomer($itemCode, $dataminimum, $harga, $name));
                                    
                                                                },
                                                                function ($ex) {
                                                                    $barangJasa__->reject($ex);
                                                                }
                                                            );
                                                                        
                                                        $barangJasa__->wait()->original;
        
                                                                    echo json_encode(
                                                                        array('status_SyncAccurate'=> "true"),
                                                                        JSON_PRETTY_PRINT
                                                                    );
        
                                                                echo json_encode(
                                                                    array('data_internal'=> "data telah diupdate diaccurate."),
                                                                    JSON_PRETTY_PRINT
                                                                );
                                                            
                                                        } 
                                                            else {
    
                                                                MasterItemTransportX::UpdateOrInserted(
                                                                    [
                                                                        'itemovdesc' => $request->get('Reqitemovdesc')
                                                                    ],
                                                                        [
                                                                            'item_code' => $check_process["r"]["no"],
                                                                            'origin' => $request->get('Reqorigin'),
                                                                            'destination' => $request->get('Reqdestination'),
                                                                            'userid' => Auth::User()->id,
                                                                            'ship_category' => $request->get('Reqshipment_category'),
                                                                            'itemovdesc' => $request->get('Reqitemovdesc'),
                                                                            'unit' => $request->get('Requnit'),
                                                                            'sub_service_id' => $request->get('Reqsubservice'),
                                                                            'moda' => $request->get('Reqmoda'),
                                                                            'customer_id' => $project,
                                                                            'itemID_accurate' => $check_process["r"]["no"],
                                                                            'itemIDaccurate' => $check_process["r"]["id"],

                                                                        ]
                                                                );

                                                                // dd("bug 4");
                                                        }

                                                } 


                                            } 
                                                else {

                                                        $itemCustomers = Customer_item_transports::UpdateOrInserted(
                                                            [
                                                                'itemovdesc' => $request->get('Reqitemovdesc')
                                                            ],
                                                                [   
                                                                    'item_code' => $item->itemID_accurate,
                                                                    'referenceID' => $item->id,
                                                                    'branch_item' => Auth::User()->oauth_accurate_company,
                                                                    'origin' => $request->get('Reqorigin'),
                                                                    'destination' => $request->get('Reqdestination'),
                                                                    'usersid' => Auth::User()->id,
                                                                    'ship_category' => $request->get('Reqshipment_category'),
                                                                    'itemovdesc' => $item->itemovdesc,
                                                                    'unit' => $request->get('Requnit'),
                                                                    'sub_service_id' => $request->get('Reqsubservice'),
                                                                    'moda' => $request->get('Reqmoda'),
                                                                    // 'price' => $request->get('Reqprice'),
                                                                    'price' => (Int)  $request->get('Reqprice') === null ? $request->get('RatePertama') : $request->get('Reqprice'),
                                                                    'batch_itemCustomer' => $collectdata,
                                                                    'customer_id' => $project,
                                                                    'itemID_accurate' => $item->itemID_accurate,
                                                                ]
                                                        );
                                                        
                                                            $barangJasa__ = new Promise(
                                                                            function () use (&$barangJasa__, &$master_code, &$dataminimum, &$harga, &$name) {
                                                                                $barangJasa__->resolve($this->UpdateSyncBarangJasaCustomer($master_code, $dataminimum, $harga, $name));
                                                
                                                                            },
                                                                            function ($ex) {
                                                                                $barangJasa__->reject($ex);
                                                                            }
                                                                        );
                                                                                    
                                                                $promise = $barangJasa__->wait()->original;
                                                        
                                                            $itemCode = $itemCustomers->itemID_accurate;
                                                        
                                                        if($promise["s"] == false){

                                                                $getCloudAccurate = $this->openModulesAccurateCloud
                                                                    ->FuncOpenmoduleAccurateCloudSaveItemBarangjasa__(
                                                                        $request->get('Reqitemovdesc'),
                                                                        $this->service, 
                                                                        $this->date,
                                                                        $itemCustomers->itemID_accurate,
                                                                        $request->get('Requnit')
                                                                    )
                                                                ;
                                                                        
                                                                $callback_response = $getCloudAccurate->getData("+");

                                                                    $check_process = isset($callback_response) ? $callback_response : false;
                    
                                                                        if(empty($check_process)){

                                                                            $barangJasa__ = new Promise(
                                                                                function () use (&$barangJasa__, &$itemCode, &$dataminimum, &$harga, &$name) {
                                                                                    $barangJasa__->resolve($this->UpdateSyncBarangJasaCustomer($itemCode, $dataminimum, $harga, $name));
                                                    
                                                                                },
                                                                                function ($ex) {
                                                                                    $barangJasa__->reject($ex);
                                                                                }
                                                                            );
                                                                                        
                                                                    $barangJasa__->wait()->original;
                    
                                                                                echo json_encode(
                                                                                    array('status_SyncAccurate'=> "false"),
                                                                                    JSON_PRETTY_PRINT
                                                                                );
                    
                                                                            echo json_encode(
                                                                                array('data_internal'=> "maaf ada data yang tidak sinkron dengan accurate."),
                                                                                JSON_PRETTY_PRINT
                                                                            );
                                                                        
                                                                        } 
                                                                            else {
                    
                                                                                MasterItemTransportX::UpdateOrInserted(
                                                                                    [
                                                                                        'itemovdesc' => $request->get('Reqitemovdesc')
                                                                                    ],
                                                                                        [
                                                                                            'item_code' => $itemCode,
                                                                                            'origin' => $request->get('Reqorigin'),
                                                                                            'destination' => $request->get('Reqdestination'),
                                                                                            'userid' => Auth::User()->id,
                                                                                            'ship_category' => $request->get('Reqshipment_category'),
                                                                                            'itemovdesc' => $request->get('Reqitemovdesc'),
                                                                                            'unit' => $request->get('Requnit'),
                                                                                            'sub_service_id' => $request->get('Reqsubservice'),
                                                                                            'moda' => $request->get('Reqmoda'),
                                                                                            'customer_id' => $project,
                                                                                            'itemID_accurate' => $itemCode,
                                                                                            'itemIDaccurate' => $check_process["r"]["id"]
                                                                                        ]
                                                                                );

                                                                                // dd("bug 4");
                                                                        }

                                                            } 
                                                }
                                                echo json_encode(
                                                    array('status_SyncAccurate'=> "true",
                                                        'fullfield' => "queue start"),
                                                    JSON_PRETTY_PRINT
                                            );
                                            // $itemCode = $item->itemID_accurate;

                                            // $barangJasa__ = new Promise(
                                            //                 function () use (&$barangJasa__, &$itemCode, &$dataminimum, &$harga, &$name) {
                                            //                     $barangJasa__->resolve($this->UpdateSyncBarangJasaCustomer($itemCode, $dataminimum, $harga, $name));
                                
                                            //                 },
                                            //                 function ($ex) {
                                            //                     $barangJasa__->reject($ex);
                                            //                 }
                                            //             );
                                                                    
                                            //     $promise = $barangJasa__->wait()->original;
                                                
                                            //     // $promised = isset($promise) ? $promise : false;
                                            //     // dd($promise);    
                                            // // die;

                                            // if($promise["s"] == false){

                                                    // $getCloudAccurate = $this->openModulesAccurateCloud
                                                    //     ->FuncOpenmoduleAccurateCloudSaveItemBarangjasa__(
                                                    //         $item->itemovdesc,
                                                    //         $item->service, 
                                                    //         $this->date,
                                                    //         $item->item_code,
                                                    //         $item->unit
                                                    //     )
                                                    // ;

                                                    // $callback_response = $getCloudAccurate->getData("+");
                                                    // dd("0",$callback_response);

                                                    //   $promised = isset($callback_response) ? $callback_response : false;

                                                    //   $itemTransports = New Customer_item_transports();
                                                    //   $itemTransports->item_code = $callback_response;
                                                    //   $itemTransports->customer_id = $project;
                                                    //   $itemTransports->referenceID = $item->id;
                                                    //   $itemTransports->sub_service_id = $item->sub_service_id;
                                                    //   $itemTransports->itemovdesc = $item->itemovdesc;
                                                    //   $itemTransports->ship_category = $item->ship_category;
                                                    //   $itemTransports->moda = $item->moda;
                                                    //   $itemTransports->usersid = $item->userid;
                                                    //   $itemTransports->origin = $item->origin;
                                                    //   $itemTransports->destination = $item->destination;
                                                    //   $itemTransports->price = $item->price;
                                                    //   $itemTransports->unit = $item->unit;
                                                    //   $itemTransports->batch_itemCustomer = $collectdata;
                                                    //   $itemTransports->itemID_accurate = $callback_response;
                                                    //   $itemTransports->save();
                                                    // $cs_fetchs = Customer_item_transports::UpdateOrInserted(
                                                    //     [
                                                    //         'itemovdesc' => $request->get('Reqitemovdesc')
                                                    //     ],
                                                    //         [   
                                                    //             'item_code' => $itemCode,
                                                    //             'referenceID' => $item->id,
                                                    //             'origin' => $request->get('Reqorigin'),
                                                    //             'destination' => $request->get('Reqdestination'),
                                                    //             'usersid' => Auth::User()->id,
                                                    //             'ship_category' => $request->get('Reqshipment_category'),
                                                    //             'itemovdesc' => $item->itemovdesc,
                                                    //             'unit' => $request->get('Requnit'),
                                                    //             'sub_service_id' => $request->get('Reqsubservice'),
                                                    //             'moda' => $request->get('Reqmoda'),
                                                    //             'customer_id' => $project,
                                                    //             'itemID_accurate' => $itemCode,
                                                    //             'flag'   => 1
                                                    //         ]
                                                    //     );

                                                            // echo json_encode(
                                                            //     array('status_SyncAccurate'=> "true"),
                                                            //     JSON_PRETTY_PRINT
                                                            // );

                                                        // echo json_encode(
                                                        //     array('data_internal'=> "maaf ada data yang tidak sinkron dengan accurate."),
                                                        //     JSON_PRETTY_PRINT
                                                        // );
                                                    
                                                    // } 
                                                    //     else {

                                                    //             $barangJasa__ = new Promise(
                                                    //                     function () use (&$barangJasa__, &$itemCode, &$dataminimum, &$harga, &$name) {
                                                    //                         $barangJasa__->resolve($this->UpdateSyncBarangJasaCustomer($itemCode, $dataminimum, $harga, $name));
                                            
                                                    //                     },
                                                    //                     function ($ex) {
                                                    //                         $barangJasa__->reject($ex);
                                                    //                     }
                                                    //                 );
                                                                                
                                                    //         $barangJasa__->wait()->original;

                                                                //     $barangJasa__ = new Promise(
                                                                //         function () use (&$barangJasa__, &$check_process, &$dataminimum, &$harga, &$name) {
                                                                //             $barangJasa__->resolve($this->UpdateSyncBarangJasaCustomer($check_process, $dataminimum, $harga, $name));
                                            
                                                                //         },
                                                                //         function ($ex) {
                                                                //             $barangJasa__->reject($ex);
                                                                //         }
                                                                //     );
                                                                    
                                                                // $promise = $barangJasa__->wait()->original["d"][0];

                                                                    // $item = MasterItemTransportX::UpdateOrInserted(
                                                                    //     [
                                                                    //         'item_code' => $check_process,
                                                                    //         'origin' => $request->get('Reqorigin'),
                                                                    //         'destination' => $request->get('Reqdestination'),
                                                                    //         'userid' => Auth::User()->id,
                                                                    //         'ship_category' => $request->get('Reqshipment_category'),
                                                                    //         'itemovdesc' => $request->get('Reqitemovdesc'),
                                                                    //         'unit' => $request->get('Requnit'),
                                                                    //         'sub_service_id' => $request->get('Reqsubservice'),
                                                                    //         'moda' => $request->get('Reqmoda'),
                                                                    //         'customer_id' => $project,
                                                                    //         'itemID_accurate' => $check_process,
                                                                    //         'flag'   => 0
                                                                    //     ]
                                                                    // );

                                                                    // $item = MasterItemTransportX::UpdateOrInserted(
                                                                    //     [
                                                                    //         'itemovdesc' => $request->get('Reqitemovdesc')
                                                                    // ],
                                                                    //         [
                                                                    //             'item_code' => $check_process,
                                                                    //             'origin' => $request->get('Reqorigin'),
                                                                    //             'destination' => $request->get('Reqdestination'),
                                                                    //             'userid' => Auth::User()->id,
                                                                    //             'ship_category' => $request->get('Reqshipment_category'),
                                                                    //             'itemovdesc' => $request->get('Reqitemovdesc'),
                                                                    //             'unit' => $request->get('Requnit'),
                                                                    //             'sub_service_id' => $request->get('Reqsubservice'),
                                                                    //             'moda' => $request->get('Reqmoda'),
                                                                    //             'customer_id' => $project,
                                                                    //             'itemID_accurate' => $check_process,
                                                                    //             'flag'   => 0
                                                                    //         ]
                                                                    // );
                                                                
                                                                        // $item->save();
                                                                // dd($item);
                                                             
            
                                                        // }
                                             
                                        } //jika data data yang sama fetchMasterItemID != null

                                            else {

                                                //cek jika ada sama, kemudian melakukan pengecekan apakah didalam terdapat customer kontrak/publish. [null]
                                                if(is_null($fetchMasterItemID->customer_id)){

                                                        //cek request, kemudian melakukan pengecekan apakah request customer null / tidak.
                                                        if(is_null($project)){

                                                                // $itemTransports = Customer_item_transports::findOrFail($fetchMasterItemID->id);
                                                                //     // $itemTransports->item_code = self::generateID();
                                                                //         $itemTransports->referenceID = $fetchMasterItemID->id;
                                                                //         $itemTransports->sub_service_id = $request->get('Reqsubservice');
                                                                //         $itemTransports->itemovdesc = $request->get('Reqitemovdesc');
                                                                //         $itemTransports->ship_category = $request->get('Reqshipment_category');
                                                                //         $itemTransports->moda = $request->get('Reqmoda');
                                                                //         $itemTransports->usersid = Auth::User()->id;
                                                                //         $itemTransports->origin = $request->get('Reqorigin');
                                                                //         $itemTransports->destination = $request->get('Reqdestination');
                                                                //         $itemTransports->price = $request->get('Reqprice');
                                                                //         $itemTransports->unit = $request->get('Requnit');
                                                                //         $itemTransports->batch_itemCustomer = $collectdata;
                                                                //     $itemTransports->itemID_accurate = $fetchMasterItemID->itemID_accurate;
                                                                // $itemTransports->save();

                                                                // $itemID_accurate = $fetchMasterItemID->itemID_accurate;
                                                                // $harga = $request->get('Reqprice');
                                                                // $name = $request->get('Reqitemovdesc');

                                                                // $barangJasa__ = new Promise(
                                                                //     function () use (&$barangJasa__, &$itemID_accurate, &$dataminimum, &$harga, &$name) {
                                                                //         $barangJasa__->resolve($this->UpdateSyncBarangJasaCustomer($itemID_accurate, $dataminimum, $harga, $name));
                                        
                                                                //     },
                                                                //     function ($ex) {
                                                                //         $barangJasa__->reject($ex);
                                                                //     }
                                                                // );
                                                                
                                                                // $barangJasa__->wait()->original["d"][0];

                                                            $getCloudAccurate = $this->openModulesAccurateCloud
                                                                ->FuncOpenmoduleAccurateCloudSaveItemBarangjasa__(
                                                                    $request->get('Reqitemovdesc'),
                                                                    $this->service, 
                                                                    $this->date,
                                                                    $master_code,
                                                                    $request->get('Requnit')
                                                                )
                                                            ;

                                                            $callback_response = $getCloudAccurate->getData("+");
                    
                                                                $check_process = isset($callback_response) ? $callback_response : false;
                
                                                                    if(empty($check_process)){
                
                                                                            echo json_encode(
                                                                                array('status_SyncAccurate'=> "false"),
                                                                                JSON_PRETTY_PRINT
                                                                            );
                
                                                                        echo json_encode(
                                                                            array('data_internal'=> "maaf ada data yang tidak sinkron dengan accurate."),
                                                                            JSON_PRETTY_PRINT
                                                                        );
                                                                    
                                                                    } 
                                                                        else {
                
                                                                                $item = MasterItemTransportX::updateOrCreate(
                                                                                    [
                                                                                        'item_code' => $check_process,
                                                                                        'origin' => $request->get('Reqorigin'),
                                                                                        'destination' => $request->get('Reqdestination'),
                                                                                        'userid' => Auth::User()->id,
                                                                                        'ship_category' => $request->get('Reqshipment_category'),
                                                                                        'itemovdesc' => $request->get('Reqitemovdesc'),
                                                                                        'unit' => $request->get('Requnit'),
                                                                                        'sub_service_id' => $request->get('Reqsubservice'),
                                                                                        'moda' => $request->get('Reqmoda'),
                                                                                        'customer_id' => $project,
                                                                                        'itemID_accurate' => $check_process,
                                                                                        'itemIDaccurate' => $check_process["r"]["id"],
                                                                                        'flag'   => 0
                                                                                    ]
                                                                                );
                                                                            
                                                                                    $item->save();
                                    
                                                                                            $itemTransports = New Customer_item_transports();
                                                                                            $itemTransports->item_code = self::generateID();
                                                                                            $itemTransports->customer_id = $project;
                                                                                            $itemTransports->branch_item = Auth::User()->oauth_accurate_company;
                                                                                            $itemTransports->referenceID = $item->id;
                                                                                            $itemTransports->sub_service_id = $request->get('Reqsubservice');
                                                                                            $itemTransports->itemovdesc = $request->get('Reqitemovdesc');
                                                                                            $itemTransports->ship_category = $request->get('Reqshipment_category');
                                                                                            $itemTransports->moda = $request->get('Reqmoda');
                                                                                            $itemTransports->usersid = Auth::User()->id;
                                                                                            $itemTransports->origin = $request->get('Reqorigin');
                                                                                            $itemTransports->destination = $request->get('Reqdestination');
                                                                                            $itemTransports->price = $request->get('Reqprice');
                                                                                            $itemTransports->unit = $request->get('Requnit');
                                                                                            $itemTransports->batch_itemCustomer = $collectdata;
                                                                                            $itemTransports->itemID_accurate = $check_process;
                                                                                            $itemTransports->save();
                        
                                                                                // echo json_encode(
                                                                                //     array('status_SyncAccurate'=> "true"),
                                                                                //     JSON_PRETTY_PRINT
                                                                                // );

                                                                                // dd("bug 2");

                
                                                                        }

                                                            echo json_encode(
                                                                array('status_SyncAccurate'=> "true"),
                                                                JSON_PRETTY_PRINT
                                                            );
                                                        //cek request, kemudian melakukan pengecekan apakah request customer null / tidak [ request customer != null]
                                                        }
                                                            else {

                                                                    // $itemTransports = Customer_item_transports::findOrFail($fetchMasterItemID->id);
                                                                    //     $itemTransports->item_code = self::generateID();
                                                                    //         $itemTransports->customer_id = $project;
                                                                    //         $itemTransports->referenceID = $fetchMasterItemID->id;
                                                                    //         $itemTransports->sub_service_id = $request->get('Reqsubservice');
                                                                    //         $itemTransports->itemovdesc = $request->get('Reqitemovdesc');
                                                                    //         $itemTransports->ship_category = $request->get('Reqshipment_category');
                                                                    //         $itemTransports->moda = $request->get('Reqmoda');
                                                                    //         $itemTransports->usersid = Auth::User()->id;
                                                                    //         $itemTransports->origin = $request->get('Reqorigin');
                                                                    //         $itemTransports->destination = $request->get('Reqdestination');
                                                                    //         $itemTransports->price = $request->get('Reqprice');
                                                                    //         $itemTransports->unit = $request->get('Requnit');
                                                                    //         $itemTransports->batch_itemCustomer = $collectdata;
                                                                    //     $itemTransports->itemID_accurate = $fetchMasterItemID->itemID_accurate;
                                                                    // $itemTransports->save();

                                                                    // $itemID_accurate = $fetchMasterItemID->itemID_accurate;
                                                                    // $harga = $request->get('Reqprice');
                                                                    // $name = $request->get('Reqitemovdesc');

                                                                    // $barangJasa__ = new Promise(
                                                                    //     function () use (&$barangJasa__, &$itemID_accurate, &$dataminimum, &$harga, &$name) {
                                                                    //         $barangJasa__->resolve($this->UpdateSyncBarangJasaCustomer($itemID_accurate, $dataminimum, $harga, $name));
                                            
                                                                    //     },
                                                                    //     function ($ex) {
                                                                    //         $barangJasa__->reject($ex);
                                                                    //     }
                                                                    // );
                                                                    
                                                                    // $barangJasa__->wait()->original["d"][0];

                                                                $getCloudAccurate = $this->openModulesAccurateCloud
                                                                    ->FuncOpenmoduleAccurateCloudSaveItemBarangjasa__(
                                                                        $request->get('Reqitemovdesc'),
                                                                        $this->service, 
                                                                        $this->date,
                                                                        $master_code,
                                                                        $request->get('Requnit')
                                                                    )
                                                                ;

                                                                $callback_response = $getCloudAccurate->getData("+");
                        
                                                                    $check_process = isset($callback_response) ? $callback_response : false;
                    
                                                                        if(empty($check_process)){
                    
                                                                                echo json_encode(
                                                                                    array('status_SyncAccurate'=> "false"),
                                                                                    JSON_PRETTY_PRINT
                                                                                );
                    
                                                                            echo json_encode(
                                                                                array('data_internal'=> "maaf ada data yang tidak sinkron dengan accurate."),
                                                                                JSON_PRETTY_PRINT
                                                                            );
                                                                        
                                                                        } 
                                                                            else {
                    
                                                                                    $item = MasterItemTransportX::updateOrCreate(
                                                                                        [
                                                                                            'item_code' => $check_process,
                                                                                            'origin' => $request->get('Reqorigin'),
                                                                                            'destination' => $request->get('Reqdestination'),
                                                                                            'userid' => Auth::User()->id,
                                                                                            'ship_category' => $request->get('Reqshipment_category'),
                                                                                            'itemovdesc' => $request->get('Reqitemovdesc'),
                                                                                            'unit' => $request->get('Requnit'),
                                                                                            'sub_service_id' => $request->get('Reqsubservice'),
                                                                                            'moda' => $request->get('Reqmoda'),
                                                                                            'customer_id' => $project,
                                                                                            'itemID_accurate' => $check_process,
                                                                                            'itemIDaccurate' => $check_process["r"]["id"],
                                                                                            'flag'   => 21
                                                                                        ]
                                                                                    );
                                                                                
                                                                                        // $item->save();
                                        
                                                                                                // $itemTransports = New Customer_item_transports();
                                                                                                // $itemTransports->item_code = self::generateID();
                                                                                                // $itemTransports->customer_id = $project;
                                                                                                // $itemTransports->referenceID = $item->id;
                                                                                                // $itemTransports->sub_service_id = $request->get('Reqsubservice');
                                                                                                // $itemTransports->itemovdesc = $request->get('Reqitemovdesc');
                                                                                                // $itemTransports->ship_category = $request->get('Reqshipment_category');
                                                                                                // $itemTransports->moda = $request->get('Reqmoda');
                                                                                                // $itemTransports->usersid = Auth::User()->id;
                                                                                                // $itemTransports->origin = $request->get('Reqorigin');
                                                                                                // $itemTransports->destination = $request->get('Reqdestination');
                                                                                                // $itemTransports->price = $request->get('Reqprice');
                                                                                                // $itemTransports->unit = $request->get('Requnit');
                                                                                                // $itemTransports->batch_itemCustomer = $collectdata;
                                                                                                // $itemTransports->itemID_accurate = $check_process;
                                                                                                // $itemTransports->save();
                                                                                Customer_item_transports::UpdateOrInserted(
                                                                                        [
                                                                                            'itemovdesc' => $request->get('Reqitemovdesc')
                                                                                        ],
                                                                                            [   
                                                                                                'item_code' => $itemCode,
                                                                                                'branch_item' => Auth::User()->oauth_accurate_company,
                                                                                                'referenceID' => $item->id,
                                                                                                'origin' => $request->get('Reqorigin'),
                                                                                                'destination' => $request->get('Reqdestination'),
                                                                                                'usersid' => Auth::User()->id,
                                                                                                'batch_itemCustomer' => $collectdata,
                                                                                                'ship_category' => $request->get('Reqshipment_category'),
                                                                                                'itemovdesc' => $item->itemovdesc,
                                                                                                'unit' => $request->get('Requnit'),
                                                                                                'sub_service_id' => $request->get('Reqsubservice'),
                                                                                                'moda' => $request->get('Reqmoda'),
                                                                                                // 'price' => $request->get('Reqprice'),
                                                                                                'price' => (Int)  $request->get('Reqprice') === null ? $request->get('RatePertama') : $request->get('Reqprice'),
                                                                                                'customer_id' => $project,
                                                                                                'itemID_accurate' => $itemCode,
                                                                                            ]
                                                                                    );
                            
                                                                                    // echo json_encode(
                                                                                    //     array('status_SyncAccurate'=> "true"),
                                                                                    //     JSON_PRETTY_PRINT
                                                                                    // );

                                                                                    // dd("bug 3");
                    
                                                                            }

                                                                // #method customer contract done 0
                                                                echo json_encode(
                                                                        array('status_SyncAccurate'=> "true",
                                                                                'fullfield'=> "queue done sadasda dddddd"),
                                                                        JSON_PRETTY_PRINT
                                                                );
                                                        }

                                                //cek jika ada sama, kemudian melakukan pengecekan apakah didalam terdapat customer kontrak/publish.[ customer kontrak != null ]
                                            }
                                                    else 
                                                            {

                                                                /**
                                                                 * #progress add item customer kontrak
                                                                 * Hit this add item customers
                                                                 */
                                                                $item = MasterItemTransportX::where([
                                                                        'customer_id' => $project,
                                                                        'itemovdesc' => $request->get('Reqitemovdesc')
                                                                        ]
                                                                    )
                                                                ->first();

                                                            $itemCustomers = Customer_item_transports::UpdateOrInserted(
                                                                [
                                                                    'itemovdesc' => $request->get('Reqitemovdesc')
                                                                ],
                                                                    [   
                                                                        'item_code' => $item->itemID_accurate,
                                                                        'referenceID' => $item->id,
                                                                        'origin' => $request->get('Reqorigin'),
                                                                        'branch_item' => Auth::User()->oauth_accurate_company,
                                                                        'destination' => $request->get('Reqdestination'),
                                                                        'usersid' => Auth::User()->id,
                                                                        'ship_category' => $request->get('Reqshipment_category'),
                                                                        'itemovdesc' => $item->itemovdesc,
                                                                        'unit' => $request->get('Requnit'),
                                                                        'sub_service_id' => $request->get('Reqsubservice'),
                                                                        'moda' => $request->get('Reqmoda'),
                                                                        'batch_itemCustomer' => $collectdata,
                                                                        // 'price' => $request->get('Reqprice'),
                                                                        'price' => (Int)  $request->get('Reqprice') === null ? $request->get('RatePertama') : $request->get('Reqprice'),
                                                                        'customer_id' => $project,
                                                                        'itemID_accurate' => $item->itemID_accurate,
                                                                    ]
                                                            );
                                                                // $itemTransports = Customer_item_transports::findOrFail($fetchMasterItemID->id);
                                                                //             $itemTransports->item_code = self::generateID();
                                                                //             $itemTransports->customer_id = $project;
                                                                //             $itemTransports->referenceID = $fetchMasterItemID->id;
                                                                //             $itemTransports->sub_service_id = $request->get('Reqsubservice');
                                                                //             $itemTransports->itemovdesc = $request->get('Reqitemovdesc');
                                                                //             $itemTransports->ship_category = $request->get('Reqshipment_category');
                                                                //             $itemTransports->moda = $request->get('Reqmoda');
                                                                //             $itemTransports->usersid = Auth::User()->id;
                                                                //             $itemTransports->origin = $request->get('Reqorigin');
                                                                //             $itemTransports->destination = $request->get('Reqdestination');
                                                                //             $itemTransports->price = $request->get('Reqprice');
                                                                //             $itemTransports->unit = $request->get('Requnit');
                                                                //             $itemTransports->batch_itemCustomer = $collectdata;
                                                                //         $itemTransports->itemID_accurate = $fetchMasterItemID->itemID_accurate;
                                                                //     $itemTransports->save();

                                                                //     $itemID_accurate = $fetchMasterItemID->itemID_accurate;
                                                                //     $harga = $request->get('Reqprice');
                                                                //     $name = $request->get('Reqitemovdesc');

                                                                //     $barangJasa__ = new Promise(
                                                                //         function () use (&$barangJasa__, &$itemID_accurate, &$dataminimum, &$harga, &$name) {
                                                                //             $barangJasa__->resolve($this->UpdateSyncBarangJasaCustomer($itemID_accurate, $dataminimum, $harga, $name));
                                            
                                                                //         },
                                                                //         function ($ex) {
                                                                //             $barangJasa__->reject($ex);
                                                                //         }
                                                                //     );
                                                                    
                                                                // $barangJasa__->wait()->original["d"][0];
                                                                $itemCode = $item->itemID_accurate;

                                                                  $barangJasa__ = new Promise(
                                                                                function () use (&$barangJasa__, &$itemCode, &$dataminimum, &$harga, &$name) {
                                                                                    $barangJasa__->resolve($this->UpdateSyncBarangJasaCustomer($itemCode, $dataminimum, $harga, $name));
                                                    
                                                                                },
                                                                                function ($ex) {
                                                                                    $barangJasa__->reject($ex);
                                                                                }
                                                                            );
                                                                                        
                                                                    $promise = $barangJasa__->wait()->original;
                                                                    
                                                                    // $promised = isset($promise) ? $promise : false;
                                                                    // dd($promise);    
                                                                // die;
                    
                                                            if($promise["s"] == false){

                                                                    $getCloudAccurate = $this->openModulesAccurateCloud
                                                                        ->FuncOpenmoduleAccurateCloudSaveItemBarangjasa__(
                                                                            $request->get('Reqitemovdesc'),
                                                                            $this->service, 
                                                                            $this->date,
                                                                            $itemCustomers->itemID_accurate,
                                                                            $request->get('Requnit')
                                                                        )
                                                                    ;
                                                                            
                                                                    $callback_response = $getCloudAccurate->getData("+");

                                                                        $check_process = isset($callback_response) ? $callback_response : false;
                        
                                                                            if(empty($check_process)){
                        
                                                                                    echo json_encode(
                                                                                        array('status_SyncAccurate'=> "false"),
                                                                                        JSON_PRETTY_PRINT
                                                                                    );
                        
                                                                                echo json_encode(
                                                                                    array('data_internal'=> "maaf ada data yang tidak sinkron dengan accurate."),
                                                                                    JSON_PRETTY_PRINT
                                                                                );
                                                                            
                                                                            } 
                                                                                else {
                        
                                                                                    $item = MasterItemTransportX::UpdateOrInserted(
                                                                                        [
                                                                                            'itemovdesc' => $request->get('Reqitemovdesc')
                                                                                        ],
                                                                                            [
                                                                                                'item_code' => $itemCode,
                                                                                                'origin' => $request->get('Reqorigin'),
                                                                                                'destination' => $request->get('Reqdestination'),
                                                                                                'userid' => Auth::User()->id,
                                                                                                'ship_category' => $request->get('Reqshipment_category'),
                                                                                                'itemovdesc' => $request->get('Reqitemovdesc'),
                                                                                                'unit' => $request->get('Requnit'),
                                                                                                'sub_service_id' => $request->get('Reqsubservice'),
                                                                                                'moda' => $request->get('Reqmoda'),
                                                                                                'customer_id' => $project,
                                                                                                'itemID_accurate' => $itemCode,
                                                                                                'itemIDaccurate' => $check_process["r"]["id"],
                                                                                                'flag'   => 342
                                                                                            ]
                                                                                    );

                                                                                    // dd("bug 4");
                                                                            }

                                                                } 

                                                                echo json_encode(
                                                            array('status_SyncAccurate'=> "true",
                                                                    'fullfield' => "queue done sdasdad"),
                                                            JSON_PRETTY_PRINT
                                                        );
                                                  }
                                            }
                                    // }

                            //by default: secara sistem akan melakukan pengecekkan data yanb diterima oleh client apakah ada atau tidak[ ada ].
                            } 
                                else 
                                        {
                                            $project = ($request->get('Reqcustomer')=="null")
                                            ? NULL 
                                            : $request->get('Reqcustomer');
                                            
                                            $sixdigit = Crypt::encryptString( $this->codes->generate_uuid() );
                                            $master_code = strtoupper(trim(substr($sixdigit, strlen($sixdigit) - 6, strlen($sixdigit)),'=').'-'.Str::random(6));
                                            // $getCloudAccurate = $this->openModulesAccurateCloud
                                            //     ->FuncOpenmoduleAccurateCloudSaveItemBarangjasa__(
                                            //         $request->get('Reqitemovdesc'),
                                            //         $this->service, 
                                            //         $this->date,
                                            //         $master_code,
                                            //         $request->get('Requnit')
                                            //     )
                                            // ;

                                            // $checkIfDataSame = isset($getCloudAccurate->original) ? $getCloudAccurate->original : false;
                                            
                                            // if($checkIfDataSame == false){

                                            //     echo json_encode(
                                            //         array('status_SyncAccurate'=> "false"),
                                            //         JSON_PRETTY_PRINT
                                            //     );

                                            //     echo json_encode(
                                            //         array('data_internal'=> "maaf ada data yang tidak sinkron dengan accurate."),
                                            //         JSON_PRETTY_PRINT
                                            //     );
                                
                                            // } 
                                            //     else {
                                                    $fetchMasterItemID = Customer_item_transports::where([
                                                            'customer_id' => $project,
                                                            'branch_item' => Auth::User()->oauth_accurate_company,
                                                            'sub_service_id' => $request->get('Reqsubservice'),
                                                            'ship_category' => $request->get('Reqshipment_category'),
                                                            'moda' => $request->get('Reqmoda'),
                                                            'origin' => $request->get('Reqorigin'),
                                                            'unit' => $request->get('Requnit'),
                                                            'destination' => $request->get('Reqdestination'),
                                                            'itemovdesc' => $request->get('Reqitemovdesc')
                                                    ])->first();

                                                    if(is_null($fetchMasterItemID)){

                                                        $fetchMasterItemID = Customer_item_transports::where([
                                                                'customer_id' => NULL,
                                                                'branch_item' => Auth::User()->oauth_accurate_company,
                                                                'sub_service_id' => $request->get('Reqsubservice'),
                                                                'ship_category' => $request->get('Reqshipment_category'),
                                                                'moda' => $request->get('Reqmoda'),
                                                                'origin' => $request->get('Reqorigin'),
                                                                'unit' => $request->get('Requnit'),
                                                                'destination' => $request->get('Reqdestination'),
                                                                'itemovdesc' => $request->get('Reqitemovdesc')
                                                        ])->first();

                                                    } 
                                                    // /**
                                                    //  * Func jika ada data yang sama setiap field, set fill attribute indexs yang saling berhubungan. 
                                                    //  * 
                                                    //  */
                                                    //     $fetchMasterItemID = MasterItemTransportX::
                                                    //         when($request->has('Reqitemovdesc') && $request->has('Reqsubservice') && $request->has('Reqorigin') && $request->has('Reqdestination') && $request->has('Reqshipment_category') && $request->has('Reqmoda') && $request->has('Requnit'), function ($que) use ($request){
                                                    //             return $que->where('sub_service_id','=',$request->get('Reqsubservice'))
                                                    //                         ->where('origin', '=',$request->get('Reqorigin'))
                                                    //                         ->where('ship_category', '=',$request->get('Reqshipment_category'))
                                                    //                         ->where('moda', '=',$request->get('Reqmoda'))
                                                    //                         ->where('unit', '=',$request->get('Requnit'))
                                                    //                         ->where('itemovdesc', '=',$request->get('Reqitemovdesc'))
                                                    //                         ->where('destination','=', $request->get('Reqdestination')); 
                                                    //             }   
                                                    //         )
                                                    //     ->first()
                                                    // ;
                                                            
                                                    // $data = MasterItemTransportX::whereIn('customer_id', function($query) use ($contract){
                                                    //     $query->whereIn('customer_id', $contract );
                                                    // })->get();
                                                    //cek jika ada sama, kemudian melakukan pengecekan apakah didalam terdapat customer kontrak/publish. [null]
                                                    if(is_null($fetchMasterItemID)){
                                                        //cek request, kemudian melakukan pengecekan apakah request customer null / tidak [ request customer == null]
                                                        if(is_null($project)){
                                                            // $masteritemidfetch = Customer_item_transports::where([
                                                            //     'customer_id' => NULL,
                                                            //     'itemovdesc' => $request->get('Reqitemovdesc')
                                                            //      ])->first();
                                                            //      dd($masteritemidfetch);die;
                                                                    // $itemTransports = Customer_item_transports::UpdateOrInserted($masteritemidfetch->id);
                                                                    //     // $itemTransports->item_code = self::generateID();
                                                                    //         $itemTransports->customer_id = $project;
                                                                    //         $itemTransports->referenceID = $masteritemidfetch->id;
                                                                    //         $itemTransports->sub_service_id = $request->get('Reqsubservice');
                                                                    //         $itemTransports->itemovdesc = $request->get('Reqitemovdesc');
                                                                    //         $itemTransports->ship_category = $request->get('Reqshipment_category');
                                                                    //         $itemTransports->moda = $request->get('Reqmoda');
                                                                    //         $itemTransports->usersid = Auth::User()->id;
                                                                    //         $itemTransports->origin = $request->get('Reqorigin');
                                                                    //         $itemTransports->destination = $request->get('Reqdestination');
                                                                    //         $itemTransports->price = $request->get('Reqprice');
                                                                    //         $itemTransports->unit = $request->get('Requnit');
                                                                    //         $itemTransports->batch_itemCustomer = $collectdata;
                                                                    //     $itemTransports->itemID_accurate = $masteritemidfetch->itemID_accurate;
                                                                    // $itemTransports->save();
                                                                    // $cs_fetchs = Customer_item_transports::UpdateOrInserted(
                                                                    // [
                                                                    //     'itemovdesc' => $request->get('Reqitemovdesc')
                                                                    // ],
                                                                    //     [
                                                                    //         'item_code' => $master_code,
                                                                    //         'referenceID' => $masteritemidfetch->id,
                                                                    //         'origin' => $request->get('Reqorigin'),
                                                                    //         'destination' => $request->get('Reqdestination'),
                                                                    //         'usersid' => Auth::User()->id,
                                                                    //         'ship_category' => $request->get('Reqshipment_category'),
                                                                    //         'itemovdesc' => $masteritemidfetch->itemovdesc,
                                                                    //         'unit' => $request->get('Requnit'),
                                                                    //         'sub_service_id' => $request->get('Reqsubservice'),
                                                                    //         'moda' => $request->get('Reqmoda'),
                                                                    //         'customer_id' => $project,
                                                                    //         'itemID_accurate' => $master_code,
                                                                    //         'flag'   => 0
                                                                    //     ]
                                                                    // );

                                                                    // $itemID_accurate = $cs_fetchs->itemID_accurate;
                                                                    // $harga = $request->get('Reqprice');
                                                                    // $name = $request->get('Reqitemovdesc');

                                                                    // $barangJasa__ = new Promise(
                                                                    //     function () use (&$barangJasa__, &$itemID_accurate, &$dataminimum, &$harga, &$name) {
                                                                    //         $barangJasa__->resolve($this->UpdateSyncBarangJasaCustomer($itemID_accurate, $dataminimum, $harga, $name));
                                            
                                                                    //     },
                                                                    //     function ($ex) {
                                                                    //         $barangJasa__->reject($ex);
                                                                    //     }
                                                                    // );
                                                                    
                                                                    // $barangJasa__->wait()->original["d"][0];
                                                                    $item = MasterItemTransportX::UpdateOrInserted(
                                                                        [
                                                                            'itemovdesc' => $request->get('Reqitemovdesc')
                                                                        ],
                                                                            [
                                                                                'item_code' => $master_code,
                                                                                'origin' => $request->get('Reqorigin'),
                                                                                'destination' => $request->get('Reqdestination'),
                                                                                'userid' => Auth::User()->id,
                                                                                'ship_category' => $request->get('Reqshipment_category'),
                                                                                'itemovdesc' => $request->get('Reqitemovdesc'),
                                                                                'unit' => $request->get('Requnit'),
                                                                                'sub_service_id' => $request->get('Reqsubservice'),
                                                                                'moda' => $request->get('Reqmoda'),
                                                                                'customer_id' => $project,
                                                                                'itemID_accurate' => $master_code,
                                                                                'flag'   => 2
                                                                            ]
                                                                    );
                    
                                                                $itemCode = $item->itemID_accurate;
                    
                                                                $barangJasa__ = new Promise(
                                                                                function () use (&$barangJasa__, &$itemCode, &$dataminimum, &$harga, &$name) {
                                                                                    $barangJasa__->resolve($this->UpdateSyncBarangJasaCustomer($itemCode, $dataminimum, $harga, $name));
                                                    
                                                                                },
                                                                                function ($ex) {
                                                                                    $barangJasa__->reject($ex);
                                                                                }
                                                                            );
                                                                                        
                                                                    $promise = $barangJasa__->wait()->original;
                                                                    
                                                                    // $promised = isset($promise) ? $promise : false;
                                                                    // dd($promise);    
                                                                // die;
                    
                                                                if($promise["s"] == false){
                    
                                                                        $getCloudAccurate = $this->openModulesAccurateCloud
                                                                            ->FuncOpenmoduleAccurateCloudSaveItemBarangjasa__(
                                                                                $request->get('Reqitemovdesc'),
                                                                                $this->service,
                                                                                $this->date,
                                                                                $itemCode,
                                                                                $request->get('Requnit')
                                                                            )
                                                                        ;
                    
                                                                        $callback_response = $getCloudAccurate->getData("+");
                                                                                // dd("1",$callback_response);
                                                                          $promised = isset($callback_response) ? $callback_response : false;
                    
                                                                        //   $itemTransports = New Customer_item_transports();
                                                                        //   $itemTransports->item_code = $callback_response;
                                                                        //   $itemTransports->customer_id = $project;
                                                                        //   $itemTransports->referenceID = $item->id;
                                                                        //   $itemTransports->sub_service_id = $item->sub_service_id;
                                                                        //   $itemTransports->itemovdesc = $item->itemovdesc;
                                                                        //   $itemTransports->ship_category = $item->ship_category;
                                                                        //   $itemTransports->moda = $item->moda;
                                                                        //   $itemTransports->usersid = $item->userid;
                                                                        //   $itemTransports->origin = $item->origin;
                                                                        //   $itemTransports->destination = $item->destination;
                                                                        //   $itemTransports->price = $item->price;
                                                                        //   $itemTransports->unit = $item->unit;
                                                                        //   $itemTransports->batch_itemCustomer = $collectdata;
                                                                        //   $itemTransports->itemID_accurate = $callback_response;
                                                                        //   $itemTransports->save();
                                                                        $cs_fetchs = Customer_item_transports::insert(
                                                                            [   
                                                                                'item_code' => $itemCode,
                                                                                'branch_item' => Auth::User()->oauth_accurate_company,
                                                                                'referenceID' => $item->id,
                                                                                'origin' => $request->get('Reqorigin'),
                                                                                'destination' => $request->get('Reqdestination'),
                                                                                'usersid' => Auth::User()->id,
                                                                                'ship_category' => $request->get('Reqshipment_category'),
                                                                                'itemovdesc' => $item->itemovdesc,
                                                                                'unit' => $request->get('Requnit'),
                                                                                'batch_itemCustomer' => $collectdata,
                                                                                'sub_service_id' => $request->get('Reqsubservice'),
                                                                                'moda' => $request->get('Reqmoda'),
                                                                                'customer_id' => $project,
                                                                                // 'price' => $request->get('Reqprice'),
                                                                                'price' => (Int)  $request->get('Reqprice') === null ? $request->get('RatePertama') : $request->get('Reqprice'),
                                                                                'itemID_accurate' => $itemCode,
                                                                                'flag'   => 43,
                                                                                'created_at'   => Carbon::Now()
                                                                            ]
                                                                        );
                                                                        //   echo json_encode(
                                                                        //     array('status_SyncAccurate'=> "true"),
                                                                        //     JSON_PRETTY_PRINT
                                                                        // );
                                                                                // echo json_encode(
                                                                                //     array('status_SyncAccurate'=> "true"),
                                                                                //     JSON_PRETTY_PRINT
                                                                                // );
                    
                                                                            // echo json_encode(
                                                                            //     array('data_internal'=> "maaf ada data yang tidak sinkron dengan accurate."),
                                                                            //     JSON_PRETTY_PRINT
                                                                            // );
                                                                        
                                                                        } 
                                                                            else {

                                                                                $item = Customer_item_transports::UpdateOrInserted(
                                                                                    [
                                                                                        'itemovdesc' => $request->get('Reqitemovdesc')
                                                                                    ],
                                                                                        [
                                                                                            'item_code' => $master_code,
                                                                                            'referenceID' => $item->id,
                                                                                            'branch_item' => Auth::User()->oauth_accurate_company,
                                                                                            'origin' => $request->get('Reqorigin'),
                                                                                            'destination' => $request->get('Reqdestination'),
                                                                                            'usersid' => Auth::User()->id,
                                                                                            'ship_category' => $request->get('Reqshipment_category'),
                                                                                            'itemovdesc' => $request->get('Reqitemovdesc'),
                                                                                            'unit' => $request->get('Requnit'),
                                                                                            'sub_service_id' => $request->get('Reqsubservice'),
                                                                                            'moda' => $request->get('Reqmoda'),
                                                                                            'batch_itemCustomer' => $collectdata,
                                                                                            // 'price' => $request->get('Reqprice'),
                                                                                            'price' => (Int)  $request->get('Reqprice') === null ? $request->get('RatePertama') : $request->get('Reqprice'),
                                                                                            'customer_id' => $project,
                                                                                            'itemID_accurate' => $master_code,
                                                                                            'flag'   => 2242,
                                                                                            'created_at' => Carbon::Now()
                                                                                        ]
                                                                                );

                                                                                // $itemTransports = New Customer_item_transports();
                                                                                //     $itemTransports->item_code = $itemCode;
                                                                                //     $itemTransports->customer_id = $project;
                                                                                //     $itemTransports->referenceID = $item->id;
                                                                                //     $itemTransports->sub_service_id = $item->sub_service_id;
                                                                                //     $itemTransports->itemovdesc = $item->itemovdesc;
                                                                                //     $itemTransports->ship_category = $item->ship_category;
                                                                                //     $itemTransports->moda = $item->moda;
                                                                                //     $itemTransports->usersid = $item->userid;
                                                                                //     $itemTransports->origin = $item->origin;
                                                                                //     $itemTransports->destination = $item->destination;
                                                                                //     $itemTransports->price = $request->get('Reqprice');
                                                                                //     $itemTransports->unit = $item->unit;
                                                                                //     $itemTransports->batch_itemCustomer = $collectdata;
                                                                                //     $itemTransports->itemID_accurate = $itemCode;
                                                                                // $itemTransports->save();
                    
                                                                                    $barangJasa__ = new Promise(
                                                                                            function () use (&$barangJasa__, &$itemCode, &$dataminimum, &$harga, &$name) {
                                                                                                $barangJasa__->resolve($this->UpdateSyncBarangJasaCustomer($itemCode, $dataminimum, $harga, $name));
                                                                
                                                                                            },
                                                                                            function ($ex) {
                                                                                                $barangJasa__->reject($ex);
                                                                                            }
                                                                                        );
                                                                                                    
                                                                                $data = $barangJasa__->wait()->original;

                                                                                if($data["s"] == false){
                                                                                    $getCloudAccurate = $this->openModulesAccurateCloud
                                                                                    ->FuncOpenmoduleAccurateCloudSaveItemBarangjasa__(
                                                                                        $request->get('Reqitemovdesc'),
                                                                                        $this->service,
                                                                                        $this->date,
                                                                                        $itemCode,
                                                                                        $request->get('Requnit')
                                                                                    )
                                                                                ;

                                                                                $callback_response = $getCloudAccurate->getData("+");
                                                                                // dd("2",$callback_response);
                    
                                                                                $itemCD = isset($callback_response) ? $callback_response["r"]["no"] : false;
                                                                                // echo json_encode(
                                                                                //     array('status_SyncAccurate'=> "true"),
                                                                                //     JSON_PRETTY_PRINT
                                                                                // );
                                                                                // MasterItemTransportX::UpdateOrInserted(
                                                                                //         [
                                                                                //             'itemovdesc' => $request->get('Reqitemovdesc')
                                                                                //         ],
                                                                                //             [
                                                                                //                 'item_code' => $itemCD,
                                                                                //                 'origin' => $request->get('Reqorigin'),
                                                                                //                 'destination' => $request->get('Reqdestination'),
                                                                                //                 'userid' => Auth::User()->id,
                                                                                //                 'ship_category' => $request->get('Reqshipment_category'),
                                                                                //                 'itemovdesc' => $request->get('Reqitemovdesc'),
                                                                                //                 'unit' => $request->get('Requnit'),
                                                                                //                 'sub_service_id' => $request->get('Reqsubservice'),
                                                                                //                 'moda' => $request->get('Reqmoda'),
                                                                                //                 'customer_id' => $project,
                                                                                //                 'itemID_accurate' => $itemCD,
                                                                                //                 'flag'   => 0
                                                                                //             ]
                                                                                //     );
                                                                                    // echo json_encode(
                                                                                    //     array('status_SyncAccurate'=> "true"),
                                                                                    //     JSON_PRETTY_PRINT
                                                                                    // );

                                                                                } 
                                                                                    else {

                                                                                        $barangJasa__ = new Promise(
                                                                                            function () use (&$barangJasa__, &$itemCode, &$dataminimum, &$harga, &$name) {
                                                                                                $barangJasa__->resolve($this->UpdateSyncBarangJasaCustomer($itemCode, $dataminimum, $harga, $name));
                                                                
                                                                                            },
                                                                                            function ($ex) {
                                                                                                $barangJasa__->reject($ex);
                                                                                            }
                                                                                        );

                                                                                        // echo json_encode(
                                                                                        //     array('status_SyncAccurate'=> "true"),
                                                                                        //     JSON_PRETTY_PRINT
                                                                                        // );
                                                                                }
                    
                                                                                    //     $barangJasa__ = new Promise(
                                                                                    //         function () use (&$barangJasa__, &$check_process, &$dataminimum, &$harga, &$name) {
                                                                                    //             $barangJasa__->resolve($this->UpdateSyncBarangJasaCustomer($check_process, $dataminimum, $harga, $name));
                                                                
                                                                                    //         },
                                                                                    //         function ($ex) {
                                                                                    //             $barangJasa__->reject($ex);
                                                                                    //         }
                                                                                    //     );
                                                                                        
                                                                                    // $promise = $barangJasa__->wait()->original["d"][0];
                    
                                                                                        // $item = MasterItemTransportX::UpdateOrInserted(
                                                                                        //     [
                                                                                        //         'item_code' => $check_process,
                                                                                        //         'origin' => $request->get('Reqorigin'),
                                                                                        //         'destination' => $request->get('Reqdestination'),
                                                                                        //         'userid' => Auth::User()->id,
                                                                                        //         'ship_category' => $request->get('Reqshipment_category'),
                                                                                        //         'itemovdesc' => $request->get('Reqitemovdesc'),
                                                                                        //         'unit' => $request->get('Requnit'),
                                                                                        //         'sub_service_id' => $request->get('Reqsubservice'),
                                                                                        //         'moda' => $request->get('Reqmoda'),
                                                                                        //         'customer_id' => $project,
                                                                                        //         'itemID_accurate' => $check_process,
                                                                                        //         'flag'   => 0
                                                                                        //     ]
                                                                                        // );
                    
                                                                                        // $item = MasterItemTransportX::UpdateOrInserted(
                                                                                        //     [
                                                                                        //         'itemovdesc' => $request->get('Reqitemovdesc')
                                                                                        // ],
                                                                                        //         [
                                                                                        //             'item_code' => $check_process,
                                                                                        //             'origin' => $request->get('Reqorigin'),
                                                                                        //             'destination' => $request->get('Reqdestination'),
                                                                                        //             'userid' => Auth::User()->id,
                                                                                        //             'ship_category' => $request->get('Reqshipment_category'),
                                                                                        //             'itemovdesc' => $request->get('Reqitemovdesc'),
                                                                                        //             'unit' => $request->get('Requnit'),
                                                                                        //             'sub_service_id' => $request->get('Reqsubservice'),
                                                                                        //             'moda' => $request->get('Reqmoda'),
                                                                                        //             'customer_id' => $project,
                                                                                        //             'itemID_accurate' => $check_process,
                                                                                        //             'flag'   => 0
                                                                                        //         ]
                                                                                        // );
                                                                                    
                                                                                            // $item->save();
                                                                                    // dd($item);
                                                                                //     echo json_encode(
                                                                                //     array('status_SyncAccurate'=> "true"),
                                                                                //     JSON_PRETTY_PRINT
                                                                                // );

                                                                            echo json_encode(
                                                                                array('status_SyncAccurate'=> "true"),
                                                                                JSON_PRETTY_PRINT
                                                                            );

                                                                        }
                                                                // dd("bug 5");

                                                            //cek request, kemudian melakukan pengecekan apakah request customer null / tidak [ request customer != null]
                                                            }
                                                                else {

                                                                         /**
                                                                         * #progress add item customer kontrak
                                                                         * Hit this add item customers
                                                                         */
                                                                            $item = MasterItemTransportX::where([
                                                                                'customer_id' => $project,
                                                                                'itemovdesc' => $request->get('Reqitemovdesc')
                                                                                ]
                                                                            )
                                                                        ->first();

                                                                        $itemID_A = Customer_item_transports::UpdateOrInserted(
                                                                            [
                                                                                'itemovdesc' => $request->get('Reqitemovdesc')
                                                                            ],
                                                                                [   
                                                                                    'item_code' => $item->itemID_accurate,
                                                                                    'branch_item' => Auth::User()->oauth_accurate_company,
                                                                                    'referenceID' => $item->id,
                                                                                    'origin' => $request->get('Reqorigin'),
                                                                                    'destination' => $request->get('Reqdestination'),
                                                                                    'usersid' => Auth::User()->id,
                                                                                    'ship_category' => $request->get('Reqshipment_category'),
                                                                                    'itemovdesc' => $item->itemovdesc,
                                                                                    'unit' => $request->get('Requnit'),
                                                                                    'sub_service_id' => $request->get('Reqsubservice'),
                                                                                    'moda' => $request->get('Reqmoda'),
                                                                                    // 'price' => $request->get('Reqprice'),
                                                                                    'price' => (Int)  $request->get('Reqprice') === null ? $request->get('RatePertama') : $request->get('Reqprice'),
                                                                                    'customer_id' => $project,
                                                                                    'itemID_accurate' => $item->itemID_accurate,
                                                                                    'batch_itemCustomer' => $collectdata,

                                                                                ]
                                                                        );

                                                                        $itemID_accurate = $itemID_A->itemID_accurate;
                                                                        // $itemTransports = Customer_item_transports::findOrFail($fetchMasterItemID->id);
                                                                        //     // $itemTransports->item_code = self::generateID();
                                                                        //         $itemTransports->customer_id = $project;
                                                                        //         $itemTransports->referenceID = $fetchMasterItemID->id;
                                                                        //         $itemTransports->sub_service_id = $request->get('Reqsubservice');
                                                                        //         $itemTransports->itemovdesc = $request->get('Reqitemovdesc');
                                                                        //         $itemTransports->ship_category = $request->get('Reqshipment_category');
                                                                        //         $itemTransports->moda = $request->get('Reqmoda');
                                                                        //         $itemTransports->usersid = Auth::User()->id;
                                                                        //         $itemTransports->origin = $request->get('Reqorigin');
                                                                        //         $itemTransports->destination = $request->get('Reqdestination');
                                                                        //         $itemTransports->price = $request->get('Reqprice');
                                                                        //         $itemTransports->unit = $request->get('Requnit');
                                                                        //         $itemTransports->batch_itemCustomer = $collectdata;
                                                                        //     $itemTransports->itemID_accurate = $fetchMasterItemID->itemID_accurate;
                                                                        // $itemTransports->save();

                                                                        // $itemID_accurate = $fetchMasterItemID->itemID_accurate;
                                                                        // $harga = $request->get('Reqprice');
                                                                        // $name = $request->get('Reqitemovdesc');

                                                                        $barangJasa__ = new Promise(
                                                                            function () use (&$barangJasa__, &$itemID_accurate, &$dataminimum, &$harga, &$name) {
                                                                                $barangJasa__->resolve($this->UpdateSyncBarangJasaCustomer($itemID_accurate, $dataminimum, $harga, $name));
                                                
                                                                            },
                                                                            function ($ex) {
                                                                                $barangJasa__->reject($ex);
                                                                            }
                                                                        );
                                                                        
                                                                        $barangJasa__->wait()->original["d"][0];

                                                                    //#method publish
                                                                    echo json_encode(
                                                                        array('status_SyncAccurate'=> "true",
                                                                        'fullfield' => "queue done"),
                                                                    JSON_PRETTY_PRINT
                                                                );
                                                                // dd("bug 6");

                                                            }

                                                    //cek jika ada sama, kemudian melakukan pengecekan apakah didalam terdapat customer kontrak/publish. [fetchMasterItemID != null]                                                        
                                                    }
                                                        else 
                                                                {

                                                                    // $itemTransports = Customer_item_transports::findOrFail($fetchMasterItemID->id);
                                                                    //     // $itemTransports->item_code = self::generateID();
                                                                    //             $itemTransports->customer_id = $project;
                                                                    //             $itemTransports->referenceID = $fetchMasterItemID->id;
                                                                    //             $itemTransports->sub_service_id = $request->get('Reqsubservice');
                                                                    //             $itemTransports->itemovdesc = $request->get('Reqitemovdesc');
                                                                    //             $itemTransports->ship_category = $request->get('Reqshipment_category');
                                                                    //             $itemTransports->moda = $request->get('Reqmoda');
                                                                    //             $itemTransports->usersid = Auth::User()->id;
                                                                    //             $itemTransports->origin = $request->get('Reqorigin');
                                                                    //             $itemTransports->destination = $request->get('Reqdestination');
                                                                    //             $itemTransports->price = $request->get('Reqprice');
                                                                    //             $itemTransports->unit = $request->get('Requnit');
                                                                    //             $itemTransports->batch_itemCustomer = $collectdata;
                                                                    //         $itemTransports->itemID_accurate = $fetchMasterItemID->itemID_accurate;
                                                                    //     $itemTransports->save();

                                                                    //     $itemID_accurate = $fetchMasterItemID->itemID_accurate;
                                                                    $harga = $request->get('Reqprice');
                                                                    $name = $request->get('Reqitemovdesc');
                                                                    $item = MasterItemTransportX::where([
                                                                                'customer_id' => $project,
                                                                                'itemovdesc' => $name
                                                                        ]
                                                                    )->first();

                                                                    $itemCode = $item->itemID_accurate;

                                                                    //     $barangJasa__ = new Promise(
                                                                    //         function () use (&$barangJasa__, &$itemID_accurate, &$dataminimum, &$harga, &$name) {
                                                                    //             $barangJasa__->resolve($this->UpdateSyncBarangJasaCustomer($itemID_accurate, $dataminimum, $harga, $name));
                                                
                                                                    //         },
                                                                    //         function ($ex) {
                                                                    //             $barangJasa__->reject($ex);
                                                                    //         }
                                                                    //     );
                                                                        
                                                                    // $barangJasa__->wait()->original["d"][0];
                                                                    $barangJasa__ = new Promise(
                                                                        function () use (&$barangJasa__, &$master_code, &$dataminimum, &$harga, &$name) {
                                                                            $barangJasa__->resolve($this->UpdateSyncBarangJasaCustomer($master_code, $dataminimum, $harga, $name));
                                            
                                                                        },
                                                                        function ($ex) {
                                                                            $barangJasa__->reject($ex);
                                                                        }
                                                                    );
                                                                                
                                                                    $promise = $barangJasa__->wait()->original;
                                                                                                                                                
                                                                        if($promise["s"] == false){

                                                                                $getCloudAccurate = $this->openModulesAccurateCloud
                                                                                    ->FuncOpenmoduleAccurateCloudSaveItemBarangjasa__(
                                                                                        $request->get('Reqitemovdesc'),
                                                                                        $this->service, 
                                                                                        $this->date,
                                                                                        $itemCode,
                                                                                        $request->get('Requnit')
                                                                                    )
                                                                                ;
                                                                                        
                                                                    $callback_response = $getCloudAccurate->getData("+");

                                                                $check_process = isset($callback_response) ? $callback_response : false;

                                                                    if(empty($check_process)){

                                                                            $barangJasa__ = new Promise(
                                                                                function () use (&$barangJasa__, &$itemCode, &$dataminimum, &$harga, &$name) {
                                                                                    $barangJasa__->resolve($this->UpdateSyncBarangJasaCustomer($itemCode, $dataminimum, $harga, $name));
                                                    
                                                                                },
                                                                                function ($ex) {
                                                                                    $barangJasa__->reject($ex);
                                                                                }
                                                                            );
                                                                                        
                                                                    $barangJasa__->wait()->original;
                    
                                                                                echo json_encode(
                                                                                    array('status_SyncAccurate'=> "true"),
                                                                                    JSON_PRETTY_PRINT
                                                                                );
                    
                                                                            echo json_encode(
                                                                                array('data_internal'=> "data telah diupdate."),
                                                                                JSON_PRETTY_PRINT
                                                                            );
                                                                        
                                                                        } 
                                                                            else {

                                                                                if($check_process["s"] == false){
                                                                                    echo json_encode(
                                                                                        array('status_SyncAccurate' => 'false','status_failed_accurate'=> $callback_response["d"]),
                                                                                        JSON_PRETTY_PRINT
                                                                                    );

                                                                                } 
                                                                                    else {

                                                                                        MasterItemTransportX::UpdateOrInserted(
                                                                                            [
                                                                                                'itemovdesc' => $request->get('Reqitemovdesc')
                                                                                            ],
                                                                                                [
                                                                                                    'item_code' => $itemCode,
                                                                                                    'origin' => $request->get('Reqorigin'),
                                                                                                    'destination' => $request->get('Reqdestination'),
                                                                                                    'userid' => Auth::User()->id,
                                                                                                    'ship_category' => $request->get('Reqshipment_category'),
                                                                                                    'itemovdesc' => $request->get('Reqitemovdesc'),
                                                                                                    'unit' => $request->get('Requnit'),
                                                                                                    'sub_service_id' => $request->get('Reqsubservice'),
                                                                                                    'moda' => $request->get('Reqmoda'),
                                                                                                    'customer_id' => $project,
                                                                                                    'itemIDaccurate' => $check_process["r"]["id"],
                                                                                                    'itemID_accurate' => $itemCode,
                                                                                                ]
                                                                                        );

                                                                                }
                                                                            }   
                                                                        } 

                                                               echo json_encode(
                                                                array('status_SyncAccurate'=> "true",
                                                                    'fullfield' => "queue done"),
                                                                JSON_PRETTY_PRINT
                                                            );
                                                            // dd("bug 7");
                                                    }
                                            // }
                                     }
                                }
                            )
                    ;
            }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function savedTransports(RequestTransportOrdersValidation $rest, Transport_orders $transports, Jobs_transaction_detail $jtd, $branch_id)
    {
        $datajc = implode(",",(array) $this->posts->input('itemID'));
        $idToArray = explode(",",$datajc);

        $qtyid = implode(",",(array) $this->posts->input('qtyID'));
        $qtyarrid = explode(",",$qtyid);

        $priceid = implode(",",(array) $this->posts->input('priceID'));
        $pricearrid = explode(",",$priceid);

        $detailnoteID = $this->posts->input('detailNotesID');

        $itemDiscount = $this->posts->input('itemDiscount');
        // dd($idToArray, $qtyarrid, $pricearrid);
        foreach($idToArray as $key=>$value) {
            
            $tempArray[] = $value;
 
        }
         
        $idToArray = $tempArray;

        foreach($qtyarrid as $key=>$value) {
            
            $qtyTEMP[] = $value;
 
        }
         
        $qtyarrid = $qtyTEMP;

        foreach($pricearrid as $key=>$value) {
            
            $priceTMP[] = $value;
 
        }
         
        $pricearrid = $priceTMP;

        // $datacollect = collect([$idToArray, $qtyarrid, $pricearrid, $detailnote]);dd($datacollect);die;
        $datacollect = collect([
                                    'itemID'=>$idToArray, 
                                    'quantity' => $qtyarrid, 
                                    'priceID' => $pricearrid, 
                                    'detailnotes' => $detailnoteID,
                                    'itemDiscount' => $itemDiscount
                                ]
                            )
                        ;
        // dd($datacollect);die;

        // dd($this->posts->input('itemID'),$this->posts->input('qtyID'),$this->posts->input('priceID'));die;
        $messages = [
            'required' => ':attribute Tidak boleh kosong'
        ];
        
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
        // customers
        $fetch_customer_id = $this->posts->input('customers');
        $regions_Id = $this->posts->input('regionName');
        $id_project = $this->posts->input('id_project');

        // origin
        $saved_origin = $this->posts->input('saved_origin');
        $origin = $this->posts->input('origin');
        $origin_city = $this->posts->input('origin_city');
        $origin_address = $this->posts->input('origin_address');
        $pic_phone_origin = $this->posts->input('pic_phone_origin');
        $pic_name_origin = $this->posts->input('pic_name_origin');
        $id_origin_city = $this->posts->input('id_origin_city');

        // destination
        $saved_destination = $this->posts->input('saved_destination');
        $destination = $this->posts->input('destination');
        $destination_city = $this->posts->input('destination_city');
        $destination_address = $this->posts->input('destination_address');
        $pic_phone_destination = $this->posts->input('pic_phone_destination');
        $pic_name_destination = $this->posts->input('pic_name_destination');
        $id_destination_city = $this->posts->input('id_destination_city');

         // detail order
         $sub_servicess = $this->posts->input('sub_servicess');
         $items_tc = $this->posts->input('items_tc');
         $qty = $this->posts->input('qty');
         $harga = $this->posts->input('harga');
         $total_rate = $this->posts->input('total_rate');
         $eta = $this->posts->input('eta');
         $etd = $this->posts->input('etd');
         $time_zone = $this->posts->input('time_zone');

         $collie = $this->posts->input('collie');
         $volume = $this->posts->input('volume');
         $actual_weight = $this->posts->input('actual_weight');
         $chargeable_weight = $this->posts->input('chargeable_weight');
         $notes = $this->posts->input('notes');

        $dataAsyncTransports = [

            // customer
            'customer_id' => $fetch_customer_id,
            'region_index' => $regions_Id,
            'id_project' => $id_project,

            // origin
            'saved_origin' => $saved_origin,
            'origin' => $origin,
            'origin_city' => $origin_city,
            'origin_address' => $origin_address,
            'pic_phone_origin' => $pic_phone_origin,
            'pic_name_origin' => $pic_name_origin,
            'id_origin_city' => $id_origin_city,

             // destination
             'saved_destination' => $saved_destination,
             'destination' => $destination,
             'destination_city' => $destination_city,
             'destination_address' => $destination_address,
             'pic_phone_destination' => $pic_phone_destination,
             'pic_name_destination' => $pic_name_destination,
             'id_destination_city' => $id_destination_city,

              // detail order
              'sub_servicess' => $sub_servicess,
              'items_tc' => $items_tc,
              'qty' => $qty,
              'harga' => $harga,
              'total_rate' => $total_rate,
              'eta' => $eta,
              'etd' => $etd,
              'time_zone' => $time_zone,
              'collie' => $collie,
              'volume' => $volume,
              'actual_weight' => $actual_weight,
              'chargeable_weight' => $chargeable_weight,
              'notes' => $notes
        ];

        session(['regions'=>$dataAsyncTransports["region_index"]]);

        foreach($dataAsyncTransports as $key =>$flush_array) {
            
            $dataAsyncTransports[$key] = $flush_array;
           
        }

        $APIs = $this->APIntegration::callstaticfunction();

        foreach((array)$APIs as $key => $detected){

            $how_working[] = $detected;

        }
        
        $jsonArray = json_decode($APIs->getContent(), true);

        foreach((array)$jsonArray as $key => $indexing){

            $testing[$key] = $indexing;

        }

        // $getCloudAccurate = $this->openModulesAccurateCloud
        //     ->FuncOpenmoduleAccurateCloudSaveSalesOrders(
        //         $this->session,
        //         $api->input('customerNo'),
        //         $api->input('itemNo'),
        //         $this->datenow,
        //         $this->date
        // );


        /**
         * @param generator custome for clients
         * @method string
         * [ Auhtor ] @artexsdns@gmail.com
         * ------ GENERATED ID FIX ------
        */
        $id = $transports->select('id')->max('id');
        $jobs = $id+1;
        $jincrement_idx = $jobs;
        $YM = Carbon::Now()->format('ymd');

        if ($id==null) {
            $jobs_order_idx = (str_repeat("TO".$YM.'00', 2-strlen($jincrement_idx))). $jincrement_idx;
        }
        elseif ($id == 1){
                $jobs_order_idx = (str_repeat("TO".$YM.'00', 2-strlen($jincrement_idx))). $jincrement_idx;
        }
        elseif ($id > 1 && $id < 9 ){
            $jobs_order_idx = (str_repeat("TO".$YM.'00', 2-strlen($jincrement_idx))). $jincrement_idx;
        }
        elseif ($id == 9){
            $jobs_order_idx = (str_repeat("TO".$YM.'00', 3-strlen($jincrement_idx))). $jincrement_idx;
        }
        elseif ($id == 10) {
            $jobs_order_idx = (str_repeat("TO".$YM.'00', 3-strlen($jincrement_idx))). $jincrement_idx;
        }
        elseif ($id > 10 && $id < 99) {
            $jobs_order_idx = (str_repeat("TO".$YM.'00', 3-strlen($jincrement_idx))). $jincrement_idx;
        }
        elseif ($id == 99) {
            $jobs_order_idx = (str_repeat("TO".$YM.'00', 4-strlen($jincrement_idx))). $jincrement_idx;
        }
        elseif ($id == 100) {
            $jobs_order_idx = (str_repeat("TO".$YM.'00', 4-strlen($jincrement_idx))). $jincrement_idx;
        }
        elseif ($id > 100 && $id < 999) {
            $jobs_order_idx = (str_repeat("TO".$YM.'00', 4-strlen($jincrement_idx))). $jincrement_idx;
        }
        elseif ($id === 999) {
            $jobs_order_idx = (str_repeat("TO".$YM.'00', 5-strlen($jincrement_idx))). $jincrement_idx;
        }
        elseif ($id === 1000) {
            $jobs_order_idx = (str_repeat("TO".$YM.'00', 5-strlen($jincrement_idx))). $jincrement_idx;
        }
        elseif ($id > 1000 && $id < 9999) {
            $jobs_order_idx = (str_repeat("TO".$YM.'00', 5-strlen($jincrement_idx))). $jincrement_idx;
        }
        elseif ($id == 9999) {
            $jobs_order_idx = (str_repeat("TO".$YM.'00', 6-strlen($jincrement_idx))). $jincrement_idx;
        }
        elseif ($id == 10000) {
            $jobs_order_idx = (str_repeat("TO".$YM.'00', 6-strlen($jincrement_idx))). $jincrement_idx;
        }
        
        try {
       
            $customer_id = Customer::findOrFail($dataAsyncTransports['customer_id']);
            
            if ($dataAsyncTransports['saved_origin'] == null && $dataAsyncTransports['saved_destination'] == null) {
                # code...
                $origin_address = $this->origin_address->create([
                    'name' => $dataAsyncTransports['origin'],
                    'usersid' => Auth::User()->id,
                    'customer_id' => $dataAsyncTransports['customer_id'],
                    // 'details' => $request->origin_detail,
                    'details' => $dataAsyncTransports['origin'],
                    'city_id' => $dataAsyncTransports['id_origin_city'],
                    'address' => $dataAsyncTransports['origin_address'],
                    // 'contact' => $request->origin_contact,
                    'contact' => $dataAsyncTransports['pic_phone_origin'],
                    // 'phone' => $request->origin_phone,
                    'phone' => $dataAsyncTransports['pic_phone_origin'],
                    'pic_name_origin' => $dataAsyncTransports['pic_name_origin'],
                    'pic_phone_origin' => $dataAsyncTransports['pic_phone_origin']
                    ]
                );

                $origin_address_book_id = (int) $origin_address->id; //define save id for origin
                $origin_address_book_id_citys = (int) $origin_address->city_id; //define save id for origin city id

                $destination_address = $this->destination_address->create([
                    'name' => $dataAsyncTransports['destination'],
                    'usersid' => Auth::User()->id,
                    'customer_id' => $dataAsyncTransports['customer_id'],
                    // 'details' => $request->origin_detail,
                    'details' => $dataAsyncTransports['destination'],
                    'city_id' => $dataAsyncTransports['id_destination_city'],
                    'address' => $dataAsyncTransports['destination_address'],
                    // 'contact' => $request->origin_contact,
                    'contact' => $dataAsyncTransports['pic_phone_destination'],
                    // 'phone' => $request->origin_phone,
                    'phone' => $dataAsyncTransports['pic_phone_destination'],
                    'pic_name_destination' => $dataAsyncTransports['pic_name_destination'],
                    'pic_phone_destination' => $dataAsyncTransports['pic_phone_destination']
                    ]
                );

                $destination_address_book_id = (int) $destination_address->id; //define save id for destination
                $destination_address_book_id_citys = (int) $destination_address->city_id; //define save id for destination city id
                
                if ($testing[0]['check_is'] == "api_izzy") {

                    if($testing[0]['operation'] == "true"){
                        $fetch_name_city_origin = $this->cityO->findOrFail($origin_address_book_id_citys);

                        $fetch_name_city_destination = $this->cityD->findOrFail($destination_address_book_id_citys);

                        // unset($request['_method']);
                        // unset($request['_token']);
                        // $client = new Client();
                        $userWithToken = Customer::findOrFail($customer_id['customer_id']);

                        $client = new Client(['auth' => ['daniel-IT', '123abc']]);

                        $response = $client->post(
                                'http://your.api.vendor.com/customer/v1/shipment/new',
                                [
                                    'headers' => [
                                        'Content-Type' => 'application/x-www-form-urlencoded',
                                        'X-IzzyTransport-Token' => $userWithToken->userWithToken,
                                        'Accept' => 'application/json'
                                                    ],
                                                        'form_params' => [
                                                            'Sh[projectId]' => $userWithToken->project_id,
                                                            'Sh[vendorId]' => '8',
                                                            'Sh[poCodes]' => '',
                                                            'Sh[collie]' => $dataAsyncTransports['collie'],
                                                            'Sh[actualWeight]' => $dataAsyncTransports['actual_weight'],
                                                            'Sh[chargeableWeight]' => $dataAsyncTransports['chargeable_weight'],
                                                            'Sh[loadingType]' => 'Item Code',
                                                            'Sh[service]' => $dataAsyncTransports['sub_servicess'],
                                                            'Sh[etd]' => $dataAsyncTransports['etd'],
                                                            'Sh[eta]' => $dataAsyncTransports['eta'],
                                                            'Sh[timeZone]' => $dataAsyncTransports['time_zone'],
                                                            'Sh[notes]' => $dataAsyncTransports['notes'],
                                                            'Sh[origin]' => $fetch_name_city_origin->name,
                                                            // 'Sh[originCompany]' => $request->origin_detail,fetch_name_city_origin->name
                                                            'Sh[originCompany]' => $fetch_name_city_origin->name,
                                                            'Sh[originAddress]' => $dataAsyncTransports['origin_address'],
                                                            // 'Sh[originContact]' => $request->origin_contact,
                                                            'Sh[originContact]' => $dataAsyncTransports['pic_name_origin'],
                                                            // 'Sh[originPhone]' => $request->origin_phone,pic_phone_origin
                                                            'Sh[originPhone]' => $dataAsyncTransports['pic_phone_origin'],
                                                            'Sh[destination]' => $fetch_name_city_destination->name,
                                                            // 'Sh[destinationCompany]' => $request->destination_detail,
                                                            'Sh[destinationCompany]' => $fetch_name_city_destination->name,
                                                            'Sh[destinationAddress]' => $dataAsyncTransports['destination_address'],
                                                            // 'Sh[destinationContact]' => $request->destination_contact,
                                                            'Sh[destinationContact]' => $dataAsyncTransports['pic_name_destination'],
                                                            // 'Sh[destinationPhone]' => $request->destination_phone,
                                                            'Sh[destinationPhone]' => $dataAsyncTransports['pic_phone_destination'],
                                                            'Sh[region]' => $dataAsyncTransports["region_index"],
                                                        ]
                                                    ]
                                                );
                                
                                        $jsonArray = json_decode($response->getBody()->getContents(), true);

                                        $saved_order_transport = Transport_orders::create(
                                            [
                                            // 'customer_id' => $request->customers_name,
                                            // 'customer_id' => '1',
                                            'customer_id' => $dataAsyncTransports['customer_id'],
                                            'order_id' =>  $jsonArray['Shipment']['code'],
                                            // 'sub_service_id' => $request->test_sb_service,
                                            'company_branch_id' => $this->pull_branch->session()->get('id'),
                                            'purchase_order_customer' => '',
                                            'by_users' => Auth::User()->oauth_accurate_company,
                                            'item_transport' => $dataAsyncTransports['items_tc'],
                                            'saved_origin_id' => $origin_address_book_id,
                                            'status_order_id' => 1,
                                            'origin' => $dataAsyncTransports['origin'],
                                            // 'origin_details' => $request->origin_detail,
                                            'origin_details' => $dataAsyncTransports['origin'],
                                            'origin_address' => $dataAsyncTransports['origin_address'],
                                            // 'origin_contact' => $request->origin_contact,
                                            'origin_contact' => $dataAsyncTransports['pic_phone_origin'],
                                            // 'origin_phone' => $request->origin_phone,
                                            'origin_phone' => $dataAsyncTransports['pic_phone_origin'],
                                            'pic_name_origin' => $dataAsyncTransports['pic_name_origin'],
                                            'pic_phone_origin' => $dataAsyncTransports['pic_phone_origin'],

                                            'saved_destination_id' => $destination_address_book_id,
                                            'destination' => $dataAsyncTransports['destination'],
                                            // 'destination_details' => $request->destination_detail,
                                            'destination_details' => $dataAsyncTransports['destination'],
                                            // 'destination_contact' => $request->destination_contact,
                                            'destination_contact' => $dataAsyncTransports['pic_phone_destination'],
                                            'destination_address' => $dataAsyncTransports['destination_address'],
                                            // 'destination_phone' => $request->destination_phone,
                                            'destination_phone' => $dataAsyncTransports['pic_phone_destination'],
                                            'pic_name_destination' => $dataAsyncTransports['pic_name_destination'],
                                            'pic_phone_destination' => $dataAsyncTransports['pic_phone_destination'],
                                        
                                            'estimated_time_of_delivery' => $dataAsyncTransports['etd'],
                                            'estimated_time_of_arrival' => $dataAsyncTransports['eta'],
                                            'time_zone' => $dataAsyncTransports['time_zone'],
                                            'quantity' => $dataAsyncTransports['qty'],
                                            'harga' => (float) str_replace(',', '', $dataAsyncTransports['harga']),
                                            // 'harga' => $dataAsyncTransports['harga'],
                                            'collie' => $dataAsyncTransports['collie'],
                                            'volume' => $dataAsyncTransports['volume'],
                                            'actual_weight' => $dataAsyncTransports['actual_weight'],
                                            'chargeable_weight' => $dataAsyncTransports['chargeable_weight'],
                                            'notes' => $dataAsyncTransports['notes'],
                                            'batch_item' => $datacollect,
                                            'total_cost' => str_replace(".", "", $dataAsyncTransports['total_rate'])
                                        ]
                                    );

                                    $inserted = New TrackShipments();
                                    // $inserted->order_id = $jsonArray['Shipment']['code'];
                                    $inserted->order_id = $saved_order_transport->id;

                                    $inserted->status = 1;
                                    $inserted->datetime = Carbon::Now();
                                    $inserted->user_id = Auth::User()->id;
                                    $inserted->created_at = Carbon::Now();
                                    $inserted->updated_at = Carbon::Now();
                                    $inserted->save();
                                    
                                    foreach($idToArray as $index =>$arrvitemidx) {
                                        $data_orderxzc[] = [
                                            'transport_id' => $saved_order_transport->id,
                                            'cash_discount' => isset($itemDiscount[$index]) ? $itemDiscount[$index] : 0,
                                            'itemID' => $arrvitemidx,
                                            'qty' => $qtyarrid[$index],
                                            'harga' => $pricearrid[$index],
                                            'detailnotes' => $detailnoteID[$index]
                                        ];
                                }
                        
                                Batchs_transaction_item_customer::insert($data_orderxzc);
                                //     $fetch_data = $transports->whereIn('id', [$saved_order_transport->id])->with(['customers','itemtransports.masteritemtc'])->get();
                                      
                                //     foreach($fetch_data as $key => $thisDataTransports){
          
                                //         $dataARRXCUSTOMER[] = $thisDataTransports->customers->itemID_accurate; //item id accurate C.0000001
                                //         $dataARRXITEMTRANSPORT[] = $thisDataTransports->itemtransports->masteritemtc->itemID_accurate; //item id accurate id internal
                                //         $dataARRXQTITY[] = $thisDataTransports->quantity; //item quantity accurate id internal
                                //         $dataHARGA[] = $thisDataTransports->harga; //item harga accurate id internal
                                //         $dataARRXITEMTRANSPORTITEMUNIT[] = $thisDataTransports->itemtransports->unit; //item id accurate id internal
          
                                //     }
          
                                //   $AccurateCloud = $this->openModulesAccurateCloud
                                //     ->FuncOpenmoduleAccurateCloudSaveSalesQoutation(
                                //         'SQ.'.$jsonArray['Shipment']['code'],
                                //         $dataARRXCUSTOMER[0],
                                //         $dataARRXITEMTRANSPORT[0],
                                //         $this->datenow,
                                //         $dataHARGA[0],
                                //         $dataARRXQTITY[0],
                                //         $dataARRXITEMTRANSPORTITEMUNIT[0]
                                //   );

                                // //   $transports->whereIn('id', $saved_order_transport->id)->update(['salesQuotation_cloud' => ]);
                                // $order_id = $transports->whereIn('id', [$saved_order_transport->id])->first();

                                // $saved_order_transport->salesQuotation_cloud = $AccurateCloud->original;
                                // $saved_order_transport->save();

                              connectify('success', 'Izzy Transport', 'Transaksi berhasil membuat dokumen sales order');
          
                            // endif;
                                // if (!$saved_order_transport && !$inserted) {
                                //     App::abort(500, 'Error');
                                // } 
                                //     else {
                                        //docs https://github.com/softon/sweetalert
                                    // swal()
                                    //     ->toast()
                                    //     ->autoclose(12500)
                                    //     ->message("Order has been archived $saved_order_transport->order_id", "You have successfully order!", 'info');
                                    return response()->json([
                                        'success' => 'Data Transport berhasil disimpan',
                                        'order_id' => $saved_order_transport->order_id
                                    ]);

                                    // if (!$saved_order_transport) {
                                    //     App::abort(500, 'Error');
                                    // } else {
                                        //docs https://github.com/softon/sweetalert
                                        // swal()
                                        //     ->toast()
                                        //             ->autoclose(12500)
                                        //         ->message("Order has been archived $saved_order_transport->order_id", "You have successfully order!", 'info');
                                        //     return response()->json([
                                        //         'success' => 'Data Transport berhasil disimpan',
                                        //         'order_id' => $saved_order_transport->order_id
                                        //     ]);
                                    // }

                            // return redirect()->route('transport.static', session()->get('id'));


                    }

                    if ($testing[0]['operation'] == "false") {
                        // return "module false";
                        $saved_order_transport = Transport_orders::create(
                            [
                            // 'customer_id' => $request->customers_name,
                            // 'customer_id' => '1',
                            'customer_id' => $dataAsyncTransports['customer_id'],
                            // 'order_id' =>  $jsonArray['Shipment']['code'],
                            'order_id' =>  $jobs_order_idx, //if not api integration
                            // 'sub_service_id' => $request->test_sb_service,
                            'company_branch_id' => $this->pull_branch->session()->get('id'),
                            'purchase_order_customer' => '',
                            'by_users' => Auth::User()->oauth_accurate_company,
                            'item_transport' => $dataAsyncTransports['items_tc'],
                            'saved_origin_id' => $origin_address_book_id,
                            'status_order_id' => 1,
                            'origin' => $dataAsyncTransports['origin'],
                            // 'origin_details' => $request->origin_detail,
                            'origin_details' => $dataAsyncTransports['origin'],
                            'origin_address' => $dataAsyncTransports['origin_address'],
                            // 'origin_contact' => $request->origin_contact,
                            'origin_contact' => $dataAsyncTransports['pic_phone_origin'],
                            // 'origin_phone' => $request->origin_phone,
                            'origin_phone' => $dataAsyncTransports['pic_phone_origin'],
                            'pic_name_origin' => $dataAsyncTransports['pic_name_origin'],
                            'pic_phone_origin' => $dataAsyncTransports['pic_phone_origin'],

                            'saved_destination_id' => $destination_address_book_id,
                            'destination' => $dataAsyncTransports['destination'],
                            // 'destination_details' => $request->destination_detail,
                            'destination_details' => $dataAsyncTransports['destination'],
                            // 'destination_contact' => $request->destination_contact,
                            'destination_contact' => $dataAsyncTransports['pic_phone_destination'],
                            'destination_address' => $dataAsyncTransports['destination_address'],
                            // 'destination_phone' => $request->destination_phone,
                            'destination_phone' => $dataAsyncTransports['pic_phone_destination'],
                            'pic_name_destination' => $dataAsyncTransports['pic_name_destination'],
                            'pic_phone_destination' => $dataAsyncTransports['pic_phone_destination'],
                        
                            'estimated_time_of_delivery' => $dataAsyncTransports['etd'],
                            'estimated_time_of_arrival' => $dataAsyncTransports['eta'],
                            'time_zone' => $dataAsyncTransports['time_zone'],
                            'collie' => $dataAsyncTransports['collie'],
                            'quantity' => $dataAsyncTransports['qty'],
                            'harga' => $dataAsyncTransports['harga'],
                            'actual_weight' => $dataAsyncTransports['actual_weight'],
                            'volume' => $dataAsyncTransports['volume'],
                            'chargeable_weight' => $dataAsyncTransports['chargeable_weight'],
                            'notes' => $dataAsyncTransports['notes'],
                            'total_cost' => str_replace(".", "", $dataAsyncTransports['total_rate'])
                        ]
                    );

                    $inserted = New TrackShipments();
                    $inserted->order_id = $jobs_order_idx;
                    // $inserted->order_id = NULL;
                    $inserted->status = 1;
                    $inserted->datetime = Carbon::Now();
                    $inserted->user_id = Auth::User()->id;
                    $inserted->created_at = Carbon::Now();
                    $inserted->updated_at = Carbon::Now();
                    $inserted->save();
                    
                //     $fetch_data = $transports->whereIn('id', [$saved_order_transport->id])->with(['customers','itemtransports.masteritemtc'])->get();
                                      
                //     foreach($fetch_data as $key => $thisDataTransports){

                //         $order_id[] = $thisDataTransports->order_id; //item id accurate C.0000001
                //         $dataARRXCUSTOMER[] = $thisDataTransports->customers->itemID_accurate; //item id accurate C.0000001
                //         $dataARRXITEMTRANSPORT[] = $thisDataTransports->itemtransports->masteritemtc->itemID_accurate; //item id accurate id internal
                //         $dataARRXQTITY[] = $thisDataTransports->quantity; //item quantity accurate id internal
                //         $dataHARGA[] = $thisDataTransports->harga; //item harga accurate id internal
                //         $dataARRXITEMTRANSPORTITEMUNIT[] = $thisDataTransports->itemtransports->unit; //item id accurate id internal

                //     }

                //   $AccurateCloud = $this->openModulesAccurateCloud
                //     ->FuncOpenmoduleAccurateCloudSaveSalesQoutation(
                //         'SQ.'.$order_id[0],
                //         $dataARRXCUSTOMER[0],
                //         $dataARRXITEMTRANSPORT[0],
                //         $this->datenow,
                //         $dataHARGA[0],
                //         $dataARRXQTITY[0],
                //         $dataARRXITEMTRANSPORTITEMUNIT[0]
                //   );

                // //   $transports->whereIn('id', $saved_order_transport->id)->update(['salesQuotation_cloud' => ]);
                // $orders_id = $transports->whereIn('id', [$saved_order_transport->id])->first();

                // $saved_order_transport->salesQuotation_cloud = $AccurateCloud->original;
                // $saved_order_transport->save();

            //   connectify('success', 'Accurate cloud ', 'Kode Transaksi: '.$orders_id->order_id.' berhasil membuat dokumen order di Izzy Transport Code: '.$saved_order_transport->order_id);
              connectify('success', 'Izzy Transport', 'Transaksi berhasil membuat dokumen sales order');

            // endif;
                // if (!$saved_order_transport && !$inserted) {
                //     App::abort(500, 'Error');
                // } 
                //     else {
                        //docs https://github.com/softon/sweetalert
                    // swal()
                    //     ->toast()
                    //     ->autoclose(12500)
                    //     ->message("Order has been archived $saved_order_transport->order_id", "You have successfully order!", 'info');
                    return response()->json([
                        'success' => 'Data Transport berhasil disimpan',
                        'order_id' => $saved_order_transport->order_id
                    ]);


                        // if (!$saved_order_transport) {
                        //     App::abort(500, 'Error');
                        // } else {
                            //docs https://github.com/softon/sweetalert
                            // swal()
                            //     ->toast()
                            //             ->autoclose(12500)
                            //         ->message("Order has been archived $saved_order_transport->order_id", "You have successfully order!", 'info');
                            //     return response()->json([
                            //         'success' => 'Data Transport berhasil disimpan',
                            //         'order_id' => $saved_order_transport->order_id
                            //     ]);

                        // }

                        // return redirect()->route('transport.static', session()->get('id'));

                    }
                }
                                 
        }
                else {

                            $testdata = $jtd->all();
                            $data = array();
                            foreach ($testdata as $key => $value) {
                                # code...
                                $data[] = $value->shipment_id;
                            }

                            $data = $transports->WhereNotin('order_id', $data)->where('by_users', Auth::User()->name)->get();
                            // return response()->json($data);

                            // if ($data->isEmpty()) {
                            # code...
                            // return response()->json("Bisa lanjut");
                            //origin
                            $data_ab = $this->origin_address->where('id', $dataAsyncTransports['saved_origin'])->first();
                            $this->origin_address->name = $dataAsyncTransports['origin']; //retrieve_dirty
                            $this->origin_address->city_id = $dataAsyncTransports['id_origin_city'];
                            $this->origin_address->customer_id = $dataAsyncTransports['customer_id'];
                            $this->origin_address->details = $dataAsyncTransports['origin']; //retrieve_dirty

                                    $this->origin_address->address = $dataAsyncTransports['origin_address']; //retrieve_dirty
                                    $this->origin_address->contact = $dataAsyncTransports['pic_phone_destination']; //retrieve_dirty
                                    $this->origin_address->phone = $dataAsyncTransports['pic_phone_origin']; //retrieve_dirty
                                    $this->origin_address->pic_name_origin = $dataAsyncTransports['pic_name_origin']; //retrieve_dirty
                                    $this->origin_address->pic_phone_origin = $dataAsyncTransports['pic_phone_origin']; //retrieve_dirty
                                    $this->origin_address->pic_name_destination = $dataAsyncTransports['pic_name_destination']; //retrieve_dirty
                                    $this->origin_address->pic_phone_destination = $dataAsyncTransports['pic_phone_destination']; //retrieve_dirty
                                    $dsr = $this->origin_address->getDirty();
        
                    //you can dump variable with getDirty with session cache { dd($dsr) }
                                    
                    //dirty_column_name
                                        $new_attr_name = $dsr['name']; //new
                                        $old_attr_name = isset($data_ab->name) ? $data_ab->name : $dataAsyncTransports['origin']; //old
                            
                                                //dirty_column_origin_detail
                                                $new_attr_origin_detail = $dsr['details']; //new
                                                $old_attr_origin_detail = isset($data_ab->details) ? $data_ab->details : $dataAsyncTransports['origin']; //old
                                    
                                            //dirty_column_origin_address
                                            $new_attr_origin_address = $dsr['address']; //new
                                            $old_attr_origin_address = isset($data_ab->address) ? $data_ab->address : $dataAsyncTransports['origin_address']; //old
                                    
                                        //dirty_column_origin_contact
                                        $new_attr_origin_contact = $dsr['contact']; //new
                                        $old_attr_origin_contact = isset($data_ab->contact) ? $data_ab->contact : $dataAsyncTransports['pic_phone_origin']; //old
                                    
                                                //dirty_column_origin_phone
                                                $new_attr_origin_phone = $dsr['phone']; //new
                                                $old_attr_origin_phone = isset($data_ab->phone) ? $data_ab->phone : $dataAsyncTransports['pic_phone_origin']; //old

                                    //dirty_column_pic_name_origin
                                    $new_origin_attr_pic_name_origin = $dsr['pic_name_origin']; //new
                                    $old_origin_attr_pic_name_origin = isset($data_ab->pic_name_origin) ? $data_ab->pic_name_origin : $dataAsyncTransports['pic_name_origin']; //old

                                    //dirty_column_pic_phone_origin
                                    $new_origin_attr_pic_phone_origin = $dsr['pic_phone_origin']; //new
                                    $old_origin_attr_pic_phone_origin = isset($data_ab->pic_phone_origin) ? $data_ab->pic_phone_origin : $dataAsyncTransports['pic_phone_origin']; //old

                                    //dirty_column_name_destination
                                    $new_origin_attr_pic_name_destination = $dsr['pic_name_destination']; //new
                                    $old_origin_attr_pic_name_destination = isset($data_ab->pic_name_destination) ? $data_ab->pic_name_destination : $dataAsyncTransports['pic_name_destination']; //old

                                    //dirty_column_phone_destination
                                    $new_origin_attr_pic_phone_destination = $dsr['pic_phone_destination']; //new
                                    $old_origin_attr_pic_phone_destination = isset($data_ab->pic_phone_destination) ? $data_ab->pic_phone_destination : $dataAsyncTransports['pic_phone_destination']; //old
                                    
                                //destination
                                $data_av = $this->destination_address->where('id', $dataAsyncTransports['saved_destination'])->first();
                                $this->destination_address->name = $dataAsyncTransports['destination']; //retrieve_dirty
                                $this->destination_address->city_id = $dataAsyncTransports['id_destination_city'];
                                $this->destination_address->customer_id = $dataAsyncTransports['customer_id'];
                                $this->destination_address->details = $dataAsyncTransports['destination']; //retrieve_dirty
                                $this->destination_address->address = $dataAsyncTransports['destination_address']; //retrieve_dirty
                                $this->destination_address->contact = $dataAsyncTransports['pic_phone_destination']; //retrieve_dirty
                                $this->destination_address->phone = $dataAsyncTransports['pic_phone_destination']; //retrieve_dirty
                                $this->destination_address->pic_name_origin = $dataAsyncTransports['pic_name_origin']; //retrieve_dirty
                                $this->destination_address->pic_phone_origin = $dataAsyncTransports['pic_phone_origin']; //retrieve_dirty
                                $this->destination_address->pic_name_destination = $dataAsyncTransports['pic_name_destination']; //retrieve_dirty
                                $this->destination_address->pic_phone_destination = $dataAsyncTransports['pic_phone_destination']; //retrieve_dirty
                                $dsv = $this->destination_address->getDirty();
        
                    //you can dump variable with getDirty with cache { dd($dsr) }
                                    
                    //dirty_column_name
                                        $new_attr_desnam = $dsv['name']; //new
                                        $old_attr_desnam = isset($data_av->name) ? $data_av->name : $dataAsyncTransports['destination']; //old
                            
                                                //dirty_column_destinaion_detail
                                                $new_attr_destination_detail = $dsv['details']; //new
                                                $old_attr_destination_detail = isset($data_av->details) ? $data_av->details : $dataAsyncTransports['destination']; //old
                                    
                                            //dirty_column_destination_address
                                            $new_attr_destination_address = $dsv['address']; //new
                                            $old_attr_destination_address = isset($data_av->address) ? $data_av->address : $dataAsyncTransports['destination_address']; //old
                                    
                                        //dirty_column_destination_contact
                                        $new_attr_destination_contact = $dsv['contact']; //new
                                        $old_attr_destination_contact = isset($data_av->contact) ? $data_av->contact : $dataAsyncTransports['pic_phone_destination']; //old
                                    
                                                //dirty_column_destination_phone
                                                $new_attr_destination_phone = $dsv['phone']; //new
                                                $old_attr_destination_phone = isset($data_av->phone) ? $data_av->phone : $dataAsyncTransports['pic_phone_origin']; //old
                                    
                                    //dirty_column_pic_name_origin
                                    $new_destination_attr_pic_name_origin = $dsr['pic_name_origin']; //new
                                    $old_destination_attr_pic_name_origin = isset($data_av->pic_name_origin) ? $data_av->pic_name_origin : $dataAsyncTransports['pic_name_origin']; //old

                                    //dirty_column_pic_phone_origin
                                    $new_destination_attr_pic_phone_origin = $dsr['pic_phone_origin']; //new
                                    $old_destination_attr_pic_phone_origin = isset($data_av->pic_phone_origin) ? $data_av->pic_phone_origin : $dataAsyncTransports['pic_phone_origin']; //old

                                    //dirty_column_name_destination
                                    $new_destination_attr_pic_name_destination = $dsr['pic_name_destination']; //new
                                    $old_destination_attr_pic_name_destination = isset($data_av->pic_name_destination) ? $data_av->pic_name_destination : $dataAsyncTransports['pic_name_destination']; //old

                                    //dirty_column_phone_destination
                                    $new_destination_attr_pic_phone_destination = $dsr['pic_phone_destination']; //new
                                    $old_destination_attr_pic_phone_destination = isset($data_av->pic_phone_destination) ? $data_av->pic_phone_destination : $dataAsyncTransports['pic_phone_destination']; //old
                                    
                                            
                                if ($new_destination_attr_pic_phone_destination === $old_destination_attr_pic_phone_destination && $new_destination_attr_pic_name_destination === $old_destination_attr_pic_name_destination && $new_destination_attr_pic_phone_origin === $old_destination_attr_pic_phone_origin && $new_destination_attr_pic_name_origin === $old_destination_attr_pic_name_origin && $new_origin_attr_pic_phone_destination === $old_origin_attr_pic_phone_destination && $new_origin_attr_pic_name_destination === $old_origin_attr_pic_name_destination && $new_origin_attr_pic_name_origin === $old_origin_attr_pic_name_origin && $new_origin_attr_pic_phone_origin === $old_origin_attr_pic_phone_origin  && $new_attr_desnam === $old_attr_desnam && $new_attr_destination_detail === $old_attr_destination_detail && $new_attr_destination_address === $old_attr_destination_address && $new_attr_destination_contact === $old_attr_destination_contact && $new_attr_destination_phone === $old_attr_destination_phone && $new_attr_name === $old_attr_name && $new_attr_origin_detail === $old_attr_origin_detail && $new_attr_origin_address === $old_attr_origin_address && $new_attr_origin_contact === $old_attr_origin_contact && $new_attr_origin_phone === $old_attr_origin_phone) {
                                        // $dsr->save();
                                        if ($testing[0]['check_is'] == "api_izzy") {

                                            if ($testing[0]['operation'] == "true") {
                                                
                                                // $fetch_name_city_origin = $this->cityO->findOrFail($origin_address_book_id);
                                                // $fetch_name_city_destination = $this->cityD->findOrFail($destination_address_book_id);
                                                // unset($request['_method']);
                                                // unset($request['_token']);
                                                $client = new Client(['auth' => ['daniel-IT', '123abc']]);
                                                $userWithToken = Customer::findOrFail($customer_id['customer_id']);

                                                $response = $client->post(
                                                                'http://your.api.vendor.com/customer/v1/shipment/new',
                                                                [
                                                                    'headers' => [
                                                                        'Content-Type' => 'application/x-www-form-urlencoded',
                                                                        'X-IzzyTransport-Token' => $userWithToken->userWithToken,
                                                                        'Accept' => 'application/json'
                                                                    ],
                                                                    'form_params' => [
                                                                        'Sh[projectId]' => $userWithToken->project_id,
                                                                        'Sh[vendorId]' => '8',
                                                                        'Sh[poCodes]' => '',
                                                                        'Sh[collie]' => $dataAsyncTransports['collie'],
                                                                        'Sh[actualWeight]' => $dataAsyncTransports['actual_weight'],
                                                                        'Sh[chargeableWeight]' => $dataAsyncTransports['chargeable_weight'],
                                                                        'Sh[loadingType]' => 'Item Code',
                                                                        'Sh[service]' => $dataAsyncTransports['sub_servicess'],
                                                                        'Sh[etd]' => $dataAsyncTransports['etd'],
                                                                        'Sh[eta]' => $dataAsyncTransports['eta'],
                                                                        'Sh[timeZone]' => $dataAsyncTransports['time_zone'],
                                                                        'Sh[notes]' => $dataAsyncTransports['time_zone'],
                                                                        'Sh[origin]' => $dataAsyncTransports['origin'],
                                                                        // 'Sh[originCompany]' => $request->origin_detail,fetch_name_city_origin->name
                                                                        'Sh[originCompany]' => $dataAsyncTransports['origin'],
                                                                        'Sh[originAddress]' => $dataAsyncTransports['origin_address'],
                                                                        // 'Sh[originContact]' => $request->origin_contact,
                                                                        'Sh[originContact]' => $dataAsyncTransports['pic_name_origin'],
                                                                        // 'Sh[originPhone]' => $request->origin_phone,pic_phone_origin
                                                                        'Sh[originPhone]' => $dataAsyncTransports['pic_phone_origin'],
                                                                        // 'Sh[destination]' => $fetch_name_city_destination->name,
                                                                        'Sh[destination]' => $dataAsyncTransports['destination'],
                                                                        // 'Sh[destinationCompany]' => $request->destination_detail,
                                                                        'Sh[destinationCompany]' => $dataAsyncTransports['destination'],
                                                                        'Sh[destinationAddress]' => $dataAsyncTransports['destination_address'],
                                                                        // 'Sh[destinationContact]' => $request->destination_contact,
                                                                        'Sh[destinationContact]' => $dataAsyncTransports['pic_name_destination'],
                                                                        // 'Sh[destinationPhone]' => $request->destination_phone,
                                                                        'Sh[destinationPhone]' => $dataAsyncTransports['pic_phone_destination'],
                                                                        'Sh[region]' => $dataAsyncTransports["region_index"],
                                                                    ]
                                                                ]
                                                            );
                                        
                                                $jsonArray = json_decode($response->getBody()->getContents(), true);
                                                        
                                                $saved_order_transport = Transport_orders::create(
                                                            [
                                                            // 'customer_id' => $request->customers_name,
                                                            // 'customer_id' => '1',
                                                            'customer_id' => $dataAsyncTransports['customer_id'],
                                                            'order_id' =>  $jsonArray['Shipment']['code'],
                                                            // 'sub_service_id' => $request->test_sb_service,
                                                            'company_branch_id' => $this->pull_branch->session()->get('id'),
                                                            'purchase_order_customer' => '',
                                                            'by_users' => Auth::User()->oauth_accurate_company,
                                                            'item_transport' => $dataAsyncTransports['items_tc'],
                                                            'saved_origin_id' => $dataAsyncTransports['saved_origin'],
                                                            'status_order_id' => 1,
                                                            'origin' => $dataAsyncTransports['origin'],
                                                            // 'origin_details' => $request->origin_detail,
                                                            'origin_details' => $dataAsyncTransports['origin'],
                                                            'origin_address' => $dataAsyncTransports['origin_address'],
                                                            // 'origin_contact' => $request->origin_contact,
                                                            'origin_contact' => $dataAsyncTransports['pic_phone_origin'],
                                                            // 'origin_phone' => $request->origin_phone,
                                                            'origin_phone' => $dataAsyncTransports['pic_phone_origin'],
                                                            'pic_name_origin' => $dataAsyncTransports['pic_name_origin'],
                                                            'pic_phone_origin' => $dataAsyncTransports['pic_phone_origin'],
                                
                                                            'saved_destination_id' => $dataAsyncTransports['saved_destination'],
                                                            'destination' => $dataAsyncTransports['destination'],
                                                            // 'destination_details' => $request->destination_detail,
                                                            'destination_details' => $dataAsyncTransports['destination'],
                                                            // 'destination_contact' => $request->destination_contact,
                                                            'destination_contact' => $dataAsyncTransports['pic_phone_destination'],
                                                            'destination_address' => $dataAsyncTransports['destination_address'],
                                                            // 'destination_phone' => $request->destination_phone,
                                                            'destination_phone' => $dataAsyncTransports['pic_phone_destination'],
                                                            'pic_name_destination' => $dataAsyncTransports['pic_name_destination'],
                                                            'pic_phone_destination' => $dataAsyncTransports['pic_phone_destination'],
                                                        
                                                            'estimated_time_of_delivery' => $dataAsyncTransports['etd'],
                                                            'estimated_time_of_arrival' => $dataAsyncTransports['eta'],
                                                            'time_zone' => $dataAsyncTransports['time_zone'],
                                                            'collie' => $dataAsyncTransports['collie'],
                                                            'quantity' => $dataAsyncTransports['qty'],
                                                            'harga' => (float) str_replace(',', '', $dataAsyncTransports['harga']),
                                                            // 'harga' => $dataAsyncTransports['harga'],
                                                            'volume' => $dataAsyncTransports['volume'],
                                                            'actual_weight' => $dataAsyncTransports['actual_weight'],
                                                            'chargeable_weight' => $dataAsyncTransports['chargeable_weight'],
                                                            'notes' => $dataAsyncTransports['notes'],
                                                            'batch_item' => $datacollect,
                                                            'total_cost' => str_replace(".", "", $dataAsyncTransports['total_rate'])
                                                        ]
                                                    );
                                                    
                                                    $inserted = New TrackShipments();
                                                    // $inserted->order_id = $jsonArray['Shipment']['code'];
                                                    $inserted->order_id = $saved_order_transport->id;

                                                    $inserted->status = 1;
                                                    $inserted->job_no = NULL;
                                                    $inserted->datetime = Carbon::Now();
                                                    $inserted->user_id = Auth::User()->id;
                                                    $inserted->created_at = Carbon::Now();
                                                    $inserted->updated_at = Carbon::Now();
                                                    $inserted->save();

                                                    foreach($idToArray as $index =>$arrvitemidx) {
                                                        $data_orderxzc[] = [
                                                            'transport_id' => $saved_order_transport->id,
                                                            'itemID' => $arrvitemidx,
                                                            'qty' => $qtyarrid[$index],
                                                            'harga' => $pricearrid[$index],
                                                            'detailnotes' => $detailnoteID[$index],
                                                            'cash_discount' => isset($itemDiscount[$index]) ? $itemDiscount[$index] : 0
                                                        ];
                                                }
                                                Batchs_transaction_item_customer::insert($data_orderxzc);
                                                //     $fetch_data = $transports->whereIn('id', [$saved_order_transport->id])->with(['customers','itemtransports.masteritemtc'])->get();
                                      
                                                //     foreach($fetch_data as $key => $thisDataTransports){
                          
                                                //         $dataARRXCUSTOMER[] = $thisDataTransports->customers->itemID_accurate; //item id accurate C.0000001
                                                //         $dataARRXITEMTRANSPORT[] = $thisDataTransports->itemtransports->masteritemtc->itemID_accurate; //item id accurate id internal
                                                //         $dataARRXQTITY[] = $thisDataTransports->quantity; //item quantity accurate id internal
                                                //         $dataHARGA[] = $thisDataTransports->harga; //item harga accurate id internal
                                                //         $dataARRXITEMTRANSPORTITEMUNIT[] = $thisDataTransports->itemtransports->unit; //item id accurate id internal
                          
                                                //     }
                          
                                                //   $AccurateCloud = $this->openModulesAccurateCloud
                                                //     ->FuncOpenmoduleAccurateCloudSaveSalesQoutation(
                                                //         'SQ.'.$jsonArray['Shipment']['code'],
                                                //         $dataARRXCUSTOMER[0],
                                                //         $dataARRXITEMTRANSPORT[0],
                                                //         $this->datenow,
                                                //         $dataHARGA[0],
                                                //         $dataARRXQTITY[0],
                                                //         $dataARRXITEMTRANSPORTITEMUNIT[0]
                                                //   );

                                                //   $transports->whereIn('id', $saved_order_transport->id)->update(['salesQuotation_cloud' => ]);
                                                // $order_id = $transports->whereIn('id', [$saved_order_transport->id])->first();

                                                // $saved_order_transport->salesQuotation_cloud = $AccurateCloud->original;
                                                // $saved_order_transport->save();

                                            //   connectify('success', 'Accurate cloud ', 'Kode Transaksi: '.$order_id->order_id.' berhasil membuat dokumen penawaran penjualan pada Code SQ: '.$AccurateCloud->original.' berhasil dibuat.');
                                            //   connectify('success', 'Accurate cloud ', 'Kode Transaksi: '.$order_id->order_id.' berhasil membuat dokumen order di Izzy transport Code: '.$saved_order_transport->order_id);
                                              connectify('success', 'Izzy Transport', 'Transaksi berhasil membuat dokumen sales order');
                          
                                            // endif;
                                                // if (!$saved_order_transport && !$inserted) {
                                                //     App::abort(500, 'Error');
                                                // } 
                                                //     else {
                                                        //docs https://github.com/softon/sweetalert
                                                    // swal()
                                                    //     ->toast()
                                                    //     ->autoclose(12500)
                                                    //     ->message("Order has been archived $saved_order_transport->order_id", "You have successfully order!", 'info');
                                                    // return response()->json([
                                                    //     'success' => 'Data Transport berhasil disimpan',
                                                    //     'order_id' => $saved_order_transport->order_id
                                                    // ]);

                                                    // if (!$saved_order_transport) {
                                                    //     App::abort(500, 'Error');
                                                    // } 
                                                    //     else {
                                                        //docs https://github.com/softon/sweetalert
            
                                                        // swal()
                                                        //         ->toast()
                                                        //         ->autoclose(12500)
                                                        //         ->message("Order has been archived $saved_order_transport->order_id", "You have successfully order!", 'info');
                                                        return response()->json([
                                                            'success' => 'Data Transport berhasil disimpan',
                                                            'order_id' => $saved_order_transport->order_id
                                                        ]);
                                                    // }
                
                                                // return redirect()->route('transport.static', session()->get('id'));
                                        
                                            }

                                            if ($testing[0]['operation'] == "false") {
                                            
                                                $saved_order_transport = Transport_orders::create(
                                                    [
                                                    // 'customer_id' => $request->customers_name,
                                                    // 'customer_id' => '1',
                                                    'customer_id' => $dataAsyncTransports['customer_id'],
                                                    // 'order_id' =>  $jsonArray['Shipment']['code'],
                                                    'order_id' =>  $jobs_order_idx, //if not api integration
                                                    // 'sub_service_id' => $request->test_sb_service,
                                                    'company_branch_id' => $this->pull_branch->session()->get('id'),
                                                    'purchase_order_customer' => '',
                                                    'by_users' => Auth::User()->oauth_accurate_company,
                                                    'item_transport' => $dataAsyncTransports['items_tc'],
                                                    'saved_origin_id' => $dataAsyncTransports['saved_origin'],
                                                    'status_order_id' => 1,
                                                    'origin' => $dataAsyncTransports['origin'],
                                                    // 'origin_details' => $request->origin_detail,
                                                    'origin_details' => $dataAsyncTransports['origin'],
                                                    'origin_address' => $dataAsyncTransports['origin_address'],
                                                    // 'origin_contact' => $request->origin_contact,
                                                    'origin_contact' => $dataAsyncTransports['pic_phone_origin'],
                                                    // 'origin_phone' => $request->origin_phone,
                                                    'origin_phone' => $dataAsyncTransports['pic_phone_origin'],
                                                    'pic_name_origin' => $dataAsyncTransports['pic_name_origin'],
                                                    'pic_phone_origin' => $dataAsyncTransports['pic_phone_origin'],
                        
                                                    'saved_destination_id' => $dataAsyncTransports['saved_destination'],
                                                    'destination' => $dataAsyncTransports['destination'],
                                                    // 'destination_details' => $request->destination_detail,
                                                    'destination_details' => $dataAsyncTransports['destination'],
                                                    // 'destination_contact' => $request->destination_contact,
                                                    'destination_contact' => $dataAsyncTransports['pic_phone_destination'],
                                                    'destination_address' => $dataAsyncTransports['destination_address'],
                                                    // 'destination_phone' => $request->destination_phone,
                                                    'destination_phone' => $dataAsyncTransports['pic_phone_destination'],
                                                    'pic_name_destination' => $dataAsyncTransports['pic_name_destination'],
                                                    'pic_phone_destination' => $dataAsyncTransports['pic_phone_destination'],
                                                
                                                    'estimated_time_of_delivery' => $dataAsyncTransports['etd'],
                                                    'estimated_time_of_arrival' => $dataAsyncTransports['eta'],
                                                    'time_zone' => $dataAsyncTransports['time_zone'],
                                                    'collie' => $dataAsyncTransports['collie'],
                                                    'quantity' => $dataAsyncTransports['qty'],
                                                    // 'harga' => $dataAsyncTransports['harga'],
                                                    'harga' => (float) str_replace(',', '', $dataAsyncTransports['harga']),
                                                    'volume' => $dataAsyncTransports['volume'],
                                                    'actual_weight' => $dataAsyncTransports['actual_weight'],
                                                    'chargeable_weight' => $dataAsyncTransports['chargeable_weight'],
                                                    'notes' => $dataAsyncTransports['notes'],
                                                    'total_cost' => str_replace(".", "", $dataAsyncTransports['total_rate'])
                                                ]
                                            );

                                        //     $fetch_data = $transports->whereIn('id', [$saved_order_transport->id])->with(['customers','itemtransports.masteritemtc'])->get();
                                      
                                        //     foreach($fetch_data as $key => $thisDataTransports){
                  
                                        //         $dataARRXCUSTOMER[] = $thisDataTransports->customers->itemID_accurate; //item id accurate C.0000001
                                        //         $dataARRXITEMTRANSPORT[] = $thisDataTransports->itemtransports->masteritemtc->itemID_accurate; //item id accurate id internal
                                        //         $dataARRXQTITY[] = $thisDataTransports->quantity; //item quantity accurate id internal
                                        //         $dataHARGA[] = $thisDataTransports->harga; //item harga accurate id internal
                                        //         $dataARRXITEMTRANSPORTITEMUNIT[] = $thisDataTransports->itemtransports->unit; //item id accurate id internal
                                        //         $order_id[] = $thisDataTransports->order_id; //item id accurate id internal
                  
                                        //     }
                  
                                        //   $AccurateCloud = $this->openModulesAccurateCloud
                                        //     ->FuncOpenmoduleAccurateCloudSaveSalesQoutation(
                                        //         'SQ'.$order_id[0],
                                        //         $dataARRXCUSTOMER[0],
                                        //         $dataARRXITEMTRANSPORT[0],
                                        //         $this->datenow,
                                        //         $dataHARGA[0],
                                        //         $dataARRXQTITY[0],
                                        //         $dataARRXITEMTRANSPORTITEMUNIT[0]
                                        //   );

                                        // //   $transports->whereIn('id', $saved_order_transport->id)->update(['salesQuotation_cloud' => ]);
                                        // $orders_id = $transports->whereIn('id', [$saved_order_transport->id])->first();

                                        // $saved_order_transport->salesQuotation_cloud = $AccurateCloud->original;
                                        // $saved_order_transport->save();

                                    //   connectify('success', 'Accurate cloud ', 'Kode Transaksi: '.$orders_id->order_id.' berhasil membuat dokumen order di Izzy Transport Code: '.$saved_order_transport->order_id);
                                    connectify('success', 'Izzy Transport', 'Transaksi berhasil membuat dokumen sales order');
                  
                                    // endif;
                                        // if (!$saved_order_transport && !$inserted) {
                                        //     App::abort(500, 'Error');
                                        // } 
                                        //     else {
                                                //docs https://github.com/softon/sweetalert
                                            // swal()
                                            //     ->toast()
                                            //     ->autoclose(12500)
                                            //     ->message("Order has been archived $saved_order_transport->order_id", "You have successfully order!", 'info');
                                            return response()->json([
                                                'success' => 'Data Transport berhasil disimpan',
                                                'order_id' => $saved_order_transport->order_id
                                            ]);

                        
                                                    // if (!$saved_order_transport) {
                                                    //     App::abort(500, 'Error');
                                                    // } 
                                                    //     else {
                                                        //docs https://github.com/softon/sweetalert
                                                        // swal()
                                                        //         ->toast()
                                                        //         ->autoclose(12500)
                                                        //         ->message("Order has been archived $saved_order_transport->order_id", "You have successfully order!", 'info');
                                                        // return response()->json([
                                                        //     'success' => 'Data Transport berhasil disimpan',
                                                        //     'order_id' => $saved_order_transport->order_id
                                                        // ]);
                                                    // }
            
                                                // return redirect()->route('transport.static', session()->get('id'));
                                            
                                            }
                                        
                                        }

                                }  //jika inputan tidak sama dengan data db address book, maka update address book
                                    else 
                                            {
                                            // isi address book, jika salah satu tidak ada di master address book maka add automatic ke master address [ origin address book ]
                                            if($data_ab == null){

                                                    //add saved origin if id on null 
                                                    $origin_address = $this->origin_address->create([
                                                        'name' => $dataAsyncTransports['origin'],
                                                        'usersid' => Auth::User()->id,
                                                        'customer_id' => $dataAsyncTransports['customer_id'],
                                                        // 'details' => $request->origin_detail,
                                                        'details' => $dataAsyncTransports['origin'],
                                                        'city_id' => $dataAsyncTransports['id_origin_city'],
                                                        'address' => $dataAsyncTransports['origin_address'],
                                                        // 'contact' => $request->origin_contact,
                                                        'contact' => $dataAsyncTransports['pic_phone_origin'],
                                                        // 'phone' => $request->origin_phone,
                                                        'phone' => $dataAsyncTransports['pic_phone_origin'],
                                                        'pic_name_origin' => $dataAsyncTransports['pic_name_origin'],
                                                        'pic_phone_origin' => $dataAsyncTransports['pic_phone_origin'],
                                                        ]
                                                    );
                                    
                                                } 
                                                    else {
            
                                                        // isi address book, jika salah satu tidak ada di master address book maka add automatic ke master address [ destination address book ]
                                                        $data_ab->update(
                                                            [
                                                                'name' => $new_attr_name,
                                                                'customer_id' => $dataAsyncTransports['customer_id'],
                                                                // 'details' => $request->origin_detail,
                                                                'details' => $new_attr_name,
                                                                'city_id' => $dataAsyncTransports['origin_city'],
                                                                'address' => $dataAsyncTransports['origin_address'],
                                                                // 'contact' => $request->origin_contact,
                                                                'contact' => $dataAsyncTransports['pic_phone_origin'],
                                                                'pic_name_origin' => $dataAsyncTransports['pic_name_origin'],
                                                                'pic_phone_origin' => $dataAsyncTransports['pic_phone_origin'],
                                                                // 'phone' => $request->origin_phone
                                                                'phone' => $dataAsyncTransports['pic_phone_origin']
                                                        ]
                                                    );

                                                }

                                                if($data_av == null){

                                                    //add saved destination if id on null 
                                                    $destination_address = $this->destination_address->create([
                                                        'name' => $dataAsyncTransports['destination'],
                                                        'usersid' => Auth::User()->id,
                                                        'customer_id' => $dataAsyncTransports['customer_id'],
                                                        // 'details' => $request->destination_detail,
                                                        'details' => $dataAsyncTransports['destination'],
                                                        'city_id' => $dataAsyncTransports['id_destination_city'],
                                                        'address' => $dataAsyncTransports['destination_address'],
                                                        // 'contact' => $request->destination_contact,
                                                        'contact' => $dataAsyncTransports['pic_phone_destination'],
                                                        // 'phone' => $request->destination_phone,
                                                        'phone' => $dataAsyncTransports['pic_phone_destination'],
                                                        // 'pic_name_destination' => $dataAsyncTransports['pic_name_destination'],
                                                        // 'pic_phone_destination' => $dataAsyncTransports['pic_phone_destination'],
                                                        'pic_name_origin' => $dataAsyncTransports['pic_name_destination'],
                                                        'pic_phone_origin' => $dataAsyncTransports['pic_phone_destination'],

                                                        ]
                                                    );

                                                } 
                                                    else {

                                                        $data_av->update(
                                                            [
                                                                'name' => $new_attr_desnam,
                                                                'customer_id' => $dataAsyncTransports['customer_id'],
                                                                // 'details' => $request->destination_detail,
                                                                'details' => $new_attr_desnam,
                                                                'city_id' => $dataAsyncTransports['destination_city'],
                                                                // 'pic_name_destination' => $dataAsyncTransports['pic_name_destination'],
                                                                // 'pic_phone_destination' => $dataAsyncTransports['pic_phone_destination'],
                                                                'pic_name_origin' => $dataAsyncTransports['pic_name_destination'],
                                                                'pic_phone_origin' => $dataAsyncTransports['pic_phone_destination'],
                                                                'address' => $dataAsyncTransports['destination_address'],
                                                                // 'contact' => $request->destination_contact,
                                                                'contact' => $dataAsyncTransports['pic_phone_destination'],
                                                                'phone' => $dataAsyncTransports['pic_phone_destination']
                                                                // 'phone' => $request->destination_phone
                                                            ]
                                                        );
                                                }
                                              
                                                
                                                if ($testing[0]['check_is'] == "api_izzy") {

                                                    if ($testing[0]['operation'] == "true") {
                                                        //is running step is true all condition

                                                        /**
                                                         * @method GET for received response method post with account samsung pw asfd123
                                                         * ==============================================================================
                                                         */
                                                        // unset($request['_method']);
                                                        // unset($request['_token']);
                                                        // $client = new Client(['auth' => ['samsunguser', 'asdf123']]);
                                                        // $response = $client->post(
                                                        //         'http://your.api.vendor.com/customer/v1/shipment/new',
                                                        //         [
                                                        //             'headers' => [
                                                        //                 'Content-Type' => 'application/x-www-form-urlencoded',
                                                        //                 'X-IzzyTransport-Token' => 'ab567919190b1b8df2b089c02e0eb3321124cf6f.1575862464',
                                                        //                 'Accept' => 'application/json'
                                                        //             ],
                                                        //                 'form_params' => [
                                                        //                     'Sh[projectId]' => (int)$dataAsyncTransports['id_project'],
                                                        //                     // 'Sh[projectId]' => $dataAsyncTransports['id_project'], // remember this manually, check your request from matching API izzy and form order
                                                        //                     // 'Sh[projectId]' => '15', // remember this manually, check your request from matching API izzy and form order
                                                        //                     'Sh[vendorId]' => '10', // remember this manually, check your request from matching API izzy and form order
                                                        //                     'Sh[poCodes]' => '',
                                                        //                     'Sh[collie]' => $dataAsyncTransports['collie'],
                                                        //                     'Sh[actualWeight]' => $dataAsyncTransports['actual_weight'],
                                                        //                     'Sh[chargeableWeight]' => $dataAsyncTransports['chargeable_weight'],
                                                        //                     'Sh[loadingType]' => 'Item Code',
                                                        //                     'Sh[service]' => $dataAsyncTransports['sub_servicess'],
                                                        //                     'Sh[etd]' => $dataAsyncTransports['etd'],
                                                        //                     'Sh[eta]' => $dataAsyncTransports['eta'],
                                                        //                     'Sh[timeZone]' => $dataAsyncTransports['time_zone'],
                                                        //                     'Sh[notes]' => $dataAsyncTransports['notes'],
                                                        //                     'Sh[origin]' => $dataAsyncTransports['origin'],
                                                        //                     // 'Sh[originCompany]' => $request->origin_detail,fetch_name_city_origin->name
                                                        //                     'Sh[originCompany]' => $dataAsyncTransports['origin'],
                                                        //                     'Sh[originAddress]' => $dataAsyncTransports['origin_address'],
                                                        //                     // 'Sh[originContact]' => $request->origin_contact,
                                                        //                     'Sh[originContact]' => $dataAsyncTransports['pic_name_origin'],
                                                        //                     // 'Sh[originPhone]' => $request->origin_phone,pic_phone_origin
                                                        //                     'Sh[originPhone]' => $dataAsyncTransports['pic_phone_origin'],
                                                        //                     // 'Sh[destination]' => $fetch_name_city_destination->name,
                                                        //                     'Sh[destination]' => $dataAsyncTransports['destination'],
                                                        //                     // 'Sh[destinationCompany]' => $request->destination_detail,
                                                        //                     'Sh[destinationCompany]' => $dataAsyncTransports['destination'],
                                                        //                     'Sh[destinationAddress]' => $dataAsyncTransports['destination_address'],
                                                        //                     // 'Sh[destinationContact]' => $request->destination_contact,
                                                        //                     'Sh[destinationContact]' => $dataAsyncTransports['pic_name_destination'],
                                                        //                     // 'Sh[destinationPhone]' => $request->destination_phone,
                                                        //                     'Sh[destinationPhone]' => $dataAsyncTransports['pic_phone_destination'],
                                                        //                 ]
                                                        //             ]
                                                        //         );
                                            
                                                        // $jsonArray = json_decode($response->getBody()->getContents(), true);

                                                        // $responsex = $client->post(
                                                        //     'http://your.api.vendor.com/customer/v1/shipment/new',
                                                        //     [
                                                        //         'headers' => [
                                                        //             'Content-Type' => 'application/x-www-form-urlencoded',
                                                        //             'X-IzzyTransport-Token' => '59ee16a121cc8dac757ed21427d3d7e8fd19b501.1552632085',
                                                        //             'Accept' => 'application/json'
                                                        //         ],
                                                        //             'form_params' => [
                                                        //                 'method' => 'CREATE',
                                                        //                 'shipment_id' => $jsonArray['Shipment']['id'],
                                                        //                 'shipment' => $jsonArray['Shipment']['code'],
                                                        //                 'description' => 'asdasdasda'
                                                                       
                                                        //             ]
                                                        //         ]
                                                        //     );

//                                                         //Prepare you post parameters
                                                            // $postData = array(
                                                            //     'method' => 'CREATE',
                                                            //     'shipment_id' => $jsonArray['Shipment']['id'],
                                                            //     'shipment' =>$jsonArray['Shipment']['code'],
                                                            //     'description' => 'asdasdasd'
                                                            // );
                                                            
                                                            // //Replace your API endpoint
                                                            // $url="http://devyour-api.co.id/webhooks";
                                                            
                                                            // // init the resource
                                                            // $ch = curl_init();
                                                            // curl_setopt_array($ch, array(
                                                            //     CURLOPT_URL => $url,
                                                            //     CURLOPT_RETURNTRANSFER => true,
                                                            //     CURLOPT_POST => true,
                                                            //     CURLOPT_POSTFIELDS => $postData
                                                            //     //,CURLOPT_FOLLOWLOCATION => true
                                                            // ));
                                                            
                                                            // //Ignore SSL certificate verification
                                                            // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                                                            // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                                                            
                                                            // //get response
                                                            // $output = curl_exec($ch);
                                                            
                                                            // //Print error if any
                                                            // // if(curl_errno($ch))
                                                            // // {
                                                            // //     echo 'error:' . curl_error($ch);
                                                            // // }
                                                            
                                                            // curl_close($ch);

                                                        // return response()->json($responsex);die;

                                                        if($dataAsyncTransports['saved_origin'] == null){

                                                            $saved_origin = $origin_address->id;

                                                        } else {

                                                            $saved_origin = $dataAsyncTransports['saved_origin'];

                                                        }

                                                        if($dataAsyncTransports['saved_destination'] == null){

                                                            $saved_destination = $destination_address->id;

                                                        } else {

                                                            $saved_destination = $dataAsyncTransports['saved_destination'];

                                                        }

                                                        $saved_order_transport = Transport_orders::create(
                                                                    [
                                                                    // 'customer_id' => $request->customers_name,
                                                                    // 'customer_id' => '1',
                                                                    'customer_id' => $dataAsyncTransports['customer_id'],
                                                                    // 'order_id' =>  $jsonArray['Shipment']['code'],
                                                                    'order_id' => NULL, //if not api integration
                                                                    // 'order_id' =>  $jsonArray['Shipment']['code'], //if not api integration
                                                                    // 'sub_service_id' => $request->test_sb_service,
                                                                    'company_branch_id' => $this->pull_branch->session()->get('id'),
                                                                    'purchase_order_customer' => '',
                                                                    'by_users' => Auth::User()->oauth_accurate_company,
                                                                    'item_transport' => $dataAsyncTransports['items_tc'],
                                                                    'saved_origin_id' => $saved_origin,
                                                                    'status_order_id' => 1,
                                                                    'origin' => $dataAsyncTransports['origin'],
                                                                    // 'origin_details' => $request->origin_detail,
                                                                    'origin_details' => $dataAsyncTransports['origin'],
                                                                    'origin_address' => $dataAsyncTransports['origin_address'],
                                                                    // 'origin_contact' => $request->origin_contact,
                                                                    'origin_contact' => $dataAsyncTransports['pic_phone_origin'],
                                                                    // 'origin_phone' => $request->origin_phone,
                                                                    'origin_phone' => $dataAsyncTransports['pic_phone_origin'],
                                                                    'pic_name_origin' => $dataAsyncTransports['pic_name_origin'],
                                                                    'pic_phone_origin' => $dataAsyncTransports['pic_phone_origin'],
                                        
                                                                    'saved_destination_id' => $saved_destination,
                                                                    'destination' => $dataAsyncTransports['destination'],
                                                                    // 'destination_details' => $request->destination_detail,
                                                                    'destination_details' => $dataAsyncTransports['destination'],
                                                                    // 'destination_contact' => $request->destination_contact,
                                                                    'destination_contact' => $dataAsyncTransports['pic_phone_destination'],
                                                                    'destination_address' => $dataAsyncTransports['destination_address'],
                                                                    // 'destination_phone' => $request->destination_phone,
                                                                    'destination_phone' => $dataAsyncTransports['pic_phone_destination'],
                                                                    'pic_name_destination' => $dataAsyncTransports['pic_name_destination'],
                                                                    'pic_phone_destination' => $dataAsyncTransports['pic_phone_destination'],
                                                                
                                                                    'estimated_time_of_delivery' => $dataAsyncTransports['etd'],
                                                                    'estimated_time_of_arrival' => $dataAsyncTransports['eta'],
                                                                    'time_zone' => $dataAsyncTransports['time_zone'],
                                                                    'collie' => $dataAsyncTransports['collie'],
                                                                    'quantity' => $dataAsyncTransports['qty'],
                                                                    'harga' => (float) str_replace(',', '', $dataAsyncTransports['harga']),
                                                                    'volume' => $dataAsyncTransports['volume'],
                                                                    'actual_weight' => $dataAsyncTransports['actual_weight'],
                                                                    'chargeable_weight' => $dataAsyncTransports['chargeable_weight'],
                                                                    'notes' => $dataAsyncTransports['notes'],
                                                                    // 'batch_item' => $datacollect,
                                                                    'batch_item' => $datacollect,
                                                                    'total_cost' => str_replace(".", "", $dataAsyncTransports['total_rate'])
                                                                ]
                                                            );
        
                                                            $inserted = New TrackShipments();
                                                            $inserted->order_id = $saved_order_transport->id;
                                                            // $inserted->order_id = $jsonArray['Shipment']['code'];
                                                            $inserted->status = 1;
                                                            $inserted->job_no = NULL;
                                                            $inserted->datetime = Carbon::Now();
                                                            $inserted->user_id = Auth::User()->id;
                                                            $inserted->created_at = Carbon::Now();
                                                            $inserted->updated_at = Carbon::Now();
                                                            $inserted->save();

                                                            foreach($idToArray as $index =>$arrvitemidx) {
                                                                $data_orderxzc[] = [
                                                                    'transport_id' => $saved_order_transport->id,
                                                                    'itemID' => $arrvitemidx,
                                                                    'qty' => $qtyarrid[$index],
                                                                    'harga' => $pricearrid[$index],
                                                                    'detailnotes' => $detailnoteID[$index],
                                                                    'cash_discount' => isset($itemDiscount[$index]) ? $itemDiscount[$index] : 0
                                                                ];
                                                        }
                                                
                                                       $sdata = Batchs_transaction_item_customer::insert($data_orderxzc);

                                                        //     $fetch_data = $transports->whereIn('id', [$saved_order_transport->id])->with(['customers','itemtransports.masteritemtc'])->get();
                                      
                                                        //         foreach($fetch_data as $key => $thisDataTransports){
                                    
                                                        //             $dataARRXCUSTOMER[] = $thisDataTransports->customers->itemID_accurate; //item id accurate C.0000001
                                                        //             $dataARRXITEMTRANSPORT[] = $thisDataTransports->itemtransports->masteritemtc->itemID_accurate; //item id accurate id internal
                                                        //             $dataARRXQTITY[] = $thisDataTransports->quantity; //item quantity accurate id internal
                                                        //             $dataHARGA[] = $thisDataTransports->harga; //item harga accurate id internal
                                                        //             $dataARRXITEMTRANSPORTITEMUNIT[] = $thisDataTransports->itemtransports->unit; //item id accurate id internal
                                    
                                                        //         }
                                  
                                                        //     $AccurateCloud = $this->openModulesAccurateCloud
                                                        //         ->FuncOpenmoduleAccurateCloudSaveSalesQoutation(
                                                        //             'SQ.'.$jsonArray['Shipment']['code'],
                                                        //             $dataARRXCUSTOMER[0],
                                                        //             $dataARRXITEMTRANSPORT[0],
                                                        //             $this->datenow,
                                                        //             $dataHARGA[0],
                                                        //             $dataARRXQTITY[0],
                                                        //             $dataARRXITEMTRANSPORTITEMUNIT[0]
                                                        //     );
                       
                                                        // //   $transports->whereIn('id', $saved_order_transport->id)->update(['salesQuotation_cloud' => ]);
                                                        // $order_id = $transports->whereIn('id', [$saved_order_transport->id])->first();

                                                        // $saved_order_transport->salesQuotation_cloud = substr($AccurateCloud->original,0,2).'.'.$jsonArray['Shipment']['code'];
                                                        // $saved_order_transport->recovery_SQ = $AccurateCloud->original;
                                                        // $saved_order_transport->save();

                                                    //   connectify('success', 'Izzy Transport', 'Transaksi berhasil membuat dokumen sales order: '.$order_id->order_id);
                                                    connectify('success', '3PS Application', 'Transaksi berhasil membuat dokumen sales order');
                                  
                                                    // endif;
                                                        // if (!$saved_order_transport && !$inserted) {
                                                        //     App::abort(500, 'Error');
                                                        // } 
                                                        //     else {
                                                                //docs https://github.com/softon/sweetalert
                                                            // swal()
                                                            //     ->toast()
                                                            //     ->autoclose(12500)
                                                            //     ->message("Order has been archived $saved_order_transport->order_id", "You have successfully order!", 'info');
                                                            return response()->json([
                                                                'success' => 'Data Transport berhasil disimpan',
                                                                // 'order_id' => $saved_order_transport->order_id
                                                                'order_id' => NULL
                                                            ]);

                                                            // if (!$saved_order_transport && !$inserted) {
                                                            //     App::abort(500, 'Error');
                                                            // } 
                                                            //     else {
                                                                //docs https://github.com/softon/sweetalert
                                                                    // swal()
                                                                    //         ->toast()
                                                                    //         ->autoclose(12500)
                                                                    //         ->message("Order has been archived $saved_order_transport->order_id", "You have successfully order!", 'info');
                                                                    // return response()->json([
                                                                    //     'success' => 'Data Transport berhasil disimpan',
                                                                    //     'order_id' => $saved_order_transport->order_id
                                                                    // ]);
                                                                // }
                    
                                                        // return redirect()->route('transport.static', session()->get('id'));
                                                    }

                                                    if ($testing[0]['operation'] == "false") {
                                                    
                                                        if($dataAsyncTransports['saved_origin'] == null){

                                                            $saved_origin = $origin_address->id;

                                                        } else {

                                                            $saved_origin = $dataAsyncTransports['saved_origin'];

                                                        }

                                                        if($dataAsyncTransports['saved_destination'] == null){

                                                            $saved_destination = $destination_address->id;

                                                        } else {

                                                            $saved_destination = $dataAsyncTransports['saved_destination'];

                                                        }

                                                        $saved_order_transport = Transport_orders::create(
                                                            [
                                                                // 'customer_id' => $request->customers_name,
                                                                // 'customer_id' => '1',
                                                                'customer_id' => $dataAsyncTransports['customer_id'],
                                                                // 'order_id' =>  $jsonArray['Shipment']['code'],
                                                                'order_id' =>  $jobs_order_idx, //if not api integration
                                                                // 'sub_service_id' => $request->test_sb_service,
                                                                'company_branch_id' => $this->pull_branch->session()->get('id'),
                                                                'purchase_order_customer' => '',
                                                                'by_users' => Auth::User()->oauth_accurate_company,
                                                                'item_transport' => $dataAsyncTransports['items_tc'],
                                                                'saved_origin_id' => $saved_origin,
                                                                'status_order_id' => 1,
                                                                'origin' => $dataAsyncTransports['origin'],
                                                                // 'origin_details' => $request->origin_detail,
                                                                'origin_details' => $dataAsyncTransports['origin'],
                                                                'origin_address' => $dataAsyncTransports['origin_address'],
                                                                // 'origin_contact' => $request->origin_contact,
                                                                'origin_contact' => $dataAsyncTransports['pic_phone_origin'],
                                                                // 'origin_phone' => $request->origin_phone,
                                                                'origin_phone' => $dataAsyncTransports['pic_phone_origin'],
                                                                'pic_name_origin' => $dataAsyncTransports['pic_name_origin'],
                                                                'pic_phone_origin' => $dataAsyncTransports['pic_phone_origin'],
                                    
                                                                'saved_destination_id' => $saved_destination,
                                                                'destination' => $dataAsyncTransports['destination'],
                                                                // 'destination_details' => $request->destination_detail,
                                                                'destination_details' => $dataAsyncTransports['destination'],
                                                                // 'destination_contact' => $request->destination_contact,
                                                                'destination_contact' => $dataAsyncTransports['pic_phone_destination'],
                                                                'destination_address' => $dataAsyncTransports['destination_address'],
                                                                // 'destination_phone' => $request->destination_phone,
                                                                'destination_phone' => $dataAsyncTransports['pic_phone_destination'],
                                                                'pic_name_destination' => $dataAsyncTransports['pic_name_destination'],
                                                                'pic_phone_destination' => $dataAsyncTransports['pic_phone_destination'],
                                                            
                                                                'estimated_time_of_delivery' => $dataAsyncTransports['etd'],
                                                                'estimated_time_of_arrival' => $dataAsyncTransports['eta'],
                                                                'time_zone' => $dataAsyncTransports['time_zone'],
                                                                'collie' => $dataAsyncTransports['collie'],
                                                                'quantity' => $dataAsyncTransports['qty'],
                                                                // 'harga' => $dataAsyncTransports['harga'],
                                                                'harga' => (float) str_replace(',', '', $dataAsyncTransports['harga']),
                                                                'volume' => $dataAsyncTransports['volume'],
                                                                'actual_weight' => $dataAsyncTransports['actual_weight'],
                                                                'chargeable_weight' => $dataAsyncTransports['chargeable_weight'],
                                                                'notes' => $dataAsyncTransports['notes'],
                                                                'total_cost' => str_replace(".", "", $dataAsyncTransports['total_rate'])
                                                        ]
                                                    );

                                                        $inserted = New TrackShipments();
                                                        $inserted->order_id = $jobs_order_idx; //if not api integration
                                                        $inserted->status = 1;
                                                        $inserted->job_no = NULL;
                                                        $inserted->datetime = Carbon::Now();
                                                        $inserted->user_id = Auth::User()->id;
                                                        $inserted->created_at = Carbon::Now();
                                                        $inserted->updated_at = Carbon::Now();
                                                        $inserted->save();

                                                        // if ($request->update_status_trnports == "8"): //draft to new Create bid 

                                                            // $fetch_data = $transports->whereIn('id', [$saved_order_transport->id])->with(['customers','itemtransports.masteritemtc'])->get();
                                      
                                                            //     foreach($fetch_data as $key => $thisDataTransports){
                                      
                                                            //         $dataARRXCUSTOMER[] = $thisDataTransports->customers->itemID_accurate; //item id accurate C.0000001
                                                            //         $dataARRXITEMTRANSPORT[] = $thisDataTransports->itemtransports->masteritemtc->itemID_accurate; //item id accurate id internal
                                                            //         $dataARRXQTITY[] = $thisDataTransports->quantity; //item quantity accurate id internal
                                                            //         $dataHARGA[] = $thisDataTransports->harga; //item harga accurate id internal
                                                            //         $dataARRXITEMTRANSPORTITEMUNIT[] = $thisDataTransports->itemtransports->unit; //item id accurate id internal
                                                            //         $order_id[] = $thisDataTransports->order_id; //item id accurate id internal
                                      
                                                            //     }
                                      
                                                            //   $AccurateCloud = $this->openModulesAccurateCloud
                                                            //     ->FuncOpenmoduleAccurateCloudSaveSalesQoutation(
                                                            //         'SQ.'.$order_id[0],
                                                            //         $dataARRXCUSTOMER[0],
                                                            //         $dataARRXITEMTRANSPORT[0],
                                                            //         $this->datenow,
                                                            //         $dataHARGA[0],
                                                            //         $dataARRXQTITY[0],
                                                            //         $dataARRXITEMTRANSPORTITEMUNIT[0]
                                                            //   );
    
                                                            // //   $transports->whereIn('id', $saved_order_transport->id)->update(['salesQuotation_cloud' => ]);
                                                            // $orders_id = $transports->whereIn('id', [$saved_order_transport->id])->first();

                                                            // $saved_order_transport->salesQuotation_cloud = $AccurateCloud->original;
                                                            // $saved_order_transport->save();

                                                        //   connectify('success', 'Accurate cloud ', 'Kode Transaksiberhasil membuat dokumen order di Izzy Transport Code: '.$saved_order_transport->order_id);
                                                        connectify('success', 'Izzy Transport', 'Transaksi berhasil membuat dokumen sales order');
                                      
                                                        // endif;
                                                            // if (!$saved_order_transport && !$inserted) {
                                                            //     App::abort(500, 'Error');
                                                            // } 
                                                            //     else {
                                                                    //docs https://github.com/softon/sweetalert
                                                                    // swal()
                                                                    //     ->toast()
                                                                    //     ->autoclose(12500)
                                                                    //     ->message("Order has been archived $saved_order_transport->order_id", "You have successfully order!", 'info');
                                                                    return response()->json([
                                                                        'success' => 'Data Transport berhasil disimpan',
                                                                        'order_id' => $saved_order_transport->order_id
                                                                    ]);
                                                            // }
                    
                                                        // return redirect()->route('transport.static', session()->get('id'));
                                                    }
                                                
                                                }
                                        // return 'tidak sama.';
                                        // swal()->toast()->autoclose(3500)->message("Information has been archived","You have successfully address book added!",'info');
                            }
                                    
                }
                        // } else {
                        //     # code...
                        //     // return response()->json("Maaf tdk bisa lanjut, selesai terlebih dahulu job shipmentnya..");
                        //             swal()
                        //             ->toast()
                        //                 ->autoclose(20000)
                        //         ->message("Maaf tidak bisa melakukan transaksi,anda punya job shipment yang belum dituntaskan ..","You don't access this transaction!",'error');

                        // }

        }
        // }  
                catch (\GuzzleHttp\Exception\ClientException $handlingApi) {

                    /**
                        * | PENJELESAN ERROR API 3PS -> IZZY TRANSPORTS |
                        * @method Bad Request Handling
                        * - Penjelesan error ketika Project id tidak cocok pada master izzy transport - |
                        * [-] Project tidak ditemukan karena pada saat mengisi master customer tidak mensinkronkan api Izzy
                        * [-] Project disini dialiaskan sebagai customer pada apps 3PS, kemudian project Id akan otomatis membaca dari project di apps izzy transprot
                    */

                    swal()
                        ->toast()
                        ->autoclose(50000)
                            ->message("Error API izzy \r\n", '"'.$handlingApi->getResponse()->getBody()->getContents(). '"'."Karena Project ".$dataAsyncTransports['id_project']." tidak ada di master izzy transport", 'error');

                    return redirect()->route('transport.static', session()->get('id'));

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
        $decrypts = Crypt::decrypt($id);
        $APIs = $this->APIntegration::callstaticfunction();
        $jobs_order_idx = self::generateID();
            foreach((array)$APIs as $key => $detected){
    
                $how_working[] = $detected;
    
            }
     
            $jsonArray = json_decode($APIs->getContent(), true);
    
            foreach((array)$jsonArray as $key => $indexing){
    
                $testing[$key] = $indexing;
    
            }

            if ($testing[0]['check_is'] == "api_izzy") {

                // if ($testing[0]['operation'] == "true") 
                // {

                //     try {

                //         $transport_list = Transport_orders::with('customers')->find($id);
                //         // $data_transport = Transport_orders::with('customers')->where('customer_id', '=', $transport_list->customers->id)->where('by_users', Auth::User()->name)->find($id);
                //         $data_transport = Transport_orders::with('customers')->findOrFail($id);

                //         $data_vendor= array();

                //         $client_vendor = new Client(['auth' => ['api_customer', 'customer123']]);
                                
                //                 $callback_v = $client_vendor->get(
                //                         'http://your.api.vendor.com/customer/v1/vendor',
                //                         [  'headers' => [
                //                                 'Content-Type' => 'application/x-www-form-urlencoded',
                //                                 'X-IzzyTransport-Token' => '59ee16a121cc8dac757ed21427d3d7e8fd19b501.1552632085',
                //                                 'Accept' => 'application/json'],
                //                                 'query' => ['limit' => '50',
                //                                             'page' => '30'
                //                             ]
                //                         ]
                //                     );
        
                //                 $jsonArrayVendor = json_decode($callback_v->getBody(), true);
                //                 $data_vendor = $jsonArrayVendor['vendors'];
        
                //                 $data_array2= array();
        
                //                 $client2 = new Client(['auth' => ['api_customer', 'customer123']]);
                //                 $response2 = $client2->get(
                //                     'http://your.api.vendor.com/customer/v1/project',
                //                     [  'headers' => [
                //                             'Content-Type' => 'application/x-www-form-urlencoded',
                //                             'X-IzzyTransport-Token' => '59ee16a121cc8dac757ed21427d3d7e8fd19b501.1552632085',
                //                             'Accept' => 'application/json'],
                //                             'query' => ['limit' => '10',
                //                                         'page' => '30'
                //                         ]
                //                     ]
                //                 );
        
                //                 $jsonArray2 = json_decode($response2->getBody(), true);
                //                 $data_array2 = $jsonArray2['Projects'];
        
                //                 $data_array1= array();
                                
        
                //                 $client1 = new Client(['auth' => ['api_customer', 'customer123']]);
                //                 $response1 = $client1->get(
                //                     'http://your.api.vendor.com/customer/v1/shipment',
                //                     [  'headers' => [
                //                             'Content-Type' => 'application/x-www-form-urlencoded',
                //                             'X-IzzyTransport-Token' => '59ee16a121cc8dac757ed21427d3d7e8fd19b501.1552632085',
                //                             'Accept' => 'application/json'],
                //                             'query' => ['code' => $transport_list->order_id,
                //                         ]
                //                     ]
                //                 );
        
                //                 $jsonArray1 = json_decode($response1->getBody(), true);
                //                 $data_array1 = $jsonArray1['Shipment'];
                                    
                //                 // dd($data_array1['Transporter']);
                //                 $data_item_alert_sys_allows0 = Customer_item_transports::with(
                //                             'customers',
                //                             'city_show_it_origin',
                //                             'city_show_it_destination'
                //                         )->where('flag', 0)->get();
                //                 $alert_customers = Customer::with('cstatusid')->where('flag', 0)->get();
                //                 $alert_items = Item::where('flag', 0)->get();
                //                 $system_alert_item_vendor = Vendor_item_transports::with(
                //                                 'vendors',
                //                                 'city_show_it_origin',
                //                                 'city_show_it_destination'
                //                             )->where('flag', 0)->get();
                //                 $transport_list = Transport_orders::with('customers')->find($id);
                //                 $prefix = Company_branchs::branchwarehouse($this->pull_branch->session()->get('id'))->first();

                //                 $fetch_izzy = dbcheck::where('check_is','=','api_izzy')->get();

                //                 foreach ($fetch_izzy as $value) {
                //                     # code...
                //                     $fetchArrays[] = $value->check_is;
                //                 } 
                        
                //                 if(isset($fetchArrays) != null){
                //                     $operations_api_izzy_is_true_v1 = dbcheck::where('check_is','=','api_izzy')->get();
                        
                //                     foreach ($operations_api_izzy_is_true_v1 as $operationz) {
                //                         # code...
                //                         $fetchArray1 = $operationz->operation;
                //                     } 
                        
                //                     $operations_api_izzy_is_true_v2 = dbcheck::where('check_is','=','api_accurate')->get();
                                    
                //                     foreach ($operations_api_izzy_is_true_v2 as $operations) {
                //                         # code...
                //                         $fetchArray2 = $operations->operation;
                //                     } 
                        
                //                 } 
        
                //                 return view('admin.transport.edit_transport_orderlist',
                //                                     ['menu' => 'Viewed Data Transport',
                //                                     'alert_items' => $alert_items,
                //                                     'api_v1' => $fetchArray1,
                //                                     'api_v2' => $fetchArray2,
                //                                     'choosen_user_with_branch' => $this->pull_branch->session()->get('id'),
                //                                     'some' => $this->pull_branch->session()->get('id'),
                //                                     'system_alert_item_vendor' => $system_alert_item_vendor,
                //                                     'system_alert_item_customer' => $data_item_alert_sys_allows0,
                //                                     'alert_customers' => $alert_customers]
                //                                 )->with(compact(
                //                                         'data_array1',
                //                                         'data_array2',
                //                                         'data_vendor',
                //                                         'transport_list',
                //                                         'prefix',
                //                                         'data_transport'
                //                                 ));
        
                //             } catch (\GuzzleHttp\Exception\ClientException $e) {
        
                //                 return $e->getResponse()
                //                         ->getBody()
                //                         ->getContents();
                        
                //         }
            
                //     }
        
                    if ($testing[0]['operation'] == "false" || $testing[0]['operation'] == "true") 
                        {
            
                            // $transport_list = Transport_orders::with('customers')->findOrFail($id);
                            // dd($transport_list->customers->id);
                            $data_transport = Transport_orders::with('customers','itemtransports.sub_services')->findOrFail($decrypts);
                            // dd($data_transport);
            
                            $data_item_alert_sys_allows0 = Customer_item_transports::with(
                                'customers',
                                'city_show_it_origin',
                                'city_show_it_destination'
                                )->where('flag', 0)->get();
                                $alert_customers = Customer::with('cstatusid')->where('flag', 0)->get();
                                $alert_items = Item::where('flag', 0)->get();
                                $system_alert_item_vendor = Vendor_item_transports::with(
                                                'vendors',
                                                'city_show_it_origin',
                                                'city_show_it_destination'
                                            )->where('flag', 0)->get();
                                // $transport_list = Transport_orders::with('customers')->find($id);
                                $transport_list = Transport_orders::with('customers')->where(function (Builder $query) use($branch_id, $decrypts) {
                                    return $query->where('id','=',$decrypts)
                                            ->whereIn('company_branch_id', [$branch_id]);
                                })->first();
                                $prefix = Company_branchs::branchwarehouse($this->pull_branch->session()->get('id'))->first();
                                    
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

                                session(['id_transport' => $id]);
                                $customers = Customer::all();
                                $address = Address_book::all();
                                $global_city = City::all();
                                $global_sub_services = Item_transport::with('sub_services')->get();
                                $cekOrders = Transport_orders::with('cek_status_transaction')->findOrFail($decrypts);
                            
                            $batch_item = app(AccurateController::class)
                                ->batch_item->with(['transportsIDX','masterItemIDACCURATE.sub_services','masterItemIDACCURATE.ItemsTransports'])
                                ->whereIn('transport_id', [$decrypts])->get();

                                // dd($batch_item);

                                if($transport_list == null){
                                    swal()
                                    ->toast()
                                        ->autoclose(9000)
                                        ->message("Security detection", "Branch changes are detected in the transaction details!", 'info');
                                    return redirect()->route('transport.static', session()->get('id'));
                                }

                                return view(
                                        'admin.transport.build_edit_transport_orderlist',
                                        [
                                            'menu' => 'Viewed Data Transport',
                                            'alert_items' => $alert_items,
                                            'choosen_user_with_branch' => $this->pull_branch->session()->get('id'),
                                            'some' => $this->pull_branch->session()->get('id'),
                                            'api_v1' => $fetchArray1,
                                            'api_v2' => $fetchArray2,
                                            'system_alert_item_vendor' => $system_alert_item_vendor,
                                            'system_alert_item_customer' => $data_item_alert_sys_allows0,
                                            'alert_customers' => $alert_customers
                                        ]
                                    )->with(compact(
                                            'jobs_order_idx',
                                            'address',
                                            'customers',
                                            'cekOrders',
                                            'transport_list',
                                            'prefix',
                                            'data_transport',
                                            'global_city',
                                            'global_sub_services',
                                            'batch_item'
                                    ));
        
                        }

            }        

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $userWithToken = Customer::findOrFail($id);

        $APIs = $this->APIntegration::callstaticfunction();

        foreach((array)$APIs as $key => $detected){

            $how_working[] = $detected;

        }
 
        $jsonArray = json_decode($APIs->getContent(), true);

        foreach((array)$jsonArray as $key => $indexing){

            $testing[$key] = $indexing;

        }

        if ($testing[0]['check_is'] == "api_izzy") {

            if ($testing[0]['operation'] == "true") {

                try
                    {
                        $transport_list = Transport_orders::with('customers')->find($id);
                        $client = new Client();
                        $response = $client->get('http://your.api.vendor.com/customer/v1/shipment',
                            [  'headers' => [
                                    'Content-Type' => 'application/x-www-form-urlencoded',
                                    'X-IzzyTransport-Token' => $userWithToken->userWithToken,
                                    'Accept' => 'application/json'],
                                    'query' => ['code' => $transport_list->order_id,
                                ]
                            ]
                        );
    
                     $data_array= array();
    
                        $jsonArray = json_decode($response->getBody(), true);
                        $data_array = $jsonArray['Shipment'];  

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
                            
                            $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
                                $alert_items = Item::where('flag',0)->get();
                                $system_alert_item_vendor = Vendor_item_transports::with('vendors',
                                'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
                                $system_alert_item_customer = Customer_item_transports::with('customers',
                                'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
                                        $transport_list = Transport_orders::with('customers')->find($id);
                                $prefix = Company_branchs::branchwarehouse($this->pull_branch->session()->get('id'))->first();
        
                                    return view ('admin.transport.edit_transport_orderlist',
                                    ['menu' => 'Viewed Data Transport',
                                        'alert_items' => $alert_items,
                                        'api_v1' => $fetchArray1,
                                        'choosen_user_with_branch' => $this->pull_branch->session()->get('id'),
                                        'some' => $this->pull_branch->session()->get('id'),
                                        'api_v2' => $fetchArray2,
                                        'system_alert_item_customer' => $system_alert_item_customer,
                                        'system_alert_item_vendor' => $system_alert_item_vendor,
                                        'alert_customers' => $alert_customers])->with(compact('prefix','data_array','transport_list'
                                    )
                                );
            
                            } catch (\GuzzleHttp\Exception\ClientException $e) {
                    
                                return $e->getResponse()
                                        ->getBody()
                                        ->getContents();
                        }
    
                }
    
                if ($testing[0]['operation'] == "false") {

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
    
                    $transport_list = Transport_orders::with('customers')->find($id);
    
                    $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
                    $alert_items = Item::where('flag',0)->get();
                    $system_alert_item_vendor = Vendor_item_transports::with('vendors',
                    'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
                    $system_alert_item_customer = Customer_item_transports::with('customers',
                    'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
                    $prefix = Company_branchs::branchwarehouse($this->pull_branch->session()->get('id'))->first();
    
                        return view ('admin.transport.edit_transport_orderlist',
                        ['menu' => 'Viewed Data Transport',
                            'alert_items' => $alert_items,
                            'api_v1' => $fetchArray1,
                            'choosen_user_with_branch' => $this->pull_branch->session()->get('id'),
                            'some' => $this->pull_branch->session()->get('id'),
                            'api_v2' => $fetchArray2,
                            'system_alert_item_customer' => $system_alert_item_customer,
                            'system_alert_item_vendor' => $system_alert_item_vendor,
                            'alert_customers' => $alert_customers])->with(compact('prefix','data_array','transport_list'
                    )
                );
    
            }
        
        }

    }

    public function updateSyncTransports(Request $request, $id,Address_book $address_book, RequestUpdateDetailsTransport $rest)
    {

        try {

                $xc = Transport_orders::findOrFail($id);
                $ssss = explode(",", $xc->id);
                
                $datajc = implode(",",$this->posts->input('itemID'));
                $itemIDinternalaccurate = explode(",",$datajc);

                $qtyid = implode(",",$this->posts->input('qtyID'));
                $qtyarrid = explode(",",$qtyid);

                $priceid = implode(",",$this->posts->input('priceID'));
                $pricearrid = explode(",",$priceid);

                $itemIDaccurate = implode(",",$this->posts->input('itemIDaccurate'));
                $arritemID = explode(",",$itemIDaccurate);

                $itemDiscount = $this->posts->input('itemDiscount');
                
                foreach($this->posts->input('detailNotesID') as $i => $xval) {
                    $detailnoteID[] = $xval;
                }

                    foreach($itemIDinternalaccurate as $keyf =>$x) {
                    
                    $data = [
                                'itemID_accurate' => $arritemID,
                                'itemID' => $x,
                                'qty' => $qtyarrid,
                                'harga' => $pricearrid,
                                'ID' => $ssss,
                                'detailNotes' => $detailnoteID,
                                'itemDiscount' => $itemDiscount,
                    ];
                    
                    $ls = [
                            'transport_id' => (Int) $data['ID'][0],
                            'itemID' => $data['itemID'],
                            'qty' => isset($data['qty'][$keyf]) ? $data['qty'][$keyf] : $data['qty'],
                            'detailnotes' => isset($data['detailNotes'][$keyf]) ? $data['detailNotes'][$keyf] : $data['detailNotes'],
                            'harga' => isset($data['harga'][$keyf]) ? $data['harga'][$keyf] : $data['harga'],
                            'cash_discount' => ($data['itemDiscount'][0] === null) ? 0 : $data['itemDiscount'][0]
                    ];

                $itemIDREX = app(AccurateController::class)->batch_item->where('transport_id',$data['ID'][0])->where('itemID', $data['itemID'] )->exists();
                            
                        $duplicateEntry = app(AccurateController::class)->batch_item->where('transport_id',$data['ID'][0])->where('itemID', $data['itemID'] )->count();
                        
                    if($duplicateEntry > 1){
                        
                        $s = app(AccurateController::class)->batch_item->where('itemID', $data['itemID'])->delete();

                    }

                    if($itemIDREX == false || $duplicateEntry < 1){

                        $s = Batchs_transaction_item_customer::insert($ls);
                
                    }
                    
                }
                
                $encrypts = Crypt::encrypt($id);

                $APIs = $this->APIntegration::callstaticfunction();

                foreach((array)$APIs as $key => $detected){

                    $how_working[] = $detected;

                }
        
                $jsonArray = json_decode($APIs->getContent(), true);

                $parsingIDCUSTOMERIZZY = Customer::where('id', '=', $request->customers_name)->first();

                foreach((array)$jsonArray as $key => $indexing){

                    $testing[$key] = $indexing;

                }

                if ($testing[0]['check_is'] == "api_izzy") {

                    if ($testing[0]['operation'] == "true") {
            
                        $this->validate($rest, []);

                        try {

                            $data_transport = Transport_orders::with('customers')->where('by_users', Auth::User()->name)->find($id);
                            // unset($request['_method']);
                            // unset($request['_token']);
                            $projectId = Customer::whereIn('id', [$request->customers_name])->first();

                            $client = new Client();
                            $userWithToken = Customer::findOrFail($request->customers_name);
                            
                            $response = $client->post('http://your.api.vendor.com/customer/v1/shipment/update', [
                                'headers' => [
                                    'Content-Type' => 'application/x-www-form-urlencoded',
                                    'X-IzzyTransport-Token' => $userWithToken->userWithToken,
                                    'Accept' => 'application/json'
                                ],
                                'form_params' => [
                                    'code' => $request->code_id,
                                    'Sh[projectId]' => $projectId['project_id'],
                                    'Sh[transporterId]' => $request->transport_id,
                                    'Sh[vendorId]' => $request->vendor,
                                    'Sh[poCodes]' => $request->purchase_order,
                                    'Sh[collie]' => $request->collie,
                                    'Sh[actualWeight]' => $request->actual_weight,
                                    'Sh[chargeableWeight]' => $request->chargeable_weight,
                                    'Sh[loadingType]' => 'Item Code',
                                    'Sh[service]' => $request->sub_services,
                                    'Sh[etd]' => $request->etd,
                                    'Sh[eta]' => $request->eta,
                                    'Sh[timeZone]' => $request->time_zone,
                                    'Sh[notes]' => $request->get('notes'),
                                    'Sh[origin]' => $request->origin,
                                    'Sh[originCompany]' => $request->origin_detail,
                                    'Sh[originAddress]' => $request->origin_address,
                                    'Sh[originContact]' => $request->pic_name_origin,
                                    'Sh[originPhone]' => $request->pic_phone_origin,
                                    'Sh[destination]' => $request->destination,
                                    'Sh[destinationCompany]' => $request->destination_detail,
                                    'Sh[destinationAddress]' => $request->destination_address,
                                    'Sh[destinationContact]' => $request->pic_name_destination,
                                    'Sh[destinationPhone]' => $request->pic_phone_destination,
                                    'Sh[region]' => $request->regionedit,
                                ]
                            ]
                        );
                        $jsonArray = json_decode($response->getBody()->getContents(), true);
            
                        $data_array2= array();
            
                        $client2 = new Client();
                        $response2 = $client2->get('http://your.api.vendor.com/customer/v1/project',
                            [  'headers' => [
                                    'Content-Type' => 'application/x-www-form-urlencoded',
                                    'X-IzzyTransport-Token' => $userWithToken->userWithToken,
                                    'Accept' => 'application/json'],
                                    'query' => ['limit' => '10',
                                                'page' => '30'
                                ]
                            ]
                        );
            
                        $jsonArray2 = json_decode($response2->getBody(), true);
                        $data_array2 = $jsonArray2['Projects'];
            
            
                        $transport_list = Transport_orders::with('customers')->find($id);
                        $data_array1= array();
                            
            
                        $client1 = new Client();
                        $response1 = $client1->get('http://your.api.vendor.com/customer/v1/shipment',
                            [  'headers' => [
                                    'Content-Type' => 'application/x-www-form-urlencoded',
                                    'X-IzzyTransport-Token' => $userWithToken->userWithToken,
                                    'Accept' => 'application/json'],
                                    'query' => ['code' => $transport_list->order_id,
                                ]
                            ]
                        );
            
                            $jsonArray1 = json_decode($response1->getBody(), true);
                            $data_array1 = $jsonArray1['Shipment'];
                            $data_origin = $address_book->with('origins')->where('id', $request->saved_origin)->where('customer_id',$request->customers_name)->first();
                            $data_destination = $address_book->with('destinations')->where('id', $request->saved_destination)->where('customer_id', $request->customers_name)->first();
            
                            if ($request->customers_name == null || $data_origin == null && $data_destination == null || $request->sub_servicess == null && $request->items_tc == null) {
                                # code...
                                    swal()
                                    ->toast()
                                        ->autoclose(12000)
                                ->message("Maaf terjadi kesalahan","Periksa kembali inputan saved_origin, sub_service & Item tidak boleh kosong..!",'error'); 
            
                                return redirect()->back();
            
                            } 
            
                                else {
            
                                    $transports_ = Transport_orders::with('customers')->find($id);
            
                                    $transports_->purchase_order_customer = Request('purchase_order');
                                    $transports_->actual_weight = $request->actual_weight;
                                    $transports_->quantity = $request->qty;
                                    $transports_->estimated_time_of_delivery = $request->etd;
                                    $transports_->estimated_time_of_arrival = $request->eta;
                                    $transports_->time_zone = $request->time_zone;
                                    $transports_->chargeable_weight = $request->chargeable_weight;
                                    $transports_->collie = $request->collie;
                                    $transports_->origin = $request->saved_origin;
                                    $transports_->origin_details = $request->origin_detail;
                                    $transports_->origin_address = $request->origin_address;
                                    $transports_->origin_contact = $request->pic_name_origin;
                                    $transports_->origin_phone = $request->pic_phone_origin;
                                    $transports_->pic_name_origin = $request->pic_name_origin;
                                    $transports_->pic_name_destination = $request->pic_name_destination;
                                    $transports_->pic_phone_origin = $request->pic_phone_origin;
                                    $transports_->pic_phone_destination = $request->pic_phone_destination;
                                    $transports_->destination = $request->saved_destination;
                                    $transports_->destination_details = $request->destination_detail;
                                    $transports_->destination_address = $request->destination_address;
                                    $transports_->destination_contact = $request->pic_name_destination;
                                    $transports_->destination_phone = $request->pic_phone_destination;
                                    $transports_->notes = $request->notes;
                                    $transports_->harga = (float) str_replace(",", "", $request->harga);
                                    $transports_->total_cost = str_replace(".", "", $request->total_rate);
                                    $alert_sys = $transports_->save();

                                $fetchDetailDataTransports = $transports_->whereIn('id', [$id])->with(['customers','itemtransports.masteritemtc'])->first();
                                $Qty = (String) $fetchDetailDataTransports->quantity;
                                $Cost = (String) $fetchDetailDataTransports->harga;
                                $itemID_accurate = $fetchDetailDataTransports["itemtransports"]->masteritemtc->itemID_accurate;
                                $responseCODESQ = $fetchDetailDataTransports->recovery_SQ;
                                $responseCODESO = $fetchDetailDataTransports->recovery_SO;
                                $responseGeneratePO = 'PO.'.$fetchDetailDataTransports->order_id;
                                $Comments = $fetchDetailDataTransports->notes;
                                $qtys = $request->input('qty');
                                $rts = $request->input('rate');

                                $Izzy = new Promise(
                                    function () use (&$Izzy, &$jsonArray) {
                                        $Izzy->resolve($jsonArray);

                                    },
                                    function ($ex) {
                                        $Izzy->reject($ex);
                                        
                                    }
                                );

                                $barangJasa__ = new Promise(
                                    function () use (&$barangJasa__, &$itemID_accurate, &$Qty, &$Cost) {
                                        $barangJasa__->resolve($this->UpdateSyncBarangJasa($itemID_accurate, $Qty, $Cost));

                                    },
                                    function ($ex) {
                                        $barangJasa__->reject($ex);
                                    }
                                );

                                $fetchDetailDataTransports = Transport_orders::whereIn('id', [$xc->id])->with(['customers','itemtransports.masteritemtc'])->first();
                                $responseCODESO = $fetchDetailDataTransports->order_id;
                                $responseGeneratePO = 'PO.'.$fetchDetailDataTransports->order_id;
                                $dataPemesan = $fetchDetailDataTransports->customers->itemID_accurate; //pelanggan
                                $itemNo = $data['itemID_accurate'];
                                $transport_id = $data['ID'];
                                $itemIDXo = $itemIDinternalaccurate;
                                $branch_id = Auth::User()->oauth_accurate_branch;
                                // $branch_id = session('UserMultiBranchAccurate')["d"][0]["id"];

                                $resetSalesOrders__ = new Promise(
                                    function () use (&$resetSalesOrders__, &$branch_id, &$responseCODESO, &$itemNo, &$itemIDXo, &$transport_id) {
                                        $resetSalesOrders__->resolve($this->ResetSyncDetailItemSO($responseCODESO, $branch_id, $itemNo, $itemIDXo, $transport_id));
                        
                                    },
                                    function ($ex) {
                                        $resetSalesOrders__->reject($ex);
                                    }
                                );

                                // dd($resetSalesOrders__);die;

                                if($resetSalesOrders__->wait() == "not found"){
                                    $SalesOrders__ = new Promise(
                                        function () use (&$SalesOrders__, &$branch_id, &$arritemID, &$dataPemesan, &$id, &$responseCODESO, &$responseGeneratePO, &$qtyarrid, &$detailnoteID, &$pricearrid, &$itemIDinternalaccurate) {
                                            $SalesOrders__->resolve($this->UpdateSyncSO($arritemID, $branch_id, $dataPemesan, $id, $responseCODESO, $responseGeneratePO, $qtyarrid, $detailnoteID, $pricearrid, $itemIDinternalaccurate));
                            
                                        },
                                        function ($ex) {
                                            $SalesOrders__->reject($ex);
                                        }
                                    );
                                    
                                    return response()->json([
                                        'success' => 'Data Transport berhasil diupdate',
                                        'izzyTransports' => 'Update shipment success - '.'['.$Izzy->wait()["Shipment"]["code"].']',
                                        'BarangJasa' => $barangJasa__->wait()->original["d"][0].'.',
                                        'SOrders' => $SalesOrders__->wait()->getData("+")["d"][0]["d"].'.'
                                    ]);

                                }

                                $data_origin = $address_book->where('id', $request->saved_origin)->where('customer_id', $request->customers_name)->first();
                                $data_origin->pic_name_origin = Request('pic_name_origin');
                                $data_origin->pic_phone_origin = Request('pic_phone_origin');
                                $data_origin->save();
                
                                $data_destination = $address_book->where('id', $request->saved_destination)->where('customer_id', $request->customers_name)->first();
                                $data_destination->pic_name_destination = Request('pic_name_destination');
                                $data_destination->pic_phone_destination = Request('pic_phone_destination');
                                $data_destination->save();
                                
                                return response()->json([
                                    'success' => 'Data Transport berhasil diupdate',
                                    'izzyTransports' => 'Update shipment success - '.'['.$Izzy->wait()["Shipment"]["code"].']',
                                    'BarangJasa' => $barangJasa__->wait()->original["d"][0].'.',
                                ]);

                            }  
                        
                                $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
                                $alert_items = Item::where('flag',0)->get();
                                $prefix = Company_branchs::branchwarehouse($this->pull_branch->session()->get('id'))->first();
                                $system_alert_item_customer = Customer_item_transports::with('customers',
                                'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
                                $system_alert_item_vendor = Vendor_item_transports::with('vendors',
                                'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
            
                                    return view ('admin.transport.edit_transport_orderlist',
                                    ['menu' => 'Viewed Data Transport',
                                        'alert_items' => $alert_items,
                                        'system_alert_item_customer' => $system_alert_item_customer,
                                        'system_alert_item_vendor' => $system_alert_item_vendor,
                                        'alert_customers' => $alert_customers])
                                        ->with(compact('data_array2','prefix','data_array1','transport_list','data_transport'
                                    )
                                );
            
                        } 
                            catch (\GuzzleHttp\Exception\ClientException $e) {
            
                                return $e->getResponse()
                                    ->getBody()
                                    ->getContents();
                    
                        }

                    }

                    if ($testing[0]['operation'] == "false") {

                        $this->validate($rest, []);

                        $data_transport = Transport_orders::with('customers')->where('by_users', Auth::User()->name)->find($id);
                        $transport_list = Transport_orders::with('customers')->find($id);
                        $data_origin = $address_book->with('origins')->where('id', $request->saved_origin)->where('customer_id',$request->customers_name)->first();
                        $data_destination = $address_book->with('destinations')->where('id', $request->saved_destination)->where('customer_id', $request->customers_name)->first();

                        if ($request->customers_name == null || $data_origin == null && $data_destination == null || $request->sub_servicess == null && $request->items_tc == null) {
                            # code...
                                swal()
                                ->toast()
                                    ->autoclose(12000)
                            ->message("Maaf terjadi kesalahan","Periksa kembali inputan saved_origin, sub_service & Item tidak boleh kosong..!",'error'); 

                            return back();

                        } 

                            else {

                                $transports_ = Transport_orders::with('customers')->findOrFail($id);

                                $transports_->purchase_order_customer = Request('purchase_order');
                                $transports_->customer_id = Request('customers_name');
                                $transports_->actual_weight = Request('actual_weight');
                                $transports_->estimated_time_of_delivery = Request('etd');
                                $transports_->quantity = Request('qty');
                                $transports_->estimated_time_of_arrival = Request('eta');
                                $transports_->time_zone = Request('time_zone');
                                $transports_->chargeable_weight = Request('chargeable_weight');
                                $transports_->collie = Request('collie');
                                $transports_->origin = Request('origin');
                                $transports_->origin_details = Request('origin_detail');
                                $transports_->origin_address = Request('origin_address');
                                $transports_->origin_contact = Request('origin_contact');
                                $transports_->origin_phone = Request('origin_phone');
                                $transports_->pic_name_origin = Request('pic_name_origin');
                                $transports_->pic_name_destination = Request('pic_name_destination');
                                $transports_->pic_phone_origin = Request('pic_phone_origin');
                                $transports_->pic_phone_destination = Request('pic_phone_destination');
                                $transports_->destination = Request('destination');
                                $transports_->destination_details = Request('destination_detail');
                                $transports_->destination_address = Request('destination_address');
                                $transports_->destination_contact = Request('destination_contact');
                                $transports_->destination_phone = Request('destination_phone');
                                $transports_->notes = $request->get('notes');
                                $transports_->total_cost = str_replace(".", "", $request->total_rate);
                                $alert_sys = $transports_->save();
                
                            $data_origin = $address_book->where('id', $request->saved_origin)
                                            ->where('customer_id', $request->customers_name)->first();
                            $data_origin->pic_name_origin = Request('pic_name_origin');
                            $data_origin->pic_phone_origin = Request('pic_phone_origin');
                            $data_origin->save();
            
                            $data_destination = $address_book->where('id', $request->saved_destination)
                                            ->where('customer_id', $request->customers_name)->first();
                            $data_destination->pic_name_destination = Request('pic_name_destination');
                            $data_destination->pic_phone_destination = Request('pic_phone_destination');
                            $data_destination->save();

                            if(!$alert_sys){
                                \App::abort(500, 'Error');
                            } 
                            else {
                                //docs https://github.com/softon/sweetalert
                                swal()
                                    ->toast()
                                        ->autoclose(3500)
                                ->message("Shipment has been approved","You have successfully accept order!",'info'); 
                            }

                        return redirect()->back();
                            
                }  
                
            }
                
        }

    } catch (\Throwable $th) {

        return response()->json(['error' => $th->getMessage()]);
    
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

    public function cari_subservice(Request $request)
    {
        $cari = $request->id;
        $data = Sub_service::select('id','name')->where('name', 'LIKE', "%$cari%")->get();
        foreach ($data as $query) {
            $results[] = ['value' => $query ];
        }
        return response()->json($data);
    }

    public function search_by_sub_service(Request $request, $id)
    {
      $data = Item_transport::select('id', 'itemovdesc')->where('sub_service_id','=', $id)->get();
      foreach ($data as $query) {
          $results[] = ['value' => $query ];
        }
      return response()->json($data);
    }

    public function search_id_by_sb_service_price($id)
    {
      $data = Item_transport::where('id','=',$id)->get();
      foreach ($data as $query) {
          $results[] = ['value' => $query ];
        }
      return response()->json($data);
    }

    public function search_by_customers($id, $origin, $destination)
    {
    //   $data = Item_transport::with('sub_services', 'customers')
    //     ->where('customer_id','=', $id)->groupBy('sub_service_id')
    //         ->get();
    //     if ($data->isEmpty()) {
            // $data_if_null = Item_transport::with('sub_services', 'customers')->where('customer_id', '=', null)->get();
            // foreach ($data_if_null as $query) {
            //     $results[] = ['value' => $query ];
            // }
            /*
            | query menampilkan item transport dengan harga contrack atau publish 
            | jika value customer NULL maka customer tersebut masuk ke kategori harga publish 
            | jika value customer terdaftar di item transport maka customer tersebut masuk ke kategori harga contract 
            */

            $data_item_transport = Item_transport::with(
                                                    'sub_services', 'customers'
                                                )
                            ->where(
                                    function (Builder $query) use ($id, $origin, $destination) {
                        return $query->whereNull('customer_id')
                            ->orWhereIn('customer_id', [$id])
                            ->where('origin', '=', $origin)
                            ->whereIn('branch_item', [Auth::User()->oauth_accurate_company])
                            ->where('destination', '=', $destination)
                        ;
                    }
                // )->distinct()->groupBy('sub_service_id')->get()
                )->distinct()->get()
                // )->get()
            ;

        return response()->json($data_item_transport);
        // }
            // } else{
            //     foreach ($data as $query) {
            //         $results[] = ['value' => $query ];
            //     }
            // return response()->json($data);
        // }
    
    }

    public function __viewItemCustomer($branch_id, $itemId)
    {
        $data = Item_transport::with('sub_services','masteritemtc')
        ->whereIn('id', [$itemId])
        // ->whereIn('referenceID', [$itemId])
        ->first();

        return response()->json(['data' =>$data]);
    } 

    public function searchonLoadItemTransport($id)
    {
    //   $data = Item_transport::with('sub_services', 'customers')
    //     ->where('customer_id','=', $id)->groupBy('sub_service_id')
    //         ->get();
    //     if ($data->isEmpty()) {
            // $data_if_null = Item_transport::with('sub_services', 'customers')->where('customer_id', '=', null)->get();
            // foreach ($data_if_null as $query) {
            //     $results[] = ['value' => $query ];
            // }
            /*
            | query menampilkan item transport dengan harga contrack atau publish 
            | jika value customer NULL maka customer tersebut masuk ke kategori harga publish 
            | jika value customer terdaftar di item transport maka customer tersebut masuk ke kategori harga contract 
            */

            $data_item_transport = Item_transport::with(
                                                            'sub_services', 'customers'
                                                        )
                            ->where(
                                    function (Builder $query) use ($id) {
                        return $query->where('customer_id', '=', null)
                            ->orWhere('customer_id', '=', $id)
                        ;
                    }
                )->get()
            ;

        return response()->json($data_item_transport);
        // }
            // } else{
            //     foreach ($data as $query) {
            //         $results[] = ['value' => $query ];
            //     }
            // return response()->json($data);
        // }
    
    }



    public function report_transport($branch_id, $id)
    {
        
    $decrypts= Crypt::decrypt($id);
    $data_transport = Transport_orders::with('customers','itemtransports.sub_services','company_branch.company','city_destination.citys','city_origin.citys')->where('company_branch_id', [$branch_id])->where('order_id','=',$decrypts)->first();
    //   $warehouseTolist = Warehouse_order::with('customers_warehouse','sub_service.remarks','service_house')->find($id);
    //   $warehouse_order_pic = Warehouse_order_customer_pic::with('to_do_list_cspics')->where('warehouse_order_id',$id)->get();
    // dd($data_transport);
    if(is_null($data_transport)){
        
            \Session::flash('surat-jalan-tidak-tersedia', "surat jalan tidak sesuai dengan cabang/company, pada saat order.");
        
        return redirect()->route('transport.static', session()->get('id'));

    } 
        else {

                $qrCode = new QrCode();
                $qrCode
                ->setText($data_transport->order_id)
                ->setSize(500)
                ->setPadding(3)

                ->setErrorCorrection('high')
                ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
                ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
                ->setLabel('')
                ->setLabelFontSize(20)
                ->setImageType(QrCode::IMAGE_TYPE_PNG);
                $now = Carbon::Now();

            // return view('admin.transport.report_transports.transport_reports');
                // $customPaper = array(0,0,781.00,596.80);
                $customPaper = array(0,0,866.00,596.80);
                    $data = ['name' =>'3 permata system'];
                        $pdf = PDF::loadView('admin.transport.report_transports.transport_reports', compact('qrCode','data','data_transport','now'));

                        $pdf->SetPaper($customPaper,'landscape');
                        return $pdf->stream("surat-jalan-$data_transport->order_id.pdf", array("Attachment"=> false));
            // exit(0);
        }
    }

    // public function search_by_customers_with_origin_destination(Request $request, $id, $sb_services, $origin, $destination )
    // {
    //   $data = Item_transport::with('sub_services', 'customers')
    //         ->where('customer_id','=', $id)
    //         ->where('sub_service_id','=', $sb_services)
    //         ->where('origin','=', $origin)
    //         ->where('destination','=', $destination)
    //         ->get();
    //     if($data->isEmpty()){
    //       $data_if_null = Item_transport::with('sub_services', 'customers')->where('customer_id','=', NULL)->get();
    //         foreach ($data_if_null as $query) {
    //             $results[] = ['value' => $query ];
    //         }
    //             return response()->json($data_if_null);
    //         } else{
    //             foreach ($data as $query) {
    //                 $results[] = ['value' => $query ];
    //             }
    //         return response()->json($data);
    //     }
    
    // } 
    
    public function search_by_customers_with_origin_destination(Request $request, $id, $sb_services, $origin, $destination)
    {

        $data_item = Item_transport::with('sub_services', 'customers')
                    ->whereIn('id', [$sb_services])
                    ->get();

            foreach ($data_item as $data_clients){
                $fetch_services[] = $data_clients->sub_service_id;
                $fetch_customers_id[] = $data_clients->customers['id'];
            }

            $data =  Item_transport::with(
                                            'sub_services', 'customers'
                                    )
                    ->where(
                        function (Builder $query) use ($fetch_customers_id, $fetch_services, $origin, $destination) {
                            return $query->whereNotNull('customer_id')
                                ->whereIn('customer_id', $fetch_customers_id)
                                ->where('origin','=', $origin)
                                ->where('destination','=', $destination)
                                ->whereIn('branch_item', [Auth::User()->oauth_accurate_company])
                                ->where('sub_service_id','=', $fetch_services)
                            ;
                        }
                    )
                ->get()
            ;

        if($data->isEmpty()){

            $data_if_null =  Item_transport::with(
                            'sub_services', 'customers'
                            )
                ->where(
                        function (Builder $query) use ($fetch_services, $origin, $destination) {
                            return $query->whereNull('customer_id')
                                ->where('sub_service_id','=', $fetch_services)
                                ->where('origin','=', $origin)
                                ->whereIn('branch_item', [Auth::User()->oauth_accurate_company])
                                ->where('destination','=', $destination)
                            ;
                        }
                    )
                ->get()
            ;
            
                    foreach ($data_if_null as $query) {

                        $data_if_null[] = ['value' => $query ];
                        
                    }

                return response()->json($data_if_null);

            } 
                else
                        {
                            foreach ($data as $query) {

                                $data[] = (array)['value' => $query ];
                                
                            }

                return response()->json($data);
        }
    
    }

    //isnull_customers
    public function search_if_null_customers_sub_services(Request $request, $id)
    {
      $data = Item_transport::with('sub_services', 'customers')->where('customer_id','=', $id)->get();
      foreach ($data as $query) {
          $results[] = ['value' => $query ];
        }
      return response()->json($data);
    }
    //

    public function choosen_unit_tc()
    {
        $foo = [];

            array_push($foo, (object)[
                    'id'=>'Rit',
                    'name'=>'Rit'
                ], (object)[
                    'id'=>'M³',
                    'name'=>'M³'
                ], (object)[
                    'id'=>'Kg',
                    'name'=>'Kg'
                ], (object)[
                    'id'=>'Koli',
                    'name'=>'Koli'
            ]);

        return response()->json($foo);
    
    }

    public function search_by_items_tcs(Request $request, $id)
    {
      $data = Item_transport::where('origin',$id)->get();
      foreach ($data as $query) {
          $results[] = ['value' => $query ];
        }
      return response()->json($data);
    }

    protected function MascustomerCloud(){

            $getCloudAccurate = $this->openModulesAccurateCloud
                ->FuncOpenmoduleAccurateCloudAllMasterCustomerList(
                    $this->session,
                    $this->fields,
                    $this->date
                )
            ;

        return response()->json($getCloudAccurate->original["d"]);
    }

    public function search_region(Request $request) :JsonResponse
    {
        $APIs = $this->APIntegration::callstaticfunction();
 
        $jsonArray = json_decode($APIs->getContent(), true);
      
        foreach((array)$jsonArray as $key => $indexing){

            $testing[$key] = $indexing;

        }

            if ($testing[0]['check_is'] == "api_izzy") {

                if ($testing[0]['operation'] == "true") {
                    $client = new Client();
                    $response = $client->get('http://api.live.izzytransport.com/company/v1/region/list',
                        [  'headers' => [
                                'Content-Type' => 'application/x-www-form-urlencoded',
                                'X-IzzyTransport-Company-Authkey' => '3d0a42bde6c9121c97639b22f8e7251533009dd7.CA-J1603875874',
                                'Accept' => 'application/json'],
                                'query' => ['limit' => '10',
                                            'page' => '1'
                            ]
                        ]
                    );

                    $jsonArray = json_decode($response->getBody(), true);

                    $data_array = $jsonArray['region'];

                    // dd($data_array);

                    $domps = array();
                    
                            foreach($data_array as $dump) {

                                $domps[] = $dump;

                            }

                            $cari = $request->q;
                  
                        // $data = Customer::with('city')->whereNotNull('customer_id')->get();
                        // $data = Customer::with('city')->whereIn('name', $domps)->where('name', 'LIKE', "%$cari%")->get();
                        $data = Customer::with('city')->where('name', 'LIKE', "%$cari%")->whereIn('branch_item', [Auth::User()->oauth_accurate_company])->get();
                    
                    return response()->json($domps);

                }

            
           }
    }

    public function cari_customers(Request $request) :JsonResponse
    {
        $APIs = $this->APIntegration::callstaticfunction();
 
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
                  
                        // $data = Customer::with('city')->whereNotNull('customer_id')->get();
                        // $data = Customer::with('city')->whereIn('name', $domps)->where('name', 'LIKE', "%$cari%")->get();
                        $data = Customer::with('city')->where('name', 'LIKE', "%$cari%")->whereIn('branch_item', [Auth::User()->oauth_accurate_company])->get();
                    
                    return response()->json($data);

                }

                if ($testing[0]['operation'] == "false") {
                    // $data_customer_transport = Customer_item_transports::with('customers',
                    // 'city_show_it_origin','city_show_it_destination','users')->get();
                    $cari = $request->q;
                    $datamme = [];
                    $ItemTransports = Customer_item_transports::with('customers','city_show_it_origin','city_show_it_destination','users')->get();
                    
                                    foreach($ItemTransports as $fetch_val){

                                        $datamme = $fetch_val->customers['id'];

                                    }

                                $data = Customer::with('city')->whereNotNull('id')->orWhereIn('id', [$datamme])->where('name', 'LIKE', '%'.$cari.'%')->get();

                            // this result for TDD data for local
                            return response()->json($data);
                            
                        /**
                         * Display a listing of the resource.
                         * 
                         * @return warehouse\Http\Controllers\Services\AccuratecloudInterface;
                         */
                    //     foreach($this->MascustomerCloud() as $key => $customer){

                    //         $data_customer[] = $customer;

                    //     }   
                        
                    //         foreach($data_customer as $key => $customers){

                    //             $fetchIndex[$key] = $customers;

                    //         }   

                    // return response()->json($fetchIndex[1]);
                }
           }
    }

    protected function findMasterCloudAccurate($id){

            $getCloudAccurate = $this->openModulesAccurateCloud
                ->FuncOpenmoduleAccurateCloudfindMasterCustomerID(
                    $this->session,
                    $id,
                    $this->date
                )
            ;

        return response()->json($getCloudAccurate->original["d"]);

    }

    public function getIDCusomterCloud($id){

            foreach($this->findMasterCloudAccurate($id) as $key => $customer){

                $data_customer[] = $customer;

            }   
            
                foreach($data_customer as $key => $customers){

                    $fetchIndex[$key] = $customers;

                }   

        return response()->json($fetchIndex[1]);
        // return response()->json($this->findMasterCloudAccurate($id));
    }

    public function cari_customers_by_id($id)
    {
        // [FIX] get per id from accurate cloud
        $data = Customer::findOrFail($id);

        /**
        * Display a listing of the resource.
        * 
        * @return warehouse\Http\Controllers\Services\AccuratecloudInterface;
        */
        // foreach($this->findMasterCloudAccurate($id) as $key => $customer){

        //     $data_customer[] = $customer;

        // }   
            
        //         foreach($data_customer as $key => $customers){

        //             $fetchIndex[$key] = $customers;

        //         }   

        // return response()->json($fetchIndex[1]);

        return response()->json($data);
    }

    public function something($id){
        $data = Customer_pics::where('customer_id','=',$id
        )->orWhere('customer_id', null)->get();
        return response()->Json($data);
    }

    public function include_customers($id){
        $data = Customer::where('id',$id)->get();
        return response()->json($data);
    }

    public function someone_cs($id)
    {
      $data = Customer_pics::select('id', 'name')->where('customer_id', '=',$id)->get();
      foreach ($data as $query) {
          $results[] = ['value' => $query ];
        }
      return response()->json($data);
    }

    protected function generateIDVENDORS(){
        
        $id = Vendor_item_transports::select('id')->max('id');
        $jobs = $id+1;
        $latest_idx_jbs = Vendor::latest()->first();
        $jincrement_idx = $jobs;
        $YM = Carbon::Now()->format('my');
        $prefix = Company_branchs::branchwarehouse($this->pull_branch->session()->get('id'))->first();


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

        return $jobs_order_idx;

    }

    
    // public function add_item_vendors($branch_id, Request $request){

    //     $minimumKategori_2 = (Int) $request->get('Qtyminimum'); 

    //     $minimumKategori_3 = (Int) $request->get('qtyPERTAMA'); 
    //     $RatePertamaKategori_3 = (Int) $request->get('RatePertama'); 

    //     if(!$minimumKategori_2){

    //                 $dataminimum = $minimumKategori_3;

    //         } 
            
    //             else

    //                 {
                        
    //                     $dataminimum = $minimumKategori_2;  
    //     }

    //     $collectdata = collect(['itemMinimumQty' =>$dataminimum, 'rateKgFirst' => $RatePertamaKategori_3]);
    //     $ETA_ = $request->get('eta_');
    //     $ETD_ = $request->get('_etd');

    //     $itemVendors = $this->itemvendors
    //     ->with('item_transport_vendor')
    //         ->get();
        
    //     if($itemVendors->isEmpty()){

    //         $project = ($request->get('Reqvendor')=="null")
    //         ? NULL 
    //         : $request->get('Reqvendor');

    //         $sixdigit = Crypt::encryptString( $this->codes->generate_uuid() );
    //         $master_code = strtoupper(trim(substr($sixdigit, strlen($sixdigit) - 6, strlen($sixdigit)),'=').'-'.Str::random(6));

    //         $getCloudAccurate = $this->openModulesAccurateCloud
    //             ->FuncOpenmoduleAccurateCloudSaveItemBarangjasa__(
    //                 $request->get('Reqitemovdesc'),
    //                 $this->service, 
    //                 $this->date,
    //                 $master_code,
    //                 $request->get('Requnit')
    //             )
    //         ;

    //     $callback_response = $getCloudAccurate->getData("+");

    //         $checkIfEmptyV = isset($callback_response) ? $callback_response : false;

    //                 if(empty($checkIfEmptyV)){

    //                     echo json_encode(
    //                         array('status_SyncAccurate'=> "false"),
    //                         JSON_PRETTY_PRINT
    //                     );

    //                 }
    //                     else 
    //                             {

    //                                 $item = MasterItemTransportX::updateOrCreate(
    //                                         [
    //                                             'item_code' => $master_code,
    //                                             'origin' => $request->get('Reqorigin'),
    //                                             'destination' => $request->get('Reqdestination'),
    //                                             'userid' => Auth::User()->id,
    //                                             'ship_category' => $request->get('Reqshipment_category'),
    //                                             'itemovdesc' => $request->get('Reqitemovdesc'),
    //                                             'unit' => $request->get('Requnit'),
    //                                             'sub_service_id' => $request->get('Reqsubservice'),
    //                                             'moda' => $request->get('Reqmoda'),
    //                                             'vendor_id' => $project,
    //                                             'itemID_accurate' => $getCloudAccurate->original,
    //                                             'flag' => 0
    //                                         ]
    //                                 );
                                            
    //                     $item->save();
        
    //                     $itemTransports = New Vendor_item_transports();
    //                         $itemTransports->item_code = self::generateIDVENDORS();
    //                         $itemTransports->vendor_id = $project;
    //                         $itemTransports->referenceID = $item->id;
    //                         $itemTransports->sub_service_id = $request->get('Reqsubservice');
    //                         $itemTransports->itemovdesc = $request->get('Reqitemovdesc');
    //                         $itemTransports->ship_category = $request->get('Reqshipment_category');
    //                         $itemTransports->moda = $request->get('Reqmoda');
    //                         $itemTransports->usersid = Auth::User()->id;
    //                         $itemTransports->origin = $request->get('Reqorigin');
    //                         $itemTransports->destination = $request->get('Reqdestination');
    //                         $itemTransports->price = $request->get('Reqprice');
    //                         $itemTransports->unit = $request->get('Requnit');
    //                         $itemTransports->batch_itemVendor = $collectdata;
    //                         $itemTransports->itemID_accurate = $getCloudAccurate->original;
    //                     $itemTransports->save();

    //                     echo json_encode(
    //                         array('status_SyncAccurate'=> "true"),
    //                         JSON_PRETTY_PRINT
    //                     )
    //                 ;
            
    //         }

    //     } 
    //         else
    //                 {    

    //                     foreach($itemVendors as $sdasd => $fetchdatOfFields){

    //                         $selfbacktoHack[] = $fetchdatOfFields;
                         
    //                             foreach($fetchdatOfFields['item_transport_vendor'] as $looprows){
    //                                 $sub_serviceID[] = $looprows->sub_service_id;
    //                                 $originID[] = $looprows->origin;
    //                                 $destinationID[] = $looprows->destination;
    //                                 $ship_categoryID[] = $looprows->ship_category;
    //                                 $modaID[] = $looprows->moda;
    //                                 $UNITS[] = $looprows->unit;
    //                             }

    //                     $dataTableItemTransport_Subservice[] = $fetchdatOfFields->sub_service_id; //master item customer of transaction instead master item transport
    //                     $dataTableItemTransport_origin[] = $fetchdatOfFields->origin; //master item customer of transaction instead master item transport
    //                     $dataTableItemTransport_Destination[] = $fetchdatOfFields->destination; //master item customer of transaction instead master item transport
    //                     $dataTableItemTransport_Ship_category[] = $fetchdatOfFields->ship_category; //master item customer of transaction instead master item transport
    //                     $dataTableItemTransport_Modas[] = $fetchdatOfFields->moda; //master item customer of transaction instead master item transport
    //                     $dataTableItemTransport_Unit[] = $fetchdatOfFields->unit; //master item customer of transaction instead master item transport
                       
    //                  }

    //                     $CollectCallbackQuerys = collect([$selfbacktoHack]);

    //                         $SubServiceInsteadOfMasterItemTransportsA = collect([$dataTableItemTransport_Subservice]);
    //                         $SubServiceInsteadOfMasterItemTransportsB = collect([$dataTableItemTransport_origin]);
    //                         $SubServiceInsteadOfMasterItemTransportsC = collect([$dataTableItemTransport_Destination]);
    //                         $SubServiceInsteadOfMasterItemTransportsD = collect([$dataTableItemTransport_Ship_category]);
    //                         $SubServiceInsteadOfMasterItemTransportsE = collect([$dataTableItemTransport_Modas]);
    //                         $SubServiceInsteadOfMasterItemTransportsF = collect([$dataTableItemTransport_Unit]);

    //                     $CollectCallbackQuerys->map(function ($resultsQuery) use ($request, $collectdata,

    //                             $SubServiceInsteadOfMasterItemTransportsA,
    //                             $SubServiceInsteadOfMasterItemTransportsB,
    //                             $SubServiceInsteadOfMasterItemTransportsC,
    //                             $SubServiceInsteadOfMasterItemTransportsD,
    //                             $SubServiceInsteadOfMasterItemTransportsE,
    //                             $SubServiceInsteadOfMasterItemTransportsF
                         
    //                      ) {
    //             if(in_array($request->get('Reqdestination'), $SubServiceInsteadOfMasterItemTransportsC[0]) && in_array($request->get('Reqorigin'), $SubServiceInsteadOfMasterItemTransportsB[0]) && in_array($request->get('Reqsubservice'), $SubServiceInsteadOfMasterItemTransportsA[0]) && in_array($request->get('Reqshipment_category'), $SubServiceInsteadOfMasterItemTransportsD[0]) && in_array($request->get('Reqmoda'), $SubServiceInsteadOfMasterItemTransportsE[0]) && in_array($request->get('Requnit'), $SubServiceInsteadOfMasterItemTransportsF[0])){
                        
    //                     $dataItem = MasterItemTransportX::
    //                                     when($request->has('Reqsubservice') && $request->has('Reqorigin') && $request->has('Reqdestination') && $request->has('Reqshipment_category') && $request->has('Reqmoda') && $request->has('Requnit'), function ($que) use ($request){
    //                                         return $que->where('sub_service_id','=',$request->get('Reqsubservice'))
    //                                                     ->where('origin', '=',$request->get('Reqorigin'))
    //                                                     ->where('ship_category', '=',$request->get('Reqshipment_category'))
    //                                                     ->where('moda', '=',$request->get('Reqmoda'))
    //                                                     ->where('unit', '=',$request->get('Requnit'))
    //                                                     ->where('destination','=', $request->get('Reqdestination'));
    //                                     }   
    //                                 )

    //                             ->first()
    //                         ;

    //                     } 
    //                         else {
                                
    //                                 $dataItem = false;

    //                     }

    //                         if($dataItem == false) {

    //                             $project = ($request->get('Reqvendor')=="null")
    //                             ? NULL 
    //                             : $request->get('Reqvendor');

    //                             $sixdigit = Crypt::encryptString( $this->codes->generate_uuid() );
    //                             $master_code = strtoupper(trim(substr($sixdigit, strlen($sixdigit) - 6, strlen($sixdigit)),'=').'-'.Str::random(6));

    //                             $getCloudAccurate = $this->openModulesAccurateCloud
    //                                                     ->FuncOpenmoduleAccurateCloudSaveItemBarangjasa__(
    //                                                         $request->get('Reqitemovdesc'),
    //                                                         $this->service, 
    //                                                         $this->date,
    //                                                         $master_code,
    //                                                         $request->get('Requnit')
    //                                                     )
    //                                                 ;

    //                             $callback_response = $getCloudAccurate->getData("+");

    //                         $check_process = isset($callback_response) ? $callback_response : false;

    //                                 if(empty($check_process)){

    //                                         echo json_encode(
    //                                             array('status_SyncAccurate'=> "false"),
    //                                             JSON_PRETTY_PRINT
    //                                         )
    //                                     ;

    //                                 }
    //                                     else
    //                                             {

    //                                                 $item = MasterItemTransportX::updateOrCreate(
    //                                                             [
    //                                                                 'item_code' => $check_process,
    //                                                                 'origin' => $request->get('Reqorigin'),
    //                                                                 'destination' => $request->get('Reqdestination'),
    //                                                                 'userid' => Auth::User()->id,
    //                                                                 'ship_category' => $request->get('Reqshipment_category'),
    //                                                                 'itemovdesc' => $request->get('Reqitemovdesc'),
    //                                                                 'unit' => $request->get('Requnit'),
    //                                                                 'sub_service_id' => $request->get('Reqsubservice'),
    //                                                                 'moda' => $request->get('Reqmoda'),
    //                                                                 'vendor_id' => $project,
    //                                                                 'itemID_accurate' => $getCloudAccurate->original,
    //                                                                 'flag'   => 0
    //                                                             ]
    //                                                 );
                                                
    //                                     $item->save();

    //                                         $itemTransports = New Vendor_item_transports();
    //                                         $itemTransports->item_code = self::generateIDVENDORS();
    //                                         $itemTransports->vendor_id = $project;
    //                                         $itemTransports->referenceID = $item->id;
    //                                         $itemTransports->sub_service_id = $request->get('Reqsubservice');
    //                                         $itemTransports->itemovdesc = $request->get('Reqitemovdesc');
    //                                         $itemTransports->ship_category = $request->get('Reqshipment_category');
    //                                         $itemTransports->moda = $request->get('Reqmoda');
    //                                         $itemTransports->usersid = Auth::User()->id;
    //                                         $itemTransports->origin = $request->get('Reqorigin');
    //                                         $itemTransports->destination = $request->get('Reqdestination');
    //                                         $itemTransports->price = $request->get('Reqprice');
    //                                         $itemTransports->unit = $request->get('Requnit');
    //                                         $itemTransports->batch_itemVendor = $collectdata;
    //                                         $itemTransports->itemID_accurate = $getCloudAccurate->original;
    //                                         $itemTransports->save();

    //                                     echo json_encode(
    //                                         array('status_SyncAccurate'=> "true"),
    //                                         JSON_PRETTY_PRINT
    //                                     );

    //                             }

    //                         } 
    //                             else 
    //                                     {
                                        
    //                                         $project = ($request->get('Reqvendor')=="null")
    //                                         ? NULL 
    //                                         : $request->get('Reqvendor');

    //                                         $sixdigit = Crypt::encryptString( $this->codes->generate_uuid() );
    //                                         $master_code = strtoupper(trim(substr($sixdigit, strlen($sixdigit) - 6, strlen($sixdigit)),'=').'-'.Str::random(6));
            
    //                                         $getCloudAccurate = $this->openModulesAccurateCloud
    //                                                                 ->FuncOpenmoduleAccurateCloudSaveItemBarangjasa__(
    //                                                                     $request->get('Reqitemovdesc'),
    //                                                                     $this->service, 
    //                                                                     $this->date,
    //                                                                     $master_code,
    //                                                                     $request->get('Requnit')
    //                                                                 )
    //                                                             ;
                                            
    //                                             $callback_response = $getCloudAccurate->getData("+");

    //                                     $checkVifTheSame = isset($callback_response) ? $callback_response : false;
                                                                    
    //                                         if(empty($checkVifTheSame)) {

    //                                                 echo json_encode(
    //                                                     array('status_SyncAccurate'=> "false"),
    //                                                     JSON_PRETTY_PRINT
    //                                                 );

    //                                         }

    //                                             else {

    //                                                     $fetchMasterItemID = MasterItemTransportX::
    //                                                         when($request->has('Reqsubservice') && $request->has('Reqorigin') && $request->has('Reqdestination') && $request->has('Reqshipment_category') && $request->has('Reqmoda') && $request->has('Requnit'), function ($que) use ($request){
    //                                                             return $que->where('sub_service_id','=',$request->get('Reqsubservice'))
    //                                                                         ->where('origin', '=',$request->get('Reqorigin'))
    //                                                                         ->where('ship_category', '=',$request->get('Reqshipment_category'))
    //                                                                         ->where('moda', '=',$request->get('Reqmoda'))
    //                                                                         ->where('unit', '=',$request->get('Requnit'))
    //                                                                         ->where('destination','=', $request->get('Reqdestination')); 
    //                                                             }   
    //                                                         )
        
    //                                                     ->first()
    //                                                 ;

    //                                             $itemTransports = New Vendor_item_transports();
    //                                                 $itemTransports->item_code = self::generateIDVENDORS();
    //                                                 $itemTransports->vendor_id = $project;
    //                                                 $itemTransports->referenceID = $fetchMasterItemID->id;
    //                                                 $itemTransports->sub_service_id = $request->get('Reqsubservice');
    //                                                 $itemTransports->itemovdesc = $request->get('Reqitemovdesc');
    //                                                 $itemTransports->ship_category = $request->get('Reqshipment_category');
    //                                                 $itemTransports->moda = $request->get('Reqmoda');
    //                                                 $itemTransports->usersid = Auth::User()->id;
    //                                                 $itemTransports->origin = $request->get('Reqorigin');
    //                                                 $itemTransports->destination = $request->get('Reqdestination');
    //                                                 $itemTransports->price = $request->get('Reqprice');
    //                                                 $itemTransports->unit = $request->get('Requnit');
    //                                                 $itemTransports->batch_itemVendor = $collectdata;
    //                                                 $itemTransports->itemID_accurate = $fetchMasterItemID->itemID_accurate;
    //                                         $itemTransports->save();

    //                                         echo json_encode(
    //                                             array('status_SyncAccurate'=> "true"),
    //                                             JSON_PRETTY_PRINT
    //                                         )
    //                                     ;
    //                                 }
    //                             }
    //                       }
    //                  )
    //             ;
    //         }
    //  }


    public function add_item_vendors($branch_id, Request $request){

        $minimumKategori_2 = (Int)$request->get('Qtyminimum'); 

        $minimumKategori_3 = (Int)$request->get('qtyPERTAMA'); 
        $RatePertamaKategori_3 = (Int)$request->get('RatePertama'); 

        if(!$minimumKategori_2){
            $dataminimum = $minimumKategori_3; 
                } else {
            $dataminimum = $minimumKategori_2;  
        }
        // $RateSelanjutnyaKategori_3 = (Int)$request->get('RateSelanjutnya'); 
        $collectdata = collect(['itemMinimumQty' =>$dataminimum, 'rateKgFirst' => $RatePertamaKategori_3]);
        $ETA_ = $request->get('eta_');
        $ETD_ = $request->get('_etd');

        $itemCustomer = $this->itemvendors
        ->with('item_transport_vendor')
            ->get(); //instead model item_transport
        
        if($itemCustomer->isEmpty())
            
            {

                $loop = Factory::create();

                    $handler = new CurlMultiHandler();
                    $timer = $loop->addPeriodicTimer(1, \Closure::bind(function () use (&$timer) {
                            $this->tick();
                            if (empty($this->handles) && \GuzzleHttp\Promise\queue()->isEmpty()) {
                                $timer->cancel();
                            }
                        }, $handler, $handler)
                    );

                $loop->run();

                $project = ($request->get('Reqvendor')=="null")
                ? NULL 
                : $request->get('Reqvendor');
                $sixdigit = Crypt::encryptString( $this->codes->generate_uuid() );
                $master_code = strtoupper(trim(substr($sixdigit, strlen($sixdigit) - 6, strlen($sixdigit)),'=').'-'.Str::random(6));

                    $getCloudAccurate = $this->openModulesAccurateCloud
                        ->FuncOpenmoduleAccurateCloudSaveItemBarangjasa__(
                            $request->get('Reqitemovdesc'),
                            $this->service, 
                            $this->date,
                            $master_code,
                            $request->get('Requnit')
                        )
                    ;

                $callback_response = $getCloudAccurate->getData("+");

                $checkIfEmptyprocess = isset($callback_response) ? $callback_response : false;

                if(empty($checkIfEmptyprocess)){

                    echo json_encode(
                        array('status_SyncAccurate'=> "false"),
                        JSON_PRETTY_PRINT
                    );

                } 
                    else {

                            $item = MasterItemTransportX::updateOrCreate(
                                    [
                                        'item_code' => $master_code,
                                        'origin' => $request->get('Reqorigin'),
                                        'destination' => $request->get('Reqdestination'),
                                        'userid' => Auth::User()->id,
                                        'ship_category' => $request->get('Reqshipment_category'),
                                        'itemovdesc' => $request->get('Reqitemovdesc'),
                                        'unit' => $request->get('Requnit'),
                                        'sub_service_id' => $request->get('Reqsubservice'),
                                        'moda' => $request->get('Reqmoda'),
                                        'vendor_id' => $project,
                                        'itemID_accurate' => $checkIfEmptyprocess["r"]["no"],
                                        'flag' => 0
                                    ]
                            );
                                        
                            $item->save();
            
                            $itemTransports = New Vendor_item_transports();
                            $itemTransports->item_code = $item->itemID_accurate;
                            $itemTransports->vendor_id = $item->vendor_id;
                            $itemTransports->referenceID = $item->id;
                            $itemTransports->sub_service_id = $item->sub_service_id;
                            $itemTransports->itemovdesc = $item->itemovdesc;
                            $itemTransports->ship_category = $item->ship_category;
                            $itemTransports->moda = $item->moda;
                            $itemTransports->usersid = Auth::User()->id;
                            $itemTransports->origin = $item->origin;
                            $itemTransports->destination = $item->destination;
                            $itemTransports->price = $request->get('Reqprice') === null ? $request->get('RatePertama') : $request->get('Reqprice');
                            $itemTransports->unit = $item->unit;
                            $itemTransports->batch_itemVendor = $collectdata;
                            $itemTransports->itemID_accurate = $checkIfEmptyprocess["r"]["no"];
                            $itemTransports->save();

                            echo json_encode(
                                array('status_SyncAccurate'=> "true"),
                                JSON_PRETTY_PRINT
                            );
                 }
    
        } 
            else
                    {    
                        foreach($itemCustomer as $sdasd => $fetchdatOfFields){

                            $selfbacktoHack[] = $fetchdatOfFields;
                         
                                foreach($fetchdatOfFields['item_transport_vendor'] as $looprows){
                                    $sub_serviceID[] = $looprows->sub_service_id;
                                    $originID[] = $looprows->origin;
                                    $destinationID[] = $looprows->destination;
                                    $ship_categoryID[] = $looprows->ship_category;
                                    $modaID[] = $looprows->moda;
                                    $UNITS[] = $looprows->unit;
                                }

                            $dataTableItemTransport_Subservice[] = $fetchdatOfFields->sub_service_id; //master item customer of transaction instead master item transport
                            $dataTableItemTransport_origin[] = $fetchdatOfFields->origin; //master item customer of transaction instead master item transport
                            $dataTableItemTransport_Destination[] = $fetchdatOfFields->destination; //master item customer of transaction instead master item transport
                            $dataTableItemTransport_Ship_category[] = $fetchdatOfFields->ship_category; //master item customer of transaction instead master item transport
                            $dataTableItemTransport_Modas[] = $fetchdatOfFields->moda; //master item customer of transaction instead master item transport
                            $dataTableItemTransport_Unit[] = $fetchdatOfFields->unit; //master item customer of transaction instead master item transport
                            $dataTableItemTransport_itemovdesc[] = $fetchdatOfFields->itemovdesc; //master item customer of transaction instead master item transport
                        }

                        $CollectCallbackQuerys = collect([$selfbacktoHack]);

                        $SubServiceInsteadOfMasterItemTransportsA = collect([$dataTableItemTransport_Subservice]);
                        $SubServiceInsteadOfMasterItemTransportsB = collect([$dataTableItemTransport_origin]);
                        $SubServiceInsteadOfMasterItemTransportsC = collect([$dataTableItemTransport_Destination]);
                        $SubServiceInsteadOfMasterItemTransportsD = collect([$dataTableItemTransport_Ship_category]);
                        $SubServiceInsteadOfMasterItemTransportsE = collect([$dataTableItemTransport_Modas]);
                        $SubServiceInsteadOfMasterItemTransportsF = collect([$dataTableItemTransport_Unit]);
                        $SubServiceInsteadOfMasterItemTransportsG = collect([$dataTableItemTransport_itemovdesc]);

                        $CollectCallbackQuerys->map(function ($resultsQuery) use ($request, $collectdata,

                                $SubServiceInsteadOfMasterItemTransportsA,
                                $SubServiceInsteadOfMasterItemTransportsB,
                                $SubServiceInsteadOfMasterItemTransportsC,
                                $SubServiceInsteadOfMasterItemTransportsD,
                                $SubServiceInsteadOfMasterItemTransportsE,
                                $SubServiceInsteadOfMasterItemTransportsF,
                                $SubServiceInsteadOfMasterItemTransportsG
                         
                         ) {

                if(in_array($request->get('Reqitemovdesc'), $SubServiceInsteadOfMasterItemTransportsG[0]) && in_array($request->get('Reqdestination'), $SubServiceInsteadOfMasterItemTransportsC[0]) && in_array($request->get('Reqorigin'), $SubServiceInsteadOfMasterItemTransportsB[0]) && in_array($request->get('Reqsubservice'), $SubServiceInsteadOfMasterItemTransportsA[0]) && in_array($request->get('Reqshipment_category'), $SubServiceInsteadOfMasterItemTransportsD[0]) && in_array($request->get('Reqmoda'), $SubServiceInsteadOfMasterItemTransportsE[0]) && in_array($request->get('Requnit'), $SubServiceInsteadOfMasterItemTransportsF[0])){
                        
                        $dataItem = MasterItemTransportX::
                                        when($request->has('Reqitemovdesc') && $request->has('Reqsubservice') && $request->has('Reqorigin') && $request->has('Reqdestination') && $request->has('Reqshipment_category') && $request->has('Reqmoda') && $request->has('Requnit'), function ($que) use ($request){
                                            return $que->where('sub_service_id','=',$request->get('Reqsubservice'))
                                                        // ->where('customer_id','=', $project)
                                                        ->where('origin', '=',$request->get('Reqorigin'))
                                                        ->where('ship_category', '=',$request->get('Reqshipment_category'))
                                                        ->where('moda', '=',$request->get('Reqmoda'))
                                                        ->where('unit', '=',$request->get('Requnit'))
                                                        ->whereIn('itemovdesc', [$request->get('Reqitemovdesc')])
                                                        ->where('destination','=', $request->get('Reqdestination'));
                                        }   
                                    )

                                ->first()
                            ;

                    } 
                            else {
                                
                                $dataItem = null;

                        }
                        

                            //by default: secara sistem akan melakukan pengecekkan data yanb diterima oleh client apakah ada atau tidak[tidak]
                if(is_null($dataItem)) {

                                $project = ($request->get('Reqvendor')=="null")
                                ? NULL 
                                : $request->get('Reqvendor');
                                $sixdigit = Crypt::encryptString( $this->codes->generate_uuid() );
                                $master_code = strtoupper(trim(substr($sixdigit, strlen($sixdigit) - 6, strlen($sixdigit)),'=').'-'.Str::random(6));
                                

                                    $project = ($request->get('Reqvendor')=="null")
                                    ? NULL 
                                    : $request->get('Reqvendor');
                                    
                                    $sixdigit = Crypt::encryptString( $this->codes->generate_uuid() );
                                    $master_code = strtoupper(trim(substr($sixdigit, strlen($sixdigit) - 6, strlen($sixdigit)),'=').'-'.Str::random(6));

                                    $fetchMasterItemID = Vendor_item_transports::where([
                                            'vendor_id' => $project,
                                            'sub_service_id' => $request->get('Reqsubservice'),
                                            'ship_category' => $request->get('Reqshipment_category'),
                                            'moda' => $request->get('Reqmoda'),
                                            'origin' => $request->get('Reqorigin'),
                                            'unit' => $request->get('Requnit'),
                                            // 'price' => $request->get('Reqprice'),
                                            'price' => (Int)  $request->get('Reqprice') === null ? $request->get('RatePertama') : $request->get('Reqprice'),
                                            'itemovdesc' => $request->get('Reqitemovdesc')
                                    ])->first();
                                    
                                    $destination = $request->get('Reqdestination');
                                    $subservice = $request->get('Reqsubservice');
                                    $shipment_category = $request->get('Reqshipment_category');
                                    $moda = $request->get('Reqmoda');
                                    $origin = $request->get('Reqorigin');
                                    $unit = $request->get('Requnit');
                                    $price = $request->get('Reqprice');
                                    $itemovdesc = $request->get('Reqitemovdesc');

                                // jika data tidak sama fetchMasterItemID == null
                                if(is_null($fetchMasterItemID)){

                                    $item = MasterItemTransportX::UpdateOrInserted(
                                        [
                                            'itemovdesc' => $itemovdesc
                                        ],
                                            [
                                                'item_code' => $master_code,
                                                'origin' => $origin,
                                                'destination' => $destination,
                                                'userid' => Auth::User()->id,
                                                'ship_category' => $shipment_category,
                                                'itemovdesc' => $itemovdesc,
                                                'unit' => $unit,
                                                'sub_service_id' => $subservice,
                                                'moda' => $moda,
                                                // 'price' => (Int) $request->get('RatePertama'),
                                                'price' => (Int)  $request->get('Reqprice') === null ? $request->get('RatePertama') : $request->get('Reqprice'),
                                                'vendor_id' => $project,
                                                'itemID_accurate' => $master_code,
                                                'flag'   => 12
                                            ]
                                    );

                                    Vendor_item_transports::UpdateOrInserted(
                                        [
                                            'itemovdesc' => $itemovdesc
                                        ],
                                            [
                                                'referenceID' => $item->id,
                                                'item_code' => $item->item_code,
                                                'origin' => $item->origin,
                                                'destination' => $item->destination,
                                                'usersid' => Auth::User()->id,
                                                'ship_category' => $item->ship_category,
                                                'itemovdesc' => $item->itemovdesc,
                                                'unit' => $item->unit,
                                                'sub_service_id' => $item->sub_service_id,
                                                'moda' => $item->moda,
                                                'batch_itemVendor' => $collectdata,
                                                'price' => (Int)  $request->get('Reqprice') === null ? $request->get('RatePertama') : $request->get('Reqprice'),
                                                'vendor_id' => $item->customer_id,
                                                'itemID_accurate' => $item->itemID_accurate,
                                                'flag'   => 34
                                            ]
                                        )
                                    ;

                                      
                                    if(is_null($project)){

                                        $itemCode = $item->itemID_accurate;
                                        $harga = $request->get('Reqprice');
                                        $name = $request->get('Reqitemovdesc');
                                        
                                            $barangJasa__ = new Promise(
                                                            function () use (&$barangJasa__, &$itemCode, &$dataminimum, &$harga, &$name) {
                                                                $barangJasa__->resolve($this->UpdateSyncBarangJasaVendor($itemCode, $dataminimum, $harga, $name));
                                
                                                            },
                                                            function ($ex) {
                                                                $barangJasa__->reject($ex);
                                                            }
                                                        );
                                                                    
                                                $promise = $barangJasa__->wait()->original;
                                        
                                        
                                        if($promise["s"] == false){

                                                $getCloudAccurate = $this->openModulesAccurateCloud
                                                    ->FuncOpenmoduleAccurateCloudSaveItemBarangjasa__(
                                                        $request->get('Reqitemovdesc'),
                                                        $this->service, 
                                                        $this->date,
                                                        $itemCode,
                                                        $request->get('Requnit')
                                                    )
                                                ;
                                                        
                                                $callback_response = $getCloudAccurate->getData("+");

                                                    $check_process = isset($callback_response) ? $callback_response : false;
    
                                                        if(empty($check_process)){

                                                            $barangJasa__ = new Promise(
                                                                function () use (&$barangJasa__, &$itemCode, &$dataminimum, &$harga, &$name) {
                                                                    $barangJasa__->resolve($this->UpdateSyncBarangJasaVendor($itemCode, $dataminimum, $harga, $name));
                                    
                                                                },
                                                                function ($ex) {
                                                                    $barangJasa__->reject($ex);
                                                                }
                                                            );
                                                                        
                                                        $barangJasa__->wait()->original;
        
                                                                    echo json_encode(
                                                                        array('status_SyncAccurate'=> "true"),
                                                                        JSON_PRETTY_PRINT
                                                                    );
        
                                                                echo json_encode(
                                                                    array('data_internal'=> "data telah diupdate diaccurate."),
                                                                    JSON_PRETTY_PRINT
                                                                );
                                                            
                                                        } 
                                                            else {
    
                                                                MasterItemTransportX::UpdateOrInserted(
                                                                    [
                                                                        'itemovdesc' => $request->get('Reqitemovdesc')
                                                                    ],
                                                                        [
                                                                            'item_code' => $check_process["r"]["no"],
                                                                            'origin' => $request->get('Reqorigin'),
                                                                            'destination' => $request->get('Reqdestination'),
                                                                            'userid' => Auth::User()->id,
                                                                            'ship_category' => $request->get('Reqshipment_category'),
                                                                            'itemovdesc' => $request->get('Reqitemovdesc'),
                                                                            'unit' => $request->get('Requnit'),
                                                                            'sub_service_id' => $request->get('Reqsubservice'),
                                                                            'moda' => $request->get('Reqmoda'),
                                                                            'vendor_id' => $project,
                                                                            'itemID_accurate' => $check_process["r"]["no"],
                                                                        ]
                                                                );

                                                                // dd("bug 4");
                                                        }

                                                } 


                                            } 
                                                else {

                                                        $itemCustomers = Vendor_item_transports::UpdateOrInserted(
                                                            [
                                                                'itemovdesc' => $request->get('Reqitemovdesc')
                                                            ],
                                                                [   
                                                                    'item_code' => $item->itemID_accurate,
                                                                    'referenceID' => $item->id,
                                                                    'origin' => $request->get('Reqorigin'),
                                                                    'destination' => $request->get('Reqdestination'),
                                                                    'usersid' => Auth::User()->id,
                                                                    'ship_category' => $request->get('Reqshipment_category'),
                                                                    'itemovdesc' => $item->itemovdesc,
                                                                    'unit' => $request->get('Requnit'),
                                                                    'sub_service_id' => $request->get('Reqsubservice'),
                                                                    'moda' => $request->get('Reqmoda'),
                                                                    // 'price' => $request->get('Reqprice'),
                                                                    'price' => (Int)  $request->get('Reqprice') === null ? $request->get('RatePertama') : $request->get('Reqprice'),
                                                                    'batch_itemVendor' => $collectdata,
                                                                    'vendor_id' => $project,
                                                                    'itemID_accurate' => $item->itemID_accurate,
                                                                ]
                                                        );
                                                        
                                                            $barangJasa__ = new Promise(
                                                                            function () use (&$barangJasa__, &$master_code, &$dataminimum, &$harga, &$name) {
                                                                                $barangJasa__->resolve($this->UpdateSyncBarangJasaVendor($master_code, $dataminimum, $harga, $name));
                                                
                                                                            },
                                                                            function ($ex) {
                                                                                $barangJasa__->reject($ex);
                                                                            }
                                                                        );
                                                                                    
                                                                $promise = $barangJasa__->wait()->original;
                                                        
                                                            $itemCode = $itemCustomers->itemID_accurate;
                                                        
                                                        if($promise["s"] == false){

                                                                $getCloudAccurate = $this->openModulesAccurateCloud
                                                                    ->FuncOpenmoduleAccurateCloudSaveItemBarangjasa__(
                                                                        $request->get('Reqitemovdesc'),
                                                                        $this->service, 
                                                                        $this->date,
                                                                        $itemCustomers->itemID_accurate,
                                                                        $request->get('Requnit')
                                                                    )
                                                                ;
                                                                        
                                                                $callback_response = $getCloudAccurate->getData("+");

                                                                    $check_process = isset($callback_response) ? $callback_response : false;
                    
                                                                        if(empty($check_process)){

                                                                            $barangJasa__ = new Promise(
                                                                                function () use (&$barangJasa__, &$itemCode, &$dataminimum, &$harga, &$name) {
                                                                                    $barangJasa__->resolve($this->UpdateSyncBarangJasaVendor($itemCode, $dataminimum, $harga, $name));
                                                    
                                                                                },
                                                                                function ($ex) {
                                                                                    $barangJasa__->reject($ex);
                                                                                }
                                                                            );
                                                                                        
                                                                    $barangJasa__->wait()->original;
                    
                                                                                echo json_encode(
                                                                                    array('status_SyncAccurate'=> "false"),
                                                                                    JSON_PRETTY_PRINT
                                                                                );
                    
                                                                            echo json_encode(
                                                                                array('data_internal'=> "maaf ada data yang tidak sinkron dengan accurate."),
                                                                                JSON_PRETTY_PRINT
                                                                            );
                                                                        
                                                                        } 
                                                                            else {
                    
                                                                                MasterItemTransportX::UpdateOrInserted(
                                                                                    [
                                                                                        'itemovdesc' => $request->get('Reqitemovdesc')
                                                                                    ],
                                                                                        [
                                                                                            'item_code' => $itemCode,
                                                                                            'origin' => $request->get('Reqorigin'),
                                                                                            'destination' => $request->get('Reqdestination'),
                                                                                            'userid' => Auth::User()->id,
                                                                                            'ship_category' => $request->get('Reqshipment_category'),
                                                                                            'itemovdesc' => $request->get('Reqitemovdesc'),
                                                                                            'unit' => $request->get('Requnit'),
                                                                                            'sub_service_id' => $request->get('Reqsubservice'),
                                                                                            'moda' => $request->get('Reqmoda'),
                                                                                            'vendor_id' => $project,
                                                                                            'itemID_accurate' => $itemCode,
                                                                                        ]
                                                                                );

                                                                                // dd("bug 4");
                                                                        }

                                                            } 
                                                }
                                                echo json_encode(
                                                    array('status_SyncAccurate'=> "true",
                                                        'fullfield' => "queue start"),
                                                    JSON_PRETTY_PRINT
                                            );
                                             
                                        } //jika data data yang sama fetchMasterItemID != null

                                            else {

                                                //cek jika ada sama, kemudian melakukan pengecekan apakah didalam terdapat customer kontrak/publish. [null]
                                                if(is_null($fetchMasterItemID->customer_id)){

                                                        //cek request, kemudian melakukan pengecekan apakah request customer null / tidak.
                                                        if(is_null($project)){

                                                                // $itemTransports = Customer_item_transports::findOrFail($fetchMasterItemID->id);
                                                                //     // $itemTransports->item_code = self::generateID();
                                                                //         $itemTransports->referenceID = $fetchMasterItemID->id;
                                                                //         $itemTransports->sub_service_id = $request->get('Reqsubservice');
                                                                //         $itemTransports->itemovdesc = $request->get('Reqitemovdesc');
                                                                //         $itemTransports->ship_category = $request->get('Reqshipment_category');
                                                                //         $itemTransports->moda = $request->get('Reqmoda');
                                                                //         $itemTransports->usersid = Auth::User()->id;
                                                                //         $itemTransports->origin = $request->get('Reqorigin');
                                                                //         $itemTransports->destination = $request->get('Reqdestination');
                                                                //         $itemTransports->price = $request->get('Reqprice');
                                                                //         $itemTransports->unit = $request->get('Requnit');
                                                                //         $itemTransports->batch_itemCustomer = $collectdata;
                                                                //     $itemTransports->itemID_accurate = $fetchMasterItemID->itemID_accurate;
                                                                // $itemTransports->save();

                                                                // $itemID_accurate = $fetchMasterItemID->itemID_accurate;
                                                                // $harga = $request->get('Reqprice');
                                                                // $name = $request->get('Reqitemovdesc');

                                                                // $barangJasa__ = new Promise(
                                                                //     function () use (&$barangJasa__, &$itemID_accurate, &$dataminimum, &$harga, &$name) {
                                                                //         $barangJasa__->resolve($this->UpdateSyncBarangJasaCustomer($itemID_accurate, $dataminimum, $harga, $name));
                                        
                                                                //     },
                                                                //     function ($ex) {
                                                                //         $barangJasa__->reject($ex);
                                                                //     }
                                                                // );
                                                                
                                                                // $barangJasa__->wait()->original["d"][0];

                                                            $getCloudAccurate = $this->openModulesAccurateCloud
                                                                ->FuncOpenmoduleAccurateCloudSaveItemBarangjasa__(
                                                                    $request->get('Reqitemovdesc'),
                                                                    $this->service, 
                                                                    $this->date,
                                                                    $master_code,
                                                                    $request->get('Requnit')
                                                                )
                                                            ;

                                                            $callback_response = $getCloudAccurate->getData("+");
                    
                                                                $check_process = isset($callback_response) ? $callback_response : false;
                
                                                                    if(empty($check_process)){
                
                                                                            echo json_encode(
                                                                                array('status_SyncAccurate'=> "false"),
                                                                                JSON_PRETTY_PRINT
                                                                            );
                
                                                                        echo json_encode(
                                                                            array('data_internal'=> "maaf ada data yang tidak sinkron dengan accurate."),
                                                                            JSON_PRETTY_PRINT
                                                                        );
                                                                    
                                                                    } 
                                                                        else {
                
                                                                                $item = MasterItemTransportX::updateOrCreate(
                                                                                    [
                                                                                        'item_code' => $check_process,
                                                                                        'origin' => $request->get('Reqorigin'),
                                                                                        'destination' => $request->get('Reqdestination'),
                                                                                        'userid' => Auth::User()->id,
                                                                                        'ship_category' => $request->get('Reqshipment_category'),
                                                                                        'itemovdesc' => $request->get('Reqitemovdesc'),
                                                                                        'unit' => $request->get('Requnit'),
                                                                                        'sub_service_id' => $request->get('Reqsubservice'),
                                                                                        'moda' => $request->get('Reqmoda'),
                                                                                        'vendor_id' => $project,
                                                                                        'itemID_accurate' => $check_process,
                                                                                        'flag'   => 0
                                                                                    ]
                                                                                );
                                                                            
                                                                                    $item->save();
                                    
                                                                                            $itemTransports = New Vendor_item_transports();
                                                                                            $itemTransports->item_code = self::generateID();
                                                                                            $itemTransports->vendor_id = $project;
                                                                                            $itemTransports->referenceID = $item->id;
                                                                                            $itemTransports->sub_service_id = $request->get('Reqsubservice');
                                                                                            $itemTransports->itemovdesc = $request->get('Reqitemovdesc');
                                                                                            $itemTransports->ship_category = $request->get('Reqshipment_category');
                                                                                            $itemTransports->moda = $request->get('Reqmoda');
                                                                                            $itemTransports->usersid = Auth::User()->id;
                                                                                            $itemTransports->origin = $request->get('Reqorigin');
                                                                                            $itemTransports->destination = $request->get('Reqdestination');
                                                                                            $itemTransports->price = $request->get('Reqprice');
                                                                                            $itemTransports->unit = $request->get('Requnit');
                                                                                            $itemTransports->batch_itemVendor = $collectdata;
                                                                                            $itemTransports->itemID_accurate = $check_process;
                                                                                            $itemTransports->save();
                        
                                                                                // echo json_encode(
                                                                                //     array('status_SyncAccurate'=> "true"),
                                                                                //     JSON_PRETTY_PRINT
                                                                                // );

                                                                                // dd("bug 2");

                
                                                                        }

                                                            echo json_encode(
                                                                array('status_SyncAccurate'=> "true"),
                                                                JSON_PRETTY_PRINT
                                                            );
                                                        //cek request, kemudian melakukan pengecekan apakah request customer null / tidak [ request customer != null]
                                                        }
                                                            else {

                                                                $getCloudAccurate = $this->openModulesAccurateCloud
                                                                    ->FuncOpenmoduleAccurateCloudSaveItemBarangjasa__(
                                                                        $request->get('Reqitemovdesc'),
                                                                        $this->service, 
                                                                        $this->date,
                                                                        $master_code,
                                                                        $request->get('Requnit')
                                                                    )
                                                                ;

                                                                $callback_response = $getCloudAccurate->getData("+");
                        
                                                                    $check_process = isset($callback_response) ? $callback_response : false;
                    
                                                                        if(empty($check_process)){
                    
                                                                                echo json_encode(
                                                                                    array('status_SyncAccurate'=> "false"),
                                                                                    JSON_PRETTY_PRINT
                                                                                );
                    
                                                                            echo json_encode(
                                                                                array('data_internal'=> "maaf ada data yang tidak sinkron dengan accurate."),
                                                                                JSON_PRETTY_PRINT
                                                                            );
                                                                        
                                                                        } 
                                                                            else {
                    
                                                                                    $item = MasterItemTransportX::updateOrCreate(
                                                                                        [
                                                                                            'item_code' => $check_process,
                                                                                            'origin' => $request->get('Reqorigin'),
                                                                                            'destination' => $request->get('Reqdestination'),
                                                                                            'userid' => Auth::User()->id,
                                                                                            'ship_category' => $request->get('Reqshipment_category'),
                                                                                            'itemovdesc' => $request->get('Reqitemovdesc'),
                                                                                            'unit' => $request->get('Requnit'),
                                                                                            'sub_service_id' => $request->get('Reqsubservice'),
                                                                                            'moda' => $request->get('Reqmoda'),
                                                                                            'vendor_id' => $project,
                                                                                            'itemID_accurate' => $check_process,
                                                                                            'flag'   => 21
                                                                                        ]
                                                                                    );
                                                                                
                                                                                        // $item->save();
                                        
                                                                                    Vendor_item_transports::UpdateOrInserted(
                                                                                        [
                                                                                            'itemovdesc' => $request->get('Reqitemovdesc')
                                                                                        ],
                                                                                            [   
                                                                                                'item_code' => $itemCode,
                                                                                                'referenceID' => $item->id,
                                                                                                'origin' => $request->get('Reqorigin'),
                                                                                                'destination' => $request->get('Reqdestination'),
                                                                                                'usersid' => Auth::User()->id,
                                                                                                'batch_itemVendor' => $collectdata,
                                                                                                'ship_category' => $request->get('Reqshipment_category'),
                                                                                                'itemovdesc' => $item->itemovdesc,
                                                                                                'unit' => $request->get('Requnit'),
                                                                                                'sub_service_id' => $request->get('Reqsubservice'),
                                                                                                'moda' => $request->get('Reqmoda'),
                                                                                                // 'price' => $request->get('Reqprice'),
                                                                                                'price' => (Int)  $request->get('Reqprice') === null ? $request->get('RatePertama') : $request->get('Reqprice'),
                                                                                                'vendor_id' => $project,
                                                                                                'itemID_accurate' => $itemCode,
                                                                                            ]
                                                                                    );
                            
                                                                                    // echo json_encode(
                                                                                    //     array('status_SyncAccurate'=> "true"),
                                                                                    //     JSON_PRETTY_PRINT
                                                                                    // );

                                                                                    // dd("bug 3");
                    
                                                                            }

                                                                // #method customer contract done 0
                                                                echo json_encode(
                                                                        array('status_SyncAccurate'=> "true",
                                                                                'fullfield'=> "queue done sadasda dddddd"),
                                                                        JSON_PRETTY_PRINT
                                                                );
                                                        }

                                                //cek jika ada sama, kemudian melakukan pengecekan apakah didalam terdapat customer kontrak/publish.[ customer kontrak != null ]
                                            }
                                                    else 
                                                            {

                                                                /**
                                                                 * #progress add item customer kontrak
                                                                 * Hit this add item customers
                                                                 */
                                                                $item = MasterItemTransportX::where([
                                                                        'vendor_id' => $project,
                                                                        'itemovdesc' => $request->get('Reqitemovdesc')
                                                                        ]
                                                                    )
                                                                ->first();

                                                            $itemCustomers = Vendor_item_transports::UpdateOrInserted(
                                                                [
                                                                    'itemovdesc' => $request->get('Reqitemovdesc')
                                                                ],
                                                                    [   
                                                                        'item_code' => $item->itemID_accurate,
                                                                        'referenceID' => $item->id,
                                                                        'origin' => $request->get('Reqorigin'),
                                                                        'destination' => $request->get('Reqdestination'),
                                                                        'usersid' => Auth::User()->id,
                                                                        'ship_category' => $request->get('Reqshipment_category'),
                                                                        'itemovdesc' => $item->itemovdesc,
                                                                        'unit' => $request->get('Requnit'),
                                                                        'sub_service_id' => $request->get('Reqsubservice'),
                                                                        'moda' => $request->get('Reqmoda'),
                                                                        'batch_itemVendor' => $collectdata,
                                                                        // 'price' => $request->get('Reqprice'),
                                                                        'price' => (Int)  $request->get('Reqprice') === null ? $request->get('RatePertama') : $request->get('Reqprice'),
                                                                        'vendor_id' => $project,
                                                                        'itemID_accurate' => $item->itemID_accurate,
                                                                    ]
                                                            );
                                                                $itemCode = $item->itemID_accurate;

                                                                  $barangJasa__ = new Promise(
                                                                                function () use (&$barangJasa__, &$itemCode, &$dataminimum, &$harga, &$name) {
                                                                                    $barangJasa__->resolve($this->UpdateSyncBarangJasaVendor($itemCode, $dataminimum, $harga, $name));
                                                    
                                                                                },
                                                                                function ($ex) {
                                                                                    $barangJasa__->reject($ex);
                                                                                }
                                                                            );
                                                                                        
                                                                    $promise = $barangJasa__->wait()->original;
                                                                    
                                                                    // $promised = isset($promise) ? $promise : false;
                                                                    // dd($promise);    
                                                                // die;
                    
                                                            if($promise["s"] == false){

                                                                    $getCloudAccurate = $this->openModulesAccurateCloud
                                                                        ->FuncOpenmoduleAccurateCloudSaveItemBarangjasa__(
                                                                            $request->get('Reqitemovdesc'),
                                                                            $this->service, 
                                                                            $this->date,
                                                                            $itemCustomers->itemID_accurate,
                                                                            $request->get('Requnit')
                                                                        )
                                                                    ;
                                                                            
                                                                    $callback_response = $getCloudAccurate->getData("+");

                                                                        $check_process = isset($callback_response) ? $callback_response : false;
                        
                                                                            if(empty($check_process)){
                        
                                                                                    echo json_encode(
                                                                                        array('status_SyncAccurate'=> "false"),
                                                                                        JSON_PRETTY_PRINT
                                                                                    );
                        
                                                                                echo json_encode(
                                                                                    array('data_internal'=> "maaf ada data yang tidak sinkron dengan accurate."),
                                                                                    JSON_PRETTY_PRINT
                                                                                );
                                                                            
                                                                            } 
                                                                                else {
                        
                                                                                    $item = MasterItemTransportX::UpdateOrInserted(
                                                                                        [
                                                                                            'itemovdesc' => $request->get('Reqitemovdesc')
                                                                                        ],
                                                                                            [
                                                                                                'item_code' => $itemCode,
                                                                                                'origin' => $request->get('Reqorigin'),
                                                                                                'destination' => $request->get('Reqdestination'),
                                                                                                'userid' => Auth::User()->id,
                                                                                                'ship_category' => $request->get('Reqshipment_category'),
                                                                                                'itemovdesc' => $request->get('Reqitemovdesc'),
                                                                                                'unit' => $request->get('Requnit'),
                                                                                                'sub_service_id' => $request->get('Reqsubservice'),
                                                                                                'moda' => $request->get('Reqmoda'),
                                                                                                'vendor_id' => $project,
                                                                                                'itemID_accurate' => $itemCode,
                                                                                                'flag'   => 342
                                                                                            ]
                                                                                    );

                                                                                    // dd("bug 4");
                                                                            }

                                                                } 

                                                                echo json_encode(
                                                            array('status_SyncAccurate'=> "true",
                                                                    'fullfield' => "queue done sdasdad"),
                                                            JSON_PRETTY_PRINT
                                                        );
                                                  }
                                            }
                                    // }

                            //by default: secara sistem akan melakukan pengecekkan data yanb diterima oleh client apakah ada atau tidak[ ada ].
                            } 
                                else 
                                        {
                                            $project = ($request->get('Reqvendor')=="null")
                                            ? NULL 
                                            : $request->get('Reqvendor');
                                            
                                            $sixdigit = Crypt::encryptString( $this->codes->generate_uuid() );
                                            $master_code = strtoupper(trim(substr($sixdigit, strlen($sixdigit) - 6, strlen($sixdigit)),'=').'-'.Str::random(6));
                                                    $fetchMasterItemID = Vendor_item_transports::where([
                                                            'vendor_id' => $project,
                                                            'sub_service_id' => $request->get('Reqsubservice'),
                                                            'ship_category' => $request->get('Reqshipment_category'),
                                                            'moda' => $request->get('Reqmoda'),
                                                            'origin' => $request->get('Reqorigin'),
                                                            'unit' => $request->get('Requnit'),
                                                            'destination' => $request->get('Reqdestination'),
                                                            'itemovdesc' => $request->get('Reqitemovdesc')
                                                    ])->first();

                                                    if(is_null($fetchMasterItemID)){

                                                        $fetchMasterItemID = Vendor_item_transports::where([
                                                                'vendor_id' => NULL,
                                                                'sub_service_id' => $request->get('Reqsubservice'),
                                                                'ship_category' => $request->get('Reqshipment_category'),
                                                                'moda' => $request->get('Reqmoda'),
                                                                'origin' => $request->get('Reqorigin'),
                                                                'unit' => $request->get('Requnit'),
                                                                'destination' => $request->get('Reqdestination'),
                                                                'itemovdesc' => $request->get('Reqitemovdesc')
                                                        ])->first();

                                                    } 
                                                    // /**
                                                    //  * Func jika ada data yang sama setiap field, set fill attribute indexs yang saling berhubungan. 
                                                    //  * 
                                                    //  */
                                                    //     $fetchMasterItemID = MasterItemTransportX::
                                                    //         when($request->has('Reqitemovdesc') && $request->has('Reqsubservice') && $request->has('Reqorigin') && $request->has('Reqdestination') && $request->has('Reqshipment_category') && $request->has('Reqmoda') && $request->has('Requnit'), function ($que) use ($request){
                                                    //             return $que->where('sub_service_id','=',$request->get('Reqsubservice'))
                                                    //                         ->where('origin', '=',$request->get('Reqorigin'))
                                                    //                         ->where('ship_category', '=',$request->get('Reqshipment_category'))
                                                    //                         ->where('moda', '=',$request->get('Reqmoda'))
                                                    //                         ->where('unit', '=',$request->get('Requnit'))
                                                    //                         ->where('itemovdesc', '=',$request->get('Reqitemovdesc'))
                                                    //                         ->where('destination','=', $request->get('Reqdestination')); 
                                                    //             }   
                                                    //         )
                                                    //     ->first()
                                                    // ;
                                                            
                                                    // $data = MasterItemTransportX::whereIn('customer_id', function($query) use ($contract){
                                                    //     $query->whereIn('customer_id', $contract );
                                                    // })->get();
                                                    //cek jika ada sama, kemudian melakukan pengecekan apakah didalam terdapat customer kontrak/publish. [null]
                                                    if(is_null($fetchMasterItemID)){
                                                        //cek request, kemudian melakukan pengecekan apakah request customer null / tidak [ request customer == null]
                                                        if(is_null($project)){
                                                                    $item = MasterItemTransportX::UpdateOrInserted(
                                                                        [
                                                                            'itemovdesc' => $request->get('Reqitemovdesc')
                                                                        ],
                                                                            [
                                                                                'item_code' => $master_code,
                                                                                'origin' => $request->get('Reqorigin'),
                                                                                'destination' => $request->get('Reqdestination'),
                                                                                'userid' => Auth::User()->id,
                                                                                'ship_category' => $request->get('Reqshipment_category'),
                                                                                'itemovdesc' => $request->get('Reqitemovdesc'),
                                                                                'unit' => $request->get('Requnit'),
                                                                                'sub_service_id' => $request->get('Reqsubservice'),
                                                                                'moda' => $request->get('Reqmoda'),
                                                                                'vendor_id' => $project,
                                                                                'itemID_accurate' => $master_code,
                                                                                'flag'   => 2
                                                                            ]
                                                                    );
                    
                                                                $itemCode = $item->itemID_accurate;
                    
                                                                $barangJasa__ = new Promise(
                                                                                function () use (&$barangJasa__, &$itemCode, &$dataminimum, &$harga, &$name) {
                                                                                    $barangJasa__->resolve($this->UpdateSyncBarangJasaVendor($itemCode, $dataminimum, $harga, $name));
                                                    
                                                                                },
                                                                                function ($ex) {
                                                                                    $barangJasa__->reject($ex);
                                                                                }
                                                                            );
                                                                                        
                                                                    $promise = $barangJasa__->wait()->original;
                                                                    
                                                                    // $promised = isset($promise) ? $promise : false;
                                                                    // dd($promise);    
                                                                // die;
                    
                                                                if($promise["s"] == false){
                    
                                                                        $getCloudAccurate = $this->openModulesAccurateCloud
                                                                            ->FuncOpenmoduleAccurateCloudSaveItemBarangjasa__(
                                                                                $request->get('Reqitemovdesc'),
                                                                                $this->service,
                                                                                $this->date,
                                                                                $itemCode,
                                                                                $request->get('Requnit')
                                                                            )
                                                                        ;
                    
                                                                        $callback_response = $getCloudAccurate->getData("+");
                                                                                // dd("1",$callback_response);
                                                                          $promised = isset($callback_response) ? $callback_response : false;
                    
                                                                        //   $itemTransports = New Customer_item_transports();
                                                                        //   $itemTransports->item_code = $callback_response;
                                                                        //   $itemTransports->customer_id = $project;
                                                                        //   $itemTransports->referenceID = $item->id;
                                                                        //   $itemTransports->sub_service_id = $item->sub_service_id;
                                                                        //   $itemTransports->itemovdesc = $item->itemovdesc;
                                                                        //   $itemTransports->ship_category = $item->ship_category;
                                                                        //   $itemTransports->moda = $item->moda;
                                                                        //   $itemTransports->usersid = $item->userid;
                                                                        //   $itemTransports->origin = $item->origin;
                                                                        //   $itemTransports->destination = $item->destination;
                                                                        //   $itemTransports->price = $item->price;
                                                                        //   $itemTransports->unit = $item->unit;
                                                                        //   $itemTransports->batch_itemCustomer = $collectdata;
                                                                        //   $itemTransports->itemID_accurate = $callback_response;
                                                                        //   $itemTransports->save();
                                                                        $cs_fetchs = Vendor_item_transports::insert(
                                                                            [   
                                                                                'item_code' => $itemCode,
                                                                                'referenceID' => $item->id,
                                                                                'origin' => $request->get('Reqorigin'),
                                                                                'destination' => $request->get('Reqdestination'),
                                                                                'usersid' => Auth::User()->id,
                                                                                'ship_category' => $request->get('Reqshipment_category'),
                                                                                'itemovdesc' => $item->itemovdesc,
                                                                                'unit' => $request->get('Requnit'),
                                                                                'batch_itemVendor' => $collectdata,
                                                                                'sub_service_id' => $request->get('Reqsubservice'),
                                                                                'moda' => $request->get('Reqmoda'),
                                                                                'vendor_id' => $project,
                                                                                // 'price' => $request->get('Reqprice'),
                                                                                'price' => (Int)  $request->get('Reqprice') === null ? $request->get('RatePertama') : $request->get('Reqprice'),
                                                                                'itemID_accurate' => $itemCode,
                                                                                'flag'   => 43,
                                                                                'created_at'   => Carbon::Now()
                                                                            ]
                                                                        );
                                                                    
                                                                    } 
                                                                            else {

                                                                                $item = Vendor_item_transports::UpdateOrInserted(
                                                                                    [
                                                                                        'itemovdesc' => $request->get('Reqitemovdesc')
                                                                                    ],
                                                                                        [
                                                                                            'item_code' => $master_code,
                                                                                            'referenceID' => $item->id,
                                                                                            'origin' => $request->get('Reqorigin'),
                                                                                            'destination' => $request->get('Reqdestination'),
                                                                                            'usersid' => Auth::User()->id,
                                                                                            'ship_category' => $request->get('Reqshipment_category'),
                                                                                            'itemovdesc' => $request->get('Reqitemovdesc'),
                                                                                            'unit' => $request->get('Requnit'),
                                                                                            'sub_service_id' => $request->get('Reqsubservice'),
                                                                                            'moda' => $request->get('Reqmoda'),
                                                                                            'batch_itemVendor' => $collectdata,
                                                                                            // 'price' => $request->get('Reqprice'),
                                                                                            'price' => (Int)  $request->get('Reqprice') === null ? $request->get('RatePertama') : $request->get('Reqprice'),
                                                                                            'vendor_id' => $project,
                                                                                            'itemID_accurate' => $master_code,
                                                                                            'flag'   => 2242,
                                                                                            'created_at' => Carbon::Now()
                                                                                        ]
                                                                                );

                    
                                                                                    $barangJasa__ = new Promise(
                                                                                            function () use (&$barangJasa__, &$itemCode, &$dataminimum, &$harga, &$name) {
                                                                                                $barangJasa__->resolve($this->UpdateSyncBarangJasaVendor($itemCode, $dataminimum, $harga, $name));
                                                                
                                                                                            },
                                                                                            function ($ex) {
                                                                                                $barangJasa__->reject($ex);
                                                                                            }
                                                                                        );
                                                                                                    
                                                                                $data = $barangJasa__->wait()->original;

                                                                                if($data["s"] == false){
                                                                                    $getCloudAccurate = $this->openModulesAccurateCloud
                                                                                    ->FuncOpenmoduleAccurateCloudSaveItemBarangjasa__(
                                                                                        $request->get('Reqitemovdesc'),
                                                                                        $this->service,
                                                                                        $this->date,
                                                                                        $itemCode,
                                                                                        $request->get('Requnit')
                                                                                    )
                                                                                ;

                                                                                $callback_response = $getCloudAccurate->getData("+");
                                                                                // dd("2",$callback_response);
                    
                                                                                $itemCD = isset($callback_response) ? $callback_response["r"]["no"] : false;

                                                                                } 
                                                                                    else {

                                                                                        $barangJasa__ = new Promise(
                                                                                            function () use (&$barangJasa__, &$itemCode, &$dataminimum, &$harga, &$name) {
                                                                                                $barangJasa__->resolve($this->UpdateSyncBarangJasaVendor($itemCode, $dataminimum, $harga, $name));
                                                                
                                                                                            },
                                                                                            function ($ex) {
                                                                                                $barangJasa__->reject($ex);
                                                                                            }
                                                                                        );

                                                                                        // echo json_encode(
                                                                                        //     array('status_SyncAccurate'=> "true"),
                                                                                        //     JSON_PRETTY_PRINT
                                                                                        // );
                                                                                }
                    

                                                                            echo json_encode(
                                                                                array('status_SyncAccurate'=> "true"),
                                                                                JSON_PRETTY_PRINT
                                                                            );

                                                                        }
                                                                // dd("bug 5");

                                                            //cek request, kemudian melakukan pengecekan apakah request customer null / tidak [ request customer != null]
                                                            }
                                                                else {

                                                                         /**
                                                                         * #progress add item customer kontrak
                                                                         * Hit this add item customers
                                                                         */
                                                                            $item = MasterItemTransportX::where([
                                                                                'vendor_id' => $project,
                                                                                'itemovdesc' => $request->get('Reqitemovdesc')
                                                                                ]
                                                                            )
                                                                        ->first();

                                                                        $itemID_A = Vendor_item_transports::UpdateOrInserted(
                                                                            [
                                                                                'itemovdesc' => $request->get('Reqitemovdesc')
                                                                            ],
                                                                                [   
                                                                                    'item_code' => $item->itemID_accurate,
                                                                                    'referenceID' => $item->id,
                                                                                    'origin' => $request->get('Reqorigin'),
                                                                                    'destination' => $request->get('Reqdestination'),
                                                                                    'usersid' => Auth::User()->id,
                                                                                    'ship_category' => $request->get('Reqshipment_category'),
                                                                                    'itemovdesc' => $item->itemovdesc,
                                                                                    'unit' => $request->get('Requnit'),
                                                                                    'sub_service_id' => $request->get('Reqsubservice'),
                                                                                    'moda' => $request->get('Reqmoda'),
                                                                                    // 'price' => $request->get('Reqprice'),
                                                                                    'price' => (Int)  $request->get('Reqprice') === null ? $request->get('RatePertama') : $request->get('Reqprice'),
                                                                                    'vendor_id' => $project,
                                                                                    'itemID_accurate' => $item->itemID_accurate,
                                                                                    'batch_itemVendor' => $collectdata,

                                                                                ]
                                                                        );

                                                                        $itemID_accurate = $itemID_A->itemID_accurate;

                                                                        $barangJasa__ = new Promise(
                                                                            function () use (&$barangJasa__, &$itemID_accurate, &$dataminimum, &$harga, &$name) {
                                                                                $barangJasa__->resolve($this->UpdateSyncBarangJasaVendor($itemID_accurate, $dataminimum, $harga, $name));
                                                
                                                                            },
                                                                            function ($ex) {
                                                                                $barangJasa__->reject($ex);
                                                                            }
                                                                        );
                                                                        
                                                                        $barangJasa__->wait()->original["d"][0];

                                                                    //#method publish
                                                                    echo json_encode(
                                                                        array('status_SyncAccurate'=> "true",
                                                                        'fullfield' => "queue done"),
                                                                    JSON_PRETTY_PRINT
                                                                );
                                                                // dd("bug 6");

                                                            }

                                                    //cek jika ada sama, kemudian melakukan pengecekan apakah didalam terdapat customer kontrak/publish. [fetchMasterItemID != null]                                                        
                                                    }
                                                        else 
                                                                {

                                                                    $harga = $request->get('Reqprice');
                                                                    $name = $request->get('Reqitemovdesc');
                                                                    $item = MasterItemTransportX::where([
                                                                                'vendor_id' => $project,
                                                                                'itemovdesc' => $name
                                                                        ]
                                                                    )->first();

                                                                    $itemCode = $item->itemID_accurate;

                                                                    $barangJasa__ = new Promise(
                                                                        function () use (&$barangJasa__, &$master_code, &$dataminimum, &$harga, &$name) {
                                                                            $barangJasa__->resolve($this->UpdateSyncBarangJasaVendor($master_code, $dataminimum, $harga, $name));
                                            
                                                                        },
                                                                        function ($ex) {
                                                                            $barangJasa__->reject($ex);
                                                                        }
                                                                    );
                                                                                
                                                                    $promise = $barangJasa__->wait()->original;
                                                                                                                                                
                                                                        if($promise["s"] == false){

                                                                                $getCloudAccurate = $this->openModulesAccurateCloud
                                                                                    ->FuncOpenmoduleAccurateCloudSaveItemBarangjasa__(
                                                                                        $request->get('Reqitemovdesc'),
                                                                                        $this->service, 
                                                                                        $this->date,
                                                                                        $itemCode,
                                                                                        $request->get('Requnit')
                                                                                    )
                                                                                ;
                                                                                        
                                                                                $callback_response = $getCloudAccurate->getData("+");

                                                                                    $check_process = isset($callback_response) ? $callback_response : false;
                                    
                                                                                        if(empty($check_process)){

                                                                                            $barangJasa__ = new Promise(
                                                                                                function () use (&$barangJasa__, &$itemCode, &$dataminimum, &$harga, &$name) {
                                                                                                    $barangJasa__->resolve($this->UpdateSyncBarangJasaVendor($itemCode, $dataminimum, $harga, $name));
                                                                    
                                                                                                },
                                                                                                function ($ex) {
                                                                                                    $barangJasa__->reject($ex);
                                                                                                }
                                                                                            );
                                                                                                        
                                                                                    $barangJasa__->wait()->original;
                                    
                                                                                                echo json_encode(
                                                                                                    array('status_SyncAccurate'=> "true"),
                                                                                                    JSON_PRETTY_PRINT
                                                                                                );
                                    
                                                                                            echo json_encode(
                                                                                                array('data_internal'=> "data telah diupdate."),
                                                                                                JSON_PRETTY_PRINT
                                                                                            );
                                                                                        
                                                                                        } 
                                                                                            else {
                                    
                                                                                                MasterItemTransportX::UpdateOrInserted(
                                                                                                    [
                                                                                                        'itemovdesc' => $request->get('Reqitemovdesc')
                                                                                                    ],
                                                                                                        [
                                                                                                            'item_code' => $itemCode,
                                                                                                            'origin' => $request->get('Reqorigin'),
                                                                                                            'destination' => $request->get('Reqdestination'),
                                                                                                            'userid' => Auth::User()->id,
                                                                                                            'ship_category' => $request->get('Reqshipment_category'),
                                                                                                            'itemovdesc' => $request->get('Reqitemovdesc'),
                                                                                                            'unit' => $request->get('Requnit'),
                                                                                                            'sub_service_id' => $request->get('Reqsubservice'),
                                                                                                            'moda' => $request->get('Reqmoda'),
                                                                                                            'vendor_id' => $project,
                                                                                                            'itemID_accurate' => $itemCode,
                                                                                                        ]
                                                                                                );

                                                                                                // dd("bug 4");
                                                                                        }

                                                                            } 

                                                                echo json_encode(
                                                                    array('status_SyncAccurate'=> "true",
                                                                        'fullfield' => "queue done"),
                                                                    JSON_PRETTY_PRINT
                                                                );
                                                                // dd("bug 7");
                                                        }
                                                // }
                                        }
                                    }
                                )
                        ;
                }
        }

}