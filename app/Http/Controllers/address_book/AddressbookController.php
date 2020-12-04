<?php

namespace warehouse\Http\Controllers\address_book;

use Auth;
use warehouse\Models\City;
use warehouse\Models\Item;
use Illuminate\Http\Request;
use warehouse\Models\Customer;
use warehouse\Models\Company_branchs;
use warehouse\Http\Controllers\Controller;
use warehouse\Models\Vendor_item_transports;
use warehouse\Models\Address_book as buku_alamatx;
use warehouse\Http\Controllers\ManagementController as RESTAPIs;
use warehouse\Models\Item_transport as Customer_item_transports;

class AddressbookController extends Controller
{
    protected $apiaddressbook;
    private $rest;

    public function __construct(RESTAPIs $apisrestaddressbook, Request $REST)
    {
      $this->middleware(['verified','BlockedBeforeSettingUser','permission:developer|warehouse|transport|accounting|superusers']);
      $this->apiaddressbook = $apisrestaddressbook;
      $this->rest = $REST;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(buku_alamatx $almts, $branch_id)
    {
        $APIs = $this->apiaddressbook::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);

        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();

        $data_customer_transport_sys_alerts = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();

        $alert_items = Item::where('flag',0)->get();

        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();

        // $book_address = $almts->with('citys','customers','users')->where('usersid', Auth::User()->id)->get();
        $book_address = $almts->with('citys','customers','users')->whereIn('users_company_id', [session()->get('company_id')])->get();
        
        $prefix = Company_branchs::globalmaster(Auth::User()->company_branch_id)->first();
        
        return view('admin.address_book.addressbooklist',
                [
                    'menu'=>'Address Book List',
                    'alert_items' => $alert_items,
                    'choosen_user_with_branch' => $this->rest->session()->get('id'),
                    'some' => $this->rest->session()->get('id'),
                    'api_v1' => $responsecallbackme['api_v1'],
                    'api_v2' => $responsecallbackme['api_v2'],
                    'system_alert_item_vendor' => $data_customer_transport_sys_alerts,
                    'system_alert_item_customer' => $data_item_alert_sys_allows0,
                    'alert_customers' => $alert_customers
                ]
            )->with(compact('jobs_order_idx','sub_service_not_dev','shc',
                'cstm','Cty','cstomers','book_address',
                'Mds','sub_service','prefix')
        );
    }

    public function load_city(Request $request){

        // if ($request->has('q')) {
            $cari = $request->q;
            $data = City::select('id','name')->where('name', 'LIKE', "%$cari%")->get();
            // dd($data);
            foreach ($data as $query) {
               $results[] = ['value' => $query];
             }
         
            return response()->json($data);

        // }

    }

    public function load_customer(Request $request){

        $cari = $request->q;
        $data = Customer::select('id','name')->where('name', 'LIKE', "%$cari%")->get();
        // dd($data);
        foreach ($data as $query) {
            $results[] = ['value' => $query];
            }
        
        return response()->json($data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($branch_id)
    {

        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();

        $data_customer_transport_sys_alerts = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();

        $alert_items = Item::where('flag',0)->get();

        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $prefix = Company_branchs::globalmaster(Auth::User()->company_branch_id)->first();
        $APIs = $this->apiaddressbook::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);
        
        return view('admin.address_book.registration.registration_book_address',
                [
                    'menu'=>'Address Book Registration',
                    'alert_items' => $alert_items,
                    'choosen_user_with_branch' => $this->rest->session()->get('id'),
                    'some' => $this->rest->session()->get('id'),
                    'api_v1' => $responsecallbackme['api_v1'],
                    'api_v2' => $responsecallbackme['api_v2'],
                    'system_alert_item_vendor' => $data_customer_transport_sys_alerts,
                    'system_alert_item_customer' => $data_item_alert_sys_allows0,
                    'alert_customers' => $alert_customers
                    ]
                )
            ->with(compact('find_i_customer','prefix','cstm','shc','Mds','cstomers','Cty','sub_service'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $saved_address_book = Address_book::create([
            'name' => $request->origin,
            'details' => $request->origin_detail,
            'address' => $request->origin_address,
            'contact' => $request->origin_contact,
            'usersid' => Auth::User()->id,
            'phone' => $request->origin_phone,
            'users_company_id' => session()->get('company_id')
          ]);

          if(!$saved_address_book){
            App::abort(500, 'Error');
        } 
          else {
            //docs https://github.com/softon/sweetalert
            swal()->toast()->autoclose(3500)->message("Order has been archived","You have successfully added.",'info'); 

        }
    }

    public function stored_add_books(Request $request)
    {
        $saved_address_book = buku_alamatx::create([
            'name' => $request->names,
            'city_id' => $request->citys,
            'customer_id' => $request->customer,
            'details' => $request->detil,
            'usersid' => Auth::User()->id,
            'address' => $request->add_boo,
            'contact' => $request->contak,
            'phone' => $request->fone,
            'pic_name_destination' => '',
            'pic_name_origin' => '',
            'pic_phone_origin' => '',
            'pic_phone_destination' => '',
            'users_company_id' => session()->get('company_id')
          ]);

            if ($saved_address_book==false){
                App::abort(500, 'Error');
            } 
            else {
                //docs https://github.com/softon/sweetalert
                swal()->toast()->autoclose(3500)->message("Order has been archived","You have successfully added.",'info'); 

            }

        return redirect()->back();

    }

    public function load_auto_releated_cty($code){

        $data = City::where('id',$code)->get();
        // dd($data);
        foreach ($data as $query) {
           $results[] = ['value' => $query];
         }
     
        return response()->json($data);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($branch_id, $id)
    {
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();

        $data_customer_transport_sys_alerts = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();

        $alert_items = Item::where('flag',0)->get();

        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $cs = Customer::all();
        $cts = City::all();

        $dataix = buku_alamatx::with('customers')->find($id);
        $prefix = Company_branchs::globalmaster(Auth::User()->company_branch_id)->first();

        $APIs = $this->apiaddressbook::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);

        session(['id_address_book' => $id]);
        return view('admin.address_book.update.update_address_book',
                    [
                        'menu'=>'Address Book Registration',
                        'alert_items' => $alert_items,
                        'choosen_user_with_branch' => $this->rest->session()->get('id'),
                        'some' => $this->rest->session()->get('id'),
                        'api_v1' => $responsecallbackme['api_v1'],
                        'api_v2' => $responsecallbackme['api_v2'],
                        'system_alert_item_vendor' => $data_customer_transport_sys_alerts,
                        'system_alert_item_customer' => $data_item_alert_sys_allows0,
                        'alert_customers' => $alert_customers
                    ]
                )
            ->with(compact('dataix','customers','prefix','find_i_customer','cs','cts','Mds','cstomers','Cty','sub_service'));
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
        $item = buku_alamatx::findOrFail($id);
        $item->customer_id = Request('customer');
        $item->name = Request('names');
        $item->city_id = Request('citys');
        $item->details = Request('detil');
        $item->address = Request('add_boo');
        $item->contact = Request('contak');
        $item->phone = Request('fone');
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
