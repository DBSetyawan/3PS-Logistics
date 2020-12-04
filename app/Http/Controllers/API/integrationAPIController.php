<?php

namespace warehouse\Http\Controllers\API;

use warehouse\Models\Item;
use Illuminate\Http\Request;
use warehouse\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use warehouse\Models\Company_branchs;
use warehouse\Http\Controllers\Controller;
use warehouse\Models\Vendor_item_transports;
use warehouse\Models\APIintractive as dbcheck;
use warehouse\Models\Item_transport as Customer_item_transports;
class integrationAPIController extends Controller
{

    private $api_integration;

    public function __construct(Request $GETclient)
    {
        $this->api_integration = $GETclient;
        $this->middleware(['auth', 'verified','CekOpenedTransaction','BlockedBeforeSettingUser', 'permission:warehouse|accounting|transport|superusers|developer']);
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

            foreach ($data_user_role as $key => $value) {
            # code...
            $auths = $value->name;

            }

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

            return view('API_integration.module_api_interface',[
                'menu'=>'APIs Client',
                'choosen_user_with_branch' => $this->api_integration->session()->get('id'),
                'some' => $this->api_integration->session()->get('id'),
                'system_alert_item_customer' => $data_item_alert_sys_allows0,
                'alert_items' => $alert_items,
                'system_alert_item_vendor' => $system_alert_item_vendor,
                'api_v1' => $fetchArray1,
                'api_v2' => $fetchArray2,
                'module_api' => $get_all_data,
                'alert_customers' => $alert_customers]
            )->with(compact('prefix','auths'));

        }

    }

    public function APIs_interactive(){

        if (Gate::allows('superusers') || Gate::allows('developer') || Gate::allows('transport') || Gate::allows('accounting') || Gate::allows('warehouse')) {
        
            $api_checking = $this->api_integration->izzy;

            foreach ($api_checking as $checked) {
                # code...
                $fr = $checked;
            }

            $data = dbcheck::where('check_is', $fr)->get();
            foreach($data as $operation){

                $check = $operation->check_is;

            }

            if($check == "api_izzy"){

            $file = dbcheck::where('check_is', $fr)->first();

                    $file->update(
                        [
                            'operation' => 'true',
                        ]
                    );

                return response()->json($data);

            } 

            if($check == "api_accurate"){

                $file = dbcheck::where('check_is', $fr)->first();

                    $file->update(
                        [
                            'operation' => 'true',
                        ]
                    );

                return response()->json($data);

            }

        }

    } 

    public function APIs_unactive(){

        if (Gate::allows('superusers') || Gate::allows('developer') || Gate::allows('transport') || Gate::allows('accounting') || Gate::allows('warehouse')) {

            $api_checking = $this->api_integration->accurate;

            foreach ($api_checking as $checked) {
                # code...
                $fr = $checked;
                
                if($fr == "api_izzy"){ 

                    $file = dbcheck::where('check_is', $fr)->first();

                        $file->update(
                            [
                                'operation' => 'false',
                            ]
                        );
                        
                    return response()->json($file);

                }

                if($fr == "api_accurate"){ 

                    $file = dbcheck::where('check_is', $fr)->first();

                        $file->update(
                            [
                                'operation' => 'false',
                            ]
                        );
                        
                    return response()->json($file);

                }
            }
        }
    } 

    public static function callstaticfunction(){
        
        if (Gate::allows('superusers') || Gate::allows('developer') || Gate::allows('transport') || Gate::allows('accounting') || Gate::allows('warehouse')) {
        
            $data = dbcheck::select('check_is','operation')->get();

                foreach($data as $operation){

                    $return[] = $operation;
                }
        
            return response()->json($return);
        }

    }
          
}
