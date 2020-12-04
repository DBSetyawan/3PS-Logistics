<?php

namespace warehouse\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use warehouse\Models\Item;
use warehouse\Models\Customer;
use warehouse\Models\Item_transport as Customer_item_transports;
use warehouse\Models\Vendor_item_transports;
use Session;

class AdministratorController extends Controller
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
        // $user = Auth::user()->with('roles')->get();
        // foreach ($user as $key => $value) {
        //     foreach ($value->roles as $key => $role) {
        //         if (!$role==false) {
                    // return view('admin.index',[
                    //     'menu' => 'Admin Dashboard'
                    // ]);
        //         }
        
        //     }
        // }
        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $system_alert_item_customers = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $alert_items = Item::where('flag',0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        return view('admin.index',[
            'menu' => 'Admin Dashboard',
            'system_alert_item_vendor' => $system_alert_item_vendor,
            'system_alert_item_customer' => $system_alert_item_customers,
            'alert_items' => $alert_items,
            'alert_customers' => $alert_customers
        ]);

    // $role = Auth::user()->roles()->get();
        
    // foreach ($role as $key => $value) {
    //         if($value->role_name == "Administrator") {
              
    //         } 
    //           else {
    //                 return redirect()->back();
                
    //         }
           
    //     } 
            

    }

}
