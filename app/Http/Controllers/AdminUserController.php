<?php

namespace warehouse\Http\Controllers;

use Illuminate\Http\Request;
use warehouse\Models\Item;
use warehouse\Models\Customer;
use Auth;
use Session;

class AdminUserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('role:Admin_user');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    $role = Auth::user()->roles()->get();

        foreach ($role as $key => $value) {
            # code...
           //  dd($value);
            if($value->role_name == "Admin_user") {
                $alert_items = Item::where('flag',0)->get();
                $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
                return view('admin.index',[
                    'menu' => 'Admin User Dashboard',
                    'alert_items' => $alert_items,
                    'alert_customers' => $alert_customers
                ]);

            } else {
                return redirect()->back();
            }
        
        }

    }

}