<?php

namespace warehouse\Http\Controllers\vehicle;

use Auth;
use warehouse\Models\City;
use warehouse\Models\Item;
use Illuminate\Http\Request;
use warehouse\Models\Vehicle;
use warehouse\Models\Customer;
use warehouse\Models\MAassociate;
use Illuminate\Support\Facades\Crypt;
use warehouse\Models\Company_branchs;
use warehouse\Http\Controllers\Controller;
use warehouse\Models\Vendor_item_transports;
use warehouse\Http\Controllers\ManagementController as RESTAPIs;
use warehouse\Models\Item_transport as Customer_item_transports;

class VehicleController extends Controller
{
    protected $apivehicles;
    private $rests;

    public function __construct(RESTAPIs $apisvehicles, Request $RESTdd)
    {
        $this->middleware(['verified','BlockedBeforeSettingUser','role:super_users|administrator']);
        $this->apivehicles = $apisvehicles;
        $this->rests = $RESTdd;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Vehicle $Vehicle)
    {
        $APIs = $this->apivehicles::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);

        $alert_items = Item::where('flag',0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();

        $Vehicle = $Vehicle->whereIn('users_company_id', [session()->get('company_id')])->get();
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();

        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();

        $prefix = Company_branchs::branchwarehouse(Auth::User()->company_branch_id)->first();
        
        return view('admin.vehicle.vehicle_to_list',[
            'menu'=>'Vehicle List',
            'choosen_user_with_branch' => $this->rests->session()->get('id'),
            'some' => $this->rests->session()->get('id'),
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2'],
            'system_alert_item_customer' => $data_item_alert_sys_allows0,
            'alert_items' => $alert_items,
            'system_alert_item_vendor' => $system_alert_item_vendor,
            'alert_customers' => $alert_customers]
        )->with(compact('Vehicle','prefix'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($branch_id)
    {
        //
        $APIs = $this->apivehicles::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);
        $alert_items = Item::where('flag',0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $data_transport = Vehicle::all();
        $city = City::all();
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $prefix = Company_branchs::branchwarehouse(Auth::User()->company_branch_id)->first();
        return view('admin.vehicle.registration_vehicle',[
            'menu'=>'Vehicle List',
            'choosen_user_with_branch' => $this->rests->session()->get('id'),
            'some' => $this->rests->session()->get('id'),
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2'],
            'system_alert_item_customer' => $data_item_alert_sys_allows0,
            'alert_items' => $alert_items,
            'system_alert_item_vendor' => $system_alert_item_vendor,
            'alert_customers' => $alert_customers]
        )->with(compact('data_transport','city','prefix'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Vehicle $tb_kendaraan, Request $request)
    {
        $results = $tb_kendaraan->create($request->all());
        $results->users_company_id = session()->get('company_id');
        $results->save();
        // return response()->json($results);
        swal()
        ->toast()
                ->autoclose(9000)
            ->message("Information", "You have successfully added!", 'success');

            return redirect()->route('registration.vehicle', session()->get('id'));
    }

    public function internal_vehicle_loader(Vehicle $vhcl, Request $request)
    {
        $data = $vhcl->get();
        foreach ($data as $query) {
           $results[] = ['value' => $query];
         }
        return response()->json($data);
    
    }

    public function internal_vehicle_find_it(Vehicle $vhcl, $id)
    {
        $data = $vhcl->where('id',$id)->get();
        foreach ($data as $query) {
           $results[] = ['value' => $query];
         }
        return response()->json($data);
    
    }

    public function choosen_vehicle__INV(MAassociate $mcs)
    {
        $foo = [];

            $sdasxcc = array_push($foo, (object)[
                    'id'=>1,
                    'name'=>'Vehicle Internal'
                    
                ], (object)[
                    'id'=>2,
                    'name'=>'Vendor'
            ]);

        return response()->json($foo);
    
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
        $alert_items = Item::where('flag',0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $vehicle_find = Vehicle::findOrFail($decrypts);
        $city = City::all();
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $prefix = Company_branchs::branchwarehouse(Auth::User()->company_branch_id)->first();
        $APIs = $this->apivehicles::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);
        session(['id_vehicle' => $id]);
        return view('admin.vehicle.edit_vehicle_list',[
            'menu'=>'Edit Vehicle List',
            'system_alert_item_customer' => $data_item_alert_sys_allows0,
            'alert_items' => $alert_items,
            'choosen_user_with_branch' => $this->rests->session()->get('id'),
            'some' => $this->rests->session()->get('id'),
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2'],
            'system_alert_item_vendor' => $system_alert_item_vendor,
            'alert_customers' => $alert_customers]
        )->with(compact('vehicle_find','city','prefix'));
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
        $APIs = $this->apivehicles::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);
        $alert_items = Item::where('flag',0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $vehicle_find = Vehicle::findOrFail($id);
        $city = City::all();
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $prefix = Company_branchs::branchwarehouse(Auth::User()->company_branch_id)->first();
        return view('admin.vehicle.edit_vehicle_list',[
            'menu'=>'Edit Vehicle List',
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2'],
            'system_alert_item_customer' => $data_item_alert_sys_allows0,
            'alert_items' => $alert_items,
            'choosen_user_with_branch' => $this->rests->session()->get('id'),
            'some' => $this->rests->session()->get('id'),
            'system_alert_item_vendor' => $system_alert_item_vendor,
            'alert_customers' => $alert_customers]
        )->with(compact('vehicle_find','city','prefix'));
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
        $vehicle_data = Vehicle::findOrFail($id);
        $vehicle_data->registrationNumberPlate = Request('registrationNumberPlate');
        $vehicle_data->nameOfOwner = Request('nameOfOwner');
        $vehicle_data->ownerAddress = Request('ownerAddress');
        $vehicle_data->brand = Request('brand');
        $vehicle_data->type = Request('type');
        $vehicle_data->model = Request('model');
        $vehicle_data->cylinderCapacity = Request('cylinderCapacity');
        $vehicle_data->manufactureYear = Request('manufactureYear');
        $vehicle_data->engineNumber = Request('engineNumber');
        $vehicle_data->color = Request('color');
        $vehicle_data->typeFuel = Request('typeFuel');
        $vehicle_data->licensePlateColor = Request('licensePlateColor');
        $vehicle_data->registrationYear = Request('registrationYear');
        $vehicle_data->vehicleOwnershipDocumentNumber = Request('vehicleOwnershipDocumentNumber');
        $vehicle_data->locationCode = Request('locationCode');
        $vehicle_data->registrationQueNumber = Request('registrationQueNumber');
        $vehicle_data->dateOfExpire = Request('dateOfExpire');
        $vehicle_data->save();
        swal()
        ->toast()
                ->autoclose(9000)
            ->message("Information", "You have successfully updated!", 'info');
        $alert_items = Item::where('flag',0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $vehicle_find = Vehicle::findOrFail($id);
        $city = City::all();
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $prefix = Company_branchs::branchwarehouse(Auth::User()->company_branch_id)->first();
        $APIs = $this->apivehicles::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);
        return view('admin.vehicle.edit_vehicle_list',[
            'menu'=>'Edit Vehicle List',
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2'],
            'system_alert_item_customer' => $data_item_alert_sys_allows0,
            'alert_items' => $alert_items,
            'choosen_user_with_branch' => $this->rests->session()->get('id'),
            'some' => $this->rests->session()->get('id'),
            'system_alert_item_vendor' => $system_alert_item_vendor,
            'alert_customers' => $alert_customers]
        )->with(compact('vehicle_find','city','prefix'));

     
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
