<?php
namespace warehouse\Http\Controllers\customer;

use Auth;
use Validator;
use Obfuscator;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use GuzzleHttp\Client;
use warehouse\Models\City;
use warehouse\Models\Item;
use warehouse\Models\Moda;
use Illuminate\Support\Str;
use GuzzleHttp\HandlerStack;
use Illuminate\Http\Request;
use React\EventLoop\Factory;
use warehouse\Models\Vendor;
use Illuminate\Http\Response;
use warehouse\Models\Customer;
use warehouse\Models\Province;
use GuzzleHttp\Promise\Promise;
use warehouse\Models\Industrys;
use warehouse\Models\Customer_pics;
use warehouse\Models\Vendor_status;
use Illuminate\App\Http\Controllers;
use Maatwebsite\Excel\Facades\Excel;
use warehouse\Models\Ship_categorie;
use Illuminate\Support\Facades\Crypt;
use warehouse\Models\Company_branchs;
use warehouse\Models\Customer_status;
use warehouse\Models\Warehouse_order;
use warehouse\Imports\CustomerImports;
use warehouse\Jobs\ImportCustomerJobs;
use GuzzleHttp\Handler\CurlMultiHandler;
use Illuminate\Support\Facades\Redirect;
use warehouse\Models\Customer_pic_status;
use warehouse\Http\Controllers\Controller;
use warehouse\Models\Vendor_item_transports;
use warehouse\Models\APIintractive as dbcheck;
use warehouse\Repositories\AccurateCloudRepos;
use warehouse\Http\Controllers\Services\AccuratecloudInterface;
use warehouse\Http\Controllers\ManagementController as RESTAPIs;
use warehouse\Models\Item_transport as Customer_item_transports;
use warehouse\Http\Requests\Customer_validation\customersValidation;
use warehouse\Http\Controllers\Helper\TraitSyncUpdateDataAccurateCloud;
use warehouse\Http\Controllers\API\integrationAPIController as IntegrationAPICustomerIzzyTransports;

class CustomerController extends Controller
{
    
    use TraitSyncUpdateDataAccurateCloud;

    protected $APP_URL;
    protected $APIntegration;
    protected $IzyTC;
    protected $datenow;
    protected $json;
    private $rest;
    private $prv;
    private $theCity;
    private $date;
    private $session;
    private $openModulesAccurateCloud;
    private $reposAccuratecloud;
    protected $callSignRepos;

    public function __construct(
                                    AccurateCloudRepos $repo, 
                                    RESTAPIs $API, 
                                    Request $REST, 
                                    City $cities, 
                                    Province $provinsi, 
                                    IntegrationAPICustomerIzzyTransports $APIzzyscalable, 
                                    AccuratecloudInterface $APInterfacecloud
                                )
    {

        $this->middleware(['BlockedBeforeSettingUser','verified']);
        $this->rest = $REST;
        $this->APIntegration = $API;
        $this->theCity = $cities;
        $this->callSignRepos = $repo;
        $this->prv = $provinsi;
        $this->IzyTC = $APIzzyscalable;
        $this->APP_URL = config('app.url');
        $this->date = gmdate('Y-m-d\TH:i:s\Z');
        $this->datenow = date('d/m/Y');
        $this->openModulesAccurateCloud = $APInterfacecloud;

    }
    
    public function obsc(){
        // $filename = __DIR__ . '/'.'CustomerController 2'; // A PHP filename (without .php) that you want to obfuscate
        // dd($filename);
        $filename = "CustomerpicsController";
        $sData = file_get_contents( __DIR__ . '/'.'CustomerpicsController.php');
        $sData = str_replace(array('<?php', '<?', '?>'), '', $sData); // We strip the open/close PHP tags
        $sObfusationData = new Obfuscator($sData, 'CustomerpicsController/@#!SDA');
        file_put_contents($filename . '_obfuscated.php', '<?php ' . "\r\n" . $sObfusationData);
    }

    public function import_excel(Request $request) 
	{

        $this->validate($request, [
            'file' => 'required'
        ]);
        
        //JIKA FILE ADA
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            

            $file->storeAs(
                'public/import', $filename
            );
        
            ImportCustomerJobs::dispatch($filename);

            \Session::flash('sukses','Data Siswa Berhasil Diimport!');
            
            return redirect()->route('master.customer.list', session()->get('id'));
            

        }  
        
	}

    public function loadData(Request $request)
    {
        // if ($request->has('q')) {
          $cari = $request->q;
          $data = Industrys::select('id', 'industry')->where('industry', 'LIKE', "%$cari%")->get();
          // foreach ($data as $query) {
          //    $results[] = ['value' => $query->industry ];
          //  }
          return response()->json($data);
        // }

    }

    public function loadDataProvins(Request $request)
    {
        // if ($request->has('q')) {
          $cari = $request->q;
          $data = Province::select('id', 'name')->where('name', 'LIKE', "%$cari%")->get();
          // foreach ($data as $query) {
          //    $results[] = ['value' => $query->industry ];
          //  }
          return response()->json($data);
        // }

    }

    public function loadDataCity(Request $request, $id)
    {
        // if ($request->has('q')) {
          $cari = $request->q;
          $data = City::select('id', 'name')->whereIn('province_id', [$id])->where('name', 'LIKE', "%$cari%")->get();
          // foreach ($data as $query) {
          //    $results[] = ['value' => $query->industry ];
          //  }
          return response()->json($data);
        // }

    }

    public function Cari_branchs(Request $request)
    {
        if ($request->has('q')) {
          $cari = $request->q;
          $data = Industrys::select('id', 'industry')->where('industry', 'LIKE', "%$cari%")->get();
          // foreach ($data as $query) {
          //    $results[] = ['value' => $query->industry ];
          //  }
          return response()->json($data);
        }

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($branch_id)
    {
        
        $APIs = $this->APIntegration::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);

        $id = Customer::select('id')->max('id');
        $YM = Carbon::Now()->format('my');
        $latest_idx_jbs = Customer::latest()->first();
        $prefix = Company_branchs::globalmaster($branch_id)->first();
        $jobs = $id+1;
        $jincrement_idx = $jobs;
        
        if ($id==null) {
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 2-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 2-strlen($jincrement_idx))). $jincrement_idx;
        }
        elseif ($id == 1){
                $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 2-strlen($jincrement_idx))). $jincrement_idx;
                $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 2-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id > 1 && $id < 9 ){
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 2-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 2-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id == 9){
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 3-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 2-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id == 10) {
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 3-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 3-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id > 10 && $id < 99) {
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 3-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 3-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id == 99) {
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 4-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 3-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id == 100) {
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 4-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 4-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id > 100 && $id < 999) {
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 4-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 4-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id === 999) {
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 5-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 4-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id === 1000) {
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 5-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 5-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id > 1000 && $id < 9999) {
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 5-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 5-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id == 9999) {
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 6-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 5-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id == 10000) {
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 6-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 6-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }

      $alert_items = Item::where('flag',0)->get();
      $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
      $system_alert_item_vendor = Vendor_item_transports::with('vendors',
      'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
      $trashlist = Customer::with('cstatusid')->onlyTrashed()
                ->get();
                $check_users = Auth::User()->id;
        $prefix = Company_branchs::globalmaster(Auth::User()->company_branch_id)->first();

      $customerlist = Customer::with('cstatusid','check_users_logged_in')
                        // ->where('users_permissions', $check_users)->get();
                        ->whereIn('branch_item', [Auth::User()->oauth_accurate_company])
                        ->whereNotNull('company_id')->get();

        $cstomers = Customer::all();
        // dd($customerlist);
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
                    'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();

                    $random_match_idx = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
                    $count = $random_match_idx;
                        $posts = Customer::get();
                        $counterID = count($posts)+1;
            
                    if(Auth::User()->oauth_accurate_company == "146583"){ //3PL
                        
                        $generateUNIQUE = "CSL".Carbon::now()->format("ym").$counterID;
                        
                    } else {
                        
                        $generateUNIQUE = "CSE".Carbon::now()->format("ym").$counterID;
                        
                    }
                   
      return view('admin.customer.customerlist',[
            'menu'=>'Customer List',
            'alert_items' => $alert_items,
            'choosen_user_with_branch' => $this->rest->session()->get('id'),
            'some' => $this->rest->session()->get('id'),
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2'],
            'system_alert_item_vendor' => $system_alert_item_vendor,
            'system_alert_item_customer' => $data_item_alert_sys_allows0,
            'alert_customers' => $alert_customers])
            ->with(compact('cstomers','prefix','jobs_order_idx','generateUNIQUE','trashlist','customerlist'));

    }

    protected function generateID($branch_id){

        $id = Customer::select('id')->max('id');
        $YM = Carbon::Now()->format('my');
        $latest_idx_jbs = Customer::latest()->first();
        $prefix = Company_branchs::globalmaster($branch_id)->first();
        $jobs = $id+1;
        $jincrement_idx = $jobs;
        
        if ($id==null) {
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 2-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 2-strlen($jincrement_idx))). $jincrement_idx;
        }
        elseif ($id == 1){
                $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 2-strlen($jincrement_idx))). $jincrement_idx;
                $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 2-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id > 1 && $id < 9 ){
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 2-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 2-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id == 9){
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 3-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 2-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id == 10) {
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 3-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 3-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id > 10 && $id < 99) {
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 3-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 3-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id == 99) {
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 4-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 3-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id == 100) {
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 4-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 4-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id > 100 && $id < 999) {
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 4-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 4-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id === 999) {
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 5-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 4-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id === 1000) {
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 5-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 5-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id > 1000 && $id < 9999) {
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 5-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 5-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id == 9999) {
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 6-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 5-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id == 10000) {
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 6-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 6-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }


        return $jobs_idx_latest;
    }

    public function showitiditemcustomertc($idx_item_customer){
        
        $decrypts= Crypt::decrypt($idx_item_customer);
        $alert_items = Item::where('flag',0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $data_customer_transport = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->get();
        $cstm = Customer::all();
        $shc = Ship_categorie::all();
        $Mds = Moda::all();
        $cstomers = Customer::all();
        $find_cst_find_it = Customer::findOrFail($decrypts);
        $Cty = City::all();
        $id = Customer_item_transports::select('id')->max('id');
        $YM = Carbon::Now()->format('my');
        $latest_idx_jbs = Customer_item_transports::latest()->first();
        $prefix = Company_branchs::globalmaster(Auth::User()->company_branch_id)->first();
        $jobs = $id+1;
        $jincrement_idx = $jobs;
        
        if ($id==null) {
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 2-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 2-strlen($jincrement_idx))). $jincrement_idx;
        }
        elseif ($id == 1){
                $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 2-strlen($jincrement_idx))). $jincrement_idx;
                $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 2-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id > 1 && $id < 9 ){
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 2-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 2-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id == 9){
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 3-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 2-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id == 10) {
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 3-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 3-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id > 10 && $id < 99) {
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 3-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 3-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id == 99) {
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 4-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 3-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id == 100) {
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 4-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 4-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id > 100 && $id < 999) {
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 4-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 4-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id === 999) {
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 5-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 4-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id === 1000) {
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 5-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 5-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id > 1000 && $id < 9999) {
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 5-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 5-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id == 9999) {
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 6-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 5-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }
        elseif ($id == 10000) {
            $jobs_order_idx = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 6-strlen($jincrement_idx))). $jincrement_idx;
            $jobs_idx_latest = (str_repeat("C1T".$prefix->prefix."TR".$YM.'00', 6-strlen($latest_idx_jbs->id))). $latest_idx_jbs->id;
        }

        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $data_customer_transport_sys_alerts = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $APIs = $this->APIntegration::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);
        return view('admin.master_transport.automically_customer_transport',[
            'menu'=>'Customer Transport List',
            'alert_items' => $alert_items,
            'choosen_user_with_branch' => $this->rest->session()->get('id'),
            'some' => $this->rest->session()->get('id'),
            'api_v1' => $responsecallbackme['api_v1'],
            'api_v2' => $responsecallbackme['api_v2'],
            'system_alert_item_vendor' => $data_customer_transport_sys_alerts,
            'system_alert_item_customer' => $data_item_alert_sys_allows0,
            'alert_customers' => $alert_customers]
        )->with(compact('jobs_order_idx','sub_service_not_dev','shc',
                'cstm','Cty','cstomers','data_customer_transport',
                'Mds','sub_service','find_cst_find_it','prefix')
            );

    }

    public function trash_customers(){
      $trashlist = Customer::with('cstatusid')->onlyTrashed()
                ->get();
      // dd($trashlist);
      return view ('admin.customer.trash_customers.trashcustomers',[
          'menu' => 'Trash Customers List'])->with(compact('trashlist'));

    }
    
    public function load_auto_move_cty($indexid){

        $data = City::where('id',$indexid)->get();
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
    public function create()
    {
        $APIs = $this->IzyTC::callstaticfunction();

        foreach((array)$APIs as $key => $detected){

            $how_working[] = $detected;

        }
 
        $jsonArray = json_decode($APIs->getContent(), true);
      
        foreach((array)$jsonArray as $key => $indexing){

            $testing[$key] = $indexing;

        }

            if ($testing[0]['check_is'] == "api_izzy") {

                if ($testing[0]['operation'] == "true") {

                            try
                            {
                                $client = new Client();
                                $response = $client->get('http://your.api.vendor.com/customer/v1/project',
                                    [  'headers' => [
                                            'Content-Type' => 'application/x-www-form-urlencoded',
                                            'X-IzzyTransport-Token' => 'a7b96913b5b1d66bed4ffdb9b04c075f19047eb3.1603097547',
                                            'Accept' => 'application/json'],
                                            'query' => ['limit' => '10',
                                                        'page' => '1'
                                        ]
                                    ]
                                );
                                $data_array= array();
                                // $YM = Carbon::Now()->format('dmy');
                                $jsonArray = json_decode($response->getBody(), true);
                                $data_array = $jsonArray['Projects'];
                                $increment_id = count($data_array)+1;
                                $max_project = $increment_id+1;
                                
                                // $random_match_id = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
                                // $project_id = $YM.$random_match_id;
                                // $customers = 'CS'.$project_id.$max_project;
                                $id_customersx = $customers;

                            $id_customers = $id_customersx;
                            $city = City::all();
                            $provinci = Province::all();

                            $YM = Carbon::Now()->format('dmy');
                            $random_match_id = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
                            $project_id = $YM.$random_match_id;
                            
                            $system_alert_item_vendor = Vendor_item_transports::with('vendors',
                            'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
                            $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
                            $alert_items = Item::where('flag',0)->get();
                            $prefix = Company_branchs::globalmaster(Auth::User()->company_branch_id)->first();
                            $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
                                'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
                                $APIs = $this->APIntegration::callbackme();
                                $responsecallbackme = json_decode($APIs->getContent(), true);
                                return view ('admin.customer.customerregistration',[
                                    'menu' => 'Customer Registration',
                                    'alert_items' => $alert_items,
                                    'system_alert_item_vendor' => $system_alert_item_vendor,
                                    'alert_customers' => $alert_customers,
                                    'choosen_user_with_branch' => $this->rest->session()->get('id'),
                                    'some' => $this->rest->session()->get('id'),
                                    'api_v1' => $responsecallbackme['api_v1'],
                                    'api_v2' => $responsecallbackme['api_v2'],
                                    'system_alert_item_customer' => $data_item_alert_sys_allows0
                                    ])->with(compact('city','customers','id_customersx','id_customers','project_id','prefix'));

                    }
                        catch (\GuzzleHttp\Exception\ClientException $e) {

                            return $e->getResponse()
                                        ->getBody()
                                        ->getContents();
                }

            }

        }


        if ($testing[0]['check_is'] == "api_izzy") {

            if ($testing[0]['operation'] == "false") {
            
                $YM = Carbon::Now()->format('dmy');
                $random_match_id = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
                $project_id = $YM.$random_match_id;
                $test = Customer::withTrashed()->select('id')->max('id');
                $customers = 'CS'.$project_id.Customer::select('id')->max('id');
                $id_customersx = $customers;

                $id_customers = $id_customersx;
                $city = City::all();
                $system_alert_item_vendor = Vendor_item_transports::with('vendors',
                'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
                $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
                $alert_items = Item::where('flag',0)->get();
                $prefix = Company_branchs::globalmaster(Auth::User()->company_branch_id)->first();
                $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
                'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
                $APIs = $this->APIntegration::callbackme();
                $responsecallbackme = json_decode($APIs->getContent(), true);
                return view ('admin.customer.customerregistration',[
                    'menu' => 'Customer Registration',
                    'alert_items' => $alert_items,
                    'choosen_user_with_branch' => $this->rest->session()->get('id'),
                    'some' => $this->rest->session()->get('id'),
                    'system_alert_item_vendor' => $system_alert_item_vendor,
                    'alert_customers' => $alert_customers,
                    'api_v1' => $responsecallbackme['api_v1'],
                    'api_v2' => $responsecallbackme['api_v2'],
                    'system_alert_item_customer' => $data_item_alert_sys_allows0
                    ])->with(compact('city','customers','id_customersx','id_customers','project_id','prefix'));
            
            }

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

        $this->validate($request, [
            'director'=>'required',
            'address'=>'required',
            'since'=>'required|min:4',
            'type_of_business'=>'required',
            'tax_address'=>'required',
            'tax_no'=>'required',
            'tax_city'=>'required',
            'tax_phone'=>'required',
            'tax_fax'=>'required',
            'address'=>'required',
            'kota'=>'required',
            'phone'=>'required',
            'fax'=>'required',
            'email'=>'required|email|unique:customers',
            'website'=>'required',
            'no_rek'=>'required',
            'an_bank'=>'required',
            'bank_name'=>'required',
            'term_of_payment'=>'required'
        ]);

    $APIs = $this->IzyTC::callstaticfunction();

        foreach((array)$APIs as $key => $detected){

            $how_working[] = $detected;

        }

            $jsonArray = json_decode($APIs->getContent(), true);
  
                foreach((array)$jsonArray as $key => $indexing){

                    $testing[$key] = $indexing;

                }

    if ($testing[0]['check_is'] == "api_izzy") {

        if ($testing[0]['operation'] == "true") {
            
            unset($request['_method']);
                unset($request['_token']);
                    $client = new Client();
                    
                    $response = $client->post('http://your.api.vendor.com/customer/v1/project/new', [
                            'headers' => [
                                'Content-Type' => 'application/x-www-form-urlencoded',
                                'X-IzzyTransport-Token' => 'a7b96913b5b1d66bed4ffdb9b04c075f19047eb3.1603097547',
                                'Accept' => 'application/json'
                            ],
                            'form_params' => [
                                'pr[code]' => $this->rest->code_project,
                                'pr[name]' => $this->rest->project,
                                'pr[pop_callback]' => $this->APP_URL.'/izzy-webhooks'
                            ]
                        ]
                    );
                
                    $jsonArray = json_decode($response->getBody()->getContents(), true);
                
                        $getCloudAccurate = $this->openModulesAccurateCloud
                            ->FuncOpenmoduleAccurateCloudSaveCustomer(
                                $this->rest->project,
                                $this->rest->project,
                                $this->rest->tahun,
                                $this->rest->ops_email,
                                $this->rest->ops_phone,
                                $this->rest->ops_phone,
                                $this->rest->ops_webs,
                                $this->rest->ops_fax,
                                $this->rest->PNGHN_alamat,
                                $fetchCity->name,
                                $this->rest->ops_kodepos,
                                $fetchProvince->name,
                                "INDONESIA",
                                $this->rest->ops_phone,
                                $this->rest->tax_no,
                                $this->rest->CustomertaxType
                            )
                        ;

                        $customer = Customer::create([
                            'status_id' => $request->statusid,
                            'customer_id' => $request->customerid,
                            'itemID_accurate' => $getCloudAccurate->original,
                            'name' => $request->project_name,
                            'director' => $request->director,
                            'industry_id' => $request->type_of_business,
                            'since' => $request->since,
                            'project_id' =>  $jsonArray['Project']['id'], //this added response id project with new customer with API izzy
                            'address' => $request->address,
                            'tax_no' => $request->tax_no,
                            'tax_address' => $request->tax_address,
                            'tax_city' => $request->tax_city,
                            'personno' => $request->code_project, //develop attr personno -> penambahan dlu id ini di accurate
                            'tax_phone' => $request->tax_phone,
                            'tax_fax' => $request->tax_fax,
                            'users_permissions' => Auth::User()->id,
                            'address' => $request->address,
                            'city_id' => $request->kota,
                            'phone' => $request->phone,
                            'fax' => $request->fax,
                            'company_id' => session()->get('company_id'),
                            'email' => $request->email,
                            'bank_name' => $request->bank_name,
                            'an_bank' => $request->an_bank,
                            'no_rek' => $request->no_rek,
                            'term_of_payment' => $request->term_of_payment,
                            'website' => $request->website,
                            'flag' => 0
                        ]);
                
                        Customer_pics::create([
                            'customer_id' => $customer->id,
                            'customer_pic_status_id' => $request->statusid,
                        ]);
                
                return redirect()->route('master.customer.list', session()->get('id'))->with('success', 'Information has been added');

            }
        
        }

        if ($testing[0]['check_is'] == "api_izzy") {
        
            if ($testing[0]['operation'] == "false") {
                
                $getCloudAccurate = $this->openModulesAccurateCloud
                    ->FuncOpenmoduleAccurateCloudSaveCustomer(
                            $this->rest->project,
                            $this->rest->project,
                            $this->rest->tahun,
                            $this->rest->ops_email,
                            $this->rest->ops_phone,
                            $this->rest->ops_phone,
                            $this->rest->ops_webs,
                            $this->rest->ops_fax,
                            $this->rest->PNGHN_alamat,
                            $fetchCity->name,
                            $this->rest->ops_kodepos,
                            $fetchProvince->name,
                            "INDONESIA",
                            $this->rest->ops_phone,
                            $this->rest->tax_no,
                            $this->rest->CustomertaxType
                    )
                ;

               $customer = Customer::create([
                    'status_id' => $request->statusid,
                    'itemID_accurate' => $getCloudAccurate->original,
                    'customer_id' => $request->customerid,
                    'name' => $request->project_name,
                    'director' => $request->director,
                    'industry_id' => $request->type_of_business,
                    'since' => $request->since,
                    'project_id' => $request->code_project, //this added response id project with new customer non make API to izzy
                    'address' => $request->address,
                    'tax_no' => $request->tax_no,
                    'tax_address' => $request->tax_address,
                    'tax_city' => $request->tax_city,
                    'personno' => $request->code_project, //develop attr personno -> penambahan dlu id ini di accurate
                    'tax_phone' => $request->tax_phone,
                    'tax_fax' => $request->tax_fax,
                    'users_permissions' => Auth::User()->id,
                    'address' => $request->address,
                    'city_id' => $request->kota,
                    'phone' => $request->phone,
                    'fax' => $request->fax,
                    'company_id' => Auth::User()->company_id,
                    'email' => $request->email,
                    'bank_name' => $request->bank_name,
                    'an_bank' => $request->an_bank,
                    'no_rek' => $request->no_rek,
                    'term_of_payment' => $request->term_of_payment,
                    'website' => $request->website,
                    'flag' => 0
                ]);
            
                    Customer_pics::create([
                        'customer_id' => $customer->id,
                        'customer_pic_status_id' => $request->statusid,
                    ]);
            
                return redirect()->route('master.customer.list', session()->get('id'))->with('success', 'Information has been added');

            }
        
        }

    }

    public function TipePajakAccurateCloud()
    {
        $foo = [];

            array_push($foo, (object)[
                    'id'=>'BKN_PEMUNGUT_PPN',
                    'name'=>'Bukan Pemungut PPN'
                ], (object)[
                    'id'=>'DPP_NILAILAIN',
                    'name'=>'DPP Nilai Lain'
                ], (object)[
                    'id'=>'EXPBKP_TDKWJD',
                    'name'=>'Ekspor BKP Tidak Berwujud'
                ], (object)[
                    'id'=>'EXPBKP_WJD',
                    'name'=>'Ekspor BKP Berwujud'
                ],(object)[
                    'id'=>'EXP_JKP',
                    'name'=>'Ekspor JKP'
                ],(object)[
                    'id'=>'PAJAK_DIDEEMED',
                    'name'=>'Pajak di Deemed'
                ],(object)[
                    'id'=>'PEMUNGUT_BENDAHARA_PEMERINTAH',
                    'name'=>'Pemungut Bendaharawan Pemerintah'
                ],(object)[
                    'id'=>'PEMUNGUT_PPN',
                    'name'=>'Pemungut PPN'
                ],(object)[
                    'id'=>'PENYERAHAN_ASSET',
                    'name'=>'Penyerahan Aset'
                ],(object)[
                    'id'=>'PENYERAHAN_LAIN',
                    'name'=>'Penyerahan Lainnya'
                ],(object)[
                    'id'=>'PPN_DIBEBASKAN',
                    'name'=>'PPN Dibebaskan'
                ],(object)[
                    'id'=>'PPN_TDK_DIPUNGUT',
                    'name'=>'PPN Tidak Dipungut'
                ]);

        return response()->json($foo);
    
    }

    public function saved_customerOfTransport(Request $request, customersValidation $rest)
    {

            $messages = [
                    'required' => 'Maaf, :attribute ini harus wajib diisi',
                ];
            
                $validator = Validator::make($rest->all(), $messages);
                
                if ($validator->fails()) {
                    
                    if($request->ajax())
                    {
                        return response()->json([
                            'success' => false,
                            'exception' => $validator->errors()->all(),
                            'errors' => $validator->getMessageBag()->toArray()
                        ], 422);
                    }

                    $this->throwValidationException(

                        $request, $validator

                    );

                }

        $random_match_idx = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
        // $project_idx = $random_match_idx;
        // $count = $random_match_idx;
            $posts = Customer::get();
            $counterID = count($posts)+1;

        if(Auth::User()->oauth_accurate_company == "146583"){ //3PL
            
            $customerID = "CSL".Carbon::now()->format("ym").$counterID;
            
        } else {
            
            $customerID = "CSE".Carbon::now()->format("ym").$counterID;
            
        }

        // $generaterandomID = 'CS'.$project_idx.$counterID;
        // $generateUNIQUE = $generaterandomID;
        $fetchCity = $this->theCity->findOrFail($this->rest->PNGHcty);
        $fetchProvince = $this->prv->findOrFail($this->rest->pengihanPRV);

            $getCloudAccurate = $this->openModulesAccurateCloud
                ->FuncOpenmoduleAccurateCloudSaveCustomer(
                    Auth::User()->oauth_accurate_branch,
                    $customerID,
                    $this->rest->project,
                    $this->rest->project,
                    $this->rest->tahun,
                    $this->rest->ops_email,
                    $this->rest->ops_phone,
                    $this->rest->ops_phone,
                    $this->rest->ops_webs,
                    $this->rest->ops_fax,
                    $this->rest->PNGHN_alamat,
                    $fetchCity->name,
                    $this->rest->ops_kodepos,
                    $fetchProvince->name,
                    "INDONESIA",
                    $this->rest->ops_phone,
                    $this->rest->tax_no,
                    $this->rest->CustomertaxType
                )
            ;

        $YM = Carbon::Now()->format('dmy');
        $random_match_id = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $project_id = $random_match_id;

        $APIs = $this->IzyTC::callstaticfunction();

        foreach((array)$APIs as $key => $detected){

            $how_working[] = $detected;

        }

            $jsonArray = json_decode($APIs->getContent(), true);
  
                foreach((array)$jsonArray as $key => $indexing){

                    $testing[$key] = $indexing;

                }

    try
        {

            if ($testing[0]['check_is'] == "api_izzy") {

                if ($testing[0]['operation'] == "true") {
            
                    // $cs = $client->post(
                    //     'http://api.trial.izzytransport.com/company/v1/customer/create',
                    //     [
                    //         'headers' => [
                    //             'Content-Type' => 'application/x-www-form-urlencoded',
                    //             'X-IzzyTransport-Company-Authkey' => '53e256e3f91de08c25650bb697caa4319b24f56f.CA-I1566629119',
                    //             'Accept' => 'application/json'
                    //         ],
                    //             'form_params' => [
                    //                 'Cus[code]' => $customerID,
                    //                 'Cus[name]' => $this->rest->project,
                    //                 'Cus[city]' => $fetchCity->name,
                    //                 'Cus[state]' => $fetchProvince->name,
                    //                 'Cus[address]' => $this->rest->PNGHN_alamat,
                    //                 'Cus[country]' => "INDONESIA",
                    //                 'Cus[zip]' => $this->rest->ops_kodepos,
                    //                 'Cus[contact]' => $this->rest->ops_phone,
                    //                 'Cus[phone]' => $this->rest->ops_phone,
                    //                 'Cus[email]' => $this->rest->ops_email,
                    //                 'Cus[hwbConfig]' => "customer",
                    //                 'Cus[aramex_feature]' => 1,
                    //                 'User[username]' => $this->rest->project,
                    //                 'User[email]' => "daniel@gmail.com",
                    //                 'User[password]' => $this->rest->project,
                                    
                    //             ]
                    //         ]
                    // );
           

                    $loop = Factory::create();

                        $handler = new CurlMultiHandler();
                        $timer = $loop->addPeriodicTimer(1, \Closure::bind(function () use (&$timer) {
                                $this->tick();
                                if (empty($this->handles) && \GuzzleHttp\Promise\queue()->isEmpty()) {
                                    $timer->cancel();
                                }
                            }, $handler, $handler)
                        );
            
                            $client = new Client(['handler' => HandlerStack::create($handler), 'base_uri' => 'http://api.live.izzytransport.com/company/v1/']);
            
                            $response[] = $client->postAsync(
                                    'customer/create',
                                    [
                                        'headers' => [
                                                'X-IzzyTransport-Company-Authkey' => '3d0a42bde6c9121c97639b22f8e7251533009dd7.CA-J1603875874',
                                                'Content-Type' => 'application/x-www-form-urlencoded',
                                                'Accept' => 'application/json'
                                        ],
                                            'form_params' => 
                                        [
                                            'Cus[code]' => $getCloudAccurate->original,
                                            'Cus[name]' => $this->rest->project,
                                            'Cus[city]' => $fetchCity->name,
                                            'Cus[state]' => $fetchProvince->name,
                                            'Cus[address]' => $this->rest->PNGHN_alamat,
                                            'Cus[country]' => "INDONESIA",
                                            'Cus[zip]' => $this->rest->ops_kodepos,
                                            'Cus[contact]' => $this->rest->ops_phone,
                                            'Cus[phone]' => $this->rest->ops_phone,
                                            'Cus[email]' => $this->rest->ops_email,
                                            'Cus[hwbConfig]' => "customer",
                                            'Cus[aramex_feature]' => 1,
                                            'User[username]' => $this->rest->project,
                                            'User[email]' => $request->ops_email,
                                            'User[password]' => "Art*&#daniels<>??()123", //set as by 3PS.
                                            'User[withToken]' => 1
                                        ]
                                    ]
                                )->then(
                                    function (\GuzzleHttp\Psr7\Response $response) {
                                        $data = json_decode($response->getBody()->getContents(), true);
                                        return response()->json($data);
                                    },
                                    function (\GuzzleHttp\Exception\ClientException $response) {
                                        $data = $response->getResponse()
                                        ->getBody()
                                        ->getContents();
                                        $ErrorMessage = json_decode($data, true);
                                        return response()->json($ErrorMessage);

                                    }
                            );
            
                            $loop->run();
            
                            $sending = \GuzzleHttp\Promise\settle($response)->wait(true);
                            $projectId = $sending[0]["value"]->original["Customer"]["id"]; // projectId Izzy.
                            $customerWithToken = $sending[0]["value"]->original["Customer"]["token"]; // projectId Izzy.
                            $code = $sending[0]["value"]->original["Customer"]["code"]; // projectId Izzy.
                            $name = $sending[0]["value"]->original["Customer"]["name"]; // projectId Izzy.

                    if(Auth::User()->oauth_accurate_company == "146584") { //3PE

                        $id = Customer::create([
                            'status_id' => 1,
                            'customer_id' => isset($projectId) ? $projectId : 0,
                            'project_id' => isset($projectId) ? $projectId : 0,
                            'userWithToken' => isset($customerWithToken) ? $customerWithToken : NULL,
                            'branch_item' => Auth::User()->oauth_accurate_company,
                            'customerID3PL' => 0,
                            'itemID_accurate3PL' => null,
                            'itemID_accurate' => $code,
                            'name' => $request->project,
                            'director' => $request->direktur,
                            'industry_id' => $request->tipe_bisnis, 
                            'since' => $request->tahun,
                            // 'project_id' => $jsonArray['Project']['id'],projectId
                            'tax_no' => $request->tax_nomor,
                            'tax_address' => $request->tax_alamat,
                            'tax_city' => $request->tax_kota,
                            'personno' => $getCloudAccurate->original, 
                            'tax_phone' => $request->tax_telephone,
                            'tax_fax' => $request->tax_faxs,
                            'users_permissions' => Auth::User()->id,
                            'address' => $request->alamat,
                            'city_id' => $request->ops_kota, 
                            'phone' => $request->ops_phone,
                            'fax' => $request->ops_fax,
                            'company_id' => session()->get('company_id'),
                            'email' => $request->ops_email,
                            'bank_name' => $request->nama_bank, 
                            'an_bank' => $request->atas_nama_bank, 
                            'no_rek' => $request->nomor_rekening,
                            'term_of_payment' => $request->kebijakan_pembayaran,
                            'website' => $request->ops_webs, 
                            'PNGHN_alamat' => $this->rest->PNGHN_alamat, 
                            'PNGHN_city' => $this->rest->PNGHcty, 
                            'PNGHN_province' => $this->rest->pengihanPRV, 
                            'PNGHN_country' => 'INDONESIA',
                            'customerTaxType' => $this->rest->CustomertaxType, 
                            'flag' => 0
                        ]);

                    } else {

                        $id = Customer::create([
                            'status_id' => 1,
                            'branch_item' => Auth::User()->oauth_accurate_company,
                            'customerID3PL' => $code,
                            'customer_id' => isset($projectId) ? $projectId : 0,
                            'userWithToken' => isset($customerWithToken) ? $customerWithToken : NULL,
                            'project_id' => isset($projectId) ? $projectId : 0,
                            'itemID_accurate' => null,
                            'itemID_accurate3PL' => $getCloudAccurate->original,
                            'name' => $request->project,
                            'director' => $request->direktur,
                            'industry_id' => $request->tipe_bisnis, 
                            'since' => $request->tahun,
                            // 'project_id' => $jsonArray['Project']['id'],projectId
                            'tax_no' => $request->tax_nomor,
                            'tax_address' => $request->tax_alamat,
                            'tax_city' => $request->tax_kota,
                            'personno' => $code,
                            'tax_phone' => $request->tax_telephone, 
                            'tax_fax' => $request->tax_faxs,
                            'users_permissions' => Auth::User()->id,
                            'address' => $request->alamat,
                            'city_id' => $request->ops_kota, 
                            'phone' => $request->ops_phone,
                            'fax' => $request->ops_fax,
                            'company_id' => session()->get('company_id'),
                            'email' => $request->ops_email,
                            'bank_name' => $request->nama_bank, 
                            'an_bank' => $request->atas_nama_bank, 
                            'no_rek' => $request->nomor_rekening,
                            'term_of_payment' => $request->kebijakan_pembayaran,
                            'website' => $request->ops_webs, 
                            'PNGHN_alamat' => $this->rest->PNGHN_alamat, 
                            'PNGHN_city' => $this->rest->PNGHcty, 
                            'PNGHN_province' => $this->rest->pengihanPRV, 
                            'PNGHN_country' => 'INDONESIA',
                            'customerTaxType' => $this->rest->CustomertaxType, 
                            'flag' => 0
                        ]);

                    }
                
                        Customer_pics::create([
                            'customer_id' => $id->id,
                            'customer_pic_status_id' => 1
                        ]);

                        $CustomerToken = Customer::findOrFail($id->id);
                        
                    $clientToProject = new Client();
        
                            $responseProject = $clientToProject->post('http://your.api.vendor.com/customer/v1/project/new', [
                                'headers' => [
                                    'Content-Type' => 'application/x-www-form-urlencoded',
                                    'X-IzzyTransport-Token' => (String) $CustomerToken->userWithToken,
                                    'Accept' => 'application/json'
                                ],
                                'form_params' => [
                                    'pr[code]' => $code.Str::random(2),
                                    'pr[name]' => $name,
                                    'pr[pop_callback]' => $this->APP_URL.'/izzy-webhooks'
                                ]
                            ]
                        );

                    $responseProjectId = json_decode($responseProject->getBody()->getContents(), true);

                        Customer::whereIn('id', [$id->id])->update(
                            [
                                'project_id' => $responseProjectId["Project"]["id"],
                            ]
                        ) 
                    ;
        
                    return response()->json(['generateID' => self::generateID($this->rest->session()->get('id'))]);

                connectify('success', 'Accurate cloud berpesan', 'Pelanggan '.$id->name.' dengan Code: '.$getCloudAccurate->original.' berhasil dibuat di acccurate cloud');
                return;
             
            }
        
        }

        if ($testing[0]['check_is'] == "api_izzy") {
        
            if ($testing[0]['operation'] == "false") {

               $id = Customer::create([
                    'status_id' => 1,
                    'customer_id' => $generateUNIQUE,
                    'itemID_accurate' => $getCloudAccurate->original,
                    'name' => $request->project,
                    'director' => $request->direktur,
                    'industry_id' => $request->tipe_bisnis,
                    'since' => $request->tahun,
                    'project_id' => $project_id, //this added response id project with new customer with API izzy
                    'address' => $request->alamat,
                    'tax_no' => $request->tax_nomor,
                    'tax_address' => $request->tax_alamat,
                    'tax_city' => $request->tax_kota,
                    'personno' => $project_id, //develop attr personno -> penambahan dlu id ini di accurate
                    'tax_phone' => $request->tax_telephone,
                    'tax_fax' => $request->tax_faxs,
                    'users_permissions' => Auth::User()->id,
                    'city_id' => $request->ops_kota,
                    'phone' => $request->ops_phone,
                    'fax' => $request->ops_fax,
                    'company_id' => session()->get('company_id'),
                    'email' => $request->ops_email,
                    'bank_name' => $request->nama_bank,
                    'an_bank' => $request->atas_nama_bank,
                    'no_rek' => $request->nomor_rekening,
                    'term_of_payment' => $request->kebijakan_pembayaran,
                    'website' => $request->ops_webs,
                    'PNGHN_alamat' => $this->rest->PNGHN_alamat, 
                    'PNGHN_city' => $this->rest->PNGHcty, 
                    'PNGHN_province' => $this->rest->pengihanPRV, 
                    'PNGHN_country' => 'INDONESIA', 
                    'customerTaxType' => $this->rest->CustomertaxType,
                    'flag' => 0
                ]);
            
                    Customer_pics::create([
                        'customer_id' => $id->id,
                        'customer_pic_status_id' => 1
                    ]);

                connectify('success', 'Accurate cloud berpesan', 'Pelanggan '.$id->name.' dengan Code: '.$getCloudAccurate->original.' berhasil dibuat di acccurate cloud');
                        return;
                        
                    }
                
                }
        } 
            catch (\GuzzleHttp\Exception\ClientException $e) {

                return $e->getResponse()
                        ->getBody()
                        ->getContents();
                
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($branch_id, $id)
    {

        $decrypts = Crypt::decrypt($id);
        $alert_items = Item::where('flag',0)->get();
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $customerpics = Customer_pics::find($decrypts);
        $vstatuss = Customer_pic_status::all();
        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $vstatus = Customer_status::all();
        $customers = Customer::with('cstatusid','city','industry','customer_pic')->find($decrypts);

        $prefix = Company_branchs::globalmaster(Auth::User()->company_branch_id)->first();

        // dd($customers);
        $city = City::all();
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
                        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
                        $APIs = $this->APIntegration::callbackme();
                        $responsecallbackme = json_decode($APIs->getContent(), true);
        session(['id_master_customer' => $id]);
        return view ('admin.customer.editcustomerregistration',[
                    'menu' => 'Edit Customer',
                    'choosen_user_with_branch' => $this->rest->session()->get('id'),
                    'some' => $this->rest->session()->get('id'),
                    'alert_items' => $alert_items,
                    'api_v1' => $responsecallbackme['api_v1'],
                    'api_v2' => $responsecallbackme['api_v2'],
                    'system_alert_item_vendor' => $system_alert_item_vendor,
                    'alert_customers' => $alert_customers,
                    'system_alert_item_customer' => $data_item_alert_sys_allows0
                ]
            )
        ->with(compact('customerpics','vstatuss','prefix','vstatus','city','customers','cstatusid','customer_pic'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $customers = Customer::with('cstatusid','city','industry')->find($id);
      $vstatus = Customer_status::all();
      $city = City::all();
        return view ('admin.customer.editcustomerregistration',[
            'menu' => 'Edit Customer'])->with(compact('vstatus','city','customers','cstatusid'));
    }

    public function automically_orders($branch_id, $id)
    {
        $decrypts = Crypt::decrypt($id);
      $warhs_order_id = Warehouse_order::select('id')->max('id');
      $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
      $wrhouse_id = $warhs_order_id+1;
      $brnchs = Company_branchs::all();
      $customerorders = Customer::find($decrypts);
      $alert_items = Item::where('flag',0)->get();
      $prefix = Company_branchs::globalmaster($branch_id)->first();
      $customerpics = Customer_pics::find($customerorders);
      $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
      $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
                    'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
                    $APIs = $this->APIntegration::callbackme();
                    $responsecallbackme = json_decode($APIs->getContent(), true);
    session(['redirects_to_whs' => $id ]);
      return view ('admin.customer.automically_booking_order',[
        'menu' => 'Order Customer',
        'choosen_user_with_branch' => $this->rest->session()->get('id'),
        'some' => $this->rest->session()->get('id'),
        'api_v1' => $responsecallbackme['api_v1'],
        'api_v2' => $responsecallbackme['api_v2'],
        'alert_items' => $alert_items,
        'system_alert_item_vendor' => $system_alert_item_vendor,
        'system_alert_item_customer' => $data_item_alert_sys_allows0,
        'alert_customers' => $alert_customers])->with(compact('prefix','customerpics','customerorders','wrhouse_id','brnchs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function UpdateCustomerAsync(Request $request, $branch_id, $id)
    {

        // dd($request->norek);die;

        $updatetocustomer = Customer::with('industry','cstatusid','city')->findOrFail($id);
        $updatetocustomer->name = $request->project_name;
        $updatetocustomer->director = $request->director;
        $updatetocustomer->industry_id = $request->type_of_business;
        $updatetocustomer->since = $request->since;
        $updatetocustomer->tax_no = $request->no_npwp;
        $updatetocustomer->tax_address = $request->tax_address;
        $updatetocustomer->tax_city = $request->tax_city;
        $updatetocustomer->tax_fax = $request->tax_fax;
        $updatetocustomer->tax_phone = $request->tax_phone;
        $updatetocustomer->address = $request->addressOPS;
        $updatetocustomer->city_id = $request->cityOPS;
        $updatetocustomer->phone = $request->phoneOPS;
        $updatetocustomer->fax = $request->faxOPS;
        $updatetocustomer->email = $request->opsemail;
        $updatetocustomer->status_id = $request->status_id;
        $updatetocustomer->website = $request->wbsiteOPS;
        $updatetocustomer->bank_name = $request->bank_name;
        $updatetocustomer->no_rek = $request->norek;
        $updatetocustomer->an_bank = $request->an_bank;
        $updatetocustomer->term_of_payment = $request->term_of_payment;
        $updatetocustomer->save();

        $pelanggan = $request->project_name;

        $customer = new Promise(
            function () use (&$customer, &$updatetocustomer, &$pelanggan) {
                $customer->resolve($this->UpdateSynCustomers($updatetocustomer->itemID_accurate, $pelanggan));
            },
            function ($ex) {
                $customer->reject($ex);
            }
        );

        $customer->wait();

        return response()->json(['success'=> $customer->wait()->original.' berhasil diupdate diaccurate.' ]);

        $vstatuss = Customer_pic_status::all();
        $vstatus = Customer_status::all();
        $city = City::all();
        $customers = Customer::with('industry','cstatusid','city')->find($id);
        $APIs = $this->APIntegration::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);
          return view ('admin.customer.editcustomerregistration',[
              'menu' => 'Edit Customer',
              'some' => $this->rest->session()->get('id'),
              'api_v1' => $responsecallbackme['api_v1'],
              'api_v2' => $responsecallbackme['api_v2']])->with(compact('vstatus','city','vstatuss','customers','cstatusid'));
    }

    public function restoreall(){
      $trashlist = Customer::with('cstatusid')->onlyTrashed()
                ->restore();
      return redirect('trash_customers')->with('success','Data has been restored.');
    }

    public function pagedels(){

        $cstatusid = Customer::with('cstatusid')->get();
        $APIs = $this->APIntegration::callbackme();
        $responsecallbackme = json_decode($APIs->getContent(), true);
          return view('admin.customer.customerlist',[
              'menu'=>'Customer List',
              'choosen_user_with_branch' => $this->rest->session()->get('id'),
              'some' => $this->rest->session()->get('id'),
              'api_v1' => $responsecallbackme['api_v1'],
              'api_v2' => $responsecallbackme['api_v2']])->with(compact('cslist','cstatusid'));

    }

    public function alert_customer_list($branch_id)
    {
        $alert_customers = Customer::with('cstatusid')->where('flag',0)->get();
        $cstatusid = Customer::with('cstatusid')->where('flag',0)->get();
        $alert_items = Item::where('flag',0)->get();
        $system_alert_item_vendor = Vendor_item_transports::with('vendors',
        'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
        $prefix = Company_branchs::globalmaster($branch_id)->first();
        $data_item_alert_sys_allows0 = Customer_item_transports::with('customers',
                    'city_show_it_origin','city_show_it_destination')->where('flag', 0)->get();
                    $APIs = $this->APIntegration::callbackme();
                    $responsecallbackme = json_decode($APIs->getContent(), true);
        if ($alert_customers->isEmpty()){
            #do something else..
            return redirect('/warehouse')->with('success','good job, now you have all customer that can be used to make orders.');
            }
              else {
                    return view('admin.customer.system_alert_customer.alert_customer_list',
                            [
                                'menu' => 'System Customer List',
                                'alert_customers' => $alert_customers,
                                'cstatusid' => $cstatusid,
                                'choosen_user_with_branch' => $this->rest->session()->get('id'),
                                'some' => $this->rest->session()->get('id'),
                                'api_v1' => $responsecallbackme['api_v1'],
                                'api_v2' => $responsecallbackme['api_v2'],
                                'system_alert_item_vendor' => $system_alert_item_vendor,
                                'system_alert_item_customer' => $data_item_alert_sys_allows0,
                                'alert_items' => $alert_items,
                                'prefix' => $prefix
                            ]
                    );
            }

    }

    public function update_alert_customer($id)
    {
        $customer = Customer::find($id);
        $customer->flag = Request('flag');
        $customer->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restored_customer($id)
    {
      Customer::withTrashed()->find($id)->restore();
      return redirect('trash_customers')->with('success','Data has been restored.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $customers = Customer::findOrFail($id)->delete();
      flash('Information has been deleted.')->error();

      return redirect()->route('master.customer.list')->with('success', 'Information has been added');

    }

}
