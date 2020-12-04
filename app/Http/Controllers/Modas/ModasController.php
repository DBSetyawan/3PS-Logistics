<?php

namespace warehouse\Http\Controllers\Modas;

use Auth;
use warehouse\Models\Item;
use Illuminate\Http\Request;
use warehouse\Models\Customer;
use warehouse\Models\Moda as MD;
use warehouse\Models\Sub_service;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Crypt;
use warehouse\Models\Company_branchs;
use warehouse\Http\Controllers\Controller;
use warehouse\Models\Vendor_item_transports;
use Illuminate\Contracts\Encryption\DecryptException;
use warehouse\Http\Controllers\ManagementController as RESTAPIs;
use warehouse\Models\Item_transport as Customer_item_transports;

class ModasController extends Controller
{

    protected $APIModas;
    private $rest;
    
    public function __construct(RESTAPIs $apimoda, Request $REST)
    {
        $this->middleware(['BlockedBeforeSettingUser','verified','role:3PL - SURABAYA WAREHOUSE|super_users|3PL - BANDUNG TRANSPORT|3PL[SPV]|3PE[SPV]|3PL[DRIVERS]|3PE[DRIVERS]|3PL[OPRASONAL][KASIR]|3PE[OPRASONAL][KASIR]|administrator']);
        $this->APIModas = $apimoda;
        $this->rest = $REST;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MD $sd)
    {
        $APIs = $this->APIModas::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);
        //
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        // $dp = $sd->with('users')->where('usersid', NULL)->orWhere('usersid', Auth::User()->id)->get();
        $dp = $sd->with('users')->get();
        // $dp = $sd->with('users')->whereIn('usersid', [session()->get('company_id')])->get();
        $data_customer_transport_sys_alerts = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $prefix = Company_branchs::globalmaster(Auth::User()->company_branch_id)->first();
        $alert_items = Item::where('flag',0)->get();

        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();

        return view('admin.Moda.modaslist',[
                'menu'=>'Modas List',
                'prefix' => $prefix,
                'choosen_user_with_branch' => $this->rest->session()->get('id'),
                'some' => $this->rest->session()->get('id'),
                'api_v1' => $responsecallbackme['api_v1'],
                'api_v2' => $responsecallbackme['api_v2'],
                'alert_items' => $alert_items,
                'system_alert_item_vendor' => $data_customer_transport_sys_alerts,
                'system_alert_item_customer' => $data_item_alert_sys_allows0,
                'alert_customers' => $alert_customers]
            )->with(compact('lpsdc','midasn','find_i_customer','dp','cstm',
                'am','itemsf','shc','Mds','cstomers','Cty','sub_service')
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

        $modas = New MD();
        $modas->name = $request->itemid;
        $modas->tonase = $request->ton;
        $modas->usersid = session()->get('company_id');
        $modas->capacity = $request->capc;
        $modas->sub_service_id_fk = $request->sub_service;
        $hsl = $modas->save();

        if(!$hsl) {
            throw new Exception('Error in saving data.');
        } 
            else {
        
                return redirect()->back()->withSuccess("Data berhasil ditambahkan.");

        }

    }

    public function moda_load_sb()
    {

        if (Gate::allows('superusers') || Gate::allows('developer')) {
            $data = Sub_service::select('id','name')->get();
            foreach ($data as $query) {
                $results[] = ['value' => $query ];
              }
            return response()->json($data);
        }

        if (Gate::allows('transport')) {
            $data = Sub_service::select('id','name')->where('prefix','=','T')->get();
            foreach ($data as $query) {
                $results[] = ['value' => $query ];
              }
            return response()->json($data);
        }

        if (Gate::allows('warehouse')) {
            $data = Sub_service::select('id','name')->where('prefix','=','W')->get();
            foreach ($data as $query) {
                $results[] = ['value' => $query ];
              }
            return response()->json($data);
        }

        // if($user = Auth::User()->company_id=="1"){
        //     $data = Sub_service::select('id','name')->where('prefix','=','W')->get();
        //     foreach ($data as $query) {
        //         $results[] = ['value' => $query ];
        //       }
        //     return response()->json($data);
        // }

        // if($user = Auth::User()->company_id=="2"){
        //     $data = Sub_service::select('id','name')->where('prefix','=','T')->get();
        //     foreach ($data as $query) {
        //         $results[] = ['value' => $query ];
        //       }
        //     return response()->json($data);
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
        try {
            
            $decrypts= Crypt::decrypt($id);
            $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
            'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
    
            $data_customer_transport_sys_alerts = Vendor_item_transports::with('vendors',
            'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
            $lm = MD::findOrFail($decrypts);
            $alert_items = Item::where('flag',0)->get();
            $allmoda = Sub_service::all();
            $prefix = Company_branchs::globalmaster($branch_id)->first();
    
            $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
            $APIs = $this->APIModas::callbackme();
            $responsecallbackme = json_decode($APIs->getContent(), true);
    
            session(['modaid'=>$id]);
            return view('admin.Moda.updated.update_formodaslist',[
                'menu'=>'Moda List Details',
                'choosen_user_with_branch' => $this->rest->session()->get('id'),
                'some' => $this->rest->session()->get('id'),
                'api_v1' => $responsecallbackme['api_v1'],
                'api_v2' => $responsecallbackme['api_v2'],
                'alert_items' => $alert_items,
                'system_alert_item_vendor' => $data_customer_transport_sys_alerts,
                'system_alert_item_customer' => $data_item_alert_sys_allows0,
                'alert_customers' => $alert_customers]
            )->with(compact('find_i_customer','srvc','allmoda','cstm','shc','prefix','Mds','lm','cstomers','Cty','sub_service'));

            
        } catch (DecryptException $e) {
            //

            return $e->getMessage();
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
        $item = MD::findOrFail($id);
        $item->name = Request('name');
        $item->tonase = Request('ton');
        $item->capacity = Request('capc');
        $item->sub_service_id_fk = Request('sub_service');
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
