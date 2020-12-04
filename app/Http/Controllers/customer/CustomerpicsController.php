<?php

namespace warehouse\Http\Controllers\customer;

use Alert;
use Session;
use warehouse\Models\City;
use warehouse\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use warehouse\Models\Customer;
use warehouse\Models\Industrys;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use warehouse\Models\Customer_pics;
use Illuminate\App\Http\Controllers;
use Illuminate\Routing\UrlGenerator;
use warehouse\Models\Company_branchs;
use warehouse\Models\Customer_pic_status;
use warehouse\Http\Controllers\Controller;
use warehouse\Models\Vendor_item_transports;
use warehouse\Http\Controllers\API\integrationAPIController as RESTAPIs;
use warehouse\Models\Item_transport as Customer_item_transports;

class CustomerpicsController extends Controller
{

    protected $APIntegration;
    private $rest;

    public function __construct(RESTAPIs $API, Request $REST)
    {
        $this->middleware(['CekOpenedTransaction','BlockedBeforeSettingUser','verified','role:3PL - SURABAYA WAREHOUSE|super_users|3PL - BANDUNG TRANSPORT|administrator']);
        $this->rest = $REST;
        $this->APIntegration = $API;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        $this->validate($request, [

          'name_customer' => 'required',
          'position_customer'=>'required',
          'email_customer'=>'required|email',
          'phone_customer'=>'required',
          'mobile_phone_customer' => 'required'

      ]);

        Customer_pics::create([
        'name' => $request->name_customer,
        'customer_id' => $request->id_customer,
        'customer_pic_status_id' => $request->customer_pic_status_customer,
        'position' => $request->position_customer,
        'email' => $request->email_customer,
        'phone' => $request->phone_customer,
        'mobile_phone' => $request->mobile_phone_customer
        ]);
        alert()->success('Success Message', 'Optional Title');

        // flash('Informasi','Berhasil.')->important();
        return redirect('customer')->with('success', 'Informasi Customer PIC berhasil disimpan');
        URL::current();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $cstatusid = Customer::with('cstatusid')->where('flag',0)->get();
        $alert_items = Item::where('flag',0)->get();
        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $prefix = Company_branchs::globalmaster(Auth::User()->company_branch_id)->first();
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
                    'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
                    $APIs = $this->APIntegration::callbackme();
                    $responsecallbackme = json_decode($APIs->getContent(), true);
      
      $customerpics = Customer_pics::find($id);
      $vstatus = Customer_pic_status::all();
    //   $vstatus = Customer_status::all();
      $customers = Customer::with('cstatusid','city','industry','customer_pic')->find($id);
      // dd($customers);
      $city = City::all();
        return view('admin.customer.editcustomerregistration',
        [
            'menu' => 'Edit Customer',
            'alert_customers' => $alert_customers,
            'choosen_user_with_branch' => $this->rest->session()->get('id'),
            'some' => $this->rest->session()->get('id'),
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2'],
            'system_alert_item_vendor' => $system_alert_item_vendor,
            'system_alert_item_customer' => $data_item_alert_sys_allows0,
            'alert_items' => $alert_items,
            'prefix' => $prefix
        ]
            )->with(compact('customerpics','city',
            'customers','cstatusid','customer_pic','vstatus'
        ));

    //   return view('admin.customer.detailcustomerpics', [
    //       'menu' => 'Customer Details PIC'])->with(compact('customerpics','vstatus'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $cstatusid = Customer::with('cstatusid')->where('flag',0)->get();
        $alert_items = Item::where('flag',0)->get();
        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $prefix = Company_branchs::globalmaster(Auth::User()->company_branch_id)->first();
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
                    'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
                    $APIs = $this->APIntegration::callbackme();
                    $responsecallbackme = json_decode($APIs->getContent(), true);

      $customerpics = Customer_pics::find($id);
      $vstatus = Customer_pic_status::all();

          return view('admin.customer.detailcustomerpics',
          [
              'menu' => 'Edit Customer',
              'alert_customers' => $alert_customers,
              'choosen_user_with_branch' => $this->rest->session()->get('id'),
              'some' => $this->rest->session()->get('id'),
              'api_v1' => $responsecallbackme['api_v1'],
              'api_v2' => $responsecallbackme['api_v2'],
              'system_alert_item_vendor' => $system_alert_item_vendor,
              'system_alert_item_customer' => $data_item_alert_sys_allows0,
              'alert_items' => $alert_items,
              'prefix' => $prefix
          ]
              )->with(compact('customerpics','city',
              'customers','cstatusid','customer_pic','vstatus'
          ));
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
        //validation::form_validation!=use;
        // $this->validate($request, [
        //     'name_customer' => 'required',
        //     'customer_pic_status_customer'=>'required',
        //     'position_customer'=>'required',
        //     'email_customer'=>'required',
        //     'phone_customer'=>'required',
        //     'mobile_phone_customer'=>'required'
        // ]);

        $updatedtocustomerpics = Customer_pics::find($id);
        $updatedtocustomerpics->name = Request('name_customer');
        $updatedtocustomerpics->customer_pic_status_id = Request('customer_pic_status_customer');
        $updatedtocustomerpics->position = Request('position_customer');
        $updatedtocustomerpics->email = Request('email_customer');
        $updatedtocustomerpics->phone = Request('phone_customer');
        $updatedtocustomerpics->mobile_phone = Request('mobile_phone_customer');
        $updatedtocustomerpics->save();

        URL::current();
        $customerpics = Customer_pics::find($id);
        $vstatus = Customer_pic_status::all();
        return redirect()->back()->with('success','Data PIC has been updated.');
       
        // flash('Informasi telah berhasil disimpan.')->important();
        // return view('admin.customer.detailcustomerpics', [
        //     'menu' => 'Customer Details PIC'])->with(compact('customerpics','vstatus'));

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
