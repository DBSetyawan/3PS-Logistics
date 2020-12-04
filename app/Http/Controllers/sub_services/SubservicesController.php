<?php

namespace warehouse\Http\Controllers\sub_services;

use Auth;
use warehouse\Models\Item;
use Illuminate\Http\Request;
use warehouse\Models\Customer;
use warehouse\Models\Companies;
use warehouse\Models\Role_branch;
use warehouse\Models\Sub_service;
use Illuminate\Support\Facades\Gate;
use warehouse\Models\Service as als;
use Illuminate\Support\Facades\Crypt;
use warehouse\Models\Company_branchs;
use Illuminate\Database\Eloquent\Builder;
use warehouse\Http\Controllers\Controller;
use warehouse\Models\Vendor_item_transports;
use warehouse\Http\Controllers\ManagementController as RESTAPIs;
use warehouse\Models\Item_transport as Customer_item_transports;

class SubservicesController extends Controller
{

    protected $APIsubservices;
    private $rest;
    
    public function __construct(RESTAPIs $subapi, Request $REST)
    {
        $this->middleware(['verified','BlockedBeforeSettingUser','role:3PL - SURABAYA WAREHOUSE|super_users|3PL - BANDUNG TRANSPORT|administrator']);
        $this->APIsubservices = $subapi;
        $this->rest = $REST;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(als $dsd, $branch_id)
    {
        $APIs = $this->APIsubservices::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();

        $data_customer_transport_sys_alerts = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();

        $alert_items = Item::where('flag',0)->get();

        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
          
        $user = Auth::User()->roles;
        $datauser = array();
        foreach ($user as $key => $value) {
          # code...
          $datauser = $value->name;

        }
        
        if (Gate::allows('superusers') || Gate::allows('developer')) {
            $sub_service = Sub_service::with('companys','service','users')
            ->where('company_id', session()->get('company_id'))->get();
        }

        // if ($datauser=="administrator" || $datauser=="super_users") {
        //     # code...
        //     $sub_service = Sub_service::with('companys','service','users')
        //     ->get();
        
        // }

        if ($datauser=="3PL[OPRASONAL][TC]") {
            # code...
            $sub_service = Sub_service::with('companys','service','users')
            ->where('prefix','=', 'T')->get();
        
        }

        if ($datauser=="3PL[OPRASONAL][WHS]") {
           # code...
           $sub_service = Sub_service::with('companys','service','users')
           ->where('prefix','=', 'W')->get();
        
        }

        if ($datauser=="3PL - SURABAYA WAREHOUSE") {
            # code...
            $sub_service = Sub_service::with('companys','service','users')
            ->where('prefix','=', 'W')->get();
         
         }

         if ($datauser=="3PL - BANDUNG TRANSPORT") {
            # code...
            $sub_service = Sub_service::with('companys','service','users')
            ->where('prefix','=', 'T')->get();
         
         }
 

        $am = $dsd->all();
        $prefix = Company_branchs::globalmaster($branch_id)->first();

        return view('admin.sub_services.subserviceslist',[
            'menu'=>'Sub Service List',
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2'],
            'alert_items' => $alert_items,
            'choosen_user_with_branch' => $this->rest->session()->get('id'),
            'some' => $this->rest->session()->get('id'),
            'system_alert_item_vendor' => $data_customer_transport_sys_alerts,
            'system_alert_item_customer' => $data_item_alert_sys_allows0,
            'alert_customers' => $alert_customers]
        )->with(compact('find_i_customer','cstm','am','prefix','itemsf','shc','Mds','cstomers','Cty','sub_service'));
        
    }

    public function loadDatas(Request $request)
    {
        // if ($request->has('q')) {
            $user = Auth::User()->roles;
            $datauser = array();
            foreach ($user as $key => $value) {
              # code...
              $datauser = $value->name;
  
            }

            if (Gate::allows('superusers') || Gate::allows('developer')) {
                $cari = $request->q;
                $data = als::select('id', 'name')->where('name', 'LIKE', "%$cari%")->get();
                // foreach ($data as $query) {
                //    $results[] = ['value' => $query->industry ];
                //  }
                return response()->json($data);
            }

            if ($datauser=="3PL[OPRASONAL][WHS]") {
                $data__array_y = array('Warehouse');
                $cari = $request->q;
                $data = als::select('id', 'name')->whereIn('name',$data__array_y)->where('name', 'LIKE', "%$cari%")->get();
                // foreach ($data as $query) {
                //    $results[] = ['value' => $query->industry ];
                //  }
                return response()->json($data);
            }

            if ($datauser=="3PL - SURABAYA WAREHOUSE") {
                $data__array_y = array('Warehouse');
                $cari = $request->q;
                $data = als::select('id', 'name')->whereIn('name',$data__array_y)->where('name', 'LIKE', "%$cari%")->get();
                // foreach ($data as $query) {
                //    $results[] = ['value' => $query->industry ];
                //  }
                return response()->json($data);
            }

            if ($datauser=="3PL[OPRASONAL][TC]") {
                $data__array_x = array('Transport');
                $cari = $request->q;
                $data = als::select('id', 'name')->whereIn('name',$data__array_x)->where('name', 'LIKE', "%$cari%")->get();
                // foreach ($data as $query) {
                //    $results[] = ['value' => $query->industry ];
                //  }
                return response()->json($data);
            }

            if ($datauser=="3PL[OPRASONAL][WHS][TC]") {
                $data__array = array('Warehouse');
                $cari = $request->q;
                $data = als::select('id', 'name')->where('name', 'LIKE', "%$cari%")->get();
                // foreach ($data as $query) {
                //    $results[] = ['value' => $query->industry ];
                //  }
                return response()->json($data);
            }
            
     
        // }

    }

    public function loadCompn(Request $request)
    {

        $user = Auth::User()->roles;
        $datauser = array();
        foreach ($user as $key => $value) {
          # code...
          $datauser = $value->name;

        }

        if ($datauser=="3PL[OPRASONAL][WHS]") {

            $dasd = array('Tiga Permata Logistik');

            $cari = $request->q;
            $data = Companies::select('id', 'name')->whereIn('name', $dasd)->where('name', 'LIKE', "%$cari%")->get();
            // foreach ($data as $query) {
            //    $results[] = ['value' => $query->industry ];
            //  }
            return response()->json($data);
        
        }

        if ($datauser=="3PL[OPRASONAL][TC]") {

            $dasdsd = array('Tiga Permata Ekspress');
            $cari = $request->q;
            $data = Companies::select('id', 'name')->whereIn('name',$dasdsd)->where('name', 'LIKE', "%$cari%")->get();
            // foreach ($data as $query) {
            //    $results[] = ['value' => $query->industry ];
            //  }
            return response()->json($data);
        
        }

        if ($datauser=="3PL - SURABAYA WAREHOUSE") {

            $dasdsd = array('3PL');
            $cari = $request->q;
            $data = Companies::select('id', 'name')->whereIn('name',$dasdsd)->where('name', 'LIKE', "%$cari%")->groupBy('name')->get();
            // foreach ($data as $query) {
            //    $results[] = ['value' => $query->industry ];
            //  }
            return response()->json($data);
        
        }

        if ($datauser=="3PL[OPRASONAL][WHS][TC]") {

            $cari = $request->q;
            $data = Companies::select('id', 'name')->where('name', 'LIKE', "%$cari%")->get();
            // foreach ($data as $query) {
            //    $results[] = ['value' => $query->industry ];
            //  }
            return response()->json($data);
        
        }
        // if ($request->has('q')) {
     
        // }

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
    public function store(Request $request, Role_branch $rbranch)
    {

        $data = Companies::select('id','name')->whereIn('owner_id', [Auth::User()->id])->get();
      
        if($data->isEmpty()){

            if(Gate::allows('developer')){
                $prefix = ($request->service == 1) ? "W" : "T";
                $company = session()->get('company_id');
                $cheats = New Sub_service();
                $cheats->name = $request->itemid;
                $cheats->company_id = session()->get('company_id');
                $cheats->service_id = $request->service;
                $cheats->remark = $request->remark;
                $cheats->prefix = $prefix;
                $cheats->usersid = Auth::User()->id;
                $item_saved = $cheats->save();
        
                if(!$item_saved) {
                    throw new Exception('Error in saving data.');
                } 
                    else {
                
                        return redirect()->back()->withSuccess("Data berhasil ditambahkan.");
        
                }
            }

            $y_column_branch = array();

                $ambil_branch_id_users = $rbranch->with('modelhasbranch.company')->whereIn('user_id', [Auth::User()->parent_id])->get();

                    foreach($ambil_branch_id_users as $row_role_branch){

                        $y_column_branch[] = $row_role_branch->modelhasbranch->company['id'];

                    }

                    $datax = Companies::where(function (Builder $query) use($y_column_branch) {
                        return $query->whereIn('id', [$y_column_branch])
                        ->addSelect('id','name');
                    })->get();
            
                $name_route = $datax[0]->name;

        } 
            else {

                $name_route = $data[0]->name;

        }

        $prefix = ($request->service == 1) ? "W" : "T";
        $company = session()->get('company_id');
        $cheats = New Sub_service();
        $cheats->name = $request->itemid;
        $cheats->company_id = session()->get('company_id');
        $cheats->service_id = $request->service;
        $cheats->remark = $request->remark;
        $cheats->prefix = $prefix;
        $cheats->usersid = Auth::User()->id;
        $item_saved = $cheats->save();

        if(!$item_saved) {
            throw new Exception('Error in saving data.');
        } 
            else {
        
                return redirect()->back()->withSuccess("Data berhasil ditambahkan.");

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($branch_id, als $sda, $id)
    {
        $decrypts = Crypt::decrypt($id);
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();

        $data_customer_transport_sys_alerts = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $lm = Sub_service::findOrFail($decrypts);
        $alert_items = Item::where('flag',0)->get();
        $sub_service = $sda->all();
        $srvc = Companies::all();
        $prefix = Company_branchs::globalmaster($branch_id)->first();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $APIs = $this->APIsubservices::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);

        session(['mastersubserviceid'=> $id]);
        return view('admin.sub_services.update.update_formsubservice',[
            'menu'=>'Sub Service Details',
            'choosen_user_with_branch' => $this->rest->session()->get('id'),
            'some' => $this->rest->session()->get('id'),
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2'],
            'alert_items' => $alert_items,
            'system_alert_item_vendor' => $data_customer_transport_sys_alerts,
            'system_alert_item_customer' => $data_item_alert_sys_allows0,
            'alert_customers' => $alert_customers]
        )->with(compact('find_i_customer','srvc','cstm','prefix','shc','Mds','lm','cstomers','Cty','sub_service'));
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $item = Sub_service::findOrFail($id);
        $item->name = Request('name');
        $item->service_id = Request('sb_service');
        $item->company_id = Request('companys_id');
        $item->remark = Request('remark');
        $item->prefix = Request('prefix');
        $item->save();

        swal()
        ->toast()
            ->autoclose(9000)
         ->message("Data has been saved","You have done updated!",'info'); 

        return redirect()->back();
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
