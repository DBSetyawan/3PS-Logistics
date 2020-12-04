<?php

namespace warehouse\Http\Controllers\item;

use Auth;
use warehouse\User;
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

class ItemController extends Controller
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

        $id = Item::select('id')->max('id');
        $itemno = $id+1;
        $whs = 'WHS';
        if ($id==null) {
            # code...
            $item_id = (str_repeat($whs.'0', 2-strlen($itemno))). $itemno;
          }
          if ($id >= 1 && $id < 10) {
            $item_id = (str_repeat($whs.'00', 2-strlen($itemno))). $itemno;
          }
           if ($id >= 9 && $id < 101) {
            $item_id = (str_repeat($whs.'00', 3-strlen($itemno))). $itemno;
        }
          if ($id >= 99 && $id < 100) {
            $item_id = (str_repeat($whs.'0', 2-strlen($itemno))). $itemno;
          } 
        if ($id >= 100 && $id < 1000) {
            $item_id = (str_repeat($whs.'0', 2-strlen($itemno))). $itemno;
        }   
        $alert_items = Item::where('flag',0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $sub_service = Sub_service::all();
        $users_logged_in = Auth::User()->id;
        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        // $users = User::with('items.sub_service')->where('id',Auth::User()->id)->first();
        $users = Item::with('sub_service')->get();

        // dd($users);die;
        $prefix = Company_branchs::globalmaster($branch_id)->first();
        // $table_items = Item::with('sub_service')->where('by_user_permission_allows', $users)->get();
        $table_items_administrator = Item::with('sub_service')->get();
        // dd($users->items);
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        return view('admin.item.itemlist',
            [   
                'menu' => 'Warehouse Item List',
                'choosen_user_with_branch' => $branch_id,
                'some' => $branch_id,
                'api_v1' => $responsecallbackme['api_v1'],
                'api_v2' => $responsecallbackme['api_v2'],
                'alert_items' => $alert_items,
                'system_alert_item_vendor' => $system_alert_item_vendor,
                'system_alert_item_customer' => $data_item_alert_sys_allows0,
                'alert_customers' => $alert_customers
            ])
            ->with(compact('table_items','table_items_administrator',
            'item_id','sub_service','itemno','prefix','users')
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

    public function alert_item_list($branch_id)
    {
        $APIs = $this->apiitems::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);
        $alert_items = Item::where('flag',0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $table_items = Item::with('sub_service')->get();
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $prefix = Company_branchs::globalmaster($branch_id)->first();
        if ($alert_items->isEmpty()){
            #do something else..
            return redirect('/warehouse')->with('success','good job, now you have all items that can be used to make orders.');
            }
              else {
                    return view('admin.item.system_alert_item.alert_item_list',
                            [
                                'menu' => 'System Item List',
                                'choosen_user_with_branch' => $this->rest->session()->get('id'),
                                'some' => $this->rest->session()->get('id'),
                                'api_v1' => $responsecallbackme['api_v1'],
                                'api_v2' => $responsecallbackme['api_v2'],
                                'system_alert_item_customer' => $data_item_alert_sys_allows0,
                                'alert_items' => $alert_items,
                                'system_alert_item_vendor' => $system_alert_item_vendor,
                                'alert_customers' => $alert_customers
                            ]
                        )
                    ->with(compact('table_items','item_id','sub_service','prefix','itemno'
                )
            );
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        # Filer & only get specific parameters.
        $items = New Item();
        $items->itemno = $request->itemid;
        $items->unit = $request->unitpcs;
        $items->sub_service_id = $request->sub_service_id;
        $items->itemovdesc = $request->itemovdesc;
        $items->by_user_permission_allows = Auth::User()->id;
        $items->price = $request->price;
        $items->flag = 0;

        $item_saved = $items->save();

        if(!$item_saved) {
            throw new Exception('Error in saving data.');
        } 
            else {
                return redirect('/items');
        }
        
        //  $add_items = Item::create([
        //     'itemno' => $request->itemid,
        //     'sub_service_id' => $request->sub_service_id,
        //     'itemovdesc' => $request->itemovdesc,
        //     'by_user_permissions_allows' => Auth::User()->id,
        //     'price' => $request->price,
        //     'flag' => 0
        //   ]);
        
        // if(!$add_items){
        //     App::abort(500, 'Error Adding data into database.');
        // } 
        //   else {

        //     return redirect('/items');

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
        $decrypts= Crypt::decrypt($id);
        $APIs = $this->apiitems::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);

        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $data_customer_transport_sys_alerts = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        // $find_i_customer = Customer_item_transports::findOrFail($id);
        $alert_items = Item::where('flag',0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $sub_service = sub_service::all();
        $prefix = Company_branchs::globalmaster(Auth::User()->company_branch_id)->first();
        $itemsf = Item::findOrFail($decrypts);
        session(['item_warehouse_id'=>$id]);
        return view('admin.item.update_form_itemwh',[
            'menu'=>'Item Warehouse Detail',
            'choosen_user_with_branch' => $this->rest->session()->get('id'),
            'some' => $this->rest->session()->get('id'),
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2'],
            'alert_items' => $alert_items,
            'system_alert_item_vendor' => $data_customer_transport_sys_alerts,
            'system_alert_item_customer' => $data_item_alert_sys_allows0,
            'alert_customers' => $alert_customers]
        )->with(compact('find_i_customer','cstm','prefix','itemsf','shc','Mds','cstomers','Cty','sub_service'));

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
        $item = Item::with('sub_service')->find($id);
        $item->itemovdesc = Request('descript');
        $item->price = Request('price');
        $item->unit = Request('unitpcs');
        $item->sub_service_id = Request('sub_service_id');
        $item->save();

        return redirect()->back()->withSuccess("data berhasil di ubah.");

    }

    public function update_alert_item($id)
    {
        $item = Item::find($id);
        $item->flag = Request('flag');
        $item->save();
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

    public function loaded_itemsss(Request $request)
    {
        if(Gate::allows('superusers') || Gate::allows('developer')){
        // if ($request->has('q')) {
            $cari = $request->q;
            $data = sub_service::select('id', 'name')->where('name', 'LIKE', "%$cari%")->get();

            foreach ($data as $query) {
                $results[] = ['value' => $query ];
            }
            return response()->json($data);
        // }
        }
    }

}