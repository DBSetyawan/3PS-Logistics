<?php
namespace warehouse\Http\Controllers\warehouse;

use PDF;
use Auth;
use SWAL;
use Alert;
use Excel;
use Session;
use Storage;
use DataTables;
use DOMDocument;
use Carbon\Carbon;
use SimpleXMLElement;
use GuzzleHttp\Client;
use warehouse\Models\City;
use warehouse\Models\Item;
use Illuminate\Http\Request;
use warehouse\Models\Vendor;
use Illuminate\Http\Response;
use warehouse\Models\Remarks;
use warehouse\Models\Service;
use warehouse\Models\Customer;
use warehouse\Models\Industrys;
use SoapBox\Formatter\Formatter;
use warehouse\Mail\OrderShipped;
use warehouse\Models\Sales_order;
use warehouse\Models\Sub_service;
use warehouse\Models\Customer_pics;
use warehouse\Models\Order_history;
use warehouse\Models\Vendor_status;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use warehouse\Models\Company_branchs;
use warehouse\Models\Customer_status;
use warehouse\Models\Warehouse_order;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Database\Eloquent\Builder;
use warehouse\Models\Customer_pic_status;
use Illuminate\warehouse\Http\Controllers;
use warehouse\Http\Controllers\Controller;
use warehouse\DataTables\WarehouseDataTable;
use warehouse\Models\Vendor_item_transports;
use warehouse\Models\Warehouse_order_status;
use warehouse\Models\APIintractive as dbcheck;
use warehouse\Models\Warehouse_order_customer_pic;
use warehouse\Models\Item_transport as Customer_item_transports;
use warehouse\Http\Controllers\Services\Apiopentransactioninterface;

class WarehouseController extends Controller
{

  private $Apiopentransaction;
  private $jagal_squad;
  private $datatabl;

  public function __construct(Apiopentransactioninterface $apiopened, Request $Rest, WarehouseDataTable $datatabl)
  {
    $this->Apiopentransaction = $apiopened;
    $this->jagal_squad = $Rest;
    $this->datatabl = $datatabl;
    $this->middleware(['BlockedBeforeSettingUser','verified','role:3PL SURABAYA ALL PERMISSION|3PL JAKARTA ALL PERMISSION|3PL - SURABAYA WAREHOUSE|super_users|administrator']);
  }

  public function getBasicData()
  {
      $users = Warehouse_order::select(['id','order_id','no_doc_customer']);

      return DataTables::of($users)->make();
  }

  public function getAddEditRemoveColumnData($id)
    {
        // $wareouses = User::select(['id', 'name', 'email', 'password', 'created_at', 'updated_at'])->get();
      //   if ($request->ajax()) {
      //     $model = Warehouse_order::with('customers_warehouse','sub_service.remarks');
      //     // ->select('customers_warehouse.*','sub_service.*','sub_service.remarks.*');

      //     return DataTables::eloquent($model)
      //     ->addColumn('customers_warehouse', function (Warehouse_order $Warehouse_order) {
      //         return $Warehouse_order->customers_warehouse->name;
      //     })
      //     ->toJson();
      // }

        $results = null;
        $Authorized = Auth::User()->roles;
        $userId = Auth::User()->id;

        foreach ($Authorized as $checkaccess) {
            # code...
            $results[] = $checkaccess->name;
        }
      
      //  return redirect()->route('warehouse.static', $this->jagal_squad->session()->get('id'));
      $id_auto = 1;
      $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
      $alert_items = Item::where('flag',0)->get();
      $data_customer_transport_sys_alerts = Vendor_item_transports::with('vendors',
      'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
      // $warehouseTolist = Warehouse_order::with('warehouse_o_status','customers_warehouse','sub_service.remarks','sub_service.item','users')
      // ->whereIn('company_branch_id', [$company_branch_with_role_branch])
      // ->orderBy('updated_at', 'DESC')->get();
      $warehouseTolist = $this->Apiopentransaction->getOpenWarehouseWithBranchId($userId);
 
      $trashlist = Warehouse_order::with('customers_warehouse','sub_service.remarks')
                                      ->onlyTrashed()
                                        ->get();
        $prefix = Company_branchs::branchwarehouse($this->jagal_squad->session()->get('id'))->first();
                      $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
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

      return $this->datatabl->render('admin.warehouse.warehouse_orderlist')
        ->with(
                [
                  'menu'=> "Warehouse Order List",
                  'trashlist' => $trashlist,
                  'some' => $id,
                  'apis' => $results,
                  'alert_customers'=> $alert_customers,
                  'choosen_user_with_branch' => $id,
                  'system_alert_item_customer' => $data_item_alert_sys_allows0,
                  'system_alert_item_vendor' => $data_customer_transport_sys_alerts,
                  'alert_items'=> $alert_items
                ]
            )
          ;
      
        // return DataTables::of($wareouses)
        //     ->addColumn('action', function ($wareouses) {
        //         return '<a href="#edit-'.$wareouses->id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
        //     })
        //     ->editColumn('id', 'ID: {{$id}}')
        //     ->removeColumn('password')
        //     ->make(true);
    }

  public function cari_customers(Request $request)
  {
    // if ($request->has('q')) {
      $cari = $request->q;
      $data = Customer::with('city')->where('name', 'LIKE', "%$cari%")->get();
      // dd($data);
      // foreach ($data as $query) {
      //    $results[] = ['value' => $query];
      //  }
      return response()->json($data);
    // }

  }

  public function search_sales_name(Request $request)
  {
    // if ($request->has('q')) {
      $cari = $request->q;
      $data = Sales_order::where('sales_name', 'LIKE', "%$cari%")->get();
      // dd($data);
      // foreach ($data as $query) {
      //    $results[] = ['value' => $query];
      //  }
      return response()->json($data);
    // }

  }

  public function Cari_branchs(Request $request)
  {
    if ($request->has('q')) {
      $cari = $request->q;
      $data = Company_branchs::select('id','branch')->where('branch', 'LIKE', "%$cari%")->get();
      // dd($data);
      foreach ($data as $query) {
         $results[] = ['value' => $query->branch];
       }
      return response()->json($data);
    }
  }

    public function loadData(Request $request)
    {
      if ($request->has('q')) {
        $cari = $request->q;
        $data = Service::select('id', 'name')->where('name', 'LIKE', "%$cari%")->get();
        // foreach ($data as $query) {
        //    $results[] = ['value' => $query->industry ];
        //  }
        return response()->json($data);
      }
    }

    public function someone_sd(){
      return $this->hasMany();

      // dd($id);

    }
    
    public function someone_cs(Request $request,$id)
    {
      $data = Customer_pics::select('id', 'name')->where('customer_id', '=',$id)->get();
      foreach ($data as $query) {
          $results[] = ['value' => $query ];
        }
      return response()->json($data);
    }

    public function someone_items($id)
    {

      if(Gate::allows('transport') || Gate::allows('warehouse') || Gate::allows('accounting') || Gate::allows('developer') || Gate::allows('superusers'))
      $data = Item::select('id', 'itemovdesc')->where('sub_service_id', '=',$id)->get();
      foreach ($data as $query) {
          $results[] = ['value' => $query ];
        }
      return response()->json($data);
    }

    public function price_items($id)
    {
      $data = Item::select('price')->where('id', '=',$id)->get();
      foreach ($data as $query) {
          $results[] = ['value' => $query ];
        }
      return response()->json($data);
    }

    public function cari_sub_services(Request $request)
    {

      $user = Auth::User()->roles;
      $datauser_company = Auth::User()->company_id;
      $datauser = array();
      foreach ($user as $key => $value) {
        # code...
        $datauser = $value->name;

      }

      if (Gate::allows('superusers') || Gate::allows('developer') || Gate::allows('transport') || Gate::allows('warehouse')) {
           # code...
          // if ($request->has('q')) {
            $cari = $request->q;
            // $data = Sub_service::select('id', 'name')->where('name', 'LIKE', "%$cari%")->where('prefix','W')->get();
            $data = Sub_service::select('id', 'name')->where('name', 'LIKE', "%$cari%")->get();
            // foreach ($data as $query) {
            //    $results[] = ['value' => $query->industry ];
            //  }
            return response()->json($data);
          // }
      }

      // if ($datauser=="administrator") {
      //   # code...
      //   // if ($request->has('q')) {
      //     $cari = $request->q;
      //     // $data = Sub_service::select('id', 'name')->where('name', 'LIKE', "%$cari%")->where('prefix','W')->get();
      //     $data = Sub_service::select('id', 'name')->where('name', 'LIKE', "%$cari%")->get();
      //     // foreach ($data as $query) {
      //     //    $results[] = ['value' => $query->industry ];
      //     //  }
      //     return response()->json($data);
      //   // }

      // }

      if ($datauser_company=="1") {
        # code...
        // if ($request->has('q')) {
          $cari = $request->q;
          $data = Sub_service::select('id', 'name')->where('name', 'LIKE', "%$cari%")->where('prefix','W')->get();
          // foreach ($data as $query) {
          //    $results[] = ['value' => $query->industry ];
          //  }
          return response()->json($data);
        // }

      }

      if ($datauser_company=="2") {
        # code...
        
        // if ($request->has('q')) {
          $cari = $request->q;
          $data = Sub_service::select('id', 'name')->where('name', 'LIKE', "%$cari%")->where('prefix','T')->get();
          // foreach ($data as $query) {
          //    $results[] = ['value' => $query->industry ];
          //  }
          return response()->json($data);
        // }

      }

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
      // return $this->Apiopentransaction->getOpenBranchId($id);die;
      // $company_branch_with_role_branch = json_decode($id, true);
    
          
        /*
        |
        | ON PHP VERISON 7.3.* METHOD COMPACT NOT SUPPORTED, LOWER VERSION PHP 7.2.* THIS WILL BE WORK WITH method COMPACT
        |
        */ 
        return $this->getAddEditRemoveColumnData($id);
        // return view('admin.warehouse.warehouse_orderlist',[
        //     'menu'=>'Warehouse Order List',
        //     'api_v1' => $fetchArray1,
        //     'api_v2' => $fetchArray2,
        //     'choosen_user_with_branch' => $id,
        //     'some' => $id,
        //     'datatable' => ,
        //     'alert_customers'=> $alert_customers,
        //     'system_alert_item_customer' => $data_item_alert_sys_allows0,
        //     'system_alert_item_vendor' => $data_customer_transport_sys_alerts,
        //     'alert_items'=> $alert_items])->with(compact('trashlist',
        //     'warehouseTolist','id_auto','prefix')
        //   );
    }

    public function display_date_range($branch_id, Request $request)
    {
        # code...
        $datepickerfrom = $request->flash('request',$request);
        $datepickerto = $request->flash('request',$request);
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $alert_items = Item::where('flag',0)->get();
        $date_now = Carbon::now()->format('Y-m-d');
        $system_alert_item_customer = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $warehouseTolist = Warehouse_order::with('warehouse_o_status',
        'customers_warehouse','sub_service.remarks')->where('company_branch_id',$branch_id)
        ->whereBetween(
          'start_date',
          [
              $request->get('datepickerfrom'),
              $request->get('datepickerto')
          ]
        )->get();
        $dates = $warehouseTolist->pluck('start_date')->toArray();
        $prefix = Company_branchs::branchwarehouse($branch_id)->first();

        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $id_auto = 1;
        $trashlist = Warehouse_order::with('customers_warehouse','sub_service.remarks')
                                        ->onlyTrashed()
                                          ->get();

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

          return view('admin.warehouse.warehouse_orderlist',[
              'menu'=>'Warehouse Order List','system_alert_item_vendor' => $system_alert_item_vendor,
              'choosen_user_with_branch' => $this->jagal_squad->session()->get('id'),
              'some' => $this->jagal_squad->session()->get('id'),
              'api_v1' => $fetchArray1,
              'api_v2' => $fetchArray2])->with(compact('datepickerto','datepickerfrom','warehouse_o_status','trashlist',
              'warehouseTolist','alert_items','prefix','system_alert_item_customer','system_alert_item_vendor ','alert_customers',
              'id_auto','date_now','customers_warehouse','sub_service')
          );

          //   return view('admin.layouts.sidebar',compact('alert_items','alert_customers')
          // );


    }

    public function loadDataStatussx(Warehouse_order_status $wos, Request $request)
    {
        // if ($request->has('q')) {
          
          $user = Auth::User()->roles;
          $datauser = array();
          foreach ($user as $key => $value) {
            # code...
            $datauser = $value->name;

          }
          
          if ($datauser=="3PL[OPRASONAL][WHS][TC]") {
            # code...
            $cari = $request->q;
            $data = $wos->select('id', 'status_name')->where('status_name', 'LIKE', "%$cari%")->get();
            foreach ($data as $query) {
                $results[] = ['value' => $query->industry ];
            }

            return response()->json($data);

          }

          if ($datauser=="3PL[OPRASONAL][TC]") {
            # code...
            $cari = $request->q;
            $data_for_tc = array('upload','paid','invoice');
            // return $data_for_tc;
            $data = $wos->select('id', 'status_name')->whereIn('status_name',$data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();

            return response()->json($data);

          }

            if ($datauser=="3PL[OPRASONAL][WHS]") {
              # code...
              $cari = $request->q;
              $data_for_tc = array('draft','cancel','process','pod');
              // return $data_for_tc;
              $data = $wos->select('id', 'status_name')->whereIn('status_name',$data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();

              return response()->json($data);

            }

        // }

    }

    public function updated_status_order_idx(Warehouse_order $whs, Request $request, $index)
    {
      $warehouseTolist = $whs->whereIn('id',$index);
      $warehouseTolist->status_order_id = $request->updated_status_warehouse;
      $warehouseTolist->save();

      // return redirect()->route('warehouse.static', session()->get('id'));
      return back();
    }

    public function find_show_status_order_whs(Warehouse_order $whs, Request $request, $id)
    {
      $warehouseTolist = $whs->with('warehouse_o_status')->where('id',$id)->first();

      return response()->json($warehouseTolist);
    }

    public function trash_customers(){
      $trashlist = Warehouse_order::with('warehouse_o_status','customers_warehouse','sub_service.remarks')
      ->onlyTrashed()
        ->get();
      // dd($trashlist);
      return view ('admin.customer.trash_customers.trashcustomers',[
          'menu' => 'Trash Customers List'])->with(compact('warehouse_o_status','trashlist'));

    }

    public function something($id){
      $data = Customer_pics::where('customer_id','=',$id)->get();
      return response()->Json($data);
    }

    public function something_awesome($id){
      $data = Item::where('sub_service_id','=',$id)->where('by_user_permission_allows',Auth::User()->id)->get();
      return response()->Json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $date_now = Carbon::now()->format('Y-m-d');
      $test = Customer::withTrashed()->select('id')->max('id');
        // dd($test);
        $customers = 'CS00'. Customer::select('id')->max('id');
        if (is_null($customers)) {
          $id_customers = '1';
          $customers = 'CS001';
        } else {
            $id = 'CS00'.  Customer::withTrashed()->select('id')->max('id');
            $str = substr($id,-1);
            $vds = $str+1;
            $customers = 'CS00'.$vds;

            //id vendors
            $ids =  Customer::withTrashed()->select('id')->max('id');
            // $str = substr($ids,-1);
            $vds = $str+1;
            $id_customers = $vds;
        }
        
        $getter_branch_user = $this->jagal_squad->session()->get('id');
        $alert_items = Item::where('flag',0)->get();
        $warhs_order_id = Warehouse_order::select('id')->max('id');
        $wrhouse_id = $warhs_order_id+1;
        $customerpics = Customer_pics::all();
        $brnchs = Company_branchs::all();
        $vstatuss = Customer_pic_status::all();
        $warehouseTolist = Warehouse_order::with('customers_warehouse','sub_service.remarks','service_house')->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $vstatus = Customer_status::all();
        $customers = Customer::with('cstatusid','city','industry','customer_pic')->get();
        $modal_list = Warehouse_order::find($warhs_order_id);

        $subservices = Sub_service::all();
        $cshfasd = Customer::all();


        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $system_alert_item_customer = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $data_customer_transport_sys_alerts = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
                          'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $city = City::all();
        $prefix = Company_branchs::branchwarehouse($this->jagal_squad->session()->get('id'))->first();

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

          $request_branchs = $this->Apiopentransaction->getBranchIdWithdynamicChoosenBrach($this->jagal_squad->session()->get('id'));
          return view ('admin.warehouse.warehouse_form_registration',[
              'menu' => 'Warehouse Form Order Registration',
              'api_v1' => $fetchArray1,
              'request_branch' => $request_branchs,
              'api_v2' => $fetchArray2,
              'choosen_user_with_branch' => $this->jagal_squad->session()->get('id'),
              'some' => $this->jagal_squad->session()->get('id'),
              'system_alert_item_customer' => $data_item_alert_sys_allows0,
              'system_alert_item_vendor' => $data_customer_transport_sys_alerts,
              'alert_items' => $alert_items, 'system_alert_item_vendor' => $system_alert_item_vendor])->with(compact('customerpics','vstatuss',
              'date_now','brnchs','modal_list','vstatus','cshfasd','city','customers','getter_branch_user','prefix','alert_customers','subservices',
              'warehouseTolist','id_customers','wrhouse_id'));
          
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
 
      // $validator = $this->validate($request, [
      //   'customers_name' => 'required',
      //   'cbrach'=>'required',
      //   'sub_services'=>'required',
      //   'items'=>'required',
      //   'start_date'=>'required',
      //   'end_date'=>'required',
      //   'contract_no'=>'required',
      //   'volume'=>'required',
      //   'rate'=>'required',
      //   'total_rate'=>'required',
      // ]);
      //     ,
      //       [
      //         'customers_name.required' =>'Customer ora oleh kosong bro',
      //         'sub_services.required' =>'serivice ora oleh kosong bro',
      //         'items.required' =>'item ora oleh kosong bro',
      //         'cbrach.required' =>'cabang ora oleh kosong bro',
      //       ]);

    /**
    * if the contents in db the id is still the unit do -2 to repeat the icrement id (001),
    * if the contents inside db the id has already done do -3 to repeat the icrement id (010),
    * if the contents inside db id have done hundreds -4 to repeat the icrement id (100) and add the string '000' to become an increment (0100), and so on.
    * ETC>
    */
    // die();
    // try {
    $start_date = $request->start_date;
    $end_date = $request->end_date;
    $YM = Carbon::Now()->format('my');
    $tgl_kegiatan = Carbon::now()->format('Y-m-d');
    $branch_the_name = Company_branchs::find($this->jagal_squad->session()->get('id'));
    $service_name = Sub_service::find($request->sub_services);
    $id = Warehouse_order::select('id')->max('id');
    $whs = $id+1;
    $status = 1;
    $warehouse = 1;
    $id_whs = $whs;
    if ($id==null) {
      # code...
      $order_id = (str_repeat($service_name->prefix.$branch_the_name->prefix.$YM.'0', 2-strlen($id_whs))). $id_whs;
    }
    if ($id >= 1 && $id < 10) {
      $order_id = (str_repeat($service_name->prefix.$branch_the_name->prefix.$YM.'0', 2-strlen($id_whs))). $id_whs;
    }
     if ($id >= 9 && $id < 101) {
      $order_id = (str_repeat($service_name->prefix.$branch_the_name->prefix.$YM.'0', 3-strlen($id_whs))). $id_whs;
      }
    if ($id >= 99 && $id < 100) {
    $order_id = (str_repeat($service_name->prefix.$branch_the_name->prefix.$YM.'0', 4-strlen($id_whs))). $id_whs;
    } 
  if ($id >= 100 && $id < 1000) {
    $order_id = (str_repeat($service_name->prefix.$branch_the_name->prefix.$YM.'0', 4-strlen($id_whs))). $id_whs;
  }
    if ($id >= 999 && $id < 10000) {
      $order_id = (str_repeat($service_name->prefix.$branch_the_name->prefix.$YM.'0', 5-strlen($id_whs))). $id_whs;
    }     
      if ($id >= 9999 && $id < 100000) {
        $order_id = (str_repeat($service_name->prefix.$branch_the_name->prefix.$YM.'0', 6-strlen($id_whs))). $id_whs;
      }
      
      $cvrt_price = trim($request->total_rate,"Rp. ");
      $request_branchs = $this->Apiopentransaction->getBranchIdWithdynamicChoosenBrach($this->jagal_squad->session()->get('id'));
      if ($end_date >= $start_date) {
      $start_date = $request->old('start_date');
        # code...
         $saved_order_warehouse = Warehouse_order::create([
                                      'service_id' => $warehouse,
                                      'order_id' => $order_id,
                                      'status_order_id' => $status,
                                      'company_branch_id' => $request_branchs->id,
                                      'customer_id_warehouse' => $request->customers_name,
                                      'sub_services_id_warehouse' => $request->sub_services,
                                      'contract_no' => $request->contract_no,
                                      'itemno' => $request->items,
                                      'sales_order_id' => $request->sales_name_order,
                                      'rate' => $request->rate,
                                      'usersid' => Auth::User()->id,
                                      'volume' => $request->volume,
                                      'wom' => $request->uom,
                                      'remark' => $request->get('remark'),
                                      'start_date' => $request->start_date,
                                      'end_date' => $request->end_date,
                                      'total_rate' => str_replace(".","",$cvrt_price),
                                      'tgl_kegiatan' => $tgl_kegiatan
                                    ]);
      
          $warhs_order_id = Warehouse_order::select('id')->max('id');
          $check_id_warehouse_id = Warehouse_order::find($warhs_order_id);
          // $check_id_warehouse_id->warehouse_order_customer_pics()->sync($request->input('check_customerpics'));
          $check_id_warehouse_id->warehouse_order_customer_pics()->sync($request->input('customerpics_name'));
          // $check_id_warehouse_id->warehouse_order_customer_pics()->sync($request->input('check_customerpics'));
          //a make sweet alert on display order_id, only successfully added. 
          if(!$saved_order_warehouse){
              \App::abort(500, 'Error');
          } 
            else {

              $inserted = New Order_history();
              $inserted->order_id = $order_id;
              $inserted->status = $status;
              $inserted->datetime = Carbon::Now();
              $inserted->user_id = Auth::User()->id;
              $inserted->created_at = Carbon::Now();
              $inserted->updated_at = Carbon::Now();
              $inserted->save();

              //docs https://github.com/softon/sweetalert
              swal()->toast()->message("You order have successfully, Order has been archived"," order ID: $order_id ",'success'); 

          }

          return redirect()->route('warehouse.static', $request_branchs->id);

      } 
            else {
           
                return redirect()->route('warehouse.registration', $request_branchs->id)->with('warning', 'Gagal menyimpan data, Maaf tanggal harus sesuai. Inputan tidak boleh lebih dari tanggal sekarang.')->withInput();
           
            }
            
      //     } catch (\GuzzleHttp\Exception\ClientException $e) {

      //       return $e->getResponse()
      //               ->getBody()
      //               ->getContents();

      // }
        
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
        $warehouse_order_pic = Warehouse_order_customer_pic::with('to_do_list_cspics')->where('warehouse_order_id',$decrypts)->get();
        $customerpics = Customer_pics::find($decrypts);
        $srvice = Sub_service::find($decrypts);
        $vstatuss = Customer_pic_status::all();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        // $warehouseTolist = Warehouse_order::with('item_t','customers_warehouse','sub_service.remarks','service_house')->findOrFail($id);
        $warehouseTolist = Warehouse_order::with('item_t','customers_warehouse','sub_service.remarks','service_house')->where(function (Builder $query) use($branch_id, $decrypts) {
          return $query->where('id','=',$decrypts)
                  ->whereIn('company_branch_id', [$branch_id]);
        })->first();
        $brnchs = Company_branchs::all();
        $items = Item::find($decrypts);
        $vstatus = Customer_status::all();
        $customers = Customer::with('cstatusid','city','industry','customer_pic')->find($decrypts);
        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $city = City::all();
        $prefix = Company_branchs::branchwarehouse($this->jagal_squad->session()->get('id'))->first();
        $alert_items = Item::where('flag',0)->get();
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
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

        session(['order_id' => $id]);

        if($warehouseTolist == null){
            swal()
              ->toast()
                ->autoclose(9000)
                  ->message("Security detection", "Branch changes are detected in the transaction details!", 'info');
            return redirect()->route('warehouse.static', session()->get('id'));
        }

        return view ('admin.warehouse.edit_warehouse_orderlist',
        ['menu' => 'Warehouse Order Viewed',
          'alert_items' => $alert_items,
          'api_v1' => $fetchArray1,
          'api_v2' => $fetchArray2,
          'choosen_user_with_branch' => $this->jagal_squad->session()->get('id'),
          'some' => $this->jagal_squad->session()->get('id'),
          'system_alert_item_vendor' => $system_alert_item_vendor,
          'system_alert_item_customer' => $data_item_alert_sys_allows0,
          'alert_customers' => $alert_customers])->with(compact('customerpics','vstatuss',
          'vstatus','srvice','prefix','city','brnchs','items','customers','cstatusid','customer_pic','to_do_list_cspics',
          'customers_warehouse','warehouseTolist','alert_items','service_house','warehouse_order_pic','whs_pics_customer'
        ));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $warehouse_order_pic = Customer_pics::with('whs_pics')->find($id);
      $customerpics = Customer_pics::find($id);
      $vstatuss = Customer_pic_status::all();
      $warehouseTolist = Warehouse_order::with('customers_warehouse','sub_service.remarks','service_house')->find($id);
      $prefix = Company_branchs::branchwarehouse($this->jagal_squad->session()->get('id'))->first();
      $vstatus = Customer_status::all();
      $customers = Customer::with('cstatusid','city','industry','customer_pic')->find($id);
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
      // dd($customers);
      $city = City::all();
        return view ('admin.customer.editcustomerregistration',[
            'menu' => 'Customer Order',
            'api_v1' => $fetchArray1,
            'api_v2' => $fetchArray2])->with(compact('customerpics','vstatuss',
            'vstatus','city','prefix','customers','cstatusid','customer_pic',
          'customers_warehouse','warehouseTolist','service_house','warehouse_order_pic'));
    }

    public function OrderShipped(Request $request, $id)
    {
      $warehouse_order_pic = Warehouse_order_customer_pic::with('to_do_list_cspics','pics_whs.cek_status_orders_pic')
                              ->where('warehouse_order_id',$id)->get();
          $id = array();
          foreach ($warehouse_order_pic as $value) {
              $id[] = $value->to_do_list_cspics->email;
                  $emails_pic = implode(", ", $id);
                Mail::to($request->User())
              ->cc($emails_pic, $request->User())
              ->send(new OrderShipped($value));
          }
      return back()->with('success', 'Information order has been send via email.');
    }

    public function htmltopdfview($id)
    {
      $warehouseTolist = Warehouse_order::with('customers_warehouse','sub_service.remarks','service_house')->findOrFail($id);
      $warehouse_order_pic = Warehouse_order_customer_pic::with('to_do_list_cspics')->where('warehouse_order_id',$id)->get();
        $data = ['name' =>'3 permata system'];
            $pdf = PDF::loadView('htmltopdf', compact('to_do_list_cspics','customers_warehouse','data',
            'pics_whs','warehouse_order_pic','warehouseTolist','sub_service',
            'remarks','service_house','service_house'));
            $pdf->SetPaper('A4','landscape');
            return $pdf->stream();
    }

    public function update(Request $request ,$branch, $id)
    {
        // return response()->json($request->get('harga'));die;
        $updatetocustomer = Warehouse_order::with('customers_warehouse','sub_service.remarks','service_house')->findOrFail($id);
        $updatetocustomer->sub_services_id_warehouse = $request->get('subservice');
        $updatetocustomer->customer_id_warehouse = $request->get('customer_name');
        $updatetocustomer->contract_no = $request->get('contract');
        $updatetocustomer->rate = $request->get('harga');
        $updatetocustomer->volume = $request->get('volume');
        $updatetocustomer->itemno = $request->get('items');
        $updatetocustomer->usersid = Auth::User()->id;
        $updatetocustomer->wom = $request->get('uom');
        $updatetocustomer->remark= $request->get('remark');
        $updatetocustomer->total_rate = str_replace(".","",$request->get('sum_rate'));
        $updatetocustomer->save();

    }

    public function restoreall(){
      // $trashlist = Customer::with('cstatusid')->onlyTrashed()
                // ->restore();
                $trashlist = Warehouse_order::with('warehouse_o_status','customers_warehouse','sub_service.remarks')
                ->onlyTrashed()
                  ->restore();
      return redirect('trash_customers')->with('success','Data has been restored.');
    }

    public function pagedels(){
        $cstatusid = Customer::with('cstatusid')->get();
          return view('admin.warehouse.warehouse_orderlist',[
              'menu'=>'Customer Order List'])->with(compact('cslist','cstatusid'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restored_customer($id)
    {
      Warehouse_order::withTrashed()->find($id)->restore();
      return redirect('trash_customers')->with('success','Data has been restored.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $customers = Warehouse_order::findOrFail($id)->delete();
      flash('Information has been deleted.')->error();
      
      return redirect('warehouse');
    }

}
