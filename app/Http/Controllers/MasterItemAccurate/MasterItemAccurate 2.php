<?php

namespace warehouse\Http\Controllers\MasterItemAccurate;

use Auth;
use warehouse\User;
use warehouse\Models\MasterItemTransportX;
use warehouse\Models\Item;
use Illuminate\Http\Request;
use warehouse\Models\Customer;
use warehouse\Models\Sub_service;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Crypt;
use warehouse\Models\Company_branchs;
use warehouse\Http\Controllers\Controller;
use warehouse\Models\Vendor_item_transports;
use warehouse\Http\Controllers\ManagementController as RESTAPIs;
use warehouse\Models\Item_transport as Customer_item_transports;

class MasterItemAccurate extends Controller
{
    protected $apiitems;
    private $rest;

    public function __construct(RESTAPIs $apitem, Request $REST)
    {
        $this->middleware(['CekOpenedTransaction','BlockedBeforeSettingUser','verified','role:3PL SURABAYA ALL PERMISSION|3PL - SURABAYA WAREHOUSE|super_users|administrator|3PL[OPRASONAL][TC][WHS]|3PL[OPRASONAL][WHS]|3PL[ACCOUNTING][TC]|3PL[ACCOUNTING][WHS][TC]|3PL[ACCOUNTING][WHS]']);
        $this->apiitems = $apitem;
        $this->rest = $REST;
    }
  
    /**
     * Display a listing of sthe resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $branch_id)
    {
        $APIs = $this->apiitems::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);

        $id = MasterItemTransportX::select('id')->max('id');
        $itemno = $id+1;
        $whs = 'WHS';
        if ($id==null) {
            $item_id = (str_repeat($whs.'0', 2-strlen($itemno))). $itemno;
        }
        elseif ($id == 1){
            $item_id = (str_repeat($whs.'0', 2-strlen($itemno))). $itemno;
        }
        elseif ($id > 1 && $id < 9 ){
            $item_id = (str_repeat($whs.'0', 2-strlen($itemno))). $itemno;
        }
        elseif ($id == 9){
           $item_id = (str_repeat($whs.'0', 3-strlen($itemno))). $itemno;
        }
        elseif ($id == 10) {
          $item_id = (str_repeat($whs.'0', 3-strlen($itemno))). $itemno;
        }
        elseif ($id > 10 && $id < 99) {
           $item_id = (str_repeat($whs.'0', 3-strlen($itemno))). $itemno;
        }
        elseif ($id == 99) {
           $item_id = (str_repeat($whs.'000', 4-strlen($itemno))). $itemno;
        }
        elseif ($id == 100) {
            $item_id = (str_repeat($whs.'0', 4-strlen($itemno))). $itemno;
        }
        elseif ($id > 100 && $id < 999) {
            $item_id = (str_repeat($whs.'0', 4-strlen($itemno))). $itemno;
        }
        elseif ($id === 999) {
            $item_id = (str_repeat($whs.'0', 5-strlen($itemno))). $itemno;
        }
        elseif ($id === 1000) {
            $item_id = (str_repeat($whs.'0', 5-strlen($itemno))). $itemno;
        }
        elseif ($id > 1000 && $id < 9999) {
            $item_id = (str_repeat($whs.'0', 5-strlen($itemno))). $itemno;
        }
        elseif ($id == 9999) {
            $item_id = (str_repeat($whs.'0', 6-strlen($itemno))). $itemno;
        }
        elseif ($id == 10000) {
            $item_id = (str_repeat($whs.'0', 6-strlen($itemno))). $itemno;
        }

        $alert_items = Item::where('flag',0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $sub_service = Sub_service::all();
        $users_logged_in = Auth::User()->id;
        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        // $users = User::with('items.sub_service')->where('id',Auth::User()->id)->first();
        // dd($users);die;
        $prefix = Company_branchs::globalmaster($branch_id)->first();
        // $table_items = Item::with('sub_service')->where('by_user_permission_allows', $users)->get();
        $tableMasterItem = MasterItemTransportX::with(
            'customers','sub_services','modas','city_show_it_origin',
            'city_show_it_destination'
        )->get();
        // dd($users->items);
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        return view('admin.masteritemaccurate.masterItemAccurate',
            [   
                'menu' => 'Master Item Accurate Cloud',
                'choosen_user_with_branch' => $branch_id,
                'some' => $branch_id,
                'api_v1' => $responsecallbackme['api_v1'],
                'api_v2' => $responsecallbackme['api_v2'],
                'alert_items' => $alert_items,
                'system_alert_item_vendor' => $system_alert_item_vendor,
                'system_alert_item_customer' => $data_item_alert_sys_allows0,
                'alert_customers' => $alert_customers
            ],
            compact('tableMasterItem',
                        'item_id','sub_service','itemno','prefix'
            )
        );

    }
    
}