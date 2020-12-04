<?php

namespace warehouse\Http\Controllers\Shipment_category;

use Auth;
use warehouse\Models\Item;
use Illuminate\Http\Request;
use warehouse\Models\Customer;
use Illuminate\Support\Facades\Crypt;
use warehouse\Models\Company_branchs;
use warehouse\Http\Controllers\Controller;
use warehouse\Models\Ship_categorie as eqx;
use warehouse\Models\Vendor_item_transports;
use warehouse\Http\Controllers\ManagementController as RESTAPIs;
use warehouse\Models\Item_transport as Customer_item_transports;

class ShipmentcategoryController extends Controller
{

    protected $APIshipcategory;
    private $rest;
    
    public function __construct(RESTAPIs $apiships, Request $REST)
    {
        $this->middleware(['verified','BlockedBeforeSettingUser','role:3PL - SURABAYA WAREHOUSE|super_users|3PL - BANDUNG TRANSPORT|3PL[SPV]|3PE[SPV]|3PL[DRIVERS]|3PE[DRIVERS]|3PL[OPRASONAL][KASIR]|3PE[OPRASONAL][KASIR]|administrator']);
        $this->APIshipcategory = $apiships;
        $this->rest = $REST;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($branch_id, eqx $lpsdc)
    {
        $APIs = $this->APIshipcategory::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);
        // $midasn = $lpsdc->with('users')->where('usersid', NULL)->orWhere('usersid', Auth::User()->id)->get();
        // $midasn = $lpsdc->with('users')->whereIn('usersid',[session()->get('company_id')] )->get();
        $midasn = $lpsdc->with('users')->get();
        // dd($midasn);
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();

        $data_customer_transport_sys_alerts = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();

        $alert_items = Item::where('flag',0)->get();

        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $prefix = Company_branchs::globalmaster($branch_id)->first();

        return view('admin.shipment_category.shipment_categorylist',[
                'menu'=>'Shipment Category List',
                'choosen_user_with_branch' => $this->rest->session()->get('id'),
                'some' => $this->rest->session()->get('id'),
                'api_v1' => $responsecallbackme['api_v1'],
                'api_v2' => $responsecallbackme['api_v2'],
                'alert_items' => $alert_items,
                'system_alert_item_vendor' => $data_customer_transport_sys_alerts,
                'system_alert_item_customer' => $data_item_alert_sys_allows0,
                'alert_customers' => $alert_customers]
            )->with(compact('lpsdc','midasn','find_i_customer','cstm',
                'am','itemsf','shc','Mds','cstomers','Cty','sub_service','prefix')
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
        $dasx = New eqx();
        $dasx->nama = $request->itemid;
        $dasx->usersid = session()->get('company_id');
        $results = $dasx->save();

        if(!$results) {
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
    public function show(eqx $sdc, $branch_id, $id)
    {
        
        $decrypts= Crypt::decrypt($id);
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();

        $data_customer_transport_sys_alerts = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $lm = eqx::findOrFail($decrypts);
        $alert_items = Item::where('flag',0)->get();
        $prefix = Company_branchs::globalmaster($branch_id)->first();

        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $APIs = $this->APIshipcategory::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);

        session(['shipmentcategoriesid' => $id]);
        return view('admin.shipment_category.update_formshipmentctgr',[
            'menu'=>'Shipment Category Details',
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
        $item = eqx::findOrFail($id);
        $item->nama = Request('name');
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
