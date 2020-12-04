<?php

namespace warehouse\Http\Controllers\Cash_advanced;

use Auth;
use Carbon\Carbon;
use warehouse\Models\Item;
use Illuminate\Http\Request;
use warehouse\Models\Driver;
use warehouse\Models\Customer;
use warehouse\Models\Jobs_cost;
use warehouse\Models\cashadvance;
use warehouse\Models\Category_cost;
use Illuminate\Support\Facades\Gate;
use warehouse\Models\Job_transports;
use warehouse\Models\Company_branchs;
use warehouse\Models\Status_cash_advance;
use warehouse\Http\Controllers\Controller;
use warehouse\Models\Cash_transaction_rpt;
use warehouse\Models\Vendor_item_transports;
use warehouse\Http\Controllers\ManagementController as RESTAPIs;
use warehouse\Models\Item_transport as Customer_item_transports;

class CashadvancedController extends Controller
{
    protected $APIcash;
    private $rest;
    
    public function __construct(RESTAPIs $apicashadvanced, Request $RESTs)
    {
        $this->middleware(['auth','verified','BlockedBeforeSettingUser','CekOpenedTransaction',
            'role:3PL[SPV]|3PE[SPV]|3PL[DRIVERS]|3PE[DRIVERS]|3PL[OPRASONAL][KASIR]|3PE[OPRASONAL][KASIR]|administrator|super_users|3PL SURABAYA ALL PERMISSION'
        ]);
        $this->APIcash = $apicashadvanced;
        $this->rest = $RESTs;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($branch_id)
    {
        $APIs = $this->APIcash::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);

        $alert_items = Item::where('flag',0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        
        foreach (Auth::User()->roles as $key => $value) {
            # code...
            if ($value->name == "3PL[DRIVERS]" || $value->name == "3PL SURABAYA ALL PERMISSION" || $value->name == "administrator" || Gate::allows('superusers') || Gate::allows('developer')) {
                # code...
                $driver = Driver::where('user_driver_id', Auth::User()->id)->get();
                foreach ($driver as $key => $tutut) {
                    # code...
                    $cashadvance = cashadvance::with(['status_advanced','drivers_master' => function ($query) {
                        $query->whereIn('user_driver_id', [Auth::User()->id]);
                    }])->where('id_penerima', $tutut->id)->get();

                    foreach ($cashadvance as $key => $dxczf) {
                        $rpt = Cash_transaction_rpt::where('driversid',$tutut->id)->get();
                        # code...
                        $total = $dxczf->amount - $rpt->sum('amount');
                    }

                    $datacount = cashadvance::where('id_penerima', $tutut->id)->sum('amount');

                }
            }
            if ($value->name == "3PE[DRIVERS]" || $value->name == "administrator" || $value->name == "3PL SURABAYA ALL PERMISSION" || Gate::allows('superusers') ||  Gate::allows('developer')) {
                # code...
                $driver = Driver::where('user_driver_id', Auth::User()->id)->get();
                foreach ($driver as $key => $tutut) {
                    # code...
                    $cashadvance = cashadvance::with(['status_advanced','drivers_master' => function ($query) {
                        $query->whereIn('user_driver_id', [Auth::User()->id]);
                    }])->where('id_penerima', $tutut->id)->get();

                    foreach ($cashadvance as $key => $dxczf) {
                        $rpt = Cash_transaction_rpt::where('driversid',$tutut->id)->get();
                        # code...
                        $total = $dxczf->amount - $rpt->sum('amount');
                    }

                    $datacount = cashadvance::where('id_penerima', $tutut->id)->sum('amount');

                }

            }
            if ($value->name == "3PL[OPRASONAL][KASIR]" || $value->name == "3PL SURABAYA ALL PERMISSION" || $value->name == "administrator" || Gate::allows('superusers') || Gate::allows('developer')) {
                # code...
                $cashadvance = cashadvance::with('status_advanced','drivers_master')->where('id_pemberi', Auth::User()->id)->get();
                $datacount = cashadvance::where('id_pemberi', Auth::User()->id)->sum('amount');
                // $cashadvance = Cash_transaction_rpt::with('status_cash_advanced','drivers_master')->whereNotNull('cash_advanced_id')->get();
                
            }
            if ($value->name == "3PE[OPRASONAL][KASIR]" || $value->name == "administrator" || $value->name == "3PL SURABAYA ALL PERMISSION" || Gate::allows('superusers') || Gate::allows('developer')) {
                # code...
                $cashadvance = cashadvance::with('status_advanced','drivers_master')->where('id_pemberi', Auth::User()->id)->get();
                $datacount = cashadvance::where('id_pemberi', Auth::User()->id)->sum('amount');
            }
            if ($value->name == "3PE[SPV]" || $value->name == "3PL[SPV]" ||$value->name == "administrator" || $value->name == "3PL SURABAYA ALL PERMISSION" || Gate::allows('superusers') || Gate::allows('developer')) {
                # code...
                $cashadvance = cashadvance::with('status_advanced','drivers_master')->get();
                $datacount = cashadvance::sum('amount');
            }

        }


        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $prefix = Company_branchs::branchwarehouse(Auth::User()->company_branch_id)->first();
        return view('admin.cash_advanced.master_list_cash_advanced.cash_advanced_list',[
            'menu'=>'Cash Advanced list',
            'system_alert_item_customer' => $data_item_alert_sys_allows0,
            'alert_items' => $alert_items,
            'choosen_user_with_branch' => $branch_id,
            'some' => $branch_id,
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2'],
            'system_alert_item_vendor' => $system_alert_item_vendor,
            'alert_customers' => $alert_customers]
        )->with(compact('cashadvance','prefix','datacount','dataselisih','total'));
    }

    public function load_data_all_drivers(Request $request)
    {

        $cari = $request->load;
        $data = Driver::where('id', 'LIKE', "%$cari%")->get();
  
        foreach ($data as $query) {
            $results[] = ['value' => $query ];
        }

        return response()->json($data);
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Cash_transaction_rpt $rpt)
    {

        $APIs = $this->APIcash::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);

        $datacount = cashadvance::findOrFail($id);
        $alert_items = Item::where('flag',0)->get();
        $datadtl = $rpt->with(['categorys','jobs_shipments','status_cash_advanced'])->where('cash_advanced_id',$datacount->id)->get();
        $total_reports_cash = $rpt->where('cash_advanced_id',$datacount->id)->sum('amount');
        $count_report_amount = $rpt->where('cash_advanced_id',$datacount->id)->count();

        $hasil_selisih = $datacount->amount - $total_reports_cash;
        // dd($datadtl);
        // foreach (Auth::User()->roles as $key => $value) {
        //     # code...
        //     if ($value->name == "3PL[DRIVERS]") {
        //         # code...
        //         $driver = Driver::where('user_driver_id', Auth::User()->id)->get();
        //         foreach ($driver as $key => $tutut) {
        //             # code...
        //             $cashadvance = cashadvance::with(['status_advanced','drivers_master' => function ($query) {
        //                 $query->whereIn('user_driver_id', [Auth::User()->id]);
        //             }])->where('id_penerima', $tutut->id)->get();
        //         }
        //     }
        //     if ($value->name == "3PE[DRIVERS]") {
        //         # code...
        //         $driver = Driver::where('user_driver_id', Auth::User()->id)->get();
        //         foreach ($driver as $key => $tutut) {
        //             # code...
        //             $cashadvance = cashadvance::with(['status_advanced','drivers_master' => function ($query) {
        //                 $query->whereIn('user_driver_id', [Auth::User()->id]);
        //             }])->where('id_penerima', $tutut->id)->get();
        //         }

        //     }
        // }
        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $prefix = Company_branchs::branchjobs(Auth::User()->company_branch_id)->first();
    
        return view('admin.cash_advanced.detail_cash_advanced.detail_cash_advanced',[
            'menu'=>'Detail Cash Advanced List',
            'alert_items'=> $alert_items,
            'id'=> $id,
            'choosen_user_with_branch' => $this->rest->session()->get('id'),
            'some' => $this->rest->session()->get('id'),
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2'],
            'system_alert_item_vendor' => $system_alert_item_vendor,
            'system_alert_item_customer' => $data_item_alert_sys_allows0,
            'alert_customers'=> $alert_customers])->with(compact('prefix','datacount','datadtl','total_reports_cash','count_report_amount','hasil_selisih')
        );
    }

    public function add_cash_advanced(cashadvance $ca, Request $request){

            $datacash_advanced[] = [
                'id_penerima' => $request->get('driver'),
                'id_pemberi' => Auth::User()->id,
                'status' => 1,
                'amount' => $request->get('amount'),
                'selisih' => $request->get('amount'),
                'report_amount' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
    
            $ca->insert($datacash_advanced);
            $datacount = $ca->sum('amount');
            return response()->json(
                [
                    'total_amount' => $datacount,
                    'response' => 'data anda berhasil disimpan',
    
                ]
            );

        }

        public function loads_categorys_cost(Request $request)
        {
            $cari = $request->load;
            $data = Category_cost::where('id', 'LIKE', "%$cari%")->get();
            foreach ($data as $query) {
               $results[] = ['value' => $query];
            }
            
            return response()->json($data);
        
        }

        public function loads_jobshipments(Request $request)
        {
            $cari = $request->load;
            $data = Job_transports::where('id', 'LIKE', "%$cari%")->get();
            foreach ($data as $query) {
               $results[] = ['value' => $query];
            }
            
            return response()->json($data);
        
        }

        public function add_cash_advanced_transaction(cashadvance $ca, Request $request){

            $datacash_advanced[] = [
                'id_penerima' => $request->get('driver'),
                'id_pemberi' => Auth::User()->id,
                'status' => 1,
                'amount' => $request->get('amount'),
                'selisih' => $request->get('amount'),
                'report_amount' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
    
            $ca->insert($datacash_advanced);
            $datacount = $ca->sum('amount');
            return response()->json(
                [
                    'total_amount' => $datacount,
                    'response' => 'data anda berhasil disimpan',
    
                ]
            );

        }

        public function search_cash_advanced(Job_transports $jts, $jobid){
            $results = $jts->where('id',$jobid)->get();

            return response()->json($results);
        }

        public function search_status_cash_master(Request $request, Status_cash_advance $sca, Cash_transaction_rpt $cashadnc, $id)
        {

            if(Gate::allows('superusers') || Gate::allows('developer')){

                $user = Auth::User()->roles;
                $datauser = array();
                foreach ($user as $key => $value) {
                # code...
                $datauser = $value->name;
    
                }

                $t_rts = $cashadnc->with(['status_cash_advanced'])->where('id',$id)->get();
                foreach ($t_rts as $hasil) {
                    $results = $hasil->status_cash_advanced->name;
                }

                if ($datauser=="3PL[OPRASONAL][KASIR]") {
                    if ($results=="create") {
                        # code...
                        $cari = $request->q;
                        $data_status_cash = array('');
                        // $data_for_tc = array('draft','cancel','proses','pod');
                        $data = $sca->select('id', 'name')->whereIn('name', $data_status_cash)->where('name', 'LIKE', "%$cari%")->get();
                        // $data = $sca->select('id','name')->where('name', 'LIKE', "%$cari%")->get();
            
                        return response()->json($data);
        
                    }

                    if ($results=="approve") {
                        # code...
                        $cari = $request->q;
                        $data_status_cash = array('');
                        // $data_for_tc = array('draft','cancel','proses','pod');
                        $data = $sca->select('id', 'name')->whereIn('name', $data_status_cash)->where('name', 'LIKE', "%$cari%")->get();
                        // $data = $sca->select('id','name')->where('name', 'LIKE', "%$cari%")->get();
            
                        return response()->json($data);
        
                    }

                    if ($results=="reject") {
                        # code...
                        $cari = $request->q;
                        $data_status_cash = array('');
                        // $data_for_tc = array('draft','cancel','proses','pod');
                        $data = $sca->select('id', 'name')->whereIn('name', $data_status_cash)->where('name', 'LIKE', "%$cari%")->get();
                        // $data = $sca->select('id','name')->where('name', 'LIKE', "%$cari%")->get();
            
                        return response()->json($data);
        
                    }

                    if ($results=="check") {
                        # code...
                        $cari = $request->q;
                        $data_status_cash = array('');
                        // $data_for_tc = array('draft','cancel','proses','pod');
                        $data = $sca->select('id', 'name')->whereIn('name', $data_status_cash)->where('name', 'LIKE', "%$cari%")->get();
                        // $data = $sca->select('id','name')->where('name', 'LIKE', "%$cari%")->get();
            
                        return response()->json($data);
        
                    }

                    if ($results=="report") {
                        # code...
                        $cari = $request->q;
                        $data_status_cash = array('check','reject');
                        // $data_for_tc = array('draft','cancel','proses','pod');
                        $data = $sca->select('id', 'name')->whereIn('name', $data_status_cash)->where('name', 'LIKE', "%$cari%")->get();
                        // $data = $sca->select('id','name')->where('name', 'LIKE', "%$cari%")->get();
            
                        return response()->json($data);
        
                    }
        
                }

                if ($datauser=="3PE[OPRASONAL][KASIR]") {
                    if ($results=="create") {
                        # code...
                        $cari = $request->q;
                        $data_status_cash = array('');
                        // $data_for_tc = array('draft','cancel','proses','pod');
                        $data = $sca->select('id', 'name')->whereIn('name', $data_status_cash)->where('name', 'LIKE', "%$cari%")->get();
                        // $data = $sca->select('id','name')->where('name', 'LIKE', "%$cari%")->get();
            
                        return response()->json($data);
        
                    }

                    if ($results=="approve") {
                        # code...
                        $cari = $request->q;
                        $data_status_cash = array('');
                        // $data_for_tc = array('draft','cancel','proses','pod');
                        $data = $sca->select('id', 'name')->whereIn('name', $data_status_cash)->where('name', 'LIKE', "%$cari%")->get();
                        // $data = $sca->select('id','name')->where('name', 'LIKE', "%$cari%")->get();
            
                        return response()->json($data);
        
                    }

                    if ($results=="reject") {
                        # code...
                        $cari = $request->q;
                        $data_status_cash = array('');
                        // $data_for_tc = array('draft','cancel','proses','pod');
                        $data = $sca->select('id', 'name')->whereIn('name', $data_status_cash)->where('name', 'LIKE', "%$cari%")->get();
                        // $data = $sca->select('id','name')->where('name', 'LIKE', "%$cari%")->get();
            
                        return response()->json($data);
        
                    }

                    if ($results=="check") {
                        # code...
                        $cari = $request->q;
                        $data_status_cash = array('');
                        // $data_for_tc = array('draft','cancel','proses','pod');
                        $data = $sca->select('id', 'name')->whereIn('name', $data_status_cash)->where('name', 'LIKE', "%$cari%")->get();
                        // $data = $sca->select('id','name')->where('name', 'LIKE', "%$cari%")->get();
            
                        return response()->json($data);
        
                    }

                    if ($results=="report") {
                        # code...
                        $cari = $request->q;
                        $data_status_cash = array('check','reject');
                        // $data_for_tc = array('draft','cancel','proses','pod');
                        $data = $sca->select('id', 'name')->whereIn('name', $data_status_cash)->where('name', 'LIKE', "%$cari%")->get();
                        // $data = $sca->select('id','name')->where('name', 'LIKE', "%$cari%")->get();
            
                        return response()->json($data);
        
                    }
        
                }

                if ($datauser=="3PL[DRIVERS]") {
                    if ($results=="check") {
                        # code...
                        $cari = $request->q;
                        $data_status_cash = array('');
                        // $data_for_tc = array('draft','cancel','proses','pod');
                        $data = $sca->select('id', 'name')->whereIn('name', $data_status_cash)->where('name', 'LIKE', "%$cari%")->get();
                        // $data = $sca->select('id','name')->where('name', 'LIKE', "%$cari%")->get();
            
                        return response()->json($data);
        
                    }

                    if ($results=="approve") {
                        # code...
                        $cari = $request->q;
                        $data_status_cash = array('');
                        // $data_for_tc = array('draft','cancel','proses','pod');
                        $data = $sca->select('id', 'name')->whereIn('name', $data_status_cash)->where('name', 'LIKE', "%$cari%")->get();
                        // $data = $sca->select('id','name')->where('name', 'LIKE', "%$cari%")->get();
            
                        return response()->json($data);
        
                    }

                    if ($results=="create") {
                        # code...
                        $cari = $request->q;
                        $data_status_cash = array('report');
                        // $data_for_tc = array('draft','cancel','proses','pod');
                        $data = $sca->select('id', 'name')->whereIn('name', $data_status_cash)->where('name', 'LIKE', "%$cari%")->get();
                        // $data = $sca->select('id','name')->where('name', 'LIKE', "%$cari%")->get();
            
                        return response()->json($data);
        
                    }

                    if ($results=="report") {
                        # code...
                        $cari = $request->q;
                        $data_status_cash = array('');
                        // $data_for_tc = array('draft','cancel','proses','pod');
                        $data = $sca->select('id', 'name')->whereIn('name', $data_status_cash)->where('name', 'LIKE', "%$cari%")->get();
                        // $data = $sca->select('id','name')->where('name', 'LIKE', "%$cari%")->get();
            
                        return response()->json($data);
        
                    }

                    if ($results=="reject") {
                        # code...
                        $cari = $request->q;
                        $data_status_cash = array('');
                        // $data_for_tc = array('draft','cancel','proses','pod');
                        $data = $sca->select('id', 'name')->whereIn('name', $data_status_cash)->where('name', 'LIKE', "%$cari%")->get();
                        // $data = $sca->select('id','name')->where('name', 'LIKE', "%$cari%")->get();
            
                        return response()->json($data);
        
                    }
        
                }

                if ($datauser=="3PE[DRIVERS]") {
                    if ($results=="check") {
                        # code...
                        $cari = $request->q;
                        $data_status_cash = array('');
                        // $data_for_tc = array('draft','cancel','proses','pod');
                        $data = $sca->select('id', 'name')->whereIn('name', $data_status_cash)->where('name', 'LIKE', "%$cari%")->get();
                        // $data = $sca->select('id','name')->where('name', 'LIKE', "%$cari%")->get();
            
                        return response()->json($data);
        
                    }

                    if ($results=="approve") {
                        # code...
                        $cari = $request->q;
                        $data_status_cash = array('');
                        // $data_for_tc = array('draft','cancel','proses','pod');
                        $data = $sca->select('id', 'name')->whereIn('name', $data_status_cash)->where('name', 'LIKE', "%$cari%")->get();
                        // $data = $sca->select('id','name')->where('name', 'LIKE', "%$cari%")->get();
            
                        return response()->json($data);
        
                    }

                    if ($results=="create") {
                        # code...
                        $cari = $request->q;
                        $data_status_cash = array('report');
                        // $data_for_tc = array('draft','cancel','proses','pod');
                        $data = $sca->select('id', 'name')->whereIn('name', $data_status_cash)->where('name', 'LIKE', "%$cari%")->get();
                        // $data = $sca->select('id','name')->where('name', 'LIKE', "%$cari%")->get();
            
                        return response()->json($data);
        
                    }

                    if ($results=="report") {
                        # code...
                        $cari = $request->q;
                        $data_status_cash = array('');
                        // $data_for_tc = array('draft','cancel','proses','pod');
                        $data = $sca->select('id', 'name')->whereIn('name', $data_status_cash)->where('name', 'LIKE', "%$cari%")->get();
                        // $data = $sca->select('id','name')->where('name', 'LIKE', "%$cari%")->get();
            
                        return response()->json($data);
        
                    }

                    if ($results=="reject") {
                        # code...
                        $cari = $request->q;
                        $data_status_cash = array('');
                        // $data_for_tc = array('draft','cancel','proses','pod');
                        $data = $sca->select('id', 'name')->whereIn('name', $data_status_cash)->where('name', 'LIKE', "%$cari%")->get();
                        // $data = $sca->select('id','name')->where('name', 'LIKE', "%$cari%")->get();
            
                        return response()->json($data);
        
                    }
        
                }

                if ($datauser=="3PL[SPV]") {
                    if ($results=="check") {
                        # code...
                        $cari = $request->q;
                        $data_status_cash = array('reject','approve');
                        // $data_for_tc = array('draft','cancel','proses','pod');
                        $data = $sca->select('id', 'name')->whereIn('name', $data_status_cash)->where('name', 'LIKE', "%$cari%")->get();
                        // $data = $sca->select('id','name')->where('name', 'LIKE', "%$cari%")->get();
            
                        return response()->json($data);
        
                    }

                    if ($results=="approve") {
                        # code...
                        $cari = $request->q;
                        $data_status_cash = array('');
                        // $data_for_tc = array('draft','cancel','proses','pod');
                        $data = $sca->select('id', 'name')->whereIn('name', $data_status_cash)->where('name', 'LIKE', "%$cari%")->get();
                        // $data = $sca->select('id','name')->where('name', 'LIKE', "%$cari%")->get();
            
                        return response()->json($data);
        
                    }

                    if ($results=="create") {
                        # code...
                        $cari = $request->q;
                        $data_status_cash = array('');
                        // $data_for_tc = array('draft','cancel','proses','pod');
                        $data = $sca->select('id', 'name')->whereIn('name', $data_status_cash)->where('name', 'LIKE', "%$cari%")->get();
                        // $data = $sca->select('id','name')->where('name', 'LIKE', "%$cari%")->get();
            
                        return response()->json($data);
        
                    }

                    if ($results=="report") {
                        # code...
                        $cari = $request->q;
                        $data_status_cash = array('');
                        // $data_for_tc = array('draft','cancel','proses','pod');
                        $data = $sca->select('id', 'name')->whereIn('name', $data_status_cash)->where('name', 'LIKE', "%$cari%")->get();
                        // $data = $sca->select('id','name')->where('name', 'LIKE', "%$cari%")->get();
            
                        return response()->json($data);
        
                    }

                    if ($results=="reject") {
                        # code...
                        $cari = $request->q;
                        $data_status_cash = array('');
                        // $data_for_tc = array('draft','cancel','proses','pod');
                        $data = $sca->select('id', 'name')->whereIn('name', $data_status_cash)->where('name', 'LIKE', "%$cari%")->get();
                        // $data = $sca->select('id','name')->where('name', 'LIKE', "%$cari%")->get();
            
                        return response()->json($data);
        
                    }
        
                }

                if ($datauser=="3PE[SPV]") {
                    if ($results=="check") {
                        # code...
                        $cari = $request->q;
                        $data_status_cash = array('reject','approve');
                        // $data_for_tc = array('draft','cancel','proses','pod');
                        $data = $sca->select('id', 'name')->whereIn('name', $data_status_cash)->where('name', 'LIKE', "%$cari%")->get();
                        // $data = $sca->select('id','name')->where('name', 'LIKE', "%$cari%")->get();
            
                        return response()->json($data);
        
                    }

                    if ($results=="approve") {
                        # code...
                        $cari = $request->q;
                        $data_status_cash = array('');
                        // $data_for_tc = array('draft','cancel','proses','pod');
                        $data = $sca->select('id', 'name')->whereIn('name', $data_status_cash)->where('name', 'LIKE', "%$cari%")->get();
                        // $data = $sca->select('id','name')->where('name', 'LIKE', "%$cari%")->get();
            
                        return response()->json($data);
        
                    }

                    if ($results=="create") {
                        # code...
                        $cari = $request->q;
                        $data_status_cash = array('');
                        // $data_for_tc = array('draft','cancel','proses','pod');
                        $data = $sca->select('id', 'name')->whereIn('name', $data_status_cash)->where('name', 'LIKE', "%$cari%")->get();
                        // $data = $sca->select('id','name')->where('name', 'LIKE', "%$cari%")->get();
            
                        return response()->json($data);
        
                    }

                    if ($results=="report") {
                        # code...
                        $cari = $request->q;
                        $data_status_cash = array('');
                        // $data_for_tc = array('draft','cancel','proses','pod');
                        $data = $sca->select('id', 'name')->whereIn('name', $data_status_cash)->where('name', 'LIKE', "%$cari%")->get();
                        // $data = $sca->select('id','name')->where('name', 'LIKE', "%$cari%")->get();
            
                        return response()->json($data);
        
                    }

                    if ($results=="reject") {
                        # code...
                        $cari = $request->q;
                        $data_status_cash = array('');
                        // $data_for_tc = array('draft','cancel','proses','pod');
                        $data = $sca->select('id', 'name')->whereIn('name', $data_status_cash)->where('name', 'LIKE', "%$cari%")->get();
                        // $data = $sca->select('id','name')->where('name', 'LIKE', "%$cari%")->get();
            
                        return response()->json($data);
        
                    }
        
                }
            }
            // return response()->json($datauser);

        }

        public function find_show_cash_advanced_index(cashadvance $cashadvance, Request $request, $id)
        {

            $cashadvanceresults = $cashadvance->with('status_advanced')->where('id',$id)->first();
    
            return response()->json($cashadvanceresults);
          
        }

        public function updated_status_cash_advc_rpt($idx, cashadvance $cashadvance, Cash_transaction_rpt $csd, Request $request, $id)
        {
            if (!$request->update_status_ca) {
                # code...
                swal()
                ->toast()
                        ->autoclose(9000)
                    ->message("Pemberitahuan system", "Inputan tidak boleh kosong!", 'error');

                 return back();

            } else {

                    $cashadvancedList = $csd->where('id',$id)->first();
                    $cashadvancedList->status = $request->update_status_ca;
                    $cashadvancedList->save();

                    $cashadvcd = $cashadvance->where('id',$idx)->first();
                    $cashadvcd->status = $request->update_status_ca;
                    $cashadvcd->save();
                    
                // return response()->json($request->update_status_ca);
                swal()
                ->toast()
                        ->autoclose(9000)
                    ->message("Pemberitahuan system", "Status berhasil diubah!", 'success');

                return back();

            }

        }

        public function add_detail_drivers_of_cash(Cash_transaction_rpt $rpt, Request $d, Jobs_cost $jcst){

            foreach (Auth::User()->roles as $key => $value) {
                # code...
                if ($value->name == "3PL[DRIVERS]" || $value->name == "administrator") {
                    # code...
                    $driver = Driver::where('user_driver_id', Auth::User()->id)->get();
                    foreach ($driver as $key => $tutut) {
                        # code...
                        $cashadvance = cashadvance::with(['status_advanced','drivers_master' => function ($query) {
                            $query->whereIn('user_driver_id', [Auth::User()->id]);
                        }])->where('id', $d->get('cash_advid'))->get();

                        $reslt = $rpt->create([
                            'job_id' => $d->get('jobs'),
                            'cash_advanced_id' => $d->get('cash_advid'),
                            'category_cost_id' => $d->get('category'),
                            'driversid' => $tutut->id,
                            'status' => 1,
                            'amount' => $d->get('amouns'),
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);
                        
                        foreach ($cashadvance as $key => $dxczf) {
                            $rptz = Cash_transaction_rpt::where('driversid',$tutut->id)->where('cash_advanced_id', $d->get('cash_advid'))->get();
                            # code...
                            $total = $dxczf->amount - $rptz->sum('amount');
                            $tco = $rptz->count();

                        }
    
                        $datacount = cashadvance::where('id_penerima', $tutut->id)->sum('amount');
                        $update_selisih = cashadvance::where('id', $d->get('cash_advid'))->update(['selisih' => $total, 'report_amount' => $tco]);
    
                    }

                }
                 
                if ($value->name == "3PE[DRIVERS]" || $value->name == "administrator") {
                    # code...
                    $driver = Driver::where('user_driver_id', Auth::User()->id)->get();
                    foreach ($driver as $key => $tutut) {
                        # code...
                        $cashadvance = cashadvance::with(['status_advanced','drivers_master' => function ($query) {
                            $query->whereIn('user_driver_id', [Auth::User()->id]);
                        }])->where('id', $d->get('cash_advid'))->get();

                        $reslt = $rpt->create([
                            'job_id' => $d->get('jobs'),
                            'cash_advanced_id' => $d->get('cash_advid'),
                            'category_cost_id' => $d->get('category'),
                            'driversid' => $tutut->id,
                            'status' => 1,
                            'amount' => $d->get('amouns'),
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);
                        
                        foreach ($cashadvance as $key => $dxczf) {
                            $rptz = Cash_transaction_rpt::where('driversid',$tutut->id)->where('cash_advanced_id', $d->get('cash_advid'))->get();
                            # code...
                            $total = $dxczf->amount - $rptz->sum('amount');
                            $tco = $rptz->count();

                        }
    
                        $datacount = cashadvance::where('id_penerima', $tutut->id)->sum('amount');
                        $update_selisih = cashadvance::where('id', $d->get('cash_advid'))->update(['selisih' => $total, 'report_amount' => $tco]);
    
                    }

                }
    
            }

            $id = $jcst->select('id')->max('id');
            $jcost_plus = $id+1;
            $jcost_increment_id = $jcost_plus;
            if ($id==null) {
                $jcost_id = (str_repeat("JCID".'00', 2-strlen($jcost_increment_id))). $jcost_increment_id;
            } 
            elseif ($id == 1){
                $jcost_id = (str_repeat("JCID".'00', 2-strlen($jcost_increment_id))). $jcost_increment_id;
            }
            elseif ($id > 1 && $id < 9 ){
                $jcost_id = (str_repeat("JCID".'00', 2-strlen($jcost_increment_id))). $jcost_increment_id;
            }
            elseif ($id == 9){
                $jcost_id = (str_repeat("JCID".'00', 3-strlen($jcost_increment_id))). $jcost_increment_id;
            }
            elseif ($id == 10) {
                $jcost_id = (str_repeat("JCID".'00', 3-strlen($jcost_increment_id))). $jcost_increment_id;
            }
            elseif ($id > 10 && $id < 99) {
                $jcost_id = (str_repeat("JCID".'00', 3-strlen($jcost_increment_id))). $jcost_increment_id;
            }
            elseif ($id == 99) {
                $jcost_id = (str_repeat("JCID".'00', 4-strlen($jcost_increment_id))). $jcost_increment_id;
            }
            elseif ($id == 100) {
                $jcost_id = (str_repeat("JCID".'00', 4-strlen($jcost_increment_id))). $jcost_increment_id;
            }
            elseif ($id > 100 && $id < 999) {
                $jcost_id = (str_repeat("JCID".'00', 4-strlen($jcost_increment_id))). $jcost_increment_id;
            }
            elseif ($id === 999) {
                $jcost_id = (str_repeat("JCID".'00', 5-strlen($jcost_increment_id))). $jcost_increment_id;
            }
            elseif ($id === 1000) {
                $jcost_id = (str_repeat("JCID".'00', 5-strlen($jcost_increment_id))). $jcost_increment_id;
            }
            elseif ($id > 1000 && $id < 9999) {
                $jcost_id = (str_repeat("JCID".'00', 5-strlen($jcost_increment_id))). $jcost_increment_id;
            }
            elseif ($id == 9999) {
                $jcost_id = (str_repeat("JCID".'00', 6-strlen($jcost_increment_id))). $jcost_increment_id;
            }
            elseif ($id == 10000) {
                $jcost_id = (str_repeat("JCID".'00', 6-strlen($jcost_increment_id))). $jcost_increment_id;
            }

            $jobcostlist[] = [
                'job_id' => $d->get('jobs'),
                'job_cost_id' => $jcost_id.uniqid(),
                // 'job_id' => $d->get('job_no'),
                'cost_id' => $d->get('category'),
                'cost' => $d->get('amouns'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            $jcst->insert($jobcostlist);

        return response()->json(
            [
                'category' => $d->get('category'),
                'job_id' => $d->get('jobs'),
                'amount' => $d->get('amouns'),
                'id_advncd' => $d->get('cash_advid'),
                'total' => $total
            ]
        );
    }

}
