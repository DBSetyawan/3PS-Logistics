<?php

namespace warehouse\Http\Controllers\API;

use GuzzleHttp\Client;
use warehouse\Models\Item;
use Illuminate\Http\Request;
use warehouse\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use warehouse\Models\Company_branchs;
use warehouse\Http\Controllers\Controller;
use warehouse\Models\Vendor_item_transports;
use warehouse\Models\APIintractive as dbcheck;
use warehouse\Http\Controllers\Services\AccuratecloudInterface;
use warehouse\Models\Item_transport as Customer_item_transports;

class AccurateCloudAPIController extends Controller
{
    const PROTOCOL_WEBHOOK = "http://your-api.co.id/api/webhook";

    private $api_integration;
    protected $access_token;
    private $openModulesAccurateCloud;

    public function __construct(Request $GETclient, AccuratecloudInterface $APInterfacecloud)
    {
        $this->access_token = "9e3c2b00-381e-4327-97d8-6c1b5345bd0c";
        $this->api_integration = $GETclient;
        $this->openModulesAccurateCloud = $APInterfacecloud;
        // $this->middleware(['auth', 'verified','CekOpenedTransaction','BlockedBeforeSettingUser', 'permission:warehouse|accounting|transport|superusers|developer']);
        // $this->middleware(['json.response']);
    }

    public function index($branch_id){
        
        if (Gate::allows('superusers') || Gate::allows('developer') || Gate::allows('transport') || Gate::allows('accounting') || Gate::allows('warehouse')) {

            $alert_items = Item::where('flag',0)->get();
            $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
            $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
            'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
            $system_alert_item_vendor = Vendor_item_transports::with('vendors',
            'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
            $prefix = Company_branchs::branchwarehouse($branch_id)->first();

            $fetch_izzy = dbcheck::where('check_is','=','api_izzy')->get();
            $get_all_data = dbcheck::all();
            $data_user_role = Auth::User()->roles;

            $datauser = array();

            // foreach ($data_user_role as $key => $value) {
            // # code...
            // $auths = $value->name;

            // }

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

            $date = gmdate('Y-m-d\TH:i:s\Z');
            $signatureSecretKey = "8856ec43765b690c2193e894433c41eb";
            
            return view('API_integration.moduleAccurateCloud',
                [
                    'menu'=>'Integration API accurate Online',
                    'choosen_user_with_branch' => $this->api_integration->session()->get('id'),
                    'some' => $this->api_integration->session()->get('id'),
                    'system_alert_item_customer' => $data_item_alert_sys_allows0,
                    'alert_items' => $alert_items,
                    'system_alert_item_vendor' => $system_alert_item_vendor,
                    'api_v1' => $fetchArray1,
                    'signatureSecretKey' => $signatureSecretKey,
                    'date' => $date,
                    'api_v2' => $fetchArray2,
                    'module_api' => $get_all_data,
                    'alert_customers' => $alert_customers
                ]
            )->with(compact('prefix'));

        }

    }

    public function AuthorizedAccurate(Request $api){
       $s = $this->openModulesAccurateCloud
                ->FuncAuthorizedAccurateCloud(
                    $api->input('client_id'),
                    $api->input('response_type'),
                    $api->input('redirect_uri'),
                    $api->input('scope')
            )
        ;
    }

    public function ShowDatabaseAccurateCloud(Request $api){
    
        $getCloudAccurate = $this->openModulesAccurateCloud
                ->FuncOpenmoduleAccurateCloudDblist(
                    $api->input('_ts')
                )
            ;

        return response()->json($getCloudAccurate);

    }


    public function getSessionDBAccurateCloud(Request $api){

        $getCloudAccurate = $this->openModulesAccurateCloud
                ->FuncOpenmoduleAccurateCloudSession();

        return response()->json($getCloudAccurate);

    }

    public function WiritingDBAccurateCloud(Request $api){
            
        $getCloudAccurate = $this->openModulesAccurateCloud
                ->FuncOpenmoduleAccurateCloudSaveItemBarangjasa__(
                    $api->input('session'),
                    $api->input('name'),
                    $api->input('itemType'),
                    $api->input('_ts')
                )
            ;

        return response()->json($getCloudAccurate->original);
     
    }

    public function AccurateCloudSessionModules(Request $api){
            
        $getCloudAccurate = $this->openModulesAccurateCloud
                        ->FuncAlwaysOnSessionAccurateCluod();
                        
        return response()->json($getCloudAccurate);
     
    }

    public function ItemListDBAccurateCloud(Request $api){
            
        $getCloudAccurate = $this->openModulesAccurateCloud
                    ->FuncOpenmoduleAccurateCloudItemList(
                            $api->input('fields'),
                            $api->input('itemType')
                    );

        return response()->json($getCloudAccurate);

    }

    public function MasterCustomerDBAccurateCloud($session, $fields, $_ts){
            
        $getCloudAccurate = $this->openModulesAccurateCloud
                    ->FuncOpenmoduleAccurateCloudAllMasterCustomerList(
                            $session,
                            $fields,
                            $_ts
                    );

        return response()->json($getCloudAccurate);

    }

    public function DetailItemListDBAccurateCloud(Request $api){

        $getCloudAccurate = $this->openModulesAccurateCloud
                ->FuncOpenmoduleAccurateCloudShowDetailDatabase(
                        $api->input('session'),
                        $api->input('id'),
                        $api->input('_ts')
                    );

        return response()->json($getCloudAccurate->original["d"]["id"]);

    }

    public function SaveCustomerDBAccurateCloud(Request $api){

        $getCloudAccurate = $this->openModulesAccurateCloud
                ->FuncOpenmoduleAccurateCloudSaveCustomer(
                        $api->input('session'),
                        $api->input('name'),
                        $api->input('transDate'),
                        $api->input('_ts')
                    );

        return response()->json($getCloudAccurate->original);

    }

    public function SaveSalesOrderDBAccurateCloud(Request $api){

        $getCloudAccurate = $this->openModulesAccurateCloud
                ->FuncOpenmoduleAccurateCloudSaveSalesOrders(
                        $api->input('session'),
                        $api->input('customerNo'),
                        $api->input('itemNo'),
                        $api->input('transDate'),
                        $api->input('_ts')
                    );

        return response()->json($getCloudAccurate->original["r"]["id"]);

    }

}