<?php

namespace warehouse\Http\Controllers\Sales_order;

use Auth;
use warehouse\Models\Item;
use Illuminate\Http\Request;
use warehouse\Models\Customer;
use warehouse\Models\Sales_order;
use warehouse\Models\Company_branchs;
use warehouse\Http\Controllers\Controller;
use warehouse\Models\Vendor_item_transports;
use warehouse\Http\Controllers\ManagementController as RESTAPIs;
use warehouse\Models\Item_transport as Customer_item_transports;

class SalesController extends Controller
{

    protected $APIsales;
    private $rests;
      
    public function __construct(RESTAPIs $apisales, Request $REST)
    {
        $this->middleware(['verified','BlockedBeforeSettingUser','role:super_users|3PL[SPV]|3PE[SPV]|3PL - SURABAYA WAREHOUSE|3PL - BANDUNG TRANSPORT|3PL[DRIVERS]|3PE[DRIVERS]|3PL[OPRASONAL][KASIR]|3PE[OPRASONAL][KASIR]|administrator']);
        $this->APIsales = $apisales;
        $this->rests = $REST;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Sales_order $son)
    {
        $APIs = $this->APIsales::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);
        
        $prefix = Company_branchs::globalmaster(Auth::User()->company_branch_id)->first();
        $sales_order_dump = $son->whereIn('users_company_id', [session()->get('company_id')])->get();
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();

        $data_customer_transport_sys_alerts = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();

        $alert_items = Item::where('flag',0)->get();

        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
          
        return view('admin.sales_order.sales_order_list',[
            'menu'=>'Sales Order List',
            'choosen_user_with_branch' => $this->rests->session()->get('id'),
            'some' => $this->rests->session()->get('id'),
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2'],
            'alert_items' => $alert_items,
            'system_alert_item_vendor' => $data_customer_transport_sys_alerts,
            'system_alert_item_customer' => $data_item_alert_sys_allows0,
            'alert_customers' => $alert_customers]
        )->with(compact('sales_order_dump','prefix'));

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
    public function store(Request $request, Sales_order $soder)
    {
        $salesorder = New $soder;
        $salesorder->sales_name = $request->sales_name;
        $salesorder->status = '1';
        $salesorder->users_company_id = session()->get('company_id');
        $salesorder->save();

        return redirect()->back()->withSuccess("Data berhasil ditambahkan.");
    
    }

    public function find_show_sales(Sales_order $tc, Request $request, $id)
    {
      $howdasfg = $tc->where('id',$id)->first();
      return response()->json($howdasfg);
    }

    public function updated_sales_named(Sales_order $tc, Request $request, $index)
    {
      $transportList = $tc->where('id',$index)->first();
      $transportList->sales_name = $request->sales_name;
      $transportList->save();
      return back();
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
