<?php

namespace warehouse\Http\Controllers\history_order;

use Auth;
use warehouse\Models\Item;
use Illuminate\Http\Request;
use warehouse\Models\Customer;
use warehouse\Models\Order_history;
use warehouse\Models\Company_branchs;
use warehouse\Models\Transport_orders;
use warehouse\Http\Controllers\Controller;
use warehouse\Models\Vendor_item_transports;
use warehouse\Models\Order_transport_history as TrackShipments;
use warehouse\Http\Controllers\ManagementController as RESTAPIs;
use warehouse\Models\Item_transport as Customer_item_transports;
use warehouse\Models\Order_job_transaction_detail_history as TrackJobShipments;

class OrderHistoryController extends Controller
{

    protected $apivehicles;

    public function __construct(RESTAPIs $apisvehicles)
    {
        $this->middleware(['verified','BlockedBeforeSettingUser','permission:developer|transport|accounting|superusers']);
        $this->apivehicles = $apisvehicles;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Order_history $son)
    {
        //
        $APIs = $this->apivehicles::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);
        
        $prefix = Company_branchs::globalmaster(Auth::User()->company_branch_id)->first();
        $history_order_list = $son->all();
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();

        $data_customer_transport_sys_alerts = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();

        $alert_items = Item::where('flag',0)->get();

        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
          
        return view('admin.history_order.history_order',[
            'menu'=>'History Order List',
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2'],
            'alert_items' => $alert_items,
            'system_alert_item_vendor' => $data_customer_transport_sys_alerts,
            'system_alert_item_customer' => $data_item_alert_sys_allows0,
            'alert_customers' => $alert_customers]
        )->with(compact('history_order_list','prefix'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order_history $orderhistory, $id)
    {
        $orderhistories = $orderhistory->where('id',$id)->first();
        return response()->json($orderhistories);
    }

    public function find_show_detail_status(Order_history $orderhistory, $id)
    {

        $orderhistories = $orderhistory::with('user_order_history')->whereIn('order_id',[$id])->get();
        
        foreach ($orderhistories as $query) {

            $results[] = ['value' => $query];
            
        }

        return response()->json($orderhistories);
    }

    public function find_show_detail_status_transports(TrackShipments $TrackShipments,  Transport_orders $TO, $id)
    {
        $orderId = $TO->where('order_id', '=', $id)
                        ->first();

        if(isset($orderId->id)){
            $primaryOrders = $orderId->id;

        } else {
            $orderIdNonObject = $TO->whereIn('id',[$id])->first();
            $orderIdNonObjectId = $orderIdNonObject->id;
            $primaryOrders = $orderIdNonObjectId;
        }

        $orderhistories = $TrackShipments::with('user_order_transport_history')
                            ->whereIn('order_id',[$primaryOrders])->orderBy('created_at','DESC')->get();

        foreach ($orderhistories as $query) {

            $results[] = ['value' => $query];
            
        }

        return response()->json($orderhistories);
    }

    public function find_show_detail_status_Jobs(TrackJobShipments $jobstrack, $id)
    {
        $orderhistories = $jobstrack::with('user_order_job_shipment_history')->whereIn('job_no',[$id])->get();

        foreach ($orderhistories as $query) {

            $results[] = ['value' => $query];
            
        }

        return response()->json($orderhistories);
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
