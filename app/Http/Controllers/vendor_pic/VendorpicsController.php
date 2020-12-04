<?php

namespace warehouse\Http\Controllers\vendor_pic;

use warehouse\Models\City;
use warehouse\Models\Item;
use Illuminate\Http\Request;
use warehouse\Models\Vendor;
use warehouse\Models\Customer;
use warehouse\Models\Vendor_pics;
use warehouse\Models\Vendor_status;
use warehouse\Http\Controllers\Controller;
use warehouse\Http\Controllers\ManagementController as RESTAPIs;

class VendorpicsController extends Controller
{
    protected $apiaddressbook;
    private $rest;

    public function __construct(RESTAPIs $apisrestaddressbook, Request $REST)
    {
      $this->middleware(['verified','CekOpenedTransaction','BlockedBeforeSettingUser','role:super_users|administrator|3PL[OPRASONAL][TC][WHS]|3PL[OPRASONAL][TC]|3PL[OPRASONAL][WHS]']);
      $this->apiaddressbook = $apisrestaddressbook;
      $this->rest = $REST;

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

      'name_customer' => 'required','position_customer'=>'required',
      'email_customer'=>'required','phone_customer'=>'required','mobile_phone_customer' => 'required'

    ]);

      Vendor_pics::create([
        'name' => $request->name_customer,
        'vendor_id' => $request->vendor_id_customer,
        'vendor_pic_status_id' => $request->vendor_pic_status_customer,
        'position' => $request->position_customer ,
        'email' => $request->email_customer,
        'phone' => $request->phone_customer,
        'mobile_phone' => $request->mobile_phone_customer
      ]);

      return redirect('vendor')->with('success', 'Information has been added');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // dd($id);
        $vst = Vendor::with('city','industry','status','vendor_pics')->find($id);
        $vstatus = Vendor_status::all();
        $tablevpc = Vendor_pics::find($id);
        $city = City::all();

        // dd($tablevpc);
        $vp = vendor_pics::find($id);
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $alert_items = Item::where('flag',0)->get();
        $details_pics = Vendor_pics::with('vendor')->find($id);
            // dd($details_pics);
        return view('admin.vendor.editregistration', [
            'menu' => 'Edit Vendor PIC',
            'choosen_user_with_branch' => $this->rest->session()->get('id'),
            'some' => $this->rest->session()->get('id'),
            'alert_items' => $alert_items,
            'alert_customers' => $alert_customers])->with(compact('details_pics','vendor',
            'vst','vp','vstatus','tablevpc','city'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
     // dd($id);
     $vst = Vendor::with('city','industry','status','vendor_pics')->find($id);
     $vstatus = Vendor_status::all();
     $city = City::all();

     $tablevpc = Vendor_pics::find($id);
     // dd($tablevpc);
     $vp = vendor_pics::find($id);
     $details_pics = Vendor_pics::with('vendor')->find($id);
       // dd($details_pics);
            return view('admin.vendor.detailvendorpics', [
                'menu' => 'Vendor Details PIC'])->with(compact('city','details_pics','vendor','vst','vp','vstatus','tablevpc')
            );
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
      $vendorpic = Vendor_pics::find($id);
      // dd($vendorpic);
      $vendorpic->name = Request('name_customer');
      $vendorpic->vendor_pic_status_id = Request('vendor_pic_status_customer');
      $vendorpic->position = Request('position_customer');
      $vendorpic->email = Request('email_customer');
      $vendorpic->phone = Request('phone_customer');
      $vendorpic->mobile_phone = Request('mobile_phone_customer');
      $vendorpic->save();

      $vst = Vendor::with('city','industry','status','vendor_pics')->find($id);
      $vstatus = Vendor_status::all();
      $city = City::all();
      $vp = Vendor_pics::find($id);
       // show the view and pass the vendors to it

       // return view('admin.vendor.editregistration', [
       //     'menu' => 'Vendor Edit'])->with(compact('vst','vp','city','vendor','vstatus','vendor_pics','tablevpc'));
         //
         // $vst = Vendor::with('city','industry','status','vendor_pics')->get();
         // return view('admin.vendor.vendorlist', [
         //     'menu' => 'Vendor List'])->with(compact('vendor','city','vst'));
        //  $vst = Vendor::with('city','industry','status','vendor_pics')->find($id);
        //  $vstatus = Vendor_status::all();
        //  $tablevpc = Vendor_pics::find($id);
         // dd($tablevpc);
        //  $vp = vendor_pics::find($id);

         // dd($vp);
          // dd($id);
          $alert_items = Item::where('flag',0)->get();
          $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        flash('Information has been updated.')->important();

        $vst = Vendor::with('city','industry','status','vendor_pics')->find($id);
        $vstatus = Vendor_status::all();
        $tablevpc = Vendor_pics::find($id);
        // dd($tablevpc);
        $vp = vendor_pics::find($id);
        $details_pics = Vendor_pics::with('vendor')->find($id);
            // dd($details_pics);
        return view('admin.vendor.detailvendorpics', [
                    'menu' => 'Vendor Details PIC',
                    'alert_items' => $alert_items,
                    'alert_customers' => $alert_customers
                ]
            )
        ->with(compact('details_pics','vendor','vst','vp','vstatus','tablevpc'));

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
