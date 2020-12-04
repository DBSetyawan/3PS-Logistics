<?php

namespace warehouse\Http\Controllers\Jobs;

use PDF;
use Auth;
use SWAL;
use Storage;
use Validator;
use warehouse\User;
use warehouse\Models\Item;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use warehouse\Models\Vendor;
use warehouse\Models\Customer;
use warehouse\Models\Jobs_cost;
use Illuminate\Http\UploadedFile;
use warehouse\Models\Jobs_status;
use warehouse\Models\City as Kota;
use warehouse\Models\Category_cost;
use warehouse\Models\Order_history;
use Illuminate\Support\Facades\Gate;
use warehouse\Models\Job_transports;
use Illuminate\Support\Facades\Crypt;
use warehouse\Models\Company_branchs;
use warehouse\Models\Transport_orders;
use Illuminate\Support\Carbon as Carbon;
use CodeItNow\BarcodeBundle\Utils\QrCode;
use Illuminate\Database\Eloquent\Builder;
use warehouse\Http\Controllers\Controller;
use warehouse\Models\Vendor_item_transports;
use warehouse\Models\Jobs_transaction_detail;
use Illuminate\Http\Concerns\InteractsWithInput;
use warehouse\Models\Transports_orders_statused;
use warehouse\Models\Order_transport_history as TrackShipments;
use warehouse\Http\Controllers\ManagementController as RESTAPIs;
use warehouse\Models\Item_transport as Customer_item_transports;
use warehouse\Models\Order_job_transaction_detail_history as TrackJobShipments;

class JobsController extends Controller
{
    protected $APIjob;
    protected $RESTs;

    public function __construct(RESTAPIs $APIjob, Request $req)
    {
        $this->middleware(['BlockedBeforeSettingUser','verified']);
        $this->APIjob = $APIjob;
        $this->RESTs = $req;

    }

    public function download_file_shipment_id(Jobs_transaction_detail $jobsdetail, $id, Request $request, $requestID)
    {

        $dir = '/';
        $recursive = false;
        $contents = collect(Storage::cloud()->listContents($dir, $recursive));
        $file = $contents
        ->where('type', '=', 'file')
        ->where('filename', '=', pathinfo($requestID, PATHINFO_FILENAME))
        ->where('extension', '=', pathinfo($requestID, PATHINFO_EXTENSION))
        ->first(); 
        // return $file; // array with file info
        // $readStream = Storage::cloud()->getDriver()->readStream($file['path']);
        // $targetFile = storage_path("downloaded-{$filename}");
        // file_put_contents($targetFile, stream_get_contents($readStream), FILE_APPEND);

        $readStream = Storage::cloud()->getDriver()->readStream($file['path']);
        return response()->stream(function () use ($readStream) {
            fpassthru($readStream);
        }, 200, [
            'Content-Type' => $file['mimetype'],
            'Content-disposition' => 'attachment; filename="'.$requestID.'"',
        ]);
               
   
    }

    public function getpreviewsFilesGrive($requestID){
        $dir = '/';
        $recursive = false;
        $contents = collect(Storage::cloud()->listContents($dir, $recursive));
      
        $file = $contents
            ->where('type', '=', 'file')
            ->where('filename', '=', pathinfo($requestID, PATHINFO_FILENAME))
            ->where('extension', '=', pathinfo($requestID, PATHINFO_EXTENSION))
            ->first(); // there can be duplicate file names!
      
        $readStream = Storage::cloud()->getDriver()->readStream($file['path']);
        return response()->stream(function () use ($readStream) {
            fpassthru($readStream);
        }, 200, [
            'Content-Type' => $file['mimetype'],
            //'Content-disposition' => 'attachment; filename="'.$filename.'"', // force download?
        ]);
    }

    public function guglesFileList(Jobs_transaction_detail $jobsdetail, Request $request, $shipments, $folderfile){
        $data = $jobsdetail->where('id',$folderfile)->get();
        $datax = $jobsdetail->where('id',$folderfile)->first(); //parsing-with-id-shipment-slug
        $dasd = array();
        foreach($data as $key => $value){
            $dasd[] = $value->file_list_pod;
        }
        // dd($dasd);die();
        // $datas = $datax->file_list_pod;
        // dd($data->file_list_pod);die();
        $alert_items = Item::where('flag',0)->get();
        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $prefix = Company_branchs::branchjobs($this->RESTs->session()->get('id'))->first();

        $APIs = $this->APIjob::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);

        return view('admin.list_download_google_drive.google_drive_file',[
            'menu'=>'File List',
            'alert_items'=> $alert_items,
            'prefix' => $prefix,
            'choosen_user_with_branch' => $this->RESTs->session()->get('id'),
            'some' => $this->RESTs->session()->get('id'),
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2'],
            'system_alert_item_vendor' => $system_alert_item_vendor,
            'system_alert_item_customer' => $data_item_alert_sys_allows0,
            'alert_customers'=> $alert_customers])->with(compact('prefix','data','datax')
        );

    }

    public function update_file_upload_shipment(Jobs_transaction_detail $jobsdetail, Request $request)
    {

        $messages = [
            'files.*.mimes' => 'File Type must be in pdf, jpg, jpeg, png.',
        ];
        
        $validator = Validator::make($request->all(), [
            'file.*' => 'required|mimes:jpeg,png,jpg,pdf|max:5000',
        ], $messages);
        
        if ($validator->fails()) {

            if($request->ajax())
            {
                return response()->json(array(
                    'success' => false,
                    'message' => 'File Type must be in pdf, jpg, jpeg, png',
                    'errors' => $validator->getMessageBag()->toArray()
                ), 422);
            }

            $this->throwValidationException(

                $request, $validator

            );

        }

            if ($request->hasFile('file')) {

                $arr = array();
                $arrex = array();
                $arrexsd = array();

                        foreach($request->file('file') as $index => $filex){
                            $fileds = $jobsdetail->findOrFail($request->id_shipment);

                            $bytes = random_bytes(5);
                            $random_bytes = bin2hex($bytes);
                            $filenamexs = str_replace($filex->getClientOriginalName(), $random_bytes, $filex->getClientOriginalName());

                            $sdaxczxc[$index] = $fileds->shipment_id.'-'.$filenamexs.'.'.$filex->guessClientExtension();
                            
                            $uploaded = Storage::cloud()->put($fileds->shipment_id.'-'.$filenamexs.'.'.$filex->guessClientExtension(), fopen($filex->getRealPath(), 'r+'));
                        }

                $fieldbefore = $fileds->file_list_pod;

                $results_all = array($fieldbefore);
                $asdxc = array_push($results_all, $sdaxczxc);
                        
                $fileds->file_list_pod = Arr::collapse($results_all);
                // return response()->json($results_all);


                $results = $fileds->save();

            }

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function delay_search_vendor(Job_transports $tc, Jobs_transaction_detail $jtd,Request $request){
        
        $r_vendorid = $request->get('vendor_j');
            $r_cost = $request->get('cost_');

        $vendor_item_transport = Vendor_item_transports::searchvendoritem($r_vendorid, $r_cost)
                                    ->searchcityvendor($r_vendorid, $r_cost)->get();
        // $vendor_item_transport = Vendor_item_transports::with(['city' => function ($q) use ($r_vendorid, $r_cost) {
        //     $q->searchvendoritem($r_vendorid, $r_cost);
        // }])->get();

        // dd($vendor_item_transport);
        
        $id = Job_transports::select('id')->max('id');
        $YM = Carbon::Now()->format('my');
        $latest_idx_jbs = Job_transports::latest()->first();
        $prefix = Company_branchs::branchjobs($this->RESTs->session()->get('id'))->first();
        $jobs = $id+1;
        $jincrement_idx = $jobs;
        if ($id==null) {
            $jobs_order_idx = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 2-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 2-strlen($jincrement_idx))). $jincrement_idx;
        } 
        elseif ($id == 1){
                $jobs_order_idx = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 2-strlen($jincrement_idx))). $jincrement_idx;
                $jobs_idx_latest = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 2-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id > 1 && $id < 9 ){
            $jobs_order_idx = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 2-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 2-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id == 9){
            $jobs_order_idx = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 3-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 2-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id == 10) {
            $jobs_order_idx = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 3-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 3-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id > 10 && $id < 99) {
            $jobs_order_idx = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 3-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 3-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id == 99) {
            $jobs_order_idx = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 4-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 3-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id == 100) {
            $jobs_order_idx = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 4-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 4-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id > 100 && $id < 999) {
            $jobs_order_idx = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 4-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 4-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id === 999) {
            $jobs_order_idx = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 5-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 4-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id === 1000) {
            $jobs_order_idx = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 5-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 5-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id > 1000 && $id < 9999) {
            $jobs_order_idx = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 5-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 5-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id == 9999) {
            $jobs_order_idx = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 6-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 5-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id == 10000) {
            $jobs_order_idx = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 6-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 6-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }

        $alert_items = Item::where('flag',0)->get();

        $testdata = $jtd->all();
        $data = array();
        foreach ($testdata as $key => $value) {
            # code...
            $data[] = $value->id;
        }

        $fetch_data_all_transaction_detail = Transport_orders::WhereNotin('order_id', $data)->whereNotIn('status_order_id', [1])
        ->where('by_users', Auth::User()->name)->get();
    
    
        // dd($fetch_data_all_transaction_detail);
        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $Joblistview = Job_transports::with('transport_orders')->get();

        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $prefix = Company_branchs::branchjobs($this->RESTs->session()->get('id'))->first();

        $APIs = $this->APIjob::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);
        return view('admin.jobs.jobs_transport',[
            'menu'=>'Details Shipment Job List',
            'alert_items'=> $alert_items,
            'prefix' => $prefix,
            'choosen_user_with_branch' => $this->RESTs->session()->get('id'),
            'some' => $this->RESTs->session()->get('id'),
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2'],
            'fetch_data_jtd' => $fetch_data_all_transaction_detail,
            'system_alert_item_vendor' => $system_alert_item_vendor,
            'system_alert_item_customer' => $data_item_alert_sys_allows0,
            'alert_customers'=> $alert_customers])->with(compact('Joblistview','jobs_order_idx',
            'jobs_idx_latest','latest_idx_jbs','vendor_item_transport')
        );

    }

    /**backup function load vendor */
    // public function vendor_jobs_loader(Vendor $vdnr, Request $request)
    // {
    //     $data = $vdnr->all();
    //     foreach ($data as $query) {
    //        $results[] = ['value' => $query];
    //      }
    //     return response()->json($data);
    
    // }

    public function vendor_jobs_loader(Vendor_item_transports $vdnr, Request $request)
    {
        $data = $vdnr->with('vendors')->get();
        foreach ($data as $query) {
            $results[] = ['value' => $query];
        }
        return response()->json($data);
    }

    /** back up function transporter load if null order id */
    // public function transport_loaders(Jobs_transaction_detail $jtd, Transport_orders $tc, Request $request)
    // {
    //     $testdata = $jtd->all();
    //     $data = array();
    //     foreach ($testdata as $key => $value) {
    //         # code...
    //         $data[] = $value->shipment_id;
    //     }

    //     $data = $tc->WhereNotin('order_id',$data)->Where('company_branch_id', $this->RESTs->session()->get('id'))->get();
    //     foreach ($data as $query) {
    //        $results[] = ['value' => $query];
    //      }
    //     return response()->json($data);
    
    // }

    private function array_combine2($arr1, $arr2) {
        $count1 = count($arr1);
        $count2 = count($arr2);
        $numofloops = $count2/$count1;
            
        $i = 0;
        while($i < $numofloops){
            $arr3 = array_slice($arr2, $count1*$i, $count1);
            $arr4[] = array_combine($arr1,$arr3);
            $i++;
        }
        
        return $arr4;
    }

    function array_combine_array(array $keys) //fungsi mencari kombinasi array berdasarkan value keys yang diberikan
    {
        $arrays = func_get_args();
        $keys = array_shift($arrays);
        
        $check = count(array_unique(array_map('is_array',array_map('current',$arrays)))) === 1;
        if (!$check) { trigger_error('Function array_combine_array() harus sama dengan type dari nilai yg dikasih.',E_USER_NOTICE); return array(); }
        
        $assocArray = is_array(array_shift(array_map('current',$arrays)));
        
        if (empty($keys)) $keys = array_keys(array_fill(0,max(($assocArray) ? array_map('count',array_map('current',$arrays)) : array_map('count',$arrays)),'foo'));

        $ret=array();$i=0;
        foreach($keys as $v)
        {
            foreach ($arrays as $k)
            {
                if ($assocArray)
                {
                    $key = key($k);
                    $ret[$v][$key] = isset($k[$key][$i]) ? $k[$key][$i]:false;
                }
                else
                    $ret[$v][] = isset($k[$i]) ? $k[$i]: false;
            }
            $i++;
        }
        return $ret;
    }

    public function transport_loader(Jobs_transaction_detail $jtd, Transport_orders $tc, Request $request)
    {
        $daataatc = $tc->with('cek_status_transaction')->where('company_branch_id', $this->RESTs->session()->get('id'))->get();
        if($daataatc->isEmpty()){
            $das = [];
            return response()->json($das);

        } else {

            foreach ($daataatc as $key => $shipmnt) {
                # code...
                $datatcx[] = $shipmnt->cek_status_transaction->status_name;
                $data_id_shipment[] = $shipmnt->id;
                
            }
        
            foreach ($datatcx as $key => $sttsname) {
                # code...
                // if ($sttsname == "new" || $sttsname == "proses" || $sttsname == "upload") {
    
                //     $data_shipment_with_status = $tc->whereIn('company_branch_id', [session()->get('id')])->whereIn('status_order_id', [8,2,6])->get();
        
                //     foreach ($data_shipment_with_status as $keys => $data_shipment_filter_status) {
                //         # code...
                //         $data_shipments[] = $data_shipment_filter_status->order_id;
                //         $data_id_shipmnts[] = $data_shipment_filter_status->id;
                //         $data_all_tc_for_draft[] = $data_shipment_filter_status;
                      
                //     }
                  
                //     $shipment_array = array('id_shipment'=>$data_id_shipmnts, 'shipment_id'=>$data_shipments);
                //     $shipment_object = (object) $shipment_array;
    
                //     $shipment_array = array('id_shipment'=>$data_id_shipmnts, 'shipment_id'=>$data_shipments);
                //     $shipment_object = (object) $shipment_array;
                //     $testdata = $jtd->select('id_shipment','shipment_id')->whereIn('id_shipment', $shipment_object->id_shipment)->get();
    
                //     if ($testdata->isEmpty()) {
    
                //         return response()->json($data_all_tc_for_draft);
    
                //     } else {
                        
                //         return response()->json($data_all_tc_for_draft);
    
                //     }
    
    
                // } else {
                    
    
                    // if($sttsname == "draft" || $sttsname == "invoice" || $sttsname == "paid" || $sttsname == "canceled" || $sttsname == "done"){
                    //     $data_arrays = array('1','3','7','5','4');
                    //     $sdxcccc = $tc->whereIn('company_branch_id', [session()->get('id')])->whereNotIn('status_order_id', $data_arrays)->get();
                    //     foreach ($sdxcccc as $keys => $sadxczxc) {
                    //         # code...
                    //         $sdxccccxz[] = $sadxczxc;
                          
                    //     }

                    //     return response()->json($sdxcccc);
    
                    // } 
    
                // }

                $sdxcccc = $tc->whereIn('company_branch_id', [session()->get('id')])->get();
                foreach ($sdxcccc as $keys => $sadxczxc) {
                    # code...
                    $sdxccccxz[] = $sadxczxc;
                  
                }

                return response()->json($sdxcccc);
                
            }

        }
    
    }

    public function loads_categorys_cost(Request $request)
    {

        $data = Category_cost::whereIn('id', [6])->get();
        foreach ($data as $query) {
           $results[] = ['value' => $query];
        }
        
        return response()->json($data);
    
    }

    public function loads_categorys_cost_of_cost(Request $request)
    {

        $data = Category_cost::whereNotIn('id', [6])->get();
        foreach ($data as $query) {
           $results[] = ['value' => $query];
        }
        
        return response()->json($data);
    
    }

    public function loads_categorys_cost_with_fk(Request $request, $id)
    {

        $cari = $request->load;
        $data = Category_cost::where('id', 'LIKE', "%$cari%")->get();
  
        foreach ($data as $query) {
            $results[] = ['value' => $query ];
          }
        return response()->json($data);
    
    }

    public function load_uuid_job_shipment(Transport_orders $transports, $id) //coba test untuk developer
    {

        $user = Auth::User()->roles;
        $datauser = array();
        
        foreach ($user as $key => $value) {
          # code...
          $datauser = $value->name;

        }

        if (Gate::allows('superusers') || Gate::allows('developer')) {
            
            $data = $transports->with('customers','cek_status_transaction')->where('id',$id)->get();

            foreach ($data as $query) {
              $results[] = ['value' => $query ];
            }
    
          return response()->json($data);
       }

        // if ($datauser=="administrator") {

        //     $data = $transports->with('customers','cek_status_transaction')->where('id',$id)->get();

        //     foreach ($data as $query) {
        //       $results[] = ['value' => $query ];
        //     }
    
        //   return response()->json($data);
          
        else {

            $data = $transports->with('customers','cek_status_transaction')->where('id',$id)->Where('company_branch_id', $this->RESTs->session()->get('id'))->get();

            foreach ($data as $query) {
              $results[] = ['value' => $query ];
            }
    
          return response()->json($data);

        }

      
    }

    public function loaded_vendor_item_transport_idx(Vendor_item_transports $vendor_item_transports, $id)
    {
      $data = $vendor_item_transports->FindidVendors($id)->get();
      foreach ($data as $query) {
          $results[] = ['value' => $query ];
        }
      return response()->json($data);
    }

    public function loaded_vendor_item_transportx(Vendor_item_transports $vendor_item_transports, $id)
    {
      $data = $vendor_item_transports->FindidVendorsidx($id)->get();
      foreach ($data as $query) {
          $results[] = ['value' => $query ];
        }
      return response()->json($data);
    }
    
    /** backup function if selected shipment if exists on jobs transport details */
    // public function load_uuid_job_shipment_selected(Jobs_transaction_detail $jtd,Transport_orders $transports, $id)
    // {   
    //     $idToArray = explode(",",$id);
    //     $tempArray = array();
        
    //     foreach($idToArray as $key=>$value) {
           
    //         $tempArray[$key+1] = $value;

    //     }
        
    //     $idToArray = $tempArray;

    //     $testdata = $jtd->all();
    //     $data = array();
    //     foreach ($testdata as $key => $value) {
    //         # code...
    //         $data[] = $value->shipment_id;
    //     }

    //     // $datacx = array_merge($idToArray, $data);


    //     // $data = $transports->WhereNotin('order_id', $data)->where('by_users', Auth::User()->name)->whereNotin('id', $idToArray)->get();
    //     $data = $transports->WhereNotin('order_id', $data)->where('company_branch_id', $this->RESTs->session()->get('id'))->whereNotin('order_id', $idToArray)->get();

    //     return response()->json($data);

        
    //     foreach ($data as $query) {

    //        $results[] = ['value' => $query];
           
    //     }
    //         if ($data->isEmpty()) {
    //             # code...
    //             $data = [];
    //         }

    //     return response()->json($data);

    // }

    public function load_uuid_job_shipment_selected(Jobs_transaction_detail $jtd,Transport_orders $tc, $id)
    {   
        // dd($id);die;
        $idToArray = explode(",",$id);
        $tempArray = array();
        
        foreach($idToArray as $key=>$value) {
           
            $tempArray[$key+1] = $value;

        }
            
        $idToArray = $tempArray;
        // dd($idToArray);die;
        $daataatc = $tc->with('cek_status_transaction')->where('company_branch_id', $this->RESTs->session()->get('id'))->get();
        if($daataatc->isEmpty()){
            $das = [];
            return response()->json($das);

        } else {

            foreach ($daataatc as $key => $shipmnt) {
                # code...
                $datatcx[] = $shipmnt->cek_status_transaction->status_name;
                $data_id_shipment[] = $shipmnt->id;
                
            }
        
            foreach ($datatcx as $key => $sttsname) {
                # code...
                if ($sttsname == "new" || $sttsname == "proses" || $sttsname == "upload") {
                    
                    if($idToArray == ''){

                        $data_shipment_with_status = $tc->whereIn('company_branch_id', [session()->get('id')])->whereIn('status_order_id', [8,2,6])->get();

                    } else {

                        $data_shipment_with_status = $tc->whereIn('company_branch_id', [session()->get('id')])->whereIn('status_order_id', [8,2,6])->whereNotIn('order_id', $idToArray)->get();

                    }
                    // dd($data_shipment_with_status);die();
    
                    return response()->json($data_shipment_with_status);
    
                }
                
            }

        }

    }

    public function load_uuid_job_shipment_try_load(Jobs_transaction_detail $jtd,Transport_orders $tc, $notid = null)
    {   
        if($notid == null){

            $data_shipment_with_status = $tc->whereIn('company_branch_id', [session()->get('id')])->whereIn('status_order_id', [8,2,6])->get();

            } 
            
                else {

                    $idToArray = explode(",",$notid);
                    $tempArray = array();
                        
                        foreach($idToArray as $key=>$value) {
                        
                            $tempArray[$key+1] = $value;

                        }
                            
                        $idToArray = $tempArray;
                        // dd($idToArray);die;
                    
                        $daataatc = $tc->with('cek_status_transaction')->where('company_branch_id', $this->RESTs->session()->get('id'))->get();
                        if($daataatc->isEmpty()){
                            $das = [];
                            return response()->json($das);

                        } else {

                            foreach ($daataatc as $key => $shipmnt) {
                                # code...
                                $datatcx[] = $shipmnt->cek_status_transaction->status_name;
                                $data_id_shipment[] = $shipmnt->id;
                                
                            }
                        
                        foreach ($datatcx as $key => $sttsname) {
                                # code...
                            if ($sttsname == "new" || $sttsname == "proses" || $sttsname == "upload") {
                                    
                                    $data_shipment_with_status = $tc->whereIn('company_branch_id', [session()->get('id')])->whereIn('status_order_id', [8,2,6])->whereNotIn('order_id', $idToArray)->get();
                                    
                                return response()->json($data_shipment_with_status);
                    
                            }
                                
                        }

                    }

            }
            
        return response()->json($data_shipment_with_status);

        // $datacx = array_merge($idToArray, $data);
        // dd($idToArray);die;
        // return response()->json($datacx);
        // $data = $transports->WhereNotin('order_id',$data)->Where('by_users', Auth::User()->name)->get();
        // $data = $transports->where('order_id', $idToArray)->where('company_branch_id', $this->RESTs->session()->get('id'))->get();
        // $data = $transports->WhereNotin('order_id', $data)->where('company_branch_id', $this->RESTs->session()->get('id'))->whereIn('order_id', $idToArray)->get();

        // $data = $transports->where('company_branch_id', $this->RESTs->session()->get('id'))->whereNotin('order_id', $idToArray)->get();
        // $data = $transports->where('company_branch_id', $this->RESTs->session()->get('id'))->whereIn('order_id', $idToArray)->get();
        // // $testdata = $jtd->select('id_shipment','shipment_id')->whereIn('id_shipment', $shipment_object->id_shipment)->get();

        // foreach ($data as $query) {

        //    $results[] = ['value' => $query];
           
        // }
        //     if (count($data) == 0) {
        //         # code...
        //         $data = [];
        //         // $data = $transports->where('company_branch_id', $this->RESTs->session()->get('id'))->get();

        //     }

        // return response()->json($data);

    }

    public function add_data_job_cost_without_code_job_shipment(Jobs_transaction_detail $jtdl, Jobs_cost $jcost, Job_transports $jt,Request $request){
    
        // in progress deploy ... 
        $id = $jcost->select('id')->max('id');
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

        $datajobcosts[] = [
            'job_cost_id' => $jcost_id.uniqid(),
            'job_id' => $request->job_id,
            'by_users' => Auth::User()->name,
            'cost_id' => $request->cost_id,
            'cost' => $request->cost,
            'driver_name' => $request->driver_name,
            'driver_number' => $request->driver_number,
            'doc_reference' => $request->doc_ref,
            'plat_number' => $request->plat_number,
            'vendor_item_id' => $request->vendor,
            'note' => $request->note,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        $jcost->insert($datajobcosts);

        return response()->json(
            [
                'job_id' => $request->job_id,
                'category_id' => $request->cost_id,
                'cost' => $request->cost,
                'vendor_item_id' => $request->vendor_item_id,
                'note' => $request->note,
                'created_at' => Carbon::now()->format('d-m-Y H:i:s'),
                'updated_at' => Carbon::now()->format('d-m-Y H:i:s'),

            ]
        );

    }

    public function updated_jobtdetail_with_jobcosts_without_job_transport(Job_transports $jtransports,Jobs_cost $jcost, Request $request){
    
        // in progress solved ...   
        //'this update data with where job_no on alocated user[branch only]
        $resultarr = $jtransports->findOrFail($request->job_id);
        $resultarr->vendor_id = $request->vendor_item_id;
        $resultarr->driver_name = $request->driver;
        $resultarr->plate_number = $request->plat;
        $resultarr->driver_number = $request->driver_number;
        $resultarr->document_reference = $request->docref;
        $resultarr->by_users = Auth::User()->name;
        $resultarr->user_of_company_branch_id = $this->RESTs->session()->get('id');
        $alivedata = $resultarr->save();

        $arrsd = array();
        foreach($request->cost_id as $key=>$value) {
        
            $arrsd[] = $value;

        }

        $arrvn = array();

            foreach($request->cost_id as $keys =>$cost_id) {
                    $datarvitem[] = [
                        'cost_id' => $request->cost_id[$keys],
                        'job_id' => $request->job_id
                    ];
            }

            $resulsts = $jcost->update($datarvitem);

            return response()->json($resulsts);

        return response()->json(
            [
                'job_transport_id' => $request->shipment_id, //is_array
                'vendor_item_id' => $request->vendor_item_id,
                'cost_id' => $request->cost_id,
                'job_id' => $request->job_id
            ]
        );

    }

    public function update_jcosts(Jobs_cost $jcst, $permid, Request $request)
    {
        $jcsots = $jcst->where('job_cost_id',$permid)->first();
        $jcsots->cost_id = $request->category_cost;
        $jcsots->cost = $request->cost;
        $jcsots->note = $request->noted;
        $jcsots->by_users = Auth::User()->name; //progress
        $jcsots->save();

        return back();
    }

    public function show_data_job_costs(Jobs_cost $tjcosts, $cost_id){
        $test = $tjcosts->jobtransports(Auth::User()->name)
        ->categorycost()->
            vendoritemtransports()->
                with('vendor_item_transports.vendors','job_transports.jobtransactiondetil')->where('job_costs.job_cost_id', $cost_id)
            ->first();

        // in progress showing data with job costs with modal [solved]
            $ShowingDataJcost = $tjcosts->with('job_transports.jobtransactiondetil')
            ->where('job_cost_id', $cost_id)->first();

            // dd($ShowingDataJcost);
        return response()->json($ShowingDataJcost);
        
    }

    public function ReduceTotalResultJobs(Job_transports $jtd, Request $req, $job_id, $col, $vol, $aw ){
        $jobs_order = $jtd->findOrFail($job_id);
        $jobs_order->total_collie = $col;
        $jobs_order->total_volume = $vol;
        $jobs_order->total_actual_weight = $aw;
        $jobs_order->save();

        return response()->json([
            'status' => $jobs_order,
            'actual weight' => $aw, 
            'volume' => $vol,
            'vollie' => $col
        ]);
    }

    public function UpdateTotalResultJobs(Job_transports $jtd, Request $req, $job_id, $col, $vol, $aw ){
        $jobs_order = $jtd->findOrFail($job_id);
        $jobs_order->total_collie = $col;
        $jobs_order->total_volume = $vol;
        $jobs_order->total_actual_weight = $aw;
        $jobs_order->save();

        return response()->json([
            'status' => $jobs_order,
            'actual weight' => $aw, 
            'volume' => $vol,
            'vollie' => $col
        ]);
    }

    public function add_shipment_inv(Jobs_transaction_detail $jtdl, Jobs_cost $jcost, Job_transports $jt,Request $request){

        $latest_idx_jbs = $jtdl->latest()->first();
      
            $get_vals = $request->get('get_now');
            if(!empty($latest_idx_jts)) {
                $test = $jtdl->create([
                    'job_id' => $request->get('job_id'),
                    'id_shipment' => $request->get('reqshipmentidx'),
                    'shipment_id' => $request->get('reqshipment'),
                    'file_list_pod' => NULL,
                    'shipping_to' => $get_vals+1,
                    'status_detail_shipment_id' => 1,
                    'created_at' => Carbon::now(),
                ]);

        } 
            else {
                $test = $jtdl->create([
                    'job_id' => $request->get('job_id'),
                    'id_shipment' => $request->get('reqshipmentidx'),
                    'shipment_id' => $request->get('reqshipment'),
                    'status_detail_shipment_id' => 1,
                    'file_list_pod' => NULL,
                    'shipping_to' => $get_vals+1,
                    'created_at' => Carbon::now(),
                ]);
        }
        return response()->json(
            [
                'shipment_id' => $request->get('reqshipment'),
                'id_shipment' => $request->get('reqshipmentidx'),
                'job_id' => $request->get('job_id'),
                'uuid' => $test->id,
                'shippersort' => $test->shipping_to,
                'pengirimansort' => $test->shipping_to
            ]
        );
        // swal()
        // ->toast()
        //     ->autoclose(23000)
        // ->message("Information has been saved",'You have successfully, make jobs!"'.$jobs_idx_latest.'',"success"); 

    }

    //function testing 1
    public function move_shipment_stopping_ENV(Jobs_transaction_detail $jtdl, Request $r, $shipment_index){

        // $check_index = $r->get('indexing_stopping');

        // if ($check_index == 1) {
        //     $jtdl->where('id',$shipment_index)->update(['shipping_to' => 1]);

        //     # code...
        // }
        //  if($check_index == 2){
        //     $jtdl->where('id',$shipment_index)->update(['shipping_to' => 2]);

        // # code...
        // }
        //  if($check_index == 3){
        //     $jtdl->where('id',$shipment_index)->update(['shipping_to' => 3]);

        // # code...
        // }

        // // return $replace_acc;
        // // $data_respon_back_end = $jtdl->findOrFail($shipment_index);
        
        // return response()->json(
        //     [
        //         'posisi-id-saat-stop' => $r->get('uid_stop'),
        //         'posisi_index_saat_stop' => $r->get('indexing_stopping')
        //     ]
        // ); 

    }

    //update realtime on with ajax #  $( "#tbods" ).sortable({ }); @jobs_transport
    public function update_movements(Transport_orders $tc, Jobs_transaction_detail $jtdl, Request $r){

        // $data = $jtdl->findOrFail($indexing);
        $array = array();
        
        // // $data = implode(",", $indexing);
        // $arrax = explode(",", $indexing);

        // foreach($arrax as $key=>$value) {
            
        //     $array[]= $value;

        // }
        
        // $arrax = array_filter($array);

        foreach ($r->get('arrys') as $key => $values) {
            # code...
            $array[$key] = $values;
            if (isset($array["shipment_index1"]) && isset($array["shorter_index1"]) && ($array!==null)) {
                # code...
                if (empty($array["shipment_index1"]) && empty($array["shorter_index1"])  ) {
                    # code...
                    continue;

                } else {

                    $jtdl->where('id',$array["shipment_index1"])->update(['shipping_to' => $array["shorter_index1"]]);
 
                }

            }
          
            if (isset($array["shipment_index2"]) && isset($array["shorter_index2"]) && ($array!==null)) {

                if (empty($array["shorter_index2"]) && empty($array["shipment_index2"])) {
                    # code...
                    continue;

                } else {

                    $jtdl->where('id',$array["shipment_index2"])->update(['shipping_to' => $array["shorter_index2"]]);
 
                }
            } 
    
            if (isset($array["shipment_index3"]) && isset($array["shorter_index3"]) && ($array!==null)) {
                # code...

                if (empty($array["shorter_index3"]) && empty($array["shipment_index3"])) {
                    # code...
                    continue;

                } else {

                    $jtdl->where('id',$array["shipment_index3"])->update(['shipping_to' => $array["shorter_index3"]]);
    
                }
               
            }

            if (isset($array["shipment_index4"]) && isset($array["shorter_index4"]) && ($array!==null)) {
                # code...

                if (empty($array["shorter_index4"]) && empty($array["shipment_index4"])) {
                    # code...
                    continue;

                } else {

                    $jtdl->where('id',$array["shipment_index4"])->update(['shipping_to' => $array["shorter_index4"]]);
    
                }
               
            }

            if (isset($array["shipment_index5"]) && isset($array["shorter_index5"]) && ($array!==null)) {
                # code...

                if (empty($array["shorter_index5"]) && empty($array["shipment_index5"])) {
                    # code...
                    continue;

                } else {

                    $jtdl->where('id',$array["shipment_index5"])->update(['shipping_to' => $array["shorter_index5"]]);
    
                }
               
            }

            if (isset($array["shipment_index6"]) && isset($array["shorter_index6"]) && ($array!==null)) {
                # code...

                if (empty($array["shorter_index6"]) && empty($array["shipment_index6"])) {
                    # code...
                    continue;

                } else {

                    $jtdl->where('id',$array["shipment_index6"])->update(['shipping_to' => $array["shorter_index6"]]);
    
                }
               
            }

            if (isset($array["shipment_index7"]) && isset($array["shorter_index7"]) && ($array!==null)) {
                # code...

                if (empty($array["shorter_index7"]) && empty($array["shipment_index7"])) {
                    # code...
                    continue;

                } else {

                    $jtdl->where('id',$array["shipment_index7"])->update(['shipping_to' => $array["shorter_index7"]]);
    
                }
               
            }

            if (isset($array["shipment_index8"]) && isset($array["shorter_index8"]) && ($array!==null)) {
                # code...

                if (empty($array["shorter_index8"]) && empty($array["shipment_index8"])) {
                    # code...
                    continue;

                } else {

                    $jtdl->where('id',$array["shipment_index8"])->update(['shipping_to' => $array["shorter_index8"]]);
    
                }
               
            }

            if (isset($array["shipment_index9"]) && isset($array["shorter_index9"]) && ($array!==null)) {
                # code...

                if (empty($array["shorter_index9"]) && empty($array["shipment_index9"])) {
                    # code...
                    continue;

                } else {

                    $jtdl->where('id',$array["shipment_index9"])->update(['shipping_to' => $array["shorter_index9"]]);
    
                }
               
            }

            if (isset($array["shipment_index10"]) && isset($array["shorter_index10"]) && ($array!==null)) {
                # code...

                if (empty($array["shorter_index10"]) && empty($array["shipment_index10"])) {
                    # code...
                    continue;

                } else {

                    $jtdl->where('id',$array["shipment_index10"])->update(['shipping_to' => $array["shorter_index10"]]);
    
                }
               
            }

            if (isset($array["shipment_index11"]) && isset($array["shorter_index11"]) && ($array!==null)) {
                # code...

                if (empty($array["shorter_index11"]) && empty($array["shipment_index11"])) {
                    # code...
                    continue;

                } else {

                    $jtdl->where('id',$array["shipment_index11"])->update(['shipping_to' => $array["shorter_index11"]]);
    
                }
               
            }

            if (isset($array["shipment_index12"]) && isset($array["shorter_index12"]) && ($array!==null)) {
                # code...

                if (empty($array["shorter_index12"]) && empty($array["shipment_index12"])) {
                    # code...
                    continue;

                } else {

                    $jtdl->where('id',$array["shipment_index12"])->update(['shipping_to' => $array["shorter_index12"]]);
    
                }
               
            }

            if (isset($array["shipment_index13"]) && isset($array["shorter_index13"]) && ($array!==null)) {
                # code...

                if (empty($array["shorter_index13"]) && empty($array["shipment_index13"])) {
                    # code...
                    continue;

                } else {

                    $jtdl->where('id',$array["shipment_index13"])->update(['shipping_to' => $array["shorter_index13"]]);
    
                }
               
            }

            if (isset($array["shipment_index14"]) && isset($array["shorter_index14"]) && ($array!==null)) {
                # code...

                if (empty($array["shorter_index14"]) && empty($array["shipment_index14"])) {
                    # code...
                    continue;

                } else {

                    $jtdl->where('id',$array["shipment_index14"])->update(['shipping_to' => $array["shorter_index14"]]);
    
                }
               
            }

            if (isset($array["shipment_index15"]) && isset($array["shorter_index15"]) && ($array!==null)) {
                # code...

                if (empty($array["shorter_index15"]) && empty($array["shipment_index15"])) {
                    # code...
                    continue;

                } else {

                    $jtdl->where('id',$array["shipment_index15"])->update(['shipping_to' => $array["shorter_index15"]]);
    
                }
               
            }

            if (isset($array["shipment_index16"]) && isset($array["shorter_index16"]) && ($array!==null)) {
                # code...

                if (empty($array["shorter_index16"]) && empty($array["shipment_index16"])) {
                    # code...
                    continue;

                } else {

                    $jtdl->where('id',$array["shipment_index16"])->update(['shipping_to' => $array["shorter_index16"]]);
    
                }
               
            }

            if (isset($array["shipment_index17"]) && isset($array["shorter_index17"]) && ($array!==null)) {
                # code...

                if (empty($array["shorter_index17"]) && empty($array["shipment_index17"])) {
                    # code...
                    continue;

                } else {

                    $jtdl->where('id',$array["shipment_index17"])->update(['shipping_to' => $array["shorter_index17"]]);
    
                }
               
            }

            if (isset($array["shipment_index18"]) && isset($array["shorter_index18"]) && ($array!==null)) {
                # code...

                if (empty($array["shorter_index18"]) && empty($array["shipment_index18"])) {
                    # code...
                    continue;

                } else {

                    $jtdl->where('id',$array["shipment_index18"])->update(['shipping_to' => $array["shorter_index18"]]);
    
                }
               
            }

            if (isset($array["shipment_index19"]) && isset($array["shorter_index19"]) && ($array!==null)) {
                # code...

                if (empty($array["shorter_index19"]) && empty($array["shipment_index19"])) {
                    # code...
                    continue;

                } else {

                    $jtdl->where('id',$array["shipment_index19"])->update(['shipping_to' => $array["shorter_index19"]]);
    
                }
               
            }

            if (isset($array["shipment_index20"]) && isset($array["shorter_index20"]) && ($array!==null)) {
                # code...

                if (empty($array["shorter_index20"]) && empty($array["shipment_index20"])) {
                    # code...
                    continue;

                } else {

                    $jtdl->where('id',$array["shipment_index20"])->update(['shipping_to' => $array["shorter_index20"]]);
    
                }
               
            }

            if (isset($array["shipment_index21"]) && isset($array["shorter_index21"]) && ($array!==null)) {
                # code...

                if (empty($array["shorter_index21"]) && empty($array["shipment_index21"])) {
                    # code...
                    continue;

                } else {

                    $jtdl->where('id',$array["shipment_index21"])->update(['shipping_to' => $array["shorter_index21"]]);
    
                }
               
            }

        }

        return response()->json(
            [
                'response' => $array
                // 'shipment-index-01' => $arrax->shipment_index1,
                // 'shipment-index-02' => $arrax->shipment_index2,
                // 'shipment-index-03' => $arrax->shipment_index3,
                // 'shorter-index-01' => $arrax->shipment_index1,
                // 'shorter-index-02' => $arrax->shipment_index2,
                // 'shorter-index-03' => $arrax->shipment_index3,
                // 'id' => $r->get('ijc'),
                // 'index-track' => $r->get('awal')
            ]
        ); 

    }


    public function sort_shipment_already_exists(Transport_orders $tc, Jobs_transaction_detail $jtdl, Request $r){

        // $data = $jtdl->findOrFail($indexing);
        $array = array();
     
        // // $data = implode(",", $indexing);
        // $arrax = explode(",", $indexing);

        // foreach($arrax as $key=>$value) {
            
        //     $array[]= $value;

        // }
        
        // $arrax = array_filter($array);

        foreach ($r->get('arrys') as $key => $values) {
            # code...
            $array[$key] = $values;
       
            if (isset($array["shipment_index1"]) && isset($array["shorter_index1"]) && ($array!==null)) {
                # code...
                if (empty($array["shipment_index1"]) && empty($array["shorter_index1"])  ) {
                    # code...
                    continue;

                } else {

                    $jtdl->where('id',$array["shipment_index1"])->update(['shipping_to' => $array["shorter_index1"]]);
 
                }

            }
          
            if (isset($array["shipment_index2"]) && isset($array["shorter_index2"]) && ($array!==null)) {

                if (empty($array["shorter_index2"]) && empty($array["shipment_index2"])) {
                    # code...
                    continue;

                } else {

                    $jtdl->where('id',$array["shipment_index2"])->update(['shipping_to' => $array["shorter_index2"]]);
 
                }
            } 
    
            if (isset($array["shipment_index3"]) && isset($array["shorter_index3"]) && ($array!==null)) {
                # code...

                if (empty($array["shorter_index3"]) && empty($array["shipment_index3"])) {
                    # code...
                    continue;

                } else {

                    $jtdl->where('id',$array["shipment_index3"])->update(['shipping_to' => $array["shorter_index3"]]);
    
                }
               
            }

            if (isset($array["shipment_index4"]) && isset($array["shorter_index4"]) && ($array!==null)) {
                # code...

                if (empty($array["shorter_index4"]) && empty($array["shipment_index4"])) {
                    # code...
                    continue;

                } else {

                    $jtdl->where('id',$array["shipment_index4"])->update(['shipping_to' => $array["shorter_index4"]]);
    
                }
               
            }

            if (isset($array["shipment_index5"]) && isset($array["shorter_index5"]) && ($array!==null)) {
                # code...

                if (empty($array["shorter_index5"]) && empty($array["shipment_index5"])) {
                    # code...
                    continue;

                } else {

                    $jtdl->where('id',$array["shipment_index5"])->update(['shipping_to' => $array["shorter_index5"]]);
    
                }
               
            }

            if (isset($array["shipment_index6"]) && isset($array["shorter_index6"]) && ($array!==null)) {
                # code...

                if (empty($array["shorter_index6"]) && empty($array["shipment_index6"])) {
                    # code...
                    continue;

                } else {

                    $jtdl->where('id',$array["shipment_index6"])->update(['shipping_to' => $array["shorter_index6"]]);
    
                }
               
            }

            if (isset($array["shipment_index7"]) && isset($array["shorter_index7"]) && ($array!==null)) {
                # code...

                if (empty($array["shorter_index7"]) && empty($array["shipment_index7"])) {
                    # code...
                    continue;

                } else {

                    $jtdl->where('id',$array["shipment_index7"])->update(['shipping_to' => $array["shorter_index7"]]);
    
                }
               
            }

            if (isset($array["shipment_index8"]) && isset($array["shorter_index8"]) && ($array!==null)) {
                # code...

                if (empty($array["shorter_index8"]) && empty($array["shipment_index8"])) {
                    # code...
                    continue;

                } else {

                    $jtdl->where('id',$array["shipment_index8"])->update(['shipping_to' => $array["shorter_index8"]]);
    
                }
               
            }

            if (isset($array["shipment_index9"]) && isset($array["shorter_index9"]) && ($array!==null)) {
                # code...

                if (empty($array["shorter_index9"]) && empty($array["shipment_index9"])) {
                    # code...
                    continue;

                } else {

                    $jtdl->where('id',$array["shipment_index9"])->update(['shipping_to' => $array["shorter_index9"]]);
    
                }
               
            }

            if (isset($array["shipment_index10"]) && isset($array["shorter_index10"]) && ($array!==null)) {
                # code...

                if (empty($array["shorter_index10"]) && empty($array["shipment_index10"])) {
                    # code...
                    continue;

                } else {

                    $jtdl->where('id',$array["shipment_index10"])->update(['shipping_to' => $array["shorter_index10"]]);
    
                }
               
            }

            if (isset($array["shipment_index11"]) && isset($array["shorter_index11"]) && ($array!==null)) {
                # code...

                if (empty($array["shorter_index11"]) && empty($array["shipment_index11"])) {
                    # code...
                    continue;

                } else {

                    $jtdl->where('id',$array["shipment_index11"])->update(['shipping_to' => $array["shorter_index11"]]);
    
                }
               
            }

            if (isset($array["shipment_index12"]) && isset($array["shorter_index12"]) && ($array!==null)) {
                # code...

                if (empty($array["shorter_index12"]) && empty($array["shipment_index12"])) {
                    # code...
                    continue;

                } else {

                    $jtdl->where('id',$array["shipment_index12"])->update(['shipping_to' => $array["shorter_index12"]]);
    
                }
               
            }

            if (isset($array["shipment_index13"]) && isset($array["shorter_index13"]) && ($array!==null)) {
                # code...

                if (empty($array["shorter_index13"]) && empty($array["shipment_index13"])) {
                    # code...
                    continue;

                } else {

                    $jtdl->where('id',$array["shipment_index13"])->update(['shipping_to' => $array["shorter_index13"]]);
    
                }
               
            }

            if (isset($array["shipment_index14"]) && isset($array["shorter_index14"]) && ($array!==null)) {
                # code...

                if (empty($array["shorter_index14"]) && empty($array["shipment_index14"])) {
                    # code...
                    continue;

                } else {

                    $jtdl->where('id',$array["shipment_index14"])->update(['shipping_to' => $array["shorter_index14"]]);
    
                }
               
            }

            if (isset($array["shipment_index15"]) && isset($array["shorter_index15"]) && ($array!==null)) {
                # code...

                if (empty($array["shorter_index15"]) && empty($array["shipment_index15"])) {
                    # code...
                    continue;

                } else {

                    $jtdl->where('id',$array["shipment_index15"])->update(['shipping_to' => $array["shorter_index15"]]);
    
                }
               
            }

            if (isset($array["shipment_index16"]) && isset($array["shorter_index16"]) && ($array!==null)) {
                # code...

                if (empty($array["shorter_index16"]) && empty($array["shipment_index16"])) {
                    # code...
                    continue;

                } else {

                    $jtdl->where('id',$array["shipment_index16"])->update(['shipping_to' => $array["shorter_index16"]]);
    
                }
               
            }

            if (isset($array["shipment_index17"]) && isset($array["shorter_index17"]) && ($array!==null)) {
                # code...

                if (empty($array["shorter_index17"]) && empty($array["shipment_index17"])) {
                    # code...
                    continue;

                } else {

                    $jtdl->where('id',$array["shipment_index17"])->update(['shipping_to' => $array["shorter_index17"]]);
    
                }
               
            }

            if (isset($array["shipment_index18"]) && isset($array["shorter_index18"]) && ($array!==null)) {
                # code...

                if (empty($array["shorter_index18"]) && empty($array["shipment_index18"])) {
                    # code...
                    continue;

                } else {

                    $jtdl->where('id',$array["shipment_index18"])->update(['shipping_to' => $array["shorter_index18"]]);
    
                }
               
            }

            if (isset($array["shipment_index19"]) && isset($array["shorter_index19"]) && ($array!==null)) {
                # code...

                if (empty($array["shorter_index19"]) && empty($array["shipment_index19"])) {
                    # code...
                    continue;

                } else {

                    $jtdl->where('id',$array["shipment_index19"])->update(['shipping_to' => $array["shorter_index19"]]);
    
                }
               
            }

            if (isset($array["shipment_index20"]) && isset($array["shorter_index20"]) && ($array!==null)) {
                # code...

                if (empty($array["shorter_index20"]) && empty($array["shipment_index20"])) {
                    # code...
                    continue;

                } else {

                    $jtdl->where('id',$array["shipment_index20"])->update(['shipping_to' => $array["shorter_index20"]]);
    
                }
               
            }

            if (isset($array["shipment_index21"]) && isset($array["shorter_index21"]) && ($array!==null)) {
                # code...

                if (empty($array["shorter_index21"]) && empty($array["shipment_index21"])) {
                    # code...
                    continue;

                } else {

                    $jtdl->where('id',$array["shipment_index21"])->update(['shipping_to' => $array["shorter_index21"]]);
    
                }
               
            }

        }

        return response()->json(
            [
                'response' => $array
                // 'shipment-index-01' => $arrax->shipment_index1,
                // 'shipment-index-02' => $arrax->shipment_index2,
                // 'shipment-index-03' => $arrax->shipment_index3,
                // 'shorter-index-01' => $arrax->shipment_index1,
                // 'shorter-index-02' => $arrax->shipment_index2,
                // 'shorter-index-03' => $arrax->shipment_index3,
                // 'id' => $r->get('ijc'),
                // 'index-track' => $r->get('awal')
            ]
        ); 

    }
    
    //function solved with indexing 21 shipment
    public function move_shipment_ENV(Jobs_transaction_detail $jtdl, Request $retrieve, $shipment_index){
        
        // $check_index = $retrieve->get('indexing_starting');

        // if ($check_index == 1) {
        //         $jtdl->where('id',$shipment_index)->update(['shipping_to' => 1]);

        //     # code...
        // }
        //  if($check_index == 2){
        //     $jtdl->where('id',$shipment_index)->update(['shipping_to' => 2]);

        // # code...
        // }
        //  if($check_index == 3){
        //     $jtdl->where('id',$shipment_index)->update(['shipping_to' => 3]);

        // # code...
        // }

        // return response()->json(
        //     [
        //         'posisi_id_saat_start' => $retrieve->get('uuid_shipment_starting'),
        //         'posisi_index_saat_start' => $retrieve->get('indexing_starting')
        //     ]
        // );

        die();
        $id = $retrieve->get('readdirdatashipper');
        // $tempArray = array();
        
        // foreach($id as $key=>$value) {
           
        //     $tempArray[$key+1] = $value;

        // }
        
        // $id = $tempArray;
        $test_move_shipment = $jtdl->whereIn('id',$id)->get();
        $sdasd = count($test_move_shipment);
        // foreach ($test_move_shipment as $key => $ambil_val) {
            # code...
                // $test[] = $test_move_shipment->shipping_to; 
            
        // }
        if($sdasd == 1){
            // $test = "data masih 1";
            $jtdl->where('id',$retrieve->isadoo)->update(['shipping_to' => 1]);

            // $warehouseTolist = $jtdl->whereIn('id',$id)->first();
            // $warehouseTolist->shipping_to = 1;
            // $warehouseTolist->save();
            // $jtdl->where('id', $id)->update(['shipping_to' => 1]);
        } else {

            $test_move_shipment = $jtdl->where('id',$retrieve->isadoo)->first();
        // $warehouseTolistsd = $jt->where('job_no',$id)->update(['status' => $request->update_data_status_job_shipments_jdx]);
            // dd($test_move_shipment);
            // die();
        //      foreach ($test_move_shipment as $key => $ambil_val) {
        //     # code...
        //          $shipper_idx[] = $ambil_val->shipping_to; 
            
        // }
        // dd($test_move_shipment->shipping_to);
        // die();

            if ($test_move_shipment->shipping_to==1) {
                // return "thats_me sort 1";
                // $jtdl->where('id',$retrieve->isadoo)->where('shipping_to', 1)->update(['shipping_to' => 1]);
                $test_move_shipment = $jtdl->whereIn('id',$id)->get();
                // dd($test_move_shipment);
                foreach ($test_move_shipment as $key => $ambil_val) {
                    //     # code...
                             $shipper_idx[] = $ambil_val->shipping_to; 
                        
                    }

                // $jtdl->where('id',$retrieve->isadoo)->where('shipping_to', 2)->update(['shipping_to' => 1]);
                if($shipper_idx == 1){
                  $jtdl->where('id',$retrieve->isadoo)->where('shipping_to', 1)->update(['shipping_to' => 2]);

                }

                if($shipper_idx == 2){
                    $jtdl->where('id',$retrieve->isadoo)->where('shipping_to', 2)->update(['shipping_to' => 1]);

                }

                if($shipper_idx == 3){
                    $jtdl->where('id',$retrieve->isadoo)->where('shipping_to', 3)->update(['shipping_to' => 2]);

                }
                // $jtdl->where('id',$retrieve->isadoo)->where('shipping_to', 2)->update(['shipping_to' => 1]);

                // $warehouseTolist = $jtdl->whereIn('id',$id);
                // $warehouseTolist->shipping_to = 2;
                // $warehouseTolist->save();
                // $jtdl->where('id', $id)->update(['shipping_to' => 2]);
                

            } 

            // if($test_move_shipment->shipping_to==2) {
            //     // return "thats_me sort 2";
            //     $jtdl->where('id',$retrieve->isadoo)->where('shipping_to', 2)->update(['shipping_to' => 1]);


            //     // $warehouseTolist = $jtdl->whereIn('id',$id);
            //     // $warehouseTolist->shipping_to = 1;
            //     // $warehouseTolist->save();
            // } 
            
        }
          //     return response()->json(
    //         [
    //             'response' => $test_move_shipment,
    //             'asdasd' => $sdasd,
    //             'read-id-shipper' => $retrieve->get('readdirdatashipper'),
    //             'id' => $retrieve->isadoo,
    //             'index_shipper' => $shipment_index
    //         ]
    //     );
    }

      


        // die();
    //     return response()->json(
    //         [
    //             'response' => $test_move_shipment,
    //             'asdasd' => $sdasd,
    //             'read-id-shipper' => $retrieve->get('readdirdatashipper'),
    //             'id' => $retrieve->isadoo,
    //             'index_shipper' => $shipment_index
    //         ]
    //     );
    // }

    public function add_job_shipment_inv(Jobs_transaction_detail $jtdl, Jobs_cost $jcost, Job_transports $jt,Request $request){

        $id = Job_transports::select('id')->max('id');
        $YM = Carbon::Now()->format('my');
        $latest_idx_jbs = Job_transports::latest()->first();
        $prefix = Company_branchs::branchjobs($this->RESTs->session()->get('id'))->first();
        $jobs = $id+1;
        $jincrement_idx = $jobs;
        if ($id==null) {
            $jobs_order_idx = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 2-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 2-strlen($jincrement_idx))). $jincrement_idx;
        } 
        elseif ($id == 1){
                $jobs_order_idx = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 2-strlen($jincrement_idx))). $jincrement_idx;
                $jobs_idx_latest = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 2-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id > 1 && $id < 9 ){
            $jobs_order_idx = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 2-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 2-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id == 9){
            $jobs_order_idx = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 3-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 2-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id == 10) {
            $jobs_order_idx = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 3-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 3-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id > 10 && $id < 99) {
            $jobs_order_idx = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 3-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 3-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id == 99) {
            $jobs_order_idx = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 4-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 3-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id == 100) {
            $jobs_order_idx = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 4-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 4-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id > 100 && $id < 999) {
            $jobs_order_idx = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 4-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 4-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id === 999) {
            $jobs_order_idx = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 5-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 4-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id === 1000) {
            $jobs_order_idx = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 5-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 5-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id > 1000 && $id < 9999) {
            $jobs_order_idx = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 5-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 5-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id == 9999) {
            $jobs_order_idx = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 6-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 5-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id == 10000) {
            $jobs_order_idx = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 6-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("JOB".$prefix->prefix."TR".$YM.'00', 6-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }

        $ETA_ = $request->get('eta_');
        $ETD_ = $request->get('_etd');

            // $datajt[] = [
            //     'vendor_id' => NULL,
            //     // 'job_no' => $generated,
            //     'job_no' => $jobs_idx_latest,
            //     'origin_id' => $request->get('Reqcity'),
            //     'destination_id' => $request->get('Reqdestination'),
            //     'by_users' => Auth::user()->name,
            //     'user_of_company_branch_id' => $this->RESTs->session()->get('id'),
            //     'status' => '1',
            //     'estimated_time_of_delivery' => $ETD_,
            //     'estimated_time_of_arrival' => $ETA_,
            //     'driver_name' => NULL,
            //     'plate_number' => NULL,
            //     'driver_number' => NULL,
            //     'document_reference' => NULL,
            //     'created_at' => Carbon::now(),
            // ];

            $test = Job_transports::create([
            'vendor_id' => NULL,
            // 'job_no' => $generated,
            'job_no' => $jobs_order_idx,
            'origin_id' => $request->get('Reqcity'),
            'destination_id' => $request->get('Reqdestination'),
            'by_users' => Auth::user()->name,
            'user_of_company_branch_id' => $this->RESTs->session()->get('id'),
            'status' => 1,
            'estimated_time_of_delivery' => $ETD_,
            'estimated_time_of_arrival' => $ETA_,
            'created_at' => Carbon::now()
        ]);

        $inserted = New TrackJobShipments();
        $inserted->job_no = $jobs_order_idx;
        $inserted->status = 1;
        $inserted->datetime = Carbon::Now();
        $inserted->user_id = Auth::User()->id;
        $inserted->created_at = Carbon::Now();
        $inserted->updated_at = Carbon::Now();
        $inserted->save();

        return response()->json(
            [
                'city_id' => $request->get('Reqcity'),
                'job_gen' => $jobs_order_idx,
                'id' => $test->id,
                'destination_id' => $request->get('Reqdestination'),
            ]
        );

        // swal()
        // ->toast()
        //     ->autoclose(23000)
        // ->message("Information has been saved",'You have successfully, make jobs!"'.$jobs_idx_latest.'',"success"); 

    }

    public function data_job_shipment_and_data_job_cost_of_cost_merge_function(Jobs_transaction_detail $jtdl, Jobs_cost $jcost, Job_transports $jt,Request $request){
        $id = $jcost->select('id')->max('id');
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
        
        $latest_idx_jts = $jcost->latest()->first();

        if(!empty($latest_idx_jts)) {
            
                $test = $jcost->create([
                    'job_id' => $request->index_job,
                    'by_users' => Auth::User()->name,
                    'job_cost_id' => $jcost_id.uniqid(),
                    'cost_id' =>$request->cosid,
                    'cost' => $request->cost_pricex,
                    'note' => $request->notedx,
                    'created_at' => Carbon::now()
                ]);

        } 
            else {

                $test = $jcost->create([
                    'job_id' => $request->index_job,
                    'by_users' => Auth::User()->name,
                    'job_cost_id' => $jcost_id.uniqid(),
                    'cost_id' =>$request->cosid,
                    'cost' => $request->cost_pricex,
                    'note' => $request->notedx,
                    'created_at' => Carbon::now()
                ]);
        }


        return response()->json(
            [
                'cost_id' => $request->cosid,
                'job_id' => $request->index_job,
                'cost_price' => $request->cost_pricex,
                'noted' => $request->notedx,
                'uuid' => $test->id,
            ]
        );

    }

    //method remove list tab shipment
    public function deleteremovejobshipment(Jobs_transaction_detail $jtdl, $id){

        $dml = $jtdl->findOrFail($id);
        $dml->delete();
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }

    //method remove list tab transport
    public function deleteremovejobtransportcost(Jobs_cost $jobcos, $id){
        // $skdaosd->where('driver_name',$id)->delete();
        $jobcost= $jobcos->findOrFail($id);
        $jobcost->delete();
        // $jcost->where('driver_name', $id)->first()->delete();
        return response()->json([
            'success' => 'Record deleted successfully!',
            'data' => $id
        ]);
    }

    //method remove list tab cost
    public function deleteremovecostofcost(Jobs_cost $sdasdasd, $id){
        
        $jobcost= $sdasdasd->findOrFail($id);
        $jobcost->delete();
        // $jcost->where('driver_name', $id)->first()->delete();
        return response()->json([
            'success' => 'Record deleted successfully!',
            'data' => $id
        ]);
    }

    public function data_job_shipment_and_data_job_cost_merge_function(Jobs_transaction_detail $jtdl, Jobs_cost $jcost, Job_transports $jt,Request $request){

        $id = $jcost->select('id')->max('id');
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
        
        $latest_idx_jts = $jcost->latest()->first();

        if(!empty($latest_idx_jts)) {
            
            $test = $jcost->create([
                'job_id' => $request->index_job,
                'by_users' => Auth::User()->name,
                'job_cost_id' => $jcost_id.uniqid(),
                'cost_id' =>$request->cosid,
                // 'vendor_item_id' => $sdpapscll[$oo],
                'vendor_item_id' => $request->vendoridx,
                'cost' => $request->cost_pricex,
                'note' => $request->notedx,
                'driver_name' => $request->driver_named,
                'driver_number' => $request->drive_phones,
                'doc_reference' => $request->docref,
                'plat_number' => $request->plat_numbers,
                'created_at' => Carbon::now()
            ]);

    } 
        else {

            $test = $jcost->create([
                'job_id' => $request->index_job,
                'by_users' => Auth::User()->name,
                'job_cost_id' => $jcost_id.uniqid(),
                'cost_id' =>$request->cosid,
                // 'vendor_item_id' => $sdpapscll[$oo],
                'vendor_item_id' => $request->vendoridx,
                'cost' => $request->cost_pricex,
                'note' => $request->notedx,
                'driver_name' => $request->driver_named,
                'driver_number' => $request->drive_phones,
                'doc_reference' => $request->docref,
                'plat_number' => $request->plat_numbers,
                'created_at' => Carbon::now()
            ]);
    }


        return response()->json(
            [
                // 'noted' => $request->get('noteds'), 'cost_price' => $request->get('cost_price'),
                // 'category_cost_id' => $idToArray, 'data_driver_name' => $listTabArray,
                // 'data_vendor' => $vendor_fetch_id, 'data_plat' => $request->get('dataFetchPlat'),
                // 'driver_number' => $request->get('dataFetchdriver 'Number'), 'datacost_id' => $request->get('rdatajc'),
                // 'document_refrence' => $request->get('dataFetchDocReference')
                'cost_id' => $request->cosid,
                'driver_name' => $request->driver_named,
                'job_id' => $request->index_job,
                'vendor_id' => $request->vendoridx,
                'plat_number' => $request->plat_numbers,
                'driver_phone' => $request->drive_phones,
                'document ref#' => $request->docref,
                'cost_price' => $request->cost_pricex,
                'uuid' => $test->id,
                'noted' => $request->notedx,
            ]
        );

    }


    public function data_job_shipment_and_data_job_cost(Jobs_transaction_detail $jtdl, Jobs_cost $jcost, Job_transports $jt,Request $request){
       
        $date_now = Carbon::now()->format('Y-m-d');
        $latest_idx_jts = $jt->latest()->first();
        $latest_idx_jts0 = $jt->latest()->first();
        $arrNotes = $request->get('noteds');
        $array_ship = $request->get('requestData');
        // $Rarrayvitemtc = $request->get('adspppdjk');
        $vendor_id = $request->get('asdkjasdoo');
        $rdatajprice = $request->get('erpjc');
        $generated = $request->get('gen_code');
        $vend_for_jt = $request->get('vendors_');

        //data transporter
        $driver_name = $request->get('driver_name');
        $plat = $request->get('plat_number');
        $driver_phone = $request->get('driver_phone');
        $document_reference = $request->get('document_reference');
        $ETA_ = $request->get('eta_');
        $ETD_ = $request->get('_etd');

        // return response()->json(array($ETA_,$ETD_,$driver_name,$plat,$driver_phone,$document_reference));
        // die();

        $id = $jcost->select('id')->max('id');
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
        
            $datajt[] = [
                'vendor_id' => $vend_for_jt,
                // 'job_no' => $generated,
                'job_no' => $jcost_id,
                'by_users' => Auth::user()->name,
                'user_of_company_branch_id' => $this->RESTs->session()->get('id'),
                'status' => '1',
                'estimated_time_of_delivery' => $ETD_,
                'estimated_time_of_arrival' => $ETA_,
                'driver_name' => $driver_name,
                'plate_number' => $plat,
                'driver_number' => $driver_phone,
                'document_reference' => $document_reference,
                'created_at' => Carbon::now(),
            ];

        $jt->insert($datajt);

        $igensv = implode(",",$vendor_id);
        $vendor_fetch_id = explode(",", $igensv);

        // $sdasdlp = implode(",",$Rarrayvitemtc);
        // $sdpapscll = explode(",", $sdasdlp);

        $idToArrayjrp = implode(",",$rdatajprice);
        $dasdasd = explode(",", $idToArrayjrp);
        $asdasdqedf = implode(",", $arrNotes);
        $sdazzx = explode(",", $asdasdqedf);
        $asdkanskjjd = implode(",",$array_ship);
        $dshpmnet = explode(",",$asdkanskjjd);
        $arrshipment = array();
        $arrcvnsadp = array();
        $arrysjci = array();

        
        // foreach($sdpapscll as $key=>$value) {
            
        //     if (trim($value) === '')
		// 	$value = null;
            
        //     $arrcvnsadp[] = $value;

        // }
        
        // $sdpapscll = $arrcvnsadp;

        foreach($dshpmnet as $key=>$value) {
            
            $arrshipment[] = $value;

        }
        
        $dshpmnet = $arrshipment;

         $datajc = implode(",",$request->get('rdatajc'));
         $idToArray = explode(",",$datajc);
         $tempArray = array();
         $tempArray0 = array();
         $array_set_vnd = array();
         $arrnote = array();

        foreach($dasdasd as $key=>$value) {
            
            $tempArray0[] = $value;

        }
        
        $dasdasd = $tempArray0;

        foreach($vendor_fetch_id as $key=>$value) {
           
            if (trim($value) === 'null')
			$value = null;
            
            $array_set_vnd[] = $value;

        }
        
        $vendor_fetch_id = $array_set_vnd;

        // return response()->json($vendor_fetch_id);
        // die();

        foreach($sdazzx as $key=>$value) {
            
            $arrnote[] = $value;

        }
        
        $sdazzx = $arrnote;
         
        foreach($idToArray as $key=>$value) {
            
            $tempArray[] = $value;
 
        }
         
        $idToArray = $tempArray;
 
        $datarvitem = [];

         
        if(!empty($latest_idx_jts)) {
            $idxs = $jt->select('id')->max('id');
            foreach($idToArray as $oo =>$arrvitemidx) {
                $datarvitem[] = [
                    'job_id' => $idxs,
                    'by_users' => Auth::User()->name,
                    'job_cost_id' => $jcost_id.uniqid(),
                    'cost_id' => $arrvitemidx,
                    // 'vendor_item_id' => $sdpapscll[$oo],
                    'vendor_item_id' => $vendor_fetch_id[$oo],
                    'cost' => $dasdasd[$oo],
                    'note' => $sdazzx[$oo],
                    'created_at' => Carbon::now(),
                ];
            }

        } 
            else {

                foreach($idToArray as $oo =>$arrvitemidx) {

                    $datarvitem[] = [
                        'job_id' => 1,
                        'by_users' => Auth::User()->name,
                        'cost_id' => $arrvitemidx,
                        'job_cost_id' => $jcost_id.uniqid(),
                        // 'vendor_item_id' => $sdpapscll[$oo],
                        'vendor_item_id' => $vendor_fetch_id[$oo],
                        'cost' => $dasdasd[$oo],
                        'note' => $sdazzx[$oo],
                        'created_at' => Carbon::now(),
                    ];

                }

        }

    // $jcost->insert($datarvitem);

    if(!empty($latest_idx_jts0)) {
        $idxssd = $jt->select('id')->max('id');
        foreach ($dshpmnet as $key => $valshipmnt) {
            # code...
            $datashipment[] = [
                'job_id' => $idxssd,
                'shipment_id' => $valshipmnt,
                'created_at' => Carbon::now()
            ];
        }
    } 
        else {

            foreach ($dshpmnet as $key => $valshipmnt) {
                # code...
                $datashipment[] = [
                    'job_id' => 1,
                    'shipment_id' => $valshipmnt,
                    'created_at' => Carbon::now()
                ];
            }

    }

    // $jtdl->insert($datashipment);

    swal()
    ->toast()
        ->autoclose(23000)
    ->message("Information has been saved",'You have successfully, make jobs!"'.$generated.'',"success"); 
   
            return response()->json(
                [
                    'requestData' => $arrNotes, 'rdatajc' => $datajc,
                    'gen_code' => $generated, 'asdkjasdoo' => $vendor_id, 'vendors_' => $vend_for_jt,
                    'erpjc' => $rdatajprice, 'noteds' => $sdazzx
                ]
            );

    }

    public function loaded_named_category_name(Category_cost $category, $idx){
        
        $data = $category->findOrFail($idx);
        
        return response()->json($data);

    }

    public function loaded_named_vendor_name(Vendor $vend, $idx){
        
        $data = $vend->findOrFail($idx);
        
        return response()->json($data);

    }

    public function getValueTransportUser(Transport_orders $tc, Jobs_transaction_detail $sdt){
        $daataatc = $tc->with('cek_status_transaction')->where('company_branch_id', $this->RESTs->session()->get('id'))->get();
        if($daataatc->isEmpty()){
            $das = [];
            return response()->json($das);

        } else {
            foreach ($daataatc as $key => $shipmnt) {
                # code...
                $datatcx[] = $shipmnt->cek_status_transaction->status_name;
                $data_id_shipment[] = $shipmnt->id;
                
            }
    
        
            foreach ($datatcx as $key => $sttsname) {
                # code...
                if ($sttsname == "new" || $sttsname == "proses" || $sttsname == "upload") {
    
                    $data_shipment_with_status = $tc->whereIn('status_order_id', [8,2,6])->get();
        
                    foreach ($data_shipment_with_status as $keys => $data_shipment_filter_status) {
                        # code...
                        $data_shipments[] = $data_shipment_filter_status->order_id;
                        $data_id_shipmnts[] = $data_shipment_filter_status->id;
                        $data_all_tc_for_draft[] = $data_shipment_filter_status;
                      
                    }
                  
                    $shipment_array = array('id_shipment'=>$data_id_shipmnts, 'shipment_id'=>$data_shipments);
                    $shipment_object = (object) $shipment_array;
    
                    $shipment_array = array('id_shipment'=>$data_id_shipmnts, 'shipment_id'=>$data_shipments);
                    $shipment_object = (object) $shipment_array;
                    $testdata = $sdt->select('id_shipment','shipment_id')->whereIn('id_shipment', $shipment_object->id_shipment)->get();
    
                    if ($testdata->isEmpty()) {
    
                        return response()->json($data_all_tc_for_draft);
    
                    } else {
                        
                        return response()->json($data_all_tc_for_draft);
    
                    }
    
    
                } else {
    
                    if($sttsname == "draft" || $sttsname == "invoice" || $sttsname == "paid" || $sttsname == "canceled" || $sttsname == "done"){
                        $data_arrays = array('1','3','7','5','4');
                        $sdxcccc = $tc->whereNotIn('status_order_id', $data_arrays)->get();
                        foreach ($sdxcccc as $keys => $sadxczxc) {
                            # code...
                            $sdxccccxz[] = $sadxczxc;
                          
                        }
                        return response()->json($sdxcccc);
    
                    } 
    
                }
                
            }

        }

    }

    public function load_json(Transport_orders $Transports, Jobs_transaction_detail $jtdl, Request $r, $id)
    {

        // $order_ids = $Transports->with('customers','cek_status_transaction')
        // ->whereIn('order_id', explode(",",$id))->get();

        $order_ids = $jtdl->whereIn('id', explode(",",$id))->orderBy('shipping_to','asc')->get();
        // dd($order_ids);
        // die();
        return response()->json($order_ids);

        // if($r->ajax()){

        //     $data = $jtdl->whereIn('id', $id)->get();

        //     return response()->json($id);
        // }

    }

    public function load_shipments_encode(Transport_orders $Transports, Jobs_transaction_detail $jtdl, Request $r, $id)
    {

        $order_ids = $Transports->with('customers','cek_status_transaction')
        ->whereIn('order_id', explode(",",$id))->orderBy('id','ASC')->get();

        return response()->json($order_ids);

        // if($r->ajax()){

        //     $data = $jtdl->whereIn('id', $id)->get();

        //     return response()->json($id);
        // }

    }

    public function shipment_jobs_list(Job_transports $td, Jobs_cost $jobcosts, $branch_id)
    {
        $APIs = $this->APIjob::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);
      
        $userid = Auth::User()->name;
        $datajcosts = $jobcosts->jobtransports($userid)
            ->categorycost()->
                vendoritemtransports()->
                    with('vendor_item_transports.vendors','job_transports.jobtransactiondetil')->get();

                    $dataretrieve_x = $td->with('job_costs','jobtransactiondetil')
                                            ->whereIn('user_of_company_branch_id', [$branch_id])->get();
                    // dd($dataretrieve_x);
        $alert_items = Item::where('flag',0)->get();
        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $Joblistview = Job_transports::with('transport_orders')->get();
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $prefix = Company_branchs::branchjobs($this->RESTs->session()->get('id'))->first();

        return view('admin.jobs.job_list_shipment.job_shipment_lister',[
            'menu'=>'Details Shipment Job List',
            'alert_items'=> $alert_items,
            'prefix' => $prefix,
            'choosen_user_with_branch' => $this->RESTs->session()->get('id'),
            'some' => $this->RESTs->session()->get('id'),
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2'],
            'system_alert_item_vendor' => $system_alert_item_vendor,
            'system_alert_item_customer' => $data_item_alert_sys_allows0,
            'alert_customers'=> $alert_customers])->with(compact('Joblistview',
            'dataretrieve_x','datajcosts')
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Job_transports $jobs)
    {
        return "im looking";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Jobs_transaction_detail $jtd, Category_cost $catcost, Job_transports $td, Jobs_cost $jobcosts,$branch_id, $id){

        $userid = Auth::User()->name;
        $datajcosts = $jobcosts->jobtransports($userid)
            ->categorycost()->
                vendoritemtransports()->
                    with('vendor_item_transports.vendors','job_transports.jobtransactiondetil')
                ->get();
                $dkaoskd = $td->with('job_costs')->where('job_no',$id)->where('by_users',Auth::User()->name)->get();
        $getVendor = Vendor::all();
        $reqresults = $td->with('jobtransactiondetil')->where('user_of_company_branch_id', $this->RESTs->session()->get('id'))->get();

        //progress
        $fetch_data_jobs = $td->with('job_costs.cost_category','jobtransactiondetil')
        ->where('user_of_company_branch_id', $this->RESTs->session()->get('id'))->where('job_no', $id)->get();

        $reqid_jobs = $td->with('job_costs.cost_category','jobtransactiondetil')
        ->where('user_of_company_branch_id', $branch_id)->where('job_no', $id)->first();
        
        if($reqid_jobs == null){
            swal()
            ->toast()
                    ->autoclose(9000)
                ->message("Security detection", "Branch changes are detected in the transaction details!", 'info');
            return redirect()->route('joblist.show', session()->get('id'));
        }
        
        $fetch_all_job_costs = $jobcosts->where('by_users', Auth::User()->name)->get();

        $fetch_all_data_category = $catcost->all();
        $alert_items = Item::where('flag',0)->get();
        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $Joblistview = Job_transports::with('transport_orders')->get();
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $prefix = Company_branchs::branchjobs($this->RESTs->session()->get('id'))->first();

        $APIs = $this->APIjob::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);

        session(['stored_id_jobs'=> $id]);
        return view('admin.jobs.detail_job_shipments.vdetail_job_shipments',[
            'menu'=>'Details Shipment Job List',
            'alert_items'=> $alert_items,
            'prefix' => $prefix,
            'choosen_user_with_branch' => $this->RESTs->session()->get('id'),
            'some' => $this->RESTs->session()->get('id'),
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2'],
            'system_alert_item_vendor' => $system_alert_item_vendor,
            'system_alert_item_customer' => $data_item_alert_sys_allows0,
            'alert_customers'=> $alert_customers])->with(compact('Joblistview','jobs_order_idx',
            'reqresults','reqid_jobs','fetch_all_data_category','getVendor','fetch_data_jobs','dkaoskd',
            'latest_idx_jbs','tds','vendor_item_transport','datajcosts','id_shipments','fetch_all_job_costs')
        );
        
    }

    public function list_gdrive_job_shipment(Job_transports $td,Jobs_transaction_detail $jtds, $job_no)
    {
        $id_detail = $td->with('job_costs.cost_category','jobtransactiondetil.transport_shipment_status','status_vendor_jobs')
        ->where('user_of_company_branch_id', $this->RESTs->session()->get('id'))->where('id', $job_no)->get();
        // dd($id_detail);die;
        return response()->json($id_detail);
    }


    public function history_job_shipment_lister(Jobs_transaction_detail $jtds,Transport_orders $Transports, Category_cost $catcost, Job_transports $td, Jobs_cost $jobcosts){
        $APIs = $this->APIjob::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);

        $alert_items = Item::where('flag',0)->get();
        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $prefix = Company_branchs::branchjobs($this->RESTs->session()->get('id'))->first();

        $fetch_data = $jtds->all();
        $iamarraythis = array();

        foreach ($fetch_data as $key => $value) {
            # code...
            $iamarraythis[] = $value->shipment_id;

        }

        $fetch_data = $iamarraythis;

        $check_for_not_available_code = $Transports
        ->whereNotIn('order_id', $fetch_data)->where('company_branch_id', $this->RESTs->session()->get('id'))->get();

        $asdccdf = array();

        foreach ($check_for_not_available_code as $key => $value) {
            # code...
            $asdccdf[] = $value->order_id;

        }

        $check_for_not_available_code = $asdccdf;
        

        $data_transport = $Transports->with('customers','cek_status_transaction')
        ->orWhereIn('order_id', $check_for_not_available_code)
        ->where('company_branch_id', $this->RESTs->session()->get('id'))->get(); 
        // dd($data_transport);
        $order_ids = $Transports->with('customers','cek_status_transaction')
        ->where('by_users', Auth::User()->name)->get();
    
        return view('admin.jobs.history_job_shipment.job_shipment_history_list',[
            'menu'=>'Histroy Jobs shipment',
            'alert_items'=> $alert_items,
            'prefix' => $prefix,
            'choosen_user_with_branch' => $this->RESTs->session()->get('id'),
            'some' => $this->RESTs->session()->get('id'),
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2'],
            'system_alert_item_vendor' => $system_alert_item_vendor,
            'system_alert_item_customer' => $data_item_alert_sys_allows0,
            'alert_customers'=> $alert_customers])->with(compact('Joblistview','jobs_order_idx',
            'reqresults','reqid_jobs','fetch_all_data_category','getVendor','fetch_data_jobs','dkaoskd',
            'latest_idx_jbs','order_ids','data_transport','check_for_not_available_code','tds','vendor_item_transport','datajcosts')
        );
        
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
        // $results = Jobs_cost::findOrFail($id)->delete();
        // flash('Information has been deleted.')->success();
        // return redirect('/jobs-forelist-vendor');
                   
    }

    public function soft_deleting_cost(Jobs_cost $jcsots, $jobshipment, $id)
    {
        $dmp = $jcsots->findOrFail($id);
        $results = Jobs_cost::findOrFail($id)->delete();
        swal()
        ->toast()
            ->autoclose(9000)
        ->message("Information has been deleted",'You have successfully order!"'.$dmp->job_cost_id.'',"info"); 
        return back();
        if($results==true){
            $dmp = $jcsots->findOrFail($id);
            $jcsots->by_users = Auth::User()->name;
            $jcsots->save();
        }
            else {
                return abort(500, "Internal server error.");
        }
                   
    }

    //progress deploy change status job with check id shipment
    public function find_status_jobs_shipment_idx(Jobs_transaction_detail $jtdl, Transport_orders $tc, Request $request,Jobs_status $js,Job_transports $jts, $id)
    {

        $result_def = $jts->with('status_vendor_jobs')->where('id',$id)->get();
            // foreach ($result_def as $datax) {
            //     # code...
            //     $queryz[] = ['value' => $datax];
            // }

            $data = $jts->with('status_vendor_jobs')->where('id', [$id])->get();
            $sdadsd = $jtdl->whereIn('job_id', [$id])->get();
        
          

            foreach ($result_def as $querys) {
                $results = $querys->status_vendor_jobs->name;
            }

            if ($results=="new") {
                # code...

                foreach ($data as $value) {
                    # code...
                    $datax = $value->status_vendor_jobs->name;
                }
    
                    foreach ($sdadsd as $jobstransaction) {
                        # code...
                        $datajdetail[] = $jobstransaction->id_shipment;
                    }
        
                    $id_shipment_log = $tc->with('cek_status_transaction')->whereIn('id', $datajdetail)->get();
                    
                        foreach ($id_shipment_log as $transport_cek_status) {
                            # code...
                            $data_cek_status = $transport_cek_status->cek_status_transaction->status_name;
                        }
            
                    if($data_cek_status == "done"){
                        $cari = $request->q;
                        $data_for_tc = array('');
                            // $data_for_tc = array('draft','cancel','proses','pod');
                        $data = $js->select('id', 'name')->whereIn('name', $data_for_tc)->where('name', 'LIKE', "%$cari%")->get();
                        return response()->json($data);
                        
                    }

                    if($data_cek_status == "new"){
                        $cari = $request->q;
                        $data_for_tc = array('process');
                            // $data_for_tc = array('draft','cancel','proses','pod');
                        $data = $js->select('id', 'name')->whereIn('name', $data_for_tc)->where('name', 'LIKE', "%$cari%")->get();
                        return response()->json($data);
                        
                    }

                    if($data_cek_status == "invoice"){
                        $cari = $request->q;
                        $data_for_tc = array('');
                            // $data_for_tc = array('draft','cancel','proses','pod');
                        $data = $js->select('id', 'name')->whereIn('name', $data_for_tc)->where('name', 'LIKE', "%$cari%")->get();
                        return response()->json($data);
                        
                    }

                    if($data_cek_status == "paid"){
                        $cari = $request->q;
                        $data_for_tc = array('');
                            // $data_for_tc = array('draft','cancel','proses','pod');
                        $data = $js->select('id', 'name')->whereIn('name', $data_for_tc)->where('name', 'LIKE', "%$cari%")->get();
                        return response()->json($data);
                        
                    }

                    if($data_cek_status == "canceled"){
                        $cari = $request->q;
                        $data_for_tc = array('new');
                            // $data_for_tc = array('draft','cancel','proses','pod');
                        $data = $js->select('id', 'name')->whereIn('name', $data_for_tc)->where('name', 'LIKE', "%$cari%")->get();
                        return response()->json($data);
                        
                    }

                    if($data_cek_status == "upload"){
                        $cari = $request->q;
                        $data_for_tc = array('process');
                            // $data_for_tc = array('draft','cancel','proses','pod');
                        $data = $js->select('id', 'name')->whereIn('name', $data_for_tc)->where('name', 'LIKE', "%$cari%")->get();
                        return response()->json($data);
                        
                    }
                    
                    if($data_cek_status == "proses"){
                        $cari = $request->q;
                        $data_for_tc = array('process');
                            // $data_for_tc = array('draft','cancel','proses','pod');
                        $data = $js->select('id', 'name')->whereIn('name', $data_for_tc)->where('name', 'LIKE', "%$cari%")->get();
                        return response()->json($data);
                        
                    } 
                    
                    // else {
                    //     $cari = $request->q;
                    //     $data_for_tc = array('process');
                    //     // $data_for_tc = array('draft','cancel','proses','pod');
                    //     $data = $js->select('id', 'name')->whereIn('name', $data_for_tc)->where('name', 'LIKE', "%$cari%")->get();
            
                    //     return response()->json($data);
                    // }

  
            }

            if ($results=="process") {
                # code...
                // $cari = $request->q;
                // $data_for_tc = array('delivering');
                // // $data_for_tc = array('draft','cancel','proses','pod');
                // $data = $js->select('id', 'name')->whereIn('name', $data_for_tc)->where('name', 'LIKE', "%$cari%")->get();
    
                // return response()->json($data);

                foreach ($sdadsd as $jobstransaction) {
                    # code...
                    $datajdetail[] = $jobstransaction->id_shipment;
                }
    
                $id_shipment_log = $tc->with('cek_status_transaction')->whereIn('id', $datajdetail)->get();
                
                    foreach ($id_shipment_log as $transport_cek_status) {
                        # code...
                        $data_cek_status = $transport_cek_status->cek_status_transaction->status_name;
                    }

                    if($data_cek_status == "proses"){
                        $cari = $request->q;
                        $data_for_tc = array('delivering');
                            // $data_for_tc = array('draft','cancel','proses','pod');
                        $data = $js->select('id', 'name')->whereIn('name', $data_for_tc)->where('name', 'LIKE', "%$cari%")->get();
                        return response()->json($data);
                        
                    } 

  
            }

            if ($results=="delivering") {
                # code...

                foreach ($data as $value) {
                    # code...
                    $datax = $value->status_vendor_jobs->name;
                }
    
                    foreach ($sdadsd as $jobstransaction) {
                        # code...
                        $datajdetail[] = $jobstransaction->id_shipment;
                    }
        
                    $id_shipment_log = $tc->with('cek_status_transaction')->whereIn('id', $datajdetail)->get();
                    
                        foreach ($id_shipment_log as $transport_cek_status) {
                            # code...
                            $data_cek_status = $transport_cek_status->cek_status_transaction->status_name;
                        }
        
                    if($data_cek_status == "proses"){
                        $cari = $request->q;
                        $data_for_tc = array('delivered');
                            // $data_for_tc = array('draft','cancel','proses','pod');
                        $data = $js->select('id', 'name')->whereIn('name', $data_for_tc)->where('name', 'LIKE', "%$cari%")->get();
                        return response()->json($data);
                        
                    } 

                    if($data_cek_status == "done"){
                        $cari = $request->q;
                        $data_for_tc = array('delivered');
                            // $data_for_tc = array('draft','cancel','proses','pod');
                        $data = $js->select('id', 'name')->whereIn('name', $data_for_tc)->where('name', 'LIKE', "%$cari%")->get();
                        return response()->json($data);
                        
                    }
                    // else {
                    //     $cari = $request->q;
                    //     $data_for_tc = array('canceled');
                    //     // $data_for_tc = array('draft','cancel','proses','pod');
                    //     $data = $js->select('id', 'name')->whereIn('name', $data_for_tc)->where('name', 'LIKE', "%$cari%")->get();
            
                    //     return response()->json($data);
                    // }

  
            }

            if ($results=="delivered") {
                # code...
                $cari = $request->q;
                $data_for_tc = array('');
                // $data_for_tc = array('draft','cancel','proses','pod');
                $data = $js->select('id', 'name')->whereIn('name', $data_for_tc)->where('name', 'LIKE', "%$cari%")->get();
    
                return response()->json($data);
  
            }

            if ($results=="canceled") {
                # code...
                $cari = $request->q;
                $data_for_tc = array('');
                // $data_for_tc = array('draft','cancel','proses','pod');
                $data = $js->select('id', 'name')->whereIn('name', $data_for_tc)->where('name', 'LIKE', "%$cari%")->get();
    
                return response()->json($data);
  
            }

    }

    public function object_unique($obj){

        $objArray = (array) $obj;

        $objArray = array_intersect_assoc(array_unique($objArray), $objArray);

        foreach((array) $obj as $n => $f) {
            if(!array_key_exists($n, $objArray)) unset($obj->$n);
        }

        return $obj;

    }

    /**
     * @method ini digunakan untuk jika order sudah delivered smua dalam 1 job maka akan otomatis mengupdate status menjadi [ DONE ]
     * array('1','2','5') == FALSE;
     * array('2','2','2') == TRUE;
     * @method function same(... arguments)
     *------------------------------------------------------
     */

    private function same($arr) {
        return $arr === array_filter($arr, function ($element) use ($arr) {
            return ($element === $arr[0]);
        });
    }

    public function update_status_job_shipment(Jobs_transaction_detail $jtdl,Request $request, Transport_orders $tc, Job_transports $jt, $id){

        // update shipment id
        $data_id = $id;
        $data = $jt->with('status_vendor_jobs')->where('id', [$data_id])->get();
        $sdadsd = $jtdl->whereIn('job_id', [$data_id])->get();
       
        foreach ($data as $value) {
            # code...
            $datax = $value->status_vendor_jobs->name;
        }

        foreach ($sdadsd as $jobstransaction) {
            # code...
            $datajdetail[] = $jobstransaction->id_shipment;
        }

        $id_shipment_log = $tc->with('cek_status_transaction')->whereIn('id', $datajdetail)->get();

        $res_jt = $jt->where('id', $data_id)->update(['status' => $request->update_data_status_job_shipments_jdx]);

            if($datax == "new"){

                    $res_jt = $jt->where('id', $data_id)->update(['status' => $request->update_data_status_job_shipments_jdx]);

                        $id_shipment_log = $tc->with('cek_status_transaction')->whereIn('id', $datajdetail)->get();
                                    
                            foreach ($id_shipment_log as $transport_cek_status) {
                                # code...
                                $data_cek_status = $transport_cek_status->cek_status_transaction->status_name;
                            }

                            // progress tracking order history
                            if($data_cek_status == "new"){
                                    $update_status_tc = $tc->whereIn('id', $datajdetail)->update(['status_order_id' => 2]);

                                    $IdTologorderProcessTrack = $jt->whereIn('id',[$data_id])->get();
                                    $arrjobuid = array();
                                        foreach($IdTologorderProcessTrack as $keyx=>$value) {
                                        
                                            $array_fetch[] = $value->job_no;
                            
                                        }
                        
                                    $IdTologorderProcessTrack = $array_fetch;

                                    $asdxcloop = implode(",",$IdTologorderProcessTrack);
                                    
                                    $job_no_uid = explode(",",$asdxcloop);

                                    foreach($job_no_uid as $key=>$value) {

                                        $arrjobuid[] = $value;
                            
                                    }
                                    
                                    $res_jobs = $arrjobuid;

                                    $data_jb = implode(",",$res_jobs);

                                        foreach($IdTologorderProcessTrack as $oo =>$arrvitemidx) {
                            
                                            $data_orderxzc[] = [
                                                'user_id' => Auth::User()->id,
                                                'job_no' => $arrvitemidx,
                                                'status' => 2,
                                                'datetime' => Carbon::now(),
                                                'created_at' => Carbon::now(),
                                                'updated_at' => Carbon::now(),
                                            ];
                            
                                        }
                        
                                TrackJobShipments::insert($data_orderxzc);

                                    $idToLogOrderIdArrays = $tc->whereIn('id',$datajdetail)->get();
                                    
                                        $arrorderid = array();
                                            foreach($idToLogOrderIdArrays as $keyx=>$value) {
                                            
                                                $array_order_id[] = $value->order_id;
                                
                                            }
                            
                                        $idToLogOrderIdArrays = $array_order_id;

                                    $sdxczxcloops = implode(",",$idToLogOrderIdArrays);


                                        $order_uid = explode(",",$sdxczxcloops);

                                        foreach($order_uid as $key=>$value) {
                
                                            $arrorderid[] = $value;
                                
                                        }
                                        
                                        $respon_order = $arrorderid;

                                    $data_orderxczxz = [];
                                            
                                            foreach($respon_order as $oox => $order_idx) {
                                
                                                $data_orderxczxz[] = [
                                                    'user_id' => Auth::User()->id,
                                                    'order_id' => $order_idx,
                                                    'job_no' => $data_jb,
                                                    'status' => 2,
                                                    'datetime' => Carbon::now(),
                                                    'created_at' => Carbon::now(),
                                                    'updated_at' => Carbon::now(),
                                                ];
                                
                                            }
                            
                                TrackShipments::insert($data_orderxczxz);
                                
                            } 

                            if($data_cek_status == "upload"){

                                $update_status_tc = $tc->whereIn('id', $datajdetail)->update(['status_order_id' => 2]);

                                $IdTologorderProcessTrack = $jt->whereIn('id',[$data_id])->get();
                                $arrjobuid = array();
                                    foreach($IdTologorderProcessTrack as $keyx=>$value) {
                                    
                                        $array_fetch[] = $value->job_no;
                        
                                    }
                    
                                $IdTologorderProcessTrack = $array_fetch;

                                $asdxcloop = implode(",",$IdTologorderProcessTrack);
                                
                                $job_no_uid = explode(",",$asdxcloop);

                                foreach($job_no_uid as $key=>$value) {

                                    $arrjobuid[] = $value;
                        
                                }
                                
                                $res_jobs = $arrjobuid;

                                    $data_jb = implode(",",$res_jobs);

                                            foreach($IdTologorderProcessTrack as $oo =>$arrvitemidx) {
                                
                                                $data_orderxzc[] = [
                                                    'user_id' => Auth::User()->id,
                                                    'job_no' => $arrvitemidx,
                                                    'status' => 2,
                                                    'datetime' => Carbon::now(),
                                                    'created_at' => Carbon::now(),
                                                    'updated_at' => Carbon::now(),
                                                ];
                                
                                            }
                            
                                    TrackJobShipments::insert($data_orderxzc);

                                        $idToLogOrderIdArrays = $tc->whereIn('id',$datajdetail)->get();
                                        
                                            $arrorderid = array();
                                                foreach($idToLogOrderIdArrays as $keyx=>$value) {
                                                
                                                    $array_order_id[] = $value->order_id;
                                    
                                                }
                                
                                            $idToLogOrderIdArrays = $array_order_id;

                                        $sdxczxcloops = implode(",",$idToLogOrderIdArrays);


                                            $order_uid = explode(",",$sdxczxcloops);

                                            foreach($order_uid as $key=>$value) {
                    
                                                $arrorderid[] = $value;
                                    
                                            }
                                            
                                            $respon_order = $arrorderid;

                                        $data_orderxczxz = [];
                                                
                                            foreach($respon_order as $oox => $order_idx) {
                                
                                                $data_orderxczxz[] = [
                                                    'user_id' => Auth::User()->id,
                                                    'order_id' => $order_idx,
                                                    'job_no' => $data_jb,
                                                    'status' => 2,
                                                    'datetime' => Carbon::now(),
                                                    'created_at' => Carbon::now(),
                                                    'updated_at' => Carbon::now(),
                                                ];
                                
                                            }
                                
                                    TrackShipments::insert($data_orderxczxz);
                                
                            }

                            if($data_cek_status == "proses"){
                                
                                $update_status_tc = $tc->whereIn('id', $datajdetail)->update(['status_order_id' => 2]);

                                $IdTologorderProcessTrack = $jt->whereIn('id',[$data_id])->get();
                                    $arrjobuid = array();

                                        foreach($IdTologorderProcessTrack as $keyx=>$value) {
                                        
                                            $array_fetch[] = $value->job_no;
                            
                                        }
                        
                                    $IdTologorderProcessTrack = $array_fetch;

                                    $asdxcloop = implode(",",$IdTologorderProcessTrack);
                                    
                                    $job_no_uid = explode(",",$asdxcloop);

                                    foreach($job_no_uid as $key=>$value) {

                                        $arrjobuid[] = $value;
                            
                                    }
                                    
                                    $res_jobs = $arrjobuid;

                                    $data_jb = implode(",",$res_jobs);

                                        foreach($IdTologorderProcessTrack as $oo =>$arrvitemidx) {
                            
                                            $data_orderxzc[] = [
                                                'user_id' => Auth::User()->id,
                                                'job_no' => $arrvitemidx,
                                                'status' => 2,
                                                'datetime' => Carbon::now(),
                                                'created_at' => Carbon::now(),
                                                'updated_at' => Carbon::now(),
                                            ];
                            
                                        }
                        
                                TrackJobShipments::insert($data_orderxzc);

                                    $idToLogOrderIdArrays = $tc->whereIn('id',$datajdetail)->get();
                                    
                                        $arrorderid = array();
                                            foreach($idToLogOrderIdArrays as $keyx=>$value) {
                                            
                                                $array_order_id[] = $value->order_id;
                                
                                            }
                            
                                        $idToLogOrderIdArrays = $array_order_id;

                                    $sdxczxcloops = implode(",",$idToLogOrderIdArrays);


                                        $order_uid = explode(",",$sdxczxcloops);

                                        foreach($order_uid as $key=>$value) {
                
                                            $arrorderid[] = $value;
                                
                                        }
                                        
                                        $respon_order = $arrorderid;

                                    $data_orderxczxz = [];
                                            
                                        foreach($respon_order as $oox => $order_idx) {
                            
                                            $data_orderxczxz[] = [
                                                'user_id' => Auth::User()->id,
                                                'order_id' => $order_idx,
                                                'job_no' => $data_jb,
                                                'status' => 2,
                                                'datetime' => Carbon::now(),
                                                'created_at' => Carbon::now(),
                                                'updated_at' => Carbon::now(),
                                            ];
                            
                                        }
                            
                                TrackShipments::insert($data_orderxczxz);
                                
                            }

                    }

            if($datax == "process"){

                $res_jt = $jt->where('id', $data_id)->update(['status' => $request->update_data_status_job_shipments_jdx]);
    
                    $id_shipment_log = $tc->with('cek_status_transaction')->whereIn('id', $datajdetail)->get();
                            
                    foreach ($id_shipment_log as $transport_cek_status) {
                        # code...
                        $data_cek_status = $transport_cek_status->cek_status_transaction->status_name;
                    }

                    if($data_cek_status == "proses"){

                        $update_status_tc = $tc->whereIn('id', $datajdetail)->update(['status_order_id' => 2]);

                        $IdTologorderProcessTrack = $jt->whereIn('id',[$data_id])->get();
                        $arrjobuid = array();

                            foreach($IdTologorderProcessTrack as $keyx=>$value) {
                            
                                $array_fetch[] = $value->job_no;
                
                            }
            
                        $IdTologorderProcessTrack = $array_fetch;

                        $asdxcloop = implode(",",$IdTologorderProcessTrack);
                        
                        $job_no_uid = explode(",",$asdxcloop);

                        foreach($job_no_uid as $key=>$value) {

                            $arrjobuid[] = $value;
                
                        }
                        
                        $res_jobs = $arrjobuid;

                        $data_jb = implode(",",$res_jobs);

                            foreach($IdTologorderProcessTrack as $oo =>$arrvitemidx) {
                
                                $data_orderxzc[] = [
                                    'user_id' => Auth::User()->id,
                                    'job_no' => $arrvitemidx,
                                    'status' => 3,
                                    'datetime' => Carbon::now(),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                ];
                
                            }
            
                    TrackJobShipments::insert($data_orderxzc);

                        $idToLogOrderIdArrays = $tc->whereIn('id',$datajdetail)->get();
                        
                            $arrorderid = array();
                                foreach($idToLogOrderIdArrays as $keyx=>$value) {
                                
                                    $array_order_id[] = $value->order_id;
                    
                                }
                
                            $idToLogOrderIdArrays = $array_order_id;

                        $sdxczxcloops = implode(",",$idToLogOrderIdArrays);


                            $order_uid = explode(",",$sdxczxcloops);

                            foreach($order_uid as $key=>$value) {
    
                                $arrorderid[] = $value;
                    
                            }
                            
                        $respon_order = $arrorderid;

                        $data_orderxczxz = [];
                                
                            foreach($respon_order as $oox => $order_idx) {
                
                                $data_orderxczxz[] = [
                                    'user_id' => Auth::User()->id,
                                    'order_id' => $order_idx,
                                    'job_no' => $data_jb,
                                    'status' => 2,
                                    'datetime' => Carbon::now(),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                ];
                
                            }
                
                    TrackShipments::insert($data_orderxczxz);
                        
                } 
                               
            }

            if($datax == "delivering"){

                //if canceled
                if($request->update_data_status_job_shipments_jdx == 5){

                    $id_shipment_log = $tc->with('cek_status_transaction')->whereIn('id', $datajdetail)->get();
                                
                        foreach ($id_shipment_log as $transport_cek_status) {
                            # code...
                            $data_cek_status = $transport_cek_status->cek_status_transaction->status_name;
                        }
                        
                        if($data_cek_status == "proses"){

                            $update_status_tc = $tc->whereIn('id', $datajdetail)->update(['status_order_id' => 5]);

                            $IdTologorderProcessTrack = $jt->whereIn('id',[$data_id])->get();

                            $arrjobuid = array();

                                foreach($IdTologorderProcessTrack as $keyx=>$value) {
                                
                                    $array_fetch[] = $value->job_no;
                    
                                }
                
                            $IdTologorderProcessTrack = $array_fetch;

                            $asdxcloop = implode(",",$IdTologorderProcessTrack);
                            
                            $job_no_uid = explode(",",$asdxcloop);

                            foreach($job_no_uid as $key=>$value) {

                                $arrjobuid[] = $value;
                    
                            }
                            
                            $res_jobs = $arrjobuid;

                            $data_jb = implode(",",$res_jobs);

                                foreach($IdTologorderProcessTrack as $oo =>$arrvitemidx) {
                    
                                    $data_orderxzc[] = [
                                        'user_id' => Auth::User()->id,
                                        'job_no' => $arrvitemidx,
                                        'status' => 5,
                                        'datetime' => Carbon::now(),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                    ];
                    
                                }
                
                        TrackJobShipments::insert($data_orderxzc);

                            $idToLogOrderIdArrays = $tc->whereIn('id',$datajdetail)->get();
                            
                                $arrorderid = array();
                                    foreach($idToLogOrderIdArrays as $keyx=>$value) {
                                    
                                        $array_order_id[] = $value->order_id;
                        
                                    }
                    
                                $idToLogOrderIdArrays = $array_order_id;

                            $sdxczxcloops = implode(",",$idToLogOrderIdArrays);


                                $order_uid = explode(",",$sdxczxcloops);

                                foreach($order_uid as $key=>$value) {
        
                                    $arrorderid[] = $value;
                        
                                }
                                
                                $respon_order = $arrorderid;

                            $data_orderxczxz = [];
                                    
                                    foreach($respon_order as $oox => $order_idx) {
                        
                                        $data_orderxczxz[] = [
                                            'user_id' => Auth::User()->id,
                                            'order_id' => $order_idx,
                                            'job_no' => $data_jb,
                                            'status' => 5,
                                            'datetime' => Carbon::now(),
                                            'created_at' => Carbon::now(),
                                            'updated_at' => Carbon::now(),
                                        ];
                        
                                    }
                    
                            TrackShipments::insert($data_orderxczxz);
                        
                        } 

                    }

                    //if delivered
                    if ($request->update_data_status_job_shipments_jdx == 4) {
                        
                        //debug parsing id $datajdetail 
                        $dataretrieve_x = $jt->with('job_costs', 'jobtransactiondetil')
                        ->where('user_of_company_branch_id', $this->RESTs->session()->get('id'))->whereIn('id', [$data_id])->get();
                        
                        foreach ($dataretrieve_x as $datatest) {
                            # code...
                            $datares = $datatest->jobtransactiondetil;
                        }

                        foreach ($datares as $res) {
                            # code...
                            $dataresx = $res->shipment_id;
                        }

                        $dxczc = $jtdl->whereIn('shipment_id', [$dataresx])->get();

                        foreach ($dxczc as $sdxcxcxc) {
                            # code...
                            //colleciton shipment_id
                            $sdcxcx[] = $sdxcxcxc->shipment_id;
                            //colleciton job_Id
                            $job_id[] = $sdxcxcxc->job_id;
                        }

                        //mengambil job berdasarkan shipment yang dijalankan
                        $fetch_job_id = $jtdl->with('job_transports.status_vendor_jobs')->whereIn('job_id', $job_id)->get();

                        foreach ($fetch_job_id as $data_job_fetch_status) {
                            # code...
                            // showing status jobs with shipment
                            $data_job_shipments[] = $data_job_fetch_status->job_transports->status_vendor_jobs->name;
                            $data_idstat[] = $data_job_fetch_status->job_transports->status_vendor_jobs->id;
                        }
                        
                        //ensure shipment id without process
                        $id_shipment_log = $tc->with('cek_status_transaction')->whereIn('id', $datajdetail)->get();
                                
                        foreach ($id_shipment_log as $transport_cek_status) {
                            # code...
                            $data_cek_status = $transport_cek_status->cek_status_transaction->status_name;
                        }

                        // ensure status-id job without process
                        $data_check = $jt->with('status_vendor_jobs')->whereIn('status', $data_idstat)->get();
                        foreach ($data_check as $sx => $cek_id) {
                            $data_id_status[] = $cek_id->status_vendor_jobs->id;
                        }

                        // ensure status-name job without process
                        foreach ($data_job_shipments as $kesu => $cek_status_jobs) {
                            # code...
                            $cek_status_respons = $cek_status_jobs;
                        }

                        $idToLogOrderIdArray = $jt->find([$data_id]);

                        foreach($idToLogOrderIdArray as $keyx=>$value) {
                        
                            $arrayorderlog[$keyx] = $value->job_no;
            
                        }
                
                            $idToLogOrderIdArray = $arrayorderlog;
                    
                                foreach($idToLogOrderIdArray as $oo =>$arrvitemidx) {
                    
                                    $data_orderdsacx[] = [
                                        'user_id' => Auth::User()->id,
                                        'job_no' => $arrvitemidx,
                                        'status' => 4,
                                        'datetime' => Carbon::now(),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                    ];
                    
                                }
                
                            TrackJobShipments::insert($data_orderdsacx);
              
                        // check sort by desc
                        if($data_cek_status == "proses"){
                           
                            $datacek = $this->same($data_id_status);

                            if($datacek == true){

                                   $update_status_tc = $tc->whereIn('id', $datajdetail)->update(['status_order_id' => 4]);

                                   $IdTologorderProcessTrack = $jt->whereIn('id',[$data_id])->get();
                                   $arrjobuid = array();

                                       foreach($IdTologorderProcessTrack as $keyx=>$value) {
                                       
                                           $array_fetch[] = $value->job_no;
                           
                                       }
                       
                                   $IdTologorderProcessTrack = $array_fetch;

                                   $asdxcloop = implode(",",$IdTologorderProcessTrack);
                                   
                                   $job_no_uid = explode(",",$asdxcloop);

                                   foreach($job_no_uid as $key=>$value) {

                                       $arrjobuid[] = $value;
                           
                                   }
                                   
                                   $res_jobs = $arrjobuid;

                                   $data_jb = implode(",",$res_jobs);

                                   $idToLogOrderIdArrays = $tc->whereIn('id',$datajdetail)->get();
                                   
                                       $arrorderid = array();
                                           foreach($idToLogOrderIdArrays as $keyx=>$value) {
                                           
                                               $array_order_id[] = $value->order_id;
                               
                                           }
                           
                                       $idToLogOrderIdArrays = $array_order_id;

                                   $sdxczxcloops = implode(",",$idToLogOrderIdArrays);


                                       $order_uid = explode(",",$sdxczxcloops);

                                       foreach($order_uid as $key=>$value) {
               
                                           $arrorderid[] = $value;
                               
                                       }
                                       
                                       $respon_order = $arrorderid;

                                   $data_orderxczxz = [];
                                           
                                           foreach($respon_order as $oox => $order_idx) {
                               
                                               $data_orderxczxz[] = [
                                                   'user_id' => Auth::User()->id,
                                                   'order_id' => $order_idx,
                                                   'job_no' => NULL,
                                                   'status' => 4,
                                                   'datetime' => Carbon::now(),
                                                   'created_at' => Carbon::now(),
                                                   'updated_at' => Carbon::now(),
                                               ];
                               
                                           }
                           
                               TrackShipments::insert($data_orderxczxz);

                            } 
                                else {

                                    $update_status_tc = $tc->whereIn('id', $datajdetail)->update(['status_order_id' => 2]);
                                    
                                    $IdTologorderProcessTrack = $jt->whereIn('id',[$data_id])->get();
                                    $arrjobuid = array();

                                        foreach($IdTologorderProcessTrack as $keyx=>$value) {
                                        
                                            $array_fetch[] = $value->job_no;
                            
                                        }
                        
                                    $IdTologorderProcessTrack = $array_fetch;

                                    $asdxcloop = implode(",",$IdTologorderProcessTrack);
                                    
                                    $job_no_uid = explode(",",$asdxcloop);

                                    foreach($job_no_uid as $key=>$value) {

                                        $arrjobuid[] = $value;
                            
                                    }
                                    
                                    $res_jobs = $arrjobuid;

                                    $data_jb = implode(",",$res_jobs);

                                    $idToLogOrderIdArrays = $tc->whereIn('id',$datajdetail)->get();
                                    
                                        $arrorderid = array();

                                            foreach($idToLogOrderIdArrays as $keyx=>$value) {
                                            
                                                $array_order_id[] = $value->order_id;
                                
                                            }
                            
                                        $idToLogOrderIdArrays = $array_order_id;

                                    $sdxczxcloops = implode(",",$idToLogOrderIdArrays);


                                        $order_uid = explode(",",$sdxczxcloops);

                                        foreach($order_uid as $key=>$value) {
                
                                            $arrorderid[] = $value;
                                
                                        }
                                        
                                        $respon_order = $arrorderid;

                                    $data_orderxczxz = [];
                                            
                                        foreach($respon_order as $oox => $order_idx) {
                            
                                            $data_orderxczxz[] = [
                                                'user_id' => Auth::User()->id,
                                                'order_id' => $order_idx,
                                                'job_no' => $data_jb,
                                                'status' => 2,
                                                'datetime' => Carbon::now(),
                                                'created_at' => Carbon::now(),
                                                'updated_at' => Carbon::now(),
                                            ];
                            
                                        }
                            
                            TrackShipments::insert($data_orderxczxz);

                        }

                    }
                          
                } 
                               
            }

        swal()
            ->toast()
                ->autoclose(23000)
            ->message("Information has been updated",'Status has changed!',"info"); 

        return redirect()->back();

    }

    public function update_status_transport_order_idx(Request $request,Transport_orders $tc, $id){
       
        $warehouseTolistsd = $tc->where('order_id',$id)->update(['status_order_id' => $request->update_data_status_job_shipments_jdx]);

        return redirect()->back();
        // return response()->json([
        //     'response' => 'success updated data.'
        // ]);
    }

    public function reportJobShipment(Job_transports $td, $branch_id, $id)
    {
        // [BUG ENV WITH CONDITION COMPANY]
    // $data_transport = Transport_orders::with('customers','itemtransports.sub_services','company_branch.company')->where('by_users', Auth::User()->name)->where('order_id','=',$id)->first();
    //   $warehouseTolist = Warehouse_order::with('customers_warehouse','sub_service.remarks','service_house')->find($id);
    //   $warehouse_order_pic = Warehouse_order_customer_pic::with('to_do_list_cspics')->where('warehouse_order_id',$id)->get();
    // dd($data_transport);
   
    // die;
    $decrypts = Crypt::decrypt($id);
    $data_jobs_shipment = $td->with('companysbranchs_uuid.company','job_costs.cost_category',
    'jobtransactiondetil.transports.city_origin','jobtransactiondetil.transports.city_destination','jobtransactiondetil.transports',
    'jobtransactiondetil.job_transports.origin','jobtransactiondetil.job_transports.destination')
    ->where('user_of_company_branch_id', $this->RESTs->session()->get('id'))->where('id', $decrypts)->get();
    foreach($data_jobs_shipment as $keys => $data_results){
        $job_no = $data_results->job_no;
        $tgl_buat = $data_results->created_at;
        $kotaid_origin = $data_results->saved_origin;
        $kotaid_destination = $data_results->saved_destination;
        $kotaid = $data_results->origin;
        $data_company_id = $data_results->companysbranchs_uuid->company->id;
        $nama_perusahaan = $data_results->companysbranchs_uuid->company->name;
        $alamat = $data_results->companysbranchs_uuid->address;
        $telp = $data_results->companysbranchs_uuid->telp;
        $data_job_detail[] = $data_results->jobtransactiondetil;
        $asdac = $data_results->jobtransactiondetil;

    } 

    foreach ($data_job_detail as $keys => $data_shipments) {

        $shipments_common = $data_shipments;

    }
    // dd($shipments_common);die;

    $qrCode = new QrCode();
    $qrCode
    ->setText($job_no)
    ->setSize(120)
    ->setPadding(10)
    ->setErrorCorrection('high')
    ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
    ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
    ->setLabel('')
    ->setLabelFontSize(12)
    ->setImageType(QrCode::IMAGE_TYPE_PNG);
    // return response()->json($data_company_id);die;

    // $qr = '<img src="data:'.$qrCode->getContentType().';base64,'.$qrCode->generate().'" />';

    $customPaper = array(0,0,860.00,596.80);
        $data = ['name' =>'3 permata system'];
            $pdf = PDF::loadView('admin.jobs.report_jobs_list.report_jobs', compact('branch_id','qrCode','shipments_common','tgl_buat','job_no','telp','data_jobs_shipment','data_company_id','nama_perusahaan','alamat'));
            $pdf->SetPaper($customPaper,'landscape');
            return $pdf->stream();
            // exit(0);

            // return view('admin.jobs.report_jobs_list.report_jobs'
            // );
    }


    public function find_status_jobs_shipment_with_transport_shipment_id(Request $request,Transports_orders_statused $tos, Transport_orders $t0,Job_transports $jts, $id)
    {

        $result_def = $t0->where('order_id',$id)->get();
            // foreach ($result_def as $datax) {
            //     # code...
            //     $queryz[] = ['value' => $datax];
            // }

        foreach ($result_def as $querys) {
            $results = $querys->cek_status_transaction->status_name;
        }

        if ($results=="new") {
            # code...
            $cari = $request->q;
            $data_for_tc = array('proses','invoice');
            // $data_for_tc = array('draft','cancel','proses','pod');
            $data = $tos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();

            return response()->json($data);

        }

        if ($results=="proses") {
            # code...
            $cari = $request->q;
            // $data_for_tc = array('proses');
            $data_for_tc = array('proses','invoice');
            $data = $tos->select('id', 'status_name')->whereIn('status_name', $data_for_tc)->where('status_name', 'LIKE', "%$cari%")->get();

            return response()->json($data);

        }

    }

    public function search_id_is_draft_only(Request $request, Job_transports $jc,Transport_orders $tc, $job_shipment_order){

        $data_job_cost = $jc->with('status_vendor_jobs')
        ->where('user_of_company_branch_id', $this->RESTs->session()->get('id'))->where('job_no', $job_shipment_order)->first();

        // return response()->json($data_job_cost['status_vendor_jobs']['name']);
        // die;
        if ($data_job_cost['status_vendor_jobs']['name'] == "process") {
            
            $cari = $request->q;
            $array_all_val = $tc->where('company_branch_id',$this->RESTs->session()->get('id'))->where('order_id','LIKE', "%$cari%")->get();
            return response()->json($array_all_val);

        }

        if ($data_job_cost['status_vendor_jobs']['name'] == "delivering") {
            
            $array_null = [];
            return response()->json($array_null);

        }

        if ($data_job_cost['status_vendor_jobs']['name'] == "canceled") {
            
            $array_null = [];
            return response()->json($array_null);

        }
        
        if ($data_job_cost['status_vendor_jobs']['name'] == "new") {
            // $data_arrays = array('8');
            $cari = $request->q;
            $data_arrays = array('2');
            // $array_all_val = $tc->where('company_branch_id',$this->RESTs->session()->get('id'))->get();
            $sdxcccc = $tc->whereIn('company_branch_id', [session()->get('id')])->whereNotIn('status_order_id', $data_arrays)->where('order_id','LIKE', "%$cari%")->get();
            foreach ($sdxcccc as $keys => $sadxczxc) {
                # code...
                $array_all_val[] = $sadxczxc;
              
            }

            return response()->json($array_all_val);
        }

        if ($data_job_cost['status_vendor_jobs']['name'] == "delivered") {
            
            $array_null = [];
            return response()->json($array_null);

        }

    }

    public function showing_dynamic_status_shipment(Job_transports $jc, $idjob){

        $dascxczxczxc = $jc->with('status_vendor_jobs')->where('job_no', $idjob)->first();
            // dd($dascxczxczxc);die;
        return response()->json($dascxczxczxc['status_vendor_jobs']['name']);


    }

    public function add_shipment_id(Transport_orders $tc, Job_transports $td,Jobs_transaction_detail $jtd, Request $request){

        //cek status job status for job shipment with order id
        $dataretrieve_x = $td->with('status_vendor_jobs')
        ->where('user_of_company_branch_id', session()->get('id'))
        ->findOrFail($request->job_id);
        if ($dataretrieve_x['status_vendor_jobs']['name'] == "process") {

            # code...
            $order_id = $tc->where('id',$request->order_id)->get();

            foreach($order_id as $shipment){
                $order_shipment = $shipment->order_id;
            }

            $datashipment[] = [
                'job_id' => $request->job_id,
                'shipment_id' => $order_shipment,
                'id_shipment' => $request->order_id,
                'status_detail_shipment_id' => 1,
                'shipping_to' => 1,
                'file_list_pod' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
    
            $jtd->insert($datashipment);
    
            return response()->json(
                [
                    'job_id' => $request->job_id,
                    'shipment_id' => $request->order_id,
                    'created_at' => Carbon::now()->format('d-m-Y H:i:s'),
                    'updated_at' => Carbon::now()->format('d-m-Y H:i:s'),
    
                ]
            );

        }

        if ($dataretrieve_x['status_vendor_jobs']['name'] == "new") {
            
            # code...
            $order_id = $tc->where('id',$request->order_id)->get();

            foreach($order_id as $shipment){
                $order_shipment = $shipment->order_id;
            }

            $datashipment[] = [
                'job_id' => $request->job_id,
                'shipment_id' => $order_shipment,
                'id_shipment' => $request->order_id,
                'status_detail_shipment_id' => 1,
                'shipping_to' => 1,
                'file_list_pod' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
    
            $jtd->insert($datashipment);
    
            return response()->json(
                [
                    'job_id' => $request->job_id,
                    'shipment_id' => $request->order_id,
                    'created_at' => Carbon::now()->format('d-m-Y H:i:s'),
                    'updated_at' => Carbon::now()->format('d-m-Y H:i:s'),
    
                ]
            );

        }

        if ($dataretrieve_x['status_vendor_jobs']['name'] == "delivering") {
            # code...
            // return response()->json(['response' => 'ini adalah delivering']);
            return back();
        }

        if ($dataretrieve_x['status_vendor_jobs']['name'] == "delivered") {
            # code...
            // return response()->json(['response' => 'ini adalah delivered']);
            return back();

        }
  
    }
    
}
