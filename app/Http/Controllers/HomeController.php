<?php

namespace warehouse\Http\Controllers;

use Illuminate\Http\Request;
use warehouse\Models\Item_transport as Customer_item_transports;
use Auth;
use warehouse\Models\Vendor_item_transports;
use warehouse\Models\Item;
use warehouse\Models\APIintractive as dbcheck;
use warehouse\Models\Customer;
use Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        // 'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        // $system_alert_item_customers = Customer_item_transports::with('customers',
        // 'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        // $alert_items = Item::where('flag',0)->get();
        // $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        // return view('admin.index',[
        //     'menu' => 'Admin Dashboard',
        //     'system_alert_item_vendor' => $system_alert_item_vendor,
        //     'alert_items' => $alert_items,
        //     'system_alert_item_customer' => $system_alert_item_customers,
        //     'alert_customers' => $alert_customers
        // ]);
        $prefix = Company_branchs::branchname(Auth::User()->company_branch_id)->first();
        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $system_alert_item_customers = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $alert_items = Item::where('flag',0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();

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

        $Authorized = Auth::User()->roles;

        foreach ($Authorized as $key => $checkaccess) {
            # code...
            $results = $checkaccess->name;
        }

        return view('admin.index',[
            'menu' => 'Admin Dashboard',
            'system_alert_item_vendor' => $system_alert_item_vendor,
            'system_alert_item_customer' => $system_alert_item_customers,
            'alert_items' => $alert_items,
            'api_v1' => $fetchArray1,
            'api_v2' => $fetchArray2,
            'apis' => $results,
            'alert_customers' => $alert_customers,
            'prefix' => $prefix
        ]);

    }

}
