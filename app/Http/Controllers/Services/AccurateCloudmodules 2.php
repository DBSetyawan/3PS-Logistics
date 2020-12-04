<?php
 /**
 * [Author] Developer PT. 3 permata logistik. API integrator to accurate cloud.
 *
 * @param  \warehouse\Http\Controllers\Services\AccuratecloudInterface $APIClient
 * @param  Interface @post | @get | @dispatch,put | @delete
 * @return \Illuminate\Http\ForceJsonResponse | $readStream === $response
 */

namespace warehouse\Http\Controllers\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Promise\EachPromise;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;
use warehouse\Models\Batchs_transaction_item_customer;
use warehouse\Http\Controllers\Services\AccuratecloudInterface;
use Closure;
use GuzzleHttp\HandlerStack;
use React\EventLoop\Factory;
use GuzzleHttp\Promise\RejectedPromise;
use GuzzleHttp\Handler\CurlMultiHandler;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;

class AccurateCloudmodules implements AccuratecloudInterface
{
 
    /**
     * @Application authroize accurate cloud 
     * refs : public.accurate.id/api
    */
    const sessionCloud = "d5a46696";  
    const signatureSecretKey = "c9756765594102ee22ec2afa7509ff64";
    const access_token = "be5ff48f-319a-42e7-92b7-4d2c843e4d1b_nonactive";
    const DBINDEXACCURATE__ = 146583;

    /**
     * @method APIs webhooks signature hooks 3PS broadcasting
     * 
     */
    const PROTOCOL_WEBHOOK = "http://your-api.co.id/webhooks";

    /**
     * @method APIs Barang & jasa 
     * 
     */
    const API_ACCURATE_SAVE_ITEMBARANGJASA_URL = "https://public.accurate.id/accurate/api/item/save.do";
    const API_ACCURATE_DETAIL_ITEM_URL = "https://public.accurate.id/accurate/api/item/detail.do";
    const API_ACCURATE_LIST_BARANGJASA_URL = "https://public.accurate.id/accurate/api/item/list.do";
    const API_ACCURATE_SAVE_ITEM_URL = "https://public.accurate.id/accurate/api/item/save.do";
    const API_ACCURATE_ITEM_LIST_URL = "https://public.accurate.id/accurate/api/item/list.do";
    const API_ACCURATE_DETAIL_DATABASE_LIST_URL = "https://public.accurate.id/accurate/api/item/detail.do";

     /**
     * @method APIs Authorization & synchronize privilage db accurate cloud
     * 
     */
    const API_ACCURATE_AUTHORIZE_URL = "https://account.accurate.id/oauth/authorize";
    const API_ACCURATE_OPEN_DATABASE_SESSION_URL = "https://account.accurate.id/api/open-db.do";
    const API_ACCURATE_DATABASE_LIST_URL = "https://account.accurate.id/api/db-list.do";
    const API_ACCURATE_CHECK_DB_SESSION_URL = "https://account.accurate.id/api/db-check-session.do";
    const API_ACCURATE_BRANCH_URL = "https://public.accurate.id/accurate/api/branch/list.do";

    /**
     * @method APIs Customers [ project ]
     * 
     */
    const API_ACCURATE_CUSTOMER_LIST_URL = "https://public.accurate.id/accurate/api/customer/list.do";
    const API_ACCURATE_SAVE_CUSTOMER_URL = "https://public.accurate.id/accurate/api/customer/save.do";
    const API_ACCURATE_UPDATE_CUSTOMER_URL = "https://public.accurate.id/accurate/api/customer/save.do";
    const API_ACCURATE_DETAIL_CUSTOMER_URL = "https://public.accurate.id/accurate/api/customer/detail.do";
    const API_ACCURATE_FIND_MASTER_CUSTOMER_ID_URL = "https://public.accurate.id/accurate/api/customer/detail.do";

    /**
     * @method APIs Sales Orders
     * 
     */
    const API_ACCURATE_DETAIL_SALES_ORDERS_URL = "https://public.accurate.id/accurate/api/sales-order/detail.do";
    const API_ACCURATE_SAVE_SALES_ORDERS_URL = "https://public.accurate.id/accurate/api/sales-order/save.do";
    const API_ACCURATE_SAVE_SALES_ORDER_URL = "https://public.accurate.id/accurate/api/sales-order/save.do";
    const API_ACCURATE_SAVE_BULK_SALES_ORDER_URL = "https://public.accurate.id/accurate/api/sales-order/bulk-save.do";
    const API_ACCURATE_LIST_SALES_ORDERS_URL = "https://public.accurate.id/accurate/api/sales-order/list.do";

    /**
     * @method APIs Sales Quotation
     * 
     */
    const API_ACCURATE_SAVE_SALES_QUOTATION_URL = "https://public.accurate.id/accurate/api/sales-quotation/save.do";
    const API_ACCURATE_UPDATE_SALES_QUOTATION_URL = "https://public.accurate.id/accurate/api/sales-quotation/save.do";
    const API_ACCURATE_LIST_SALES_QUOTATION_URL = "https://public.accurate.id/accurate/api/sales-quotation/list.do";
    const API_ACCURATE_DETAIL_SALES_QUOTATION_URL = "https://public.accurate.id/accurate/api/sales-quotation/detail.do";

    /**
     * @method APIs vendor [ pemasok ]
     * 
     */
    const API_ACCURATE_SAVE_VENDOR_URL = "https://public.accurate.id/accurate/api/vendor/save.do";
    const API_ACCURATE_LIST_VENDOR_URL = "https://public.accurate.id/accurate/api/vendor/list.do";
    const API_ACCURATE_DETAIL_VENDOR_URL = "https://public.accurate.id/accurate/api/vendor/detail.do";
    const API_ACCURATE_UPDATE_VENDOR_URL = "https://public.accurate.id/accurate/api/vendor/save.do";

    /**
     * @method APIs delivery orders
     * 
     */
    const API_ACCURATE_SAVE_DELIVERY_ORDERS_URL = "https://public.accurate.id/accurate/api/delivery-order/save.do";
    const API_ACCURATE_SAVE_DELIVERY_BULK_ORDERS_URL = "https://public.accurate.id/accurate/api/delivery-order/bulk-save.do";

    /**
     * @method APIs Sales invoice
     * 
     */
    const API_ACCURATE_SAVE_SALES_INVOICE_URL = "https://public.accurate.id/accurate/api/sales-invoice/save.do";

     /**
     * @method APIs Sales receipts
     * 
     */
    const API_ACCURATE_SAVE_SALES_RECEIPT_URL = "https://public.accurate.id/accurate/api/sales-receipt/save.do";

    private $url;

    protected $requests;
    protected $date;
    protected $access_token;
    protected $signatureSecretKey;
    protected $db_id;
    protected $batch_item;
    protected $session;


    protected $indexView = 'admin.index'; //views
    protected $detailView = 'admin.detail'; //views
    protected $routeBindModel = 'model_access'; //binding model
    protected $redirectPageWhenFormSuccess = 'payroll_process.index'; //Route Name
    protected $title = 'Payroll Process';
    /**
     * @Func consume API Accurate cloud
     * @Author @artexsdns@gmail.com - daniel
     * ------ PATTERN REPOSITORY ------
     * Apabila pengguna memberikan akses pada tahap otorisasi, maka web browser akan melakukan redirect ke redirect_uri yang ditentukan.
     * dengan parameter tambahan dimana pada parameter tersebut terdapat Access Token yang dapat digunakan untuk mengakses API AOL.
     * Berikut ini contoh URL redirect di web browser:
     * https://example.com/aol-oauth-callback#access_token=e8446369-bd56-4731-acea-c0a9e0cc46fa&token_type=bearer&user=%7Bname=John%20Doe,%20email=john@example.com%7D
     * ----------------------------------------------------------------------------------------------------------------------------------------------------------------
     * Pada tahap ini aplikasi pihak ke-3 harus bisa melakukan parsing URL browser untuk bisa mendapatkan Access Token yang disertakan di URL.
     * yang pada contoh ini adalah e8446369-bd56-4731-acea-c0a9e0cc46fa.
     * @reference : https://accurate.id/api-integration/api-example/
    */

    /**
     * @Authorized Accurate online binding model|views
     * optional authenticated sync accurate online
     */
    public function __construct(Request $request, Batchs_transaction_item_customer $batch_item)
    {
        /**
         * this class not intended to be extended
         */
        //construct class. this can call other class controller want you want, so far be fine.
        // parent::__construct();
        $this->requests = $request;
        $this->batch_item = $batch_item;
        $this->date = gmdate('Y-m-d\TH:i:s\Z');

        /**
         * render this method
         */
        // public function render(View $view, $route = null, $obj = null, $method = 'POST')
        // {
        //call this controller from other class
        // $this->model_access->function();
        // return parent::render($view, $route, $obj, $method);
        // }

    }

    /**
     * @Func consume API Accurate cloud metode CODE
     * Authorization Code (response_type=code)
     * Setiap Access Token yang diterima oleh aplikasi pihak ke-3 akan expire dalam waktu 15 hari sejak dibuat.
     * Jika expire, Access Token tidak lagi dapat digunakan untuk mengakses API.
     * Untuk flow Grant Type: Authorization Code, aplikasi pihak ke-3 juga menerima Refresh Token pada response Access Token.
     * dimana Refresh Token ini dapat digunakan untuk mendapatkan Access Token baru
    */
    
    protected function FuncBasicAuthentication(){

        $client = new Client();
        $credentials = base64_encode('f4c839b9-340a-4471-8c84-4406cfae5613:4717eb2cc2757f914ea4cfbf777d7402');
        $response = $client->post('https://account.accurate.id/oauth/token', [
                'Authorization' => ['Basic '.$credentials],
                    'form_params' => 
                    [
                        'code' => "", //response dari Autentikasi basic Authorization
                        'grant_type' => "authorization_code",
                        'redirect_uri' => $redirectURI
                    ]
            ]
        );

        return $response;

    }

    /**
     * @Func consume API Accurate cloud metode TOKEN
     * Authorization Code (response_type=token)
    */
    public function FuncAuthorizedAccurateCloud($clientID, $responseType, $redirectURI, $scope){
        
        try
            {
                $client = new Client();
                $response = $client->post(
                    self::API_ACCURATE_AUTHORIZE_URL,
                        [
                            'headers' => [
                                'Content-Type' => 'application/x-www-form-urlencoded',
                                'Accept' => 'application/json'
                                        ],
                            'form_params' => 
                            [
                                'client_id' => $clientID,
                                'response_type' => $responseType,
                                'redirect_uri' => $redirectURI,
                                'scope' => $scope
                            ]
                        ]
                    );

            } 
                catch (\GuzzleHttp\Exception\ClientException $e) {
        
            return $e->getResponse()
                    ->getBody()
                    ->getContents();

        }

    }

    public function FuncOpenmoduleAccurateCloudItemList($fields, $itemType)
    {
        try 
            {

                $array_fetch_asort = [
                        'session' => $this->FuncAlwaysOnSessionAccurateCluod(),
                        'fields' => $fields,
                        'itemType' => $itemType,
                        '_ts' => $this->date
                    ]
                ;

                    ksort($array_fetch_asort);
                
                        $api = array_map('trim', $array_fetch_asort);
            
                $data = '';

                foreach ( $array_fetch_asort as $nama => $nilai ) {

                    if ($nilai == '') {

                        continue;

                    }
            
                        if ($data != '') {

                            $data .= '&';
                            
                        }

                    $data .= rawurlencode($nama).'='.rawurlencode($nilai);

                }
                
                $hash = hash_hmac('sha256', $data, self::signatureSecretKey , true );

                $signature = base64_encode($hash);

                    $client = new Client();
                    
                        $response = $client->post(
                                self::API_ACCURATE_ITEM_LIST_URL,
                                [
                                    'headers' => [
                                                    'Content-Type' => 'application/x-www-form-urlencoded',
                                                    'Authorization' =>'bearer'.self::access_token,
                                                    'Accept' => 'application/json'
                                                ],
                                    'form_params' => 
                                    [
                                        'session' => $array_fetch_asort['session'],
                                        'fields' => $array_fetch_asort['fields'],
                                        'itemType' => $array_fetch_asort['itemType'],
                                        '_ts' => $array_fetch_asort['_ts'],
                                        'sign' => $signature
                                    ]
                                ]
                            );

                    $jsonArray = json_decode($response->getBody()->getContents(), true);

                return response()->json($jsonArray);

        } 
            catch (\GuzzleHttp\Exception\ClientException $e) {
    
                return $e->getResponse()
                        ->getBody()
                        ->getContents();
                    
        }
        
    }

    public function FuncOpenmoduleAccurateCloudDblist($_ts)
    {
        try 
            {

                $array_fetch_asort = [
                        '_ts' => $_ts
                    ]
                ;

                ksort($array_fetch_asort);
                
                $api = array_map('trim', $array_fetch_asort);
            
                $data = '';
                foreach ( $array_fetch_asort as $nama => $nilai ) {

                    if ($nilai == '') {

                        continue;

                    }
            
                        if ($data != '') {

                            $data .= '&';
                            
                        }

                    $data .= rawurlencode($nama).'='.rawurlencode($nilai);

                }

                
                $hash = hash_hmac('sha256', $data, self::signatureSecretKey  , true );
                $signature = base64_encode($hash);
                
                $client = new Client();

                $response = $client->post(
                        self::API_ACCURATE_DATABASE_LIST_URL,
                        [
                            'headers' => [
                                            'Content-Type' => 'application/x-www-form-urlencoded',
                                            'Authorization' =>'bearer'.self::access_token,
                                            'Accept' => 'application/json'
                                        ],
                            'form_params' => 
                                [
                                    '_ts' => $array_fetch_asort['_ts'],
                                    'sign' => $signature
                                ]
                        ]
                    );

                $jsonArray = json_decode($response->getBody()->getContents(), true);

            return response()->json($jsonArray);

        } 
            catch (\GuzzleHttp\Exception\ClientException $e) {

                return $e->getResponse()
                        ->getBody()
                        ->getContents();
                    
        }

    }

    public function FuncOpenmoduleAccurateCloudSession()
    {
        try {

        //     $array_fetch_asort = [
        //         '_ts' => $this->date
        //     ]
        // ;

        // ksort($array_fetch_asort);
        
        // $api = array_map('trim', $array_fetch_asort);
    
        // $data = '';
        // foreach ( $array_fetch_asort as $nama => $nilai ) {

        //     if ($nilai == '') {

        //         continue;

        //     }
    
        //         if ($data != '') {

        //             $data .= '&';
                    
        //         }

        //     $data .= rawurlencode($nama).'='.rawurlencode($nilai);

        // }

        
        // $hash = hash_hmac('sha256', $data, self::signatureSecretKey  , true );
        // $signature = base64_encode($hash);
        
        // $client = new Client();

        // $response = $client->get(
        //         self::API_ACCURATE_DATABASE_LIST_URL,
        //         [
        //             'headers' => [
        //                             'Content-Type' => 'application/x-www-form-urlencoded',
        //                             'Authorization' =>'bearer'.self::access_token,
        //                             'Accept' => 'application/json'
        //                         ],
                    // 'form_params' => 
                    //     [
                    //         '_ts' => $array_fetch_asort['_ts'],
                    //         'sign' => $signature
                    //     ]
            //     ]
            // );

        // $jsonArray = json_decode($response->getBody()->getContents(), true);
        // dd($jsonArray["d"][0]["id"]);
        // $dbID = $jsonArray["d"][0]["id"];
            // return response()->json($jsonArray);
    
            // $array_fetch_asort = array(
            //             "id" => $dasd,
            //             // '_ts' => $this->date
            // )
            //     ;

            //     ksort($array_fetch_asort);
                
            //     $api = array_map('trim', $array_fetch_asort);
            
            //     $data = '';
            //     foreach ( $array_fetch_asort as $nama => $nilai ) {

            //         if ($nilai == '') {

            //             continue;

            //         }
            
            //             if ($data != '') {

            //                 $data .= '&';
                            
            //             }

            //         $data .= rawurlencode($nama).'='.rawurlencode($nilai);

            //     }

            //     $hash = hash_hmac('sha256', $data, self::signatureSecretKey  , true );
            //     $signature = base64_encode($hash);

                $client = new Client();

                $response = $client->post(
                        self::API_ACCURATE_OPEN_DATABASE_SESSION_URL,
                        [
                            'headers' => [
                                            // 'Content-Type' => 'application/x-www-form-urlencoded',
                                            'Authorization' =>'Bearer'.self::access_token,
                                            'Accept' => 'application/json'
                                        ],
                            'form_params' =>
                            [
                                'id' => self::DBINDEXACCURATE__
                                // '_ts' => $array_fetch_asort["_ts"],
                                // 'sign' => $signature
                            ]
                        ]
                    );

                    $jsonArray = json_decode($response->getBody()->getContents(), true);
                    // dd($jsonArray);   
                return $jsonArray["session"];

            } 
                catch (\GuzzleHttp\Exception\ClientException $e) {
        
                    return $e->getResponse()
                            ->getBody() 
                            ->getContents();
                        
        }

    }

    public function FuncOpenmoduleAccurateCloudUsersBranchId()
    {
        try {

            $client = new Client();

                $response = $client->get(
                        self::API_ACCURATE_BRANCH_URL,
                        [
                            'headers' => [
                                            'Content-Type' => 'application/x-www-form-urlencoded',
                                            'Authorization' =>'Bearer'.self::access_token,
                                            'X-Session-ID' => $this->FuncAlwaysOnSessionAccurateCluod(),
                                            'Accept' => 'application/json'
                                        ],
                            'form_params' =>
                            [
                                'filter.lastUpdate.op' => 'NOT_EMPTY'
                            ]
                        ]
                    );

                    $jsonArray = json_decode($response->getBody()->getContents(), true);
                    // dd($jsonArray);
                    return $jsonArray; 
                // return response()->json($jsonArray);

            } 
                catch (\GuzzleHttp\Exception\ClientException $e) {
        
                    return $e->getResponse()
                            ->getBody() 
                            ->getContents();
                        
        }

    }

    public function FuncOpenmoduleAccurateCloudSaveSalesReceipt($bankno, $chequeAmount, $customerNo, $invoiceNo, $paymentAmount, $transDate){

        try 
            {

                $array_fetch_asort = [
                        'session' => $this->FuncAlwaysOnSessionAccurateCluod(),
                        'bankNo' => $bankno,
                        'chequeAmount' => $chequeAmount,
                        'customerNo' => $customerNo,
                        'detailInvoice[0].invoiceNo' => $invoiceNo,
                        'detailInvoice[0].paymentAmount' => $paymentAmount,
                        'transDate' => $transDate,
                        '_ts' => $this->date
                    ]
                ;

                ksort($array_fetch_asort);
                
                $api = array_map('trim', $array_fetch_asort);
            
                $data = '';
                foreach ( $array_fetch_asort as $nama => $nilai ) {

                    if ($nilai == '') {

                        continue;

                    }
            
                        if ($data != '') {

                            $data .= '&';
                            
                        }

                    $data .= rawurlencode($nama).'='.rawurlencode($nilai);

                }
                
                $hash = hash_hmac('sha256', $data, self::signatureSecretKey , true );

                $signature = base64_encode($hash);
                $client = new Client();
                $response = $client->post(
                        self::API_ACCURATE_SAVE_SALES_RECEIPT_URL,
                        [
                            'headers' => [
                                            'Content-Type' => 'application/x-www-form-urlencoded',
                                            'Authorization' =>'bearer'.self::access_token,
                                            'Accept' => 'application/json'
                                        ],
                            'form_params' => 
                                    [
                                        'session' => $array_fetch_asort['session'],
                                        'bankNo' => $array_fetch_asort['bankNo'],
                                        'chequeAmount' => $array_fetch_asort['chequeAmount'],
                                        'customerNo' => $array_fetch_asort['customerNo'],
                                        'detailInvoice[0].invoiceNo' => $array_fetch_asort['detailInvoice[0].invoiceNo'],
                                        'detailInvoice[0].paymentAmount' => $array_fetch_asort['detailInvoice[0].paymentAmount'],
                                        'transDate' => $array_fetch_asort['transDate'],
                                        '_ts' => $array_fetch_asort['_ts'],
                                        'sign' => $signature
                                    ]
                        ]
                    );

                    $jsonArray = json_decode($response->getBody()->getContents(), true);

                    $data_array2 = $jsonArray["r"]["number"];

                return response()->json($data_array2);

            } 
            catch (\GuzzleHttp\Exception\ClientException $e) {
    
                return $e->getResponse()
                        ->getBody()
                        ->getContents();
                    
        }

    }

    public function FuncOpenmoduleAccurateCloudSaveItemBarangjasa__($name, $itemType, $_ts, $kode_unik, $UnitName){

        try 
            {

                $array_fetch_asort = [
                        'session' => $this->FuncAlwaysOnSessionAccurateCluod(),
                        'name' => $name,
                        'itemType' => $itemType,
                        '_ts' => $_ts,
                        'no' => $kode_unik,
                        'unit1Name' => $UnitName
                    ]
                ;

                ksort($array_fetch_asort);
                
                $api = array_map('trim', $array_fetch_asort);
            
                $data = '';
                foreach ( $array_fetch_asort as $nama => $nilai ) {

                    if ($nilai == '') {

                        continue;

                    }
            
                        if ($data != '') {

                            $data .= '&';
                            
                        }

                    $data .= rawurlencode($nama).'='.rawurlencode($nilai);

                }
                
                $hash = hash_hmac('sha256', $data, self::signatureSecretKey , true );

                $loop = Factory::create();

                $handler = new CurlMultiHandler();
                $timer = $loop->addPeriodicTimer(2, \Closure::bind(function () use (&$timer) {
                        $this->tick();
                        if (empty($this->handles) && \GuzzleHttp\Promise\queue()->isEmpty()) {
                            $timer->cancel();
                        }
                    }, $handler, $handler)
                );

                $signature = base64_encode($hash);
                $client = new Client(['handler' => HandlerStack::create($handler)]);

                $response[] = $client->postAsync(
                        self::API_ACCURATE_SAVE_ITEM_URL,
                        [
                            'headers' => [
                                            'Content-Type' => 'application/x-www-form-urlencoded',
                                            'Authorization' =>'bearer'.self::access_token,
                                            'X-Session-ID' => $this->FuncAlwaysOnSessionAccurateCluod(),
                                            'Accept' => 'application/json'
                                        ],
                            'form_params' => 
                                    [
                                        // 'session' => $array_fetch_asort['session'],
                                        'name' => $array_fetch_asort['name'],
                                        'itemType' => $array_fetch_asort['itemType'],
                                        'unit1Name' => $array_fetch_asort['unit1Name'],
                                        // '_ts' => $array_fetch_asort['_ts'],
                                        'no' => $array_fetch_asort['no']
                                        // 'sign' => $signature
                                    ]
                        ]
                    )->then(
                        function (Response $response) {
                            $data = $response->getBody()->getContents();
                            return response()->json($data);
                        },
                        function (\Exception $response) {
                            $data = $response->getMessage();
                            return response()->json($data);
                        }
                );

                $loop->run();

                    $results = Promise\settle($response)->wait(true);
                    $jsonArray = $results[0]["value"];
                    $data = $jsonArray 
                            ? $jsonArray 
                            : $jsonArray->original;
                    $dd = json_decode($data->getData(), true);
// return $dd;
//                     $data_array2 = $dd["r"]["no"];

                return response()->json($dd);

            } 

                catch (\GuzzleHttp\Exception\ClientException $e) {
    
                    return $e->getResponse()
                            ->getBody()
                            ->getContents();
                    
        }

    }
    
    public function FuncOpenmoduleAccurateCloudShowDetailDatabase($session, $id, $_ts){

        try {

            $array_fetch_asort = [
                    'session' => $this->FuncAlwaysOnSessionAccurateCluod(),
                    'id' => $id,
                    '_ts' => $_ts
                ]
            ;

            ksort($array_fetch_asort);
            
            $api = array_map('trim', $array_fetch_asort);
        
            $data = '';
            foreach ( $array_fetch_asort as $nama => $nilai ) {

                if ($nilai == '') {

                    continue;

                }
        
                    if ($data != '') {

                        $data .= '&';
                        
                    }

                $data .= rawurlencode($nama).'='.rawurlencode($nilai);

            }
            
            $hash = hash_hmac('sha256', $data, self::signatureSecretKey , true);

            $signature = base64_encode($hash);
            $client = new Client();
            $response = $client->post(
                    self::API_ACCURATE_DETAIL_DATABASE_LIST_URL,
                    [
                        'headers' => [
                                        'Content-Type' => 'application/x-www-form-urlencoded',
                                        'Authorization' =>'bearer'.self::access_token,
                                        'Accept' => 'application/json'
                                    ],
                        'form_params' => 
                                [
                                    'session' => $array_fetch_asort['session'],
                                    'id' => $array_fetch_asort['id'],
                                    '_ts' => $array_fetch_asort['_ts'],
                                    'sign' => $signature
                                ]
                    ]
                );

                $jsonArray = json_decode($response->getBody()->getContents(), true);

            return response()->json($jsonArray);

        }
             catch (\GuzzleHttp\Exception\ClientException $e) {
    
                return $e->getResponse()
                        ->getBody()
                        ->getContents();
                    
        }


    }

    public function FuncOpenmoduleAccurateCloudSaveCustomer(
                    $numbering, 
                    $name,
                    $detailName, 
                    $transDate, 
                    $email, 
                    $homePhone, 
                    $MobilePhone,
                    $website,
                    $Famiximili,
                    $alamatPenagihan,
                    $kotaPenagihan,
                    $billZipCode,
                    $billProvince,
                    $billCountry,
                    $whatsapp,
                    $npwpNo,
                    $CustomerTaxType
    ) 
        {

        try {

            $array_fetch_asort = [
                    'customerNo' => $numbering,
                    'session' => $this->FuncAlwaysOnSessionAccurateCluod(),
                    'name' => $name,
                    'transDate' => $transDate,
                    'email' => $email,
                    'homePhone' => $homePhone,
                    'mobilePhone' => $MobilePhone,
                    'fax' => $Famiximili,
                    'website' => $website,
                    'billStreet' => $alamatPenagihan,
                    'billCity' => $kotaPenagihan,
                    'billZipCode' => $billZipCode,
                    'billProvince' => $billProvince,
                    'billCountry' => $billCountry,
                    'npwpNo' => $npwpNo,
                    'customerTaxType' => $CustomerTaxType,
                    'detailContact[n].bbmPin' => $whatsapp,
                    '_ts' => $this->date
                ]
            ;

            ksort($array_fetch_asort);
            
            $api = array_map('trim', $array_fetch_asort);
        
            $data = '';
            foreach ( $array_fetch_asort as $nama => $nilai) {

                if ($nilai == '') {

                    continue;

                }
        
                    if ($data != '') {

                        $data .= '&';
                        
                    }

                $data .= rawurlencode($nama).'='.rawurlencode($nilai);

            }
            
            $hash = hash_hmac('sha256', $data, self::signatureSecretKey , true);

            $signature = base64_encode($hash);
            $client = new Client();
            $response = $client->post(
                    self::API_ACCURATE_SAVE_CUSTOMER_URL,
                    [
                        'headers' => [
                                        'Content-Type' => 'application/x-www-form-urlencoded',
                                        'Authorization' =>'bearer'.self::access_token,
                                        'X-Session-ID' => $this->FuncAlwaysOnSessionAccurateCluod(),
                                        'Accept' => 'application/json'
                                    ],
                        'form_params' => 
                                [
                                    'session' => $array_fetch_asort['session'],
                                    'customerNo' => $array_fetch_asort['customerNo'],
                                    'name' => $array_fetch_asort['name'],
                                    'transDate' => $array_fetch_asort['transDate'],
                                    'email' => $array_fetch_asort['email'],
                                    'homePhone' => $array_fetch_asort['homePhone'],
                                    'mobilePhone' => $array_fetch_asort['mobilePhone'],
                                    'fax' => $array_fetch_asort['fax'],
                                    'website' => $array_fetch_asort['website'],
                                    'billStreet' => $array_fetch_asort['billStreet'],
                                    'billCity' => $array_fetch_asort['billCity'],
                                    'billZipCode' => $array_fetch_asort['billZipCode'],
                                    'billProvince' => $array_fetch_asort['billProvince'],
                                    'billCountry' => $array_fetch_asort['billCountry'],
                                    'npwpNo' => $array_fetch_asort['npwpNo'],
                                    'customerTaxType' => $array_fetch_asort['customerTaxType'],
                                    'detailContact[n].bbmPin' => $array_fetch_asort['detailContact[n].bbmPin'],
                                    '_ts' => $array_fetch_asort['_ts']
                                    // 'sign' => $signature
                                ]
                    ]
                );

                    $jsonArray = json_decode($response->getBody()->getContents(), true);
                $responsecustomerid = $jsonArray["r"]["customerNo"];

            return response()->json($responsecustomerid);

        } catch (\GuzzleHttp\Exception\ClientException $e) {
    
                return $e->getResponse()
                        ->getBody()
                        ->getContents();
                    
        }

    }

    public function FuncOpenmoduleAccurateCloudUpdateCustomer(
                    $id, 
                    // $numbering, 
                    $name
                    // $detailName, 
                    // $transDate, 
                    // $email, 
                    // $homePhone, 
                    // $MobilePhone,
                    // $website,
                    // $Famiximili,
                    // $alamatPenagihan,
                    // $kotaPenagihan,
                    // $billZipCode,
                    // $billProvince,
                    // $billCountry,
                    // $whatsapp,
                    // $npwpNo,
                    // $CustomerTaxType
            ) 
    {

            try {

            $array_fetch_asort = [
                    'id' => $id,
                    // 'customerNo' => $numbering,
                    'session' => $this->FuncAlwaysOnSessionAccurateCluod(),
                    'name' => $name,
                    // 'transDate' => $transDate,
                    // 'email' => $email,
                    // 'homePhone' => $homePhone,
                    // 'mobilePhone' => $MobilePhone,
                    // 'fax' => $Famiximili,
                    // 'website' => $website,
                    // 'billStreet' => $alamatPenagihan,
                    // 'billCity' => $kotaPenagihan,
                    // 'billZipCode' => $billZipCode,
                    // 'billProvince' => $billProvince,
                    // 'billCountry' => $billCountry,
                    // 'npwpNo' => $npwpNo,
                    // 'customerTaxType' => $CustomerTaxType,
                    // 'detailContact[n].bbmPin' => $whatsapp,
                    '_ts' => $this->date
                ]
            ;

            ksort($array_fetch_asort);

            $api = array_map('trim', $array_fetch_asort);

            $data = '';
            foreach ( $array_fetch_asort as $nama => $nilai) {

                if ($nilai == '') {

                    continue;

                }

                    if ($data != '') {

                        $data .= '&';
                        
                    }

                $data .= rawurlencode($nama).'='.rawurlencode($nilai);

            }

            $hash = hash_hmac('sha256', $data, self::signatureSecretKey , true);

            $signature = base64_encode($hash);
            $client = new Client();
            $response = $client->post(
                    self::API_ACCURATE_UPDATE_CUSTOMER_URL,
                    [
                        'headers' => [
                                        'Content-Type' => 'application/x-www-form-urlencoded',
                                        'Authorization' =>'bearer'.self::access_token,
                                        'X-Session-ID' => $this->FuncAlwaysOnSessionAccurateCluod(),
                                        'Accept' => 'application/json'
                                    ],
                        'form_params' => 
                                [
                                    // 'session' => $array_fetch_asort['session'],
                                    'id' => $array_fetch_asort['id'],
                                    // 'customerNo' => $array_fetch_asort['customerNo'],
                                    'name' => $array_fetch_asort['name']
                                    // 'transDate' => $array_fetch_asort['transDate'],
                                    // 'email' => $array_fetch_asort['email'],
                                    // 'homePhone' => $array_fetch_asort['homePhone'],
                                    // 'mobilePhone' => $array_fetch_asort['mobilePhone'],
                                    // 'fax' => $array_fetch_asort['fax'],
                                    // 'website' => $array_fetch_asort['website'],
                                    // 'billStreet' => $array_fetch_asort['billStreet'],
                                    // 'billCity' => $array_fetch_asort['billCity'],
                                    // 'billZipCode' => $array_fetch_asort['billZipCode'],
                                    // 'billProvince' => $array_fetch_asort['billProvince'],
                                    // 'billCountry' => $array_fetch_asort['billCountry'],
                                    // 'npwpNo' => $array_fetch_asort['npwpNo'],
                                    // 'customerTaxType' => $array_fetch_asort['customerTaxType'],
                                    // 'detailContact[n].bbmPin' => $array_fetch_asort['detailContact[n].bbmPin'],
                                    // '_ts' => $array_fetch_asort['_ts'],
                                    // 'sign' => $signature
                                ]
                    ]
                );

                    $jsonArray = json_decode($response->getBody()->getContents(), true);
                
                $responsecustomerid = $jsonArray["r"]["customerNo"];

            return response()->json($responsecustomerid);

            } catch (\GuzzleHttp\Exception\ClientException $e) {

                return $e->getResponse()
                        ->getBody()
                        ->getContents();
                    
            }

    }


    public function FuncOpenmoduleAccurateCloudUpdatePemasok(
                                                                $id, 
                                                                $name
                                                            ) 
    {

    try {

            $array_fetch_asort = [
                    'id' => $id,
                    'session' => $this->FuncAlwaysOnSessionAccurateCluod(),
                    'name' => $name,
                    '_ts' => $this->date
                ]
            ;

                    ksort($array_fetch_asort);

                    $api = array_map('trim', $array_fetch_asort);

                    $data = '';
                    foreach ( $array_fetch_asort as $nama => $nilai) {

                        if ($nilai == '') {

                            continue;

                        }

                            if ($data != '') {

                                $data .= '&';
                                
                            }

                        $data .= rawurlencode($nama).'='.rawurlencode($nilai);

                    }

                $hash = hash_hmac('sha256', $data, self::signatureSecretKey , true);

            $signature = base64_encode($hash);
            $client = new Client();
            $response = $client->post(
                    self::API_ACCURATE_UPDATE_VENDOR_URL,
                    [
                        'headers' => [
                                        'Content-Type' => 'application/x-www-form-urlencoded',
                                        'Authorization' =>'bearer'.self::access_token,
                                        'X-Session-ID' => $this->FuncAlwaysOnSessionAccurateCluod(),
                                        'Accept' => 'application/json'
                                    ],
                        'form_params' => 
                                [
                                    // 'session' => $array_fetch_asort['session'],
                                    'id' => $array_fetch_asort['id'],
                                    'name' => $array_fetch_asort['name']
                                    // '_ts' => $array_fetch_asort['_ts']
                                    // 'sign' => $signature
                                ]
                        ]
                    );

                    $jsonArray = json_decode($response->getBody()->getContents(), true);
                
                $responsecustomerid = $jsonArray["r"]["vendorNo"];

            return response()->json($responsecustomerid);

        } catch (\GuzzleHttp\Exception\ClientException $e) {

            return $e->getResponse()
                    ->getBody()
                    ->getContents();
                
        }

    }

    public function FuncOpenmoduleAccurateCloudSaveVendor(
                            $name, 
                            $detailName, 
                            $transDate, 
                            $email, 
                            $homePhone, 
                            $MobilePhone,
                            $website,
                            $Famiximili,
                            $alamatPenagihan,
                            $kotaPenagihan,
                            $billZipCode,
                            $billProvince,
                            $billCountry,
                            $whatsapp,
                            $npwpNo,
                            $CustomerTaxType
        ) 
            {

                try {

                    $array_fetch_asort = [
                            'session' => $this->FuncAlwaysOnSessionAccurateCluod(),
                            'name' => $name,
                            'transDate' => $transDate,
                            'email' => $email,
                            'homePhone' => $homePhone,
                            'mobilePhone' => $MobilePhone,
                            'fax' => $Famiximili,
                            'website' => $website,
                            'billStreet' => $alamatPenagihan,
                            'billCity' => $kotaPenagihan,
                            'billZipCode' => $billZipCode,
                            'billProvince' => $billProvince,
                            'billCountry' => $billCountry,
                            'npwpNo' => $npwpNo,
                            'customerTaxType' => $CustomerTaxType,
                            'detailContact[n].bbmPin' => $whatsapp,
                            '_ts' => $this->date
                        ]
                    ;

                    ksort($array_fetch_asort);

                    $api = array_map('trim', $array_fetch_asort);

                    $data = '';
                    foreach ( $array_fetch_asort as $nama => $nilai) {

                        if ($nilai == '') {

                            continue;

                        }

                            if ($data != '') {

                                $data .= '&';
                                
                            }

                        $data .= rawurlencode($nama).'='.rawurlencode($nilai);

                    }

                    $hash = hash_hmac('sha256', $data, self::signatureSecretKey , true);

                    $signature = base64_encode($hash);
                    $client = new Client();
                    $response = $client->post(
                            self::API_ACCURATE_SAVE_VENDOR_URL,
                            [
                                'headers' => [
                                                'Content-Type' => 'application/x-www-form-urlencoded',
                                                'Authorization' =>'bearer'.self::access_token,
                                                'X-Session-ID' => $this->FuncAlwaysOnSessionAccurateCluod(),
                                                'Accept' => 'application/json'
                                            ],
                                'form_params' => 
                                        [
                                            'session' => $array_fetch_asort['session'],
                                            'name' => $array_fetch_asort['name'],
                                            'transDate' => $array_fetch_asort['transDate'],
                                            'email' => $array_fetch_asort['email'],
                                            'homePhone' => $array_fetch_asort['homePhone'],
                                            'mobilePhone' => $array_fetch_asort['mobilePhone'],
                                            'fax' => $array_fetch_asort['fax'],
                                            'website' => $array_fetch_asort['website'],
                                            'billStreet' => $array_fetch_asort['billStreet'],
                                            'billCity' => $array_fetch_asort['billCity'],
                                            'billZipCode' => $array_fetch_asort['billZipCode'],
                                            'billProvince' => $array_fetch_asort['billProvince'],
                                            'billCountry' => $array_fetch_asort['billCountry'],
                                            'npwpNo' => $array_fetch_asort['npwpNo'],
                                            'customerTaxType' => $array_fetch_asort['customerTaxType'],
                                            'detailContact[n].bbmPin' => $array_fetch_asort['detailContact[n].bbmPin'],
                                            '_ts' => $array_fetch_asort['_ts'],
                                            // 'sign' => $signature
                                        ]
                            ]
                        );

                            $jsonArray = json_decode($response->getBody()->getContents(), true);
                            
                        $vendorno = $jsonArray["r"]["vendorNo"];

                    return response()->json($vendorno);

                } catch (\GuzzleHttp\Exception\ClientException $e) {

                    return $e->getResponse()
                            ->getBody()
                            ->getContents();
                        
            }

    }
    
    public function FuncOpenmoduleAccurateCloudSaveSalesQoutation($number, $customerno, $itemNo, $transDate, $unitPrice, $quantity, $ItemUnit, $transport_id, $detailNotes, $itemDiscount){

        try {

            $datax = collect([
                                [
                                    'number'=> $number,
                                    'customerNo'=> $customerno,
                                    'transDate'=> $transDate,
                                    'itemNo'=> (array)$itemNo,
                                    'unitPrice'=> (array)$unitPrice,
                                    'quantity'=> (array)$quantity,
                                    'detailNotes'=> $detailNotes,
                                    'itemUnitName'=> (array)$ItemUnit,
                                    'itemDiscount'=> (array)$itemDiscount
                                ]
                            ]
                        )
                    ;
// dd($datax[0]['detailNotes']);
                    //data[n].detailItem[n].itemCashDiscount
                                    // dd($fetchBatchItemOrderDetail);die;
        $fetchBatchItemOrderDetail = $this->batch_item
                ->with(['transportsIDX','masterItemIDACCURATE'])
                    ->whereIn('transport_id',[$transport_id])
                        ->get();

                foreach ($datax as $key => $value) {
                    $values[$key] = $value;

                    foreach($fetchBatchItemOrderDetail as $keys => $thisdataBatchItemTransports){
                        $transport_id[] = $thisdataBatchItemTransports->transport_id;
                        $detailnotes[$key] = $thisdataBatchItemTransports->detailnotes;
                        $itemTRANSPORT[] = $thisdataBatchItemTransports->masterItemIDACCURATE->itemID_accurate;
                        $itemName[] = $thisdataBatchItemTransports->masterItemIDACCURATE->itemovdesc;
                        $qty[] = $thisdataBatchItemTransports->qty;
                        $hargaID[] = $thisdataBatchItemTransports->harga;
                        $unitName[] = $thisdataBatchItemTransports->masterItemIDACCURATE->unit;
                    
                    // for ($index = 0 ; $index < count($datax); $index++) {
                        $mArray[] =[
                            // 'session' => $this->FuncAlwaysOnSessionAccurateCluod(),
                            'data['.(Int)$key.'].number' => $values[$key]['number'],
                            'data['.(Int)$key.'].customerNo' => $values[$key]['customerNo'],
                            'data['.(Int)$key.'].transDate' => $values[$key]['transDate'],
                            'data['.(Int)$key.'].description' => implode("\n", $values[$key]['detailNotes']),
                            // 'data['.$key.'].detailItem[0].id' => $values[$key]['idItem'],
                            'data[0].detailItem['.(Int)$keys.'].itemNo' => $thisdataBatchItemTransports->masterItemIDACCURATE->itemID_accurate,
                            'data[0].detailItem['.(Int)$keys.'].unitPrice' => $thisdataBatchItemTransports->harga,
                            'data[0].detailItem['.(Int)$keys.'].quantity' => $thisdataBatchItemTransports->qty,
                            'data[0].detailItem['.(Int)$keys.'].detailNotes' => $thisdataBatchItemTransports->detailnotes,
                            'data[0].detailItem['.(Int)$keys.'].itemUnitName' => $thisdataBatchItemTransports->masterItemIDACCURATE->unit
                            // '_ts' => $this->date
                        ];
                // }

                    $arry[] =[
                        'data['.(int)$key.'].number',
                        'data['.(int)$key.'].customerNo',
                        'data['.(int)$key.'].transDate',
                        'data['.(int)$key.'].description',
                        'data[0].detailItem['.(Int)$keys.'].itemNo',
                        // 'data['.(int)$key.'].detailItem[0].id',
                        'data[0].detailItem['.(Int)$keys.'].unitPrice',
                        'data[0].detailItem['.(Int)$keys.'].quantity',
                        'data[0].detailItem['.(Int)$keys.'].detailNotes',
                        'data[0].detailItem['.(Int)$keys.'].itemUnitName',
                        'session',
                        '_ts',
                ];
                        
                    }
                }

                // dd($mArray);
                $needles = Arr::flatten($arry);
                array_walk_recursive($mArray, function ($v, $k) use (&$sArray,$needles) {
                    if (in_array($k, $needles)) {
                        $sArray[$k]=$v;
                    }
                });
                ksort($sArray);

                
                //       foreach($sArray as $data){
                //             $dataFlat[] = $data;
                //       }

                // foreach ($datax as $key => $value) {
                //     # code...
                //     $newkey[] = sprintf('%s', $key);
                //     $values[$key] = $value;
                //     // dd($values[$key]["itemNo"]);die;
                //     foreach($values[$key]["itemNo"] as $indexcItemNo => $itemNoID){
                //         $newkeyItemNo[] = sprintf('%s', $indexcItemNo);

                //         $itemID[] = $itemNoID;
                //     }

                //     foreach($values[$key]["quantity"] as $indexcQTY => $quantity){
                //         $newkeyQty[] = sprintf('%s', $indexcQTY);

                //         $quantityID[] = $quantity;
                //     }

                //     foreach($values[$key]["unitPrice"] as $indexcUNIT => $unitPrice){
                //         $newkeyUnitPrice[] = sprintf('%s', $indexcUNIT);

                //         $unitPrices[] = $unitPrice;
                //     }

                //     foreach($values[$key]["itemUnitName"] as $indexcUNIT => $itemUnitName){
                //         $newkeyUnitPrice[] = sprintf('%s', $indexcUNIT);

                //         $itemUnits[] = $itemUnitName;
                //     }
                //     // dd($newkeyItemNo);die;
                //     $mArray[] =[
                //                 'session' => $this->FuncAlwaysOnSessionAccurateCluod(),
                //                 'data['.(Int)$key.'].number' => $values[$key]['number'],
                //                 'data['.(Int)$key.'].customerNo' => $values[$key]['customerNo'],
                //                 'data['.(Int)$key.'].transDate' => $values[$key]['transDate'],
                //                 // 'data['.$key.'].detailItem[0].id' => $values[$key]['idItem'],
                //                 'data['.(Int)$key.'].detailItem[0].itemNo' => $itemID,
                //                 'data['.(Int)$key.'].detailItem[0].unitPrice' => $unitPrices,
                //                 'data['.(Int)$key.'].detailItem[0].quantity' => $quantityID,
                //                 'data['.(Int)$key.'].detailItem[0].itemUnitName' => $itemUnits,
                //                 '_ts' => $this->date
                //         ];

                //     $arry[] =[
                //                 'data['.(int)$key.'].number',
                //                 'data['.(int)$key.'].customerNo',
                //                 'data['.(int)$key.'].transDate',
                //                 'data['.(int)$key.'].detailItem[0].itemNo',
                //                 // 'data['.(int)$key.'].detailItem[0].id',
                //                 'data['.(int)$key.'].detailItem[0].unitPrice',
                //                 'data['.(int)$key.'].detailItem[0].quantity',
                //                 'data['.(int)$key.'].detailItem[0].itemUnitName',
                //                 'session',
                //                 '_ts',
                //         ];
                // }
                // $needles = Arr::flatten($arry);
                // array_walk_recursive($mArray, function ($v, $k) use (&$sArray,$needles) {
                //     if (in_array($k, $needles)) {
                //         $sArray[$k]=$v;
                //     }
                // });

                // ksort($sArray);
                // dd($mArray);
                // die;

                $api = array_map('trim', $sArray);
                
                $data = '';

                foreach ($api as $nama => $nilai) {
                    if ($nilai == '') {
                        continue;
                    }
                
                    if ($data != '') {
                        $data .= '&';
                    }

                    $data .= rawurlencode($nama).'='.rawurlencode($nilai);
                }
                
                
                $hash = hash_hmac('sha256', $data, self::signatureSecretKey, true);
                $signature = base64_encode($hash);
                // dd($sArray);
                
                // $client = new Client();

                // $intArray = array_map(
                //         function ($value) {
                //             return (int)$value;
                //         },
                //         $newkey
                //     );

                // foreach ($intArray as $key => $value) {
                //     $sdasx[] = array(
                //                         '_ts' => $sArray['_ts'],
                //                         'sign' => $signature,
                //                         'session' => $sArray['session'],
                //                         'data['.$key.'].customerNo' => $sArray['data['.$value.'].customerNo'],
                //                         'data['.$key.'].number' => $sArray['data['.$value.'].number'],
                //                         'data['.$key.'].transDate' => $sArray['data['.$value.'].transDate'],
                //                         // 'data['.$key.'].detailItem[0].id' => $sArray['data['.$value.'].detailItem[0].id'],
                //                         'data['.$key.'].detailItem[0].itemNo' => $sArray['data['.$value.'].detailItem[0].itemNo'],
                //                         'data['.$key.'].detailItem[0].unitPrice' => $sArray['data['.$value.'].detailItem[0].unitPrice'],
                //                         'data['.$key.'].detailItem[0].quantity' => $sArray['data['.$value.'].detailItem[0].quantity'],
                //                         'data['.$key.'].detailItem[0].itemUnitName' => $sArray['data['.$value.'].detailItem[0].itemUnitName'],

                //                         // 'data['.$key.'].number',
                //                         // 'data['.$key.'].customerNo',
                //                         // 'data['.$key.'].transDate',
                //                         // 'data['.$key.'].detailItem[0].itemNo',
                //                         // 'data['.$key.'].detailItem[0].unitPrice',
                //                         // 'data['.$key.'].detailItem[0].quantity',
                //                         // 'data['.$key.'].detailItem[0].itemUnitName',
                //                     );
                // }
                // $sArray['sign'] = $signature;
                // dd($sArray);
                // dd($this->FuncOpenmoduleAccurateCloudListBarangJasa($itemNo));die;
                // dd($this->FuncOpenmoduleAccurateCloudAllMasterCustomerList($customerno));die;
                    // dd($sArray);
                // $opts = array('http' =>
                //                         array(
                //                         'method'  => 'POST',
                //                         'header'  => "Authorization: bearer " . self::access_token . "\r\n" ."Content-Type: application/x-www-form-urlencoded\r\n",
                //                         'content' => http_build_query($sArray),
                //                         'ignore_errors' => true,
                //                         )
                //             );

                // $context  = stream_context_create($opts);
                // $response = file_get_contents('https://public.accurate.id/accurate/api/sales-quotation/bulk-save.do', false, $context);
                // return response()->json($response);

                $queue = \GuzzleHttp\Promise\queue();
                $client = new Client();
                    
                $promise = $client->postAsync('https://public.accurate.id/accurate/api/sales-quotation/bulk-save.do',
                    [

                        'headers' => 
                            [
                                'Content-Type' => 'application/x-www-form-urlencoded',
                                'Authorization' =>'bearer'.self::access_token,
                                'X-Session-ID' => $this->FuncAlwaysOnSessionAccurateCluod(),
                                'Accept' => 'application/json'
                            ],

                        'form_params' => $sArray
                            
                    ])->then(
                        function (ResponseInterface $res){

                            $response = json_decode($res->getBody()->getContents());
                    
                            return response()->json($response);
                          
                    },
                        function (RequestException $e) {

                            $response = [];
                            $response[] = $e->getResponse()
                                            ->getBody()
                                            ->getContents();
                        
                            return response()->json($response);

                    }
                );

                $queue->run();
                
                $response = $promise->wait();

    return $response;

                // die;

                // $array_fetch_asort = [
                //         'session' => $this->FuncAlwaysOnSessionAccurateCluod(),
                //         'number' => $number,
                //         'customerNo' => $customerno,
                //         'detailItem[0].itemNo' => $itemNo,
                //         'transDate' => $transDate,
                //         'detailItem[0].unitPrice' => $unitPrice,
                //         'detailItem[0].quantity' => $quantity,
                //         'detailItem[0].itemUnitName' => $ItemUnit,
                //         '_ts' => $this->date
                //     ]
                // ;

                // ksort($array_fetch_asort);
                
                // $api = array_map('trim', $array_fetch_asort);
            
                // $data = '';
                // foreach ( $array_fetch_asort as $nama => $nilai ) {

                //     if ($nilai == '') {

                //         continue;

                //     }
            
                //         if ($data != '') {

                //             $data .= '&';
                            
                //         }

                //     $data .= rawurlencode($nama).'='.rawurlencode($nilai);

                // }
                
                // $hash = hash_hmac('sha256', $data, self::signatureSecretKey , true);

                // $signature = base64_encode($hash);
                // $client = new Client();
                // $response = $client->post(
                //         "https://public.accurate.id/accurate/api/sales-quotation/bulk-save.do",
                //         [
                //             'headers' => [
                //                             'Content-Type' => 'application/x-www-form-urlencoded',
                //                             'Authorization' =>'bearer'.self::access_token,
                //                             'Accept' => 'application/json'
                //                         ],
                //             'form_params' => $sdasx
                //                     // [
                //                     //     'session' => $array_fetch_asort['session'],
                //                     //     'number' => $array_fetch_asort['number'],
                //                     //     'detailItem[0].itemNo' => $array_fetch_asort['detailItem[0].itemNo'],
                //                     //     'customerNo' => $array_fetch_asort['customerNo'],
                //                     //     'transDate' => $array_fetch_asort['transDate'],
                //                     //     'detailItem[0].unitPrice' => $array_fetch_asort['detailItem[0].unitPrice'],
                //                     //     'detailItem[0].quantity' => $array_fetch_asort['detailItem[0].quantity'],
                //                     //     'detailItem[0].itemUnitName' => $array_fetch_asort['detailItem[0].itemUnitName'],
                //                     //     '_ts' => $array_fetch_asort['_ts'],
                //                     //     'sign' => $signature
                //                     // ]
                //         ]
                //     );

                //     $jsonArray = json_decode($response->getBody()->getContents(), true);
                //     dd($jsonArray);die;
                //     $data_array2 = $jsonArray["r"]["number"];

                // return response()->json($data_array2);

            } 
                catch (\GuzzleHttp\Exception\ClientException $e) {
    
                    return $e->getResponse()
                            ->getBody()
                            ->getContents();
                        
        }

    }

    public function FuncOpenmoduleAccurateCloudListSalesQoutation($fields){

        try {

                $array_fetch_asort = [
                        'session' => $this->FuncAlwaysOnSessionAccurateCluod(),
                        'keywords' => $fields,
                        '_ts' => $this->date
                    ]
                ;

                ksort($array_fetch_asort);
                
                $api = array_map('trim', $array_fetch_asort);
            
                $data = '';
                foreach ( $array_fetch_asort as $nama => $nilai ) {

                    if ($nilai == '') {

                        continue;

                    }
            
                        if ($data != '') {

                            $data .= '&';
                            
                        }

                    $data .= rawurlencode($nama).'='.rawurlencode($nilai);

                }
                
                $hash = hash_hmac('sha256', $data, self::signatureSecretKey , true);

                $signature = base64_encode($hash);
                $client = new Client();
                $response = $client->post(
                        self::API_ACCURATE_LIST_SALES_QUOTATION_URL,
                        [
                            'headers' => [
                                            'Content-Type' => 'application/x-www-form-urlencoded',
                                            'Authorization' =>'bearer'.self::access_token,
                                            'Accept' => 'application/json'
                                        ],
                            'form_params' => 
                                    [
                                        'session' => $array_fetch_asort['session'],
                                        'keywords' => $array_fetch_asort['keywords'],
                                        '_ts' => $array_fetch_asort['_ts'],
                                        'sign' => $signature
                                    ]
                        ]
                    );

                    $jsonArray = json_decode($response->getBody()->getContents(), true);

                    $data_array2 = $jsonArray["d"][0]["id"];

                return response()->json($data_array2);

            } 
                catch (\GuzzleHttp\Exception\ClientException $e) {
    
                    return $e->getResponse()
                            ->getBody()
                            ->getContents();
                        
        }

    }

    public function FuncOpenmoduleAccurateCloudListPemasok($fields){

        try {

                $array_fetch_asort = [
                        'session' => $this->FuncAlwaysOnSessionAccurateCluod(),
                        'keywords' => $fields,
                        '_ts' => $this->date
                    ]
                ;

                ksort($array_fetch_asort);
                
                $api = array_map('trim', $array_fetch_asort);
            
                $data = '';
                foreach ( $array_fetch_asort as $nama => $nilai ) {

                    if ($nilai == '') {

                        continue;

                    }
            
                        if ($data != '') {

                            $data .= '&';
                            
                        }

                    $data .= rawurlencode($nama).'='.rawurlencode($nilai);

                }
                
                $hash = hash_hmac('sha256', $data, self::signatureSecretKey , true);

                $signature = base64_encode($hash);
                $client = new Client();
                $response = $client->post(
                        self::API_ACCURATE_LIST_VENDOR_URL,
                        [
                            'headers' => [
                                            'Content-Type' => 'application/x-www-form-urlencoded',
                                            'Authorization' =>'bearer'.self::access_token,
                                            'X-Session-ID' => $this->FuncAlwaysOnSessionAccurateCluod(),
                                            'Accept' => 'application/json'
                                        ],
                            'form_params' => 
                                    [
                                        // 'session' => $array_fetch_asort['session'],
                                        'keywords' => $array_fetch_asort['keywords']
                                        // '_ts' => $array_fetch_asort['_ts'],
                                        // 'sign' => $signature
                                    ]
                        ]
                    );

                    $jsonArray = json_decode($response->getBody()->getContents(), true);

                    $data_array2 = $jsonArray["d"][0]["id"];

                return response()->json($data_array2);

            } 
                catch (\GuzzleHttp\Exception\ClientException $e) {
    
                    return $e->getResponse()
                            ->getBody()
                            ->getContents();
                        
        }

    }

    public function FuncOpenmoduleAccurateCloudListSalesOrders($fields){

        try {

                $array_fetch_asort = [
                        'session' => $this->FuncAlwaysOnSessionAccurateCluod(),
                        'keywords' => $fields,
                        '_ts' => $this->date
                    ]
                ;

                ksort($array_fetch_asort);
                
                $api = array_map('trim', $array_fetch_asort);
            
                $data = '';
                foreach ( $array_fetch_asort as $nama => $nilai ) {

                    if ($nilai == '') {

                        continue;

                    }
            
                        if ($data != '') {

                            $data .= '&';
                            
                        }

                    $data .= rawurlencode($nama).'='.rawurlencode($nilai);

                }
                
                $hash = hash_hmac('sha256', $data, self::signatureSecretKey , true);

                $signature = base64_encode($hash);
                $client = new Client();
                $response = $client->post(
                        self::API_ACCURATE_LIST_SALES_ORDERS_URL,
                        [
                            'headers' => [
                                            'Content-Type' => 'application/x-www-form-urlencoded',
                                            'Authorization' =>'bearer'.self::access_token,
                                            'Accept' => 'application/json'
                                        ],
                            'form_params' => 
                                    [
                                        'session' => $array_fetch_asort['session'],
                                        'keywords' => $array_fetch_asort['keywords'],
                                        '_ts' => $array_fetch_asort['_ts'],
                                        'sign' => $signature
                                    ]
                        ]
                    );

                    $jsonArray = json_decode($response->getBody()->getContents(), true);

                    $data_array2 = $jsonArray["d"][0]["id"];

                return response()->json($data_array2);

            } 
                catch (\GuzzleHttp\Exception\ClientException $e) {
    
                    return $e->getResponse()
                            ->getBody()
                            ->getContents();
                        
        }

    }

    public function FuncOpenmoduleAccurateCloudUpdateSalesQoutation($qty, $id, $datailItemID, $detailPrice, $comments){

        try {

                $array_fetch_asort = [
                        'session' => $this->FuncAlwaysOnSessionAccurateCluod(),
                        'detailItem[0].quantity' => $qty,
                        'detailItem[0].id' => $datailItemID,
                        'detailItem[0].unitPrice' => $detailPrice,
                        'detailItem[0].detailNotes' => $comments,
                        'id' => (String) $id,
                        '_ts' => $this->date
                    ]
                ;
                    // dd($array_fetch_asort);die;
                ksort($array_fetch_asort);
                
                $api = array_map('trim', $array_fetch_asort);
            
                $data = '';
                foreach ( $array_fetch_asort as $nama => $nilai ) {

                    if ($nilai == '') {

                        continue;

                    }
            
                        if ($data != '') {

                            $data .= '&';
                            
                        }

                    $data .= rawurlencode($nama).'='.rawurlencode($nilai);

                }
                
                $hash = hash_hmac('sha256', $data, self::signatureSecretKey , true);

                $signature = base64_encode($hash);
                $client = new Client();
                $response = $client->post(
                        self::API_ACCURATE_SAVE_SALES_QUOTATION_URL,
                        [
                            'headers' => [
                                            'Content-Type' => 'application/x-www-form-urlencoded',
                                            'Authorization' =>'bearer'.self::access_token,
                                            'Accept' => 'application/json'
                                        ],
                            'form_params' => 
                                    [
                                        'session' => $array_fetch_asort['session'],
                                        'id' => $array_fetch_asort['id'],
                                        'detailItem[0].quantity' => $array_fetch_asort['detailItem[0].quantity'],
                                        'detailItem[0].unitPrice' => $array_fetch_asort['detailItem[0].unitPrice'],
                                        'detailItem[0].id' => $array_fetch_asort['detailItem[0].id'],
                                        'detailItem[0].detailNotes' => $array_fetch_asort['detailItem[0].detailNotes'],
                                        '_ts' => $array_fetch_asort['_ts'],
                                        'sign' => $signature
                                    ]
                        ]
                    );

                    $jsonArray = json_decode($response->getBody()->getContents(), true);

                    $data_array2 = $jsonArray;

                return response()->json($data_array2);

            } 
                catch (\GuzzleHttp\Exception\ClientException $e) {
    
                    return $e->getResponse()
                            ->getBody()
                            ->getContents();
                        
        }

    }

    public function FuncOpenmoduleAccurateCloudUpdateSalesOrders($detailNotes, $number, $id, $detailIDItem, $kuantitas, $price){

        try {

                $array_fetch_asort = [
                        'session' => $this->FuncAlwaysOnSessionAccurateCluod(),
                        'poNumber' => $number,
                        'detailItem[0].detailNotes' => $detailNotes,
                        'detailItem[0].id' => $detailIDItem,
                        'detailItem[0].quantity' => $kuantitas,
                        'detailItem[0].unitPrice' => $price,
                        'id' => (String) $id,
                        '_ts' => $this->date
                    ]
                ;
                    // dd($array_fetch_asort);die;
                ksort($array_fetch_asort);
                
                $api = array_map('trim', $array_fetch_asort);
            
                $data = '';
                foreach ( $array_fetch_asort as $nama => $nilai ) {

                    if ($nilai == '') {

                        continue;

                    }
            
                        if ($data != '') {

                            $data .= '&';
                            
                        }

                    $data .= rawurlencode($nama).'='.rawurlencode($nilai);

                }
                
                $hash = hash_hmac('sha256', $data, self::signatureSecretKey , true);

                $signature = base64_encode($hash);
                $client = new Client();
                $response = $client->post(
                        self::API_ACCURATE_SAVE_SALES_ORDERS_URL,
                        [
                            'headers' => [
                                            'Content-Type' => 'application/x-www-form-urlencoded',
                                            'Authorization' =>'bearer'.self::access_token,
                                            'Accept' => 'application/json'
                                        ],
                            'form_params' => 
                                    [
                                        'session' => $array_fetch_asort['session'],
                                        'id' => $array_fetch_asort['id'],
                                        'poNumber' => $array_fetch_asort['poNumber'],
                                        'detailItem[0].id' => $array_fetch_asort['detailItem[0].id'],
                                        'detailItem[0].quantity' => $array_fetch_asort['detailItem[0].quantity'],
                                        'detailItem[0].detailNotes' => $array_fetch_asort['detailItem[0].detailNotes'],
                                        'detailItem[0].unitPrice' => $array_fetch_asort['detailItem[0].unitPrice'],
                                        '_ts' => $array_fetch_asort['_ts'],
                                        'sign' => $signature
                                    ]
                        ]
                    );

                    $jsonArray = json_decode($response->getBody()->getContents(), true);

                    $data_array2 = $jsonArray;

                return response()->json($data_array2);

            } 
                catch (\GuzzleHttp\Exception\ClientException $e) {
    
                    return $e->getResponse()
                            ->getBody()
                            ->getContents();
                        
        }

    }

    public function FuncOpenmoduleAccurateCloudUpdateBarangJasa($id, $minimumQuantity, $Cost){

        try {

                $array_fetch_asort = [
                        'session' => $this->FuncAlwaysOnSessionAccurateCluod(),
                        'detailOpenBalance[0].quantity' => $minimumQuantity === null ? 34550 : $minimumQuantity,
                        'detailOpenBalance[0].unitCost' => (Int)$Cost,
                        'id' => (String) $id,
                        '_ts' => $this->date
                    ]
                ;
                    // dd($array_fetch_asort);die;
                ksort($array_fetch_asort);
                
                $api = array_map('trim', $array_fetch_asort);
            
                $data = '';
                foreach ( $array_fetch_asort as $nama => $nilai ) {

                    if ($nilai == '') {

                        continue;

                    }
            
                        if ($data != '') {

                            $data .= '&';
                            
                        }

                    $data .= rawurlencode($nama).'='.rawurlencode($nilai);

                }
                
                $hash = hash_hmac('sha256', $data, self::signatureSecretKey , true);

                $signature = base64_encode($hash);
                $client = new Client();
                $response = $client->post(
                        self::API_ACCURATE_SAVE_ITEMBARANGJASA_URL,
                        [
                            'headers' => [
                                            'Content-Type' => 'application/x-www-form-urlencoded',
                                            'Authorization' =>'bearer'.self::access_token,
                                            'X-Session-ID' => $this->FuncAlwaysOnSessionAccurateCluod(),
                                            'Accept' => 'application/json'
                                        ],
                            'form_params' => 
                                    [
                                        // 'session' => $array_fetch_asort['session'],
                                        'id' => $array_fetch_asort['id'],
                                        'detailOpenBalance[0].quantity' => $array_fetch_asort['detailOpenBalance[0].quantity'],
                                        'detailOpenBalance[0].unitCost' => $array_fetch_asort['detailOpenBalance[0].unitCost']
                                        // '_ts' => $array_fetch_asort['_ts'],
                                        // 'sign' => $signature
                                    ]
                        ]
                    );

                    $jsonArray = json_decode($response->getBody()->getContents(), true);

                    $data_array2 = $jsonArray;

                return response()->json($data_array2);

            } 
                catch (\GuzzleHttp\Exception\ClientException $e) {
    
                    return $e->getResponse()
                            ->getBody()
                            ->getContents();
                        
        }

    }

    public function FuncOpenmoduleAccurateCloudDetailSalesQoutation($id, $_ts){

        try {

                $array_fetch_asort = [
                        'session' => $this->FuncAlwaysOnSessionAccurateCluod(),
                        'id' => $id,
                        '_ts' => $_ts
                    ]
                ;

                ksort($array_fetch_asort);
                
                $api = array_map('trim', $array_fetch_asort);
            
                $data = '';
                foreach ( $array_fetch_asort as $nama => $nilai ) {

                    if ($nilai == '') {

                        continue;

                    }
            
                        if ($data != '') {

                            $data .= '&';
                            
                        }

                    $data .= rawurlencode($nama).'='.rawurlencode($nilai);

                }
                
                $hash = hash_hmac('sha256', $data, self::signatureSecretKey , true);

                $signature = base64_encode($hash);
                $client = new Client();
                $response = $client->post(
                        self::API_ACCURATE_DETAIL_SALES_QUOTATION_URL,
                        [
                            'headers' => [
                                            'Content-Type' => 'application/x-www-form-urlencoded',
                                            'Authorization' =>'bearer'.self::access_token,
                                            'Accept' => 'application/json'
                                        ],
                            'form_params' => 
                                    [
                                        'session' => $array_fetch_asort['session'],
                                        'id' => $array_fetch_asort['id'],
                                        '_ts' => $array_fetch_asort['_ts'],
                                        'sign' => $signature
                                    ]
                        ]
                    );

                    $jsonArray = json_decode($response->getBody()->getContents(), true);

                    $data_array2 = $jsonArray;

                return response()->json($data_array2);

            } 
                catch (\GuzzleHttp\Exception\ClientException $e) {
    
                    return $e->getResponse()
                            ->getBody()
                            ->getContents();
                        
        }

    }

    public function FuncOpenmoduleAccurateCloudDetailCustomers($id, $_ts){

        try {
            
                $array_fetch_asort = [
                        'session' => $this->FuncAlwaysOnSessionAccurateCluod(),
                        'id' => $id,
                        '_ts' => $_ts
                    ]
                ;

                ksort($array_fetch_asort);
                
                $api = array_map('trim', $array_fetch_asort);
            
                $data = '';
                foreach ( $array_fetch_asort as $nama => $nilai ) {

                    if ($nilai == '') {

                        continue;

                    }
            
                        if ($data != '') {

                            $data .= '&';
                            
                        }

                    $data .= rawurlencode($nama).'='.rawurlencode($nilai);

                }
                
                $hash = hash_hmac('sha256', $data, self::signatureSecretKey , true);

                $signature = base64_encode($hash);
                $client = new Client();
                $response = $client->post(
                        self::API_ACCURATE_DETAIL_CUSTOMER_URL,
                        [
                            'headers' => [
                                            'Content-Type' => 'application/x-www-form-urlencoded',
                                            'Authorization' =>'bearer'.self::access_token,
                                            'X-Session-ID' => $this->FuncAlwaysOnSessionAccurateCluod(), 
                                            'Accept' => 'application/json'
                                        ],
                            'form_params' => 
                                    [
                                        // 'session' => $array_fetch_asort['session'],
                                        'id' => $array_fetch_asort['id']
                                        // '_ts' => $array_fetch_asort['_ts'],
                                        // 'sign' => $signature
                                    ]
                        ]
                    );

                    $jsonArray = json_decode($response->getBody()->getContents(), true);

                    $data_array2 = $jsonArray;

                return response()->json($data_array2);

            } 
                catch (\GuzzleHttp\Exception\ClientException $e) {
    
                    return $e->getResponse()
                            ->getBody()
                            ->getContents();
                        
        }

    }

    public function FuncOpenmoduleAccurateCloudDetailPemasok($id){

        try {

                $array_fetch_asort = [
                        'session' => $this->FuncAlwaysOnSessionAccurateCluod(),
                        'id' => $id,
                        '_ts' => $this->date
                    ]
                ;

                ksort($array_fetch_asort);
                
                $api = array_map('trim', $array_fetch_asort);
            
                $data = '';
                foreach ( $array_fetch_asort as $nama => $nilai ) {

                    if ($nilai == '') {

                        continue;

                    }
            
                        if ($data != '') {

                            $data .= '&';
                            
                        }

                    $data .= rawurlencode($nama).'='.rawurlencode($nilai);

                }
                
                $hash = hash_hmac('sha256', $data, self::signatureSecretKey , true);

                $signature = base64_encode($hash);
                $client = new Client();
                $response = $client->post(
                        self::API_ACCURATE_DETAIL_VENDOR_URL,
                        [
                            'headers' => [
                                            'Content-Type' => 'application/x-www-form-urlencoded',
                                            'Authorization' =>'bearer'.self::access_token,
                                            'X-Session-ID' => $this->FuncAlwaysOnSessionAccurateCluod(),
                                            'Accept' => 'application/json'
                                        ],
                            'form_params' => 
                                    [
                                        // 'session' => $array_fetch_asort['session'],
                                        'id' => $array_fetch_asort['id']
                                        // '_ts' => $array_fetch_asort['_ts'],
                                        // 'sign' => $signature
                                    ]
                        ]
                    );

                    $jsonArray = json_decode($response->getBody()->getContents(), true);

                    $data_array2 = $jsonArray;

                return response()->json($data_array2);

            } 
                catch (\GuzzleHttp\Exception\ClientException $e) {
    
                    return $e->getResponse()
                            ->getBody()
                            ->getContents();
                        
        }

    }

    public function FuncOpenmoduleAccurateCloudDetailSalesOrders($id, $_ts){

        try {

                $array_fetch_asort = [
                        'session' => $this->FuncAlwaysOnSessionAccurateCluod(),
                        'id' => $id,
                        '_ts' => $_ts
                    ]
                ;

                ksort($array_fetch_asort);
                
                $api = array_map('trim', $array_fetch_asort);
            
                $data = '';
                foreach ( $array_fetch_asort as $nama => $nilai ) {

                    if ($nilai == '') {

                        continue;

                    }
            
                        if ($data != '') {

                            $data .= '&';
                            
                        }

                    $data .= rawurlencode($nama).'='.rawurlencode($nilai);

                }
                
                $hash = hash_hmac('sha256', $data, self::signatureSecretKey , true);

                $signature = base64_encode($hash);
                $client = new Client();
                $response = $client->post(
                        self::API_ACCURATE_DETAIL_SALES_ORDERS_URL,
                        [
                            'headers' => [
                                            'Content-Type' => 'application/x-www-form-urlencoded',
                                            'Authorization' =>'bearer'.self::access_token,
                                            'Accept' => 'application/json'
                                        ],
                            'form_params' => 
                                    [
                                        'session' => $array_fetch_asort['session'],
                                        'id' => $array_fetch_asort['id'],
                                        '_ts' => $array_fetch_asort['_ts'],
                                        'sign' => $signature
                                    ]
                        ]
                    );

                    $jsonArray = json_decode($response->getBody()->getContents(), true);

                    $data_array2 = $jsonArray;

                return response()->json($data_array2);

            } 
                catch (\GuzzleHttp\Exception\ClientException $e) {
    
                    return $e->getResponse()
                            ->getBody()
                            ->getContents();
                        
        }

    }

    public function FuncOpenmoduleAccurateCloudDetailBarangJasa($id, $_ts){

        try {

                $array_fetch_asort = [
                        'session' => $this->FuncAlwaysOnSessionAccurateCluod(),
                        'id' => $id,
                    ]
                ;
                
                ksort($array_fetch_asort);
                
                $api = array_map('trim', $array_fetch_asort);
            
                $data = '';
                foreach ( $array_fetch_asort as $nama => $nilai ) {

                    if ($nilai == '') {

                        continue;

                    }
            
                        if ($data != '') {

                            $data .= '&';
                            
                        }

                    $data .= rawurlencode($nama).'='.rawurlencode($nilai);

                }
                
                $hash = hash_hmac('sha256', $data, self::signatureSecretKey , true);

                $signature = base64_encode($hash);
                $client = new Client();
                $response = $client->post(
                        self::API_ACCURATE_DETAIL_ITEM_URL,
                        [
                            'headers' => [
                                            'Content-Type' => 'application/x-www-form-urlencoded',
                                            'Authorization' =>'bearer'.self::access_token,
                                            'X-Session-ID' => $this->FuncAlwaysOnSessionAccurateCluod(),
                                            'Accept' => 'application/json'
                                        ],
                            'form_params' => 
                                    [
                                        // 'session' => $array_fetch_asort['session'],
                                        'id' => $array_fetch_asort['id']
                                        // '_ts' => $array_fetch_asort['_ts'],
                                        // 'sign' => $signature
                                    ]
                        ]
                    );

                    $jsonArray = json_decode($response->getBody()->getContents(), true);

                    $data_array2 = $jsonArray;

                return response()->json($data_array2);

            } 
                catch (\GuzzleHttp\Exception\ClientException $e) {
    
                    return $e->getResponse()
                            ->getBody()
                            ->getContents();
                        
        }

    }

    public function FuncOpenmoduleAccurateCloudSaveSalesOrders($branchId, $branchName, $number, $customerno, $itemNo, $transDate, $harga, $quantity, $transport_id, $detailnotes){
        // public function FuncOpenmoduleAccurateCloudSaveSalesOrders($number, $customerno, $itemNo, $transDate, $SalesQuotationNumber, $harga, $quantity, $transport_id, $detailnotes){

        try {

                // $array_fetch_asort = [
                //         'session' => $this->FuncAlwaysOnSessionAccurateCluod(),
                //         'customerNo' => $customerno,
                //         // 'detailItem[0].itemNo' => $itemNo, //assign array
                //         'data[n].detailItem[n].itemNo' => $itemNo, //assign array
                //         'number' => $number,
                //         'transDate' => $transDate,
                //         'detailItem[0].salesQuotationNumber' => $SalesQuotationNumber,
                //         'data[]detailItem[0].unitPrice' => $harga,
                //         'detailItem[0].quantity' => $quantity,
                //         '_ts' => $this->date
                //     ]
                // ;

                // ksort($array_fetch_asort);   

                $datax = collect([
                    [
                        'customerNo'=> $customerno,
                        'transDate'=> $transDate,
                        'detailNotes'=> $detailnotes,
                        // 'SalesQoutatioNumber'=> $SalesQuotationNumber
                    ]
                ]
            )
        ;

        $fetchBatchItemOrderDetail = $this->batch_item
                    ->with(['transportsIDX','masterItemIDACCURATE'])
                        ->whereIn('transport_id',[$transport_id])
                            ->get();

                foreach ($datax as $key => $value) {
                    $values[$key] = $value;
                        foreach($fetchBatchItemOrderDetail as $keys => $thisdataBatchItemTransports){
                            $transport_id[] = $thisdataBatchItemTransports->transport_id;
                            $detailnotes[$key] = $thisdataBatchItemTransports->detailnotes;
                            $itemTRANSPORT[] = $thisdataBatchItemTransports->masterItemIDACCURATE->itemID_accurate;
                            $itemName[] = $thisdataBatchItemTransports->masterItemIDACCURATE->itemovdesc;
                            $qty[] = $thisdataBatchItemTransports->qty;
                            $hargaID[] = $thisdataBatchItemTransports->harga;
                            $unitName[] = $thisdataBatchItemTransports->masterItemIDACCURATE->unit;
                            
                             /**
                             * @fetch data order id
                             */
                            $mArray[] = [

                                    'session' => $this->FuncAlwaysOnSessionAccurateCluod(),
                                    'data['.(Int)$key.'].branchId' => $branchId,
                                    'data['.(Int)$key.'].branchName' => $branchName,
                                    'data['.(Int)$key.'].number' => $number,
                                    'data['.(Int)$key.'].customerNo' => $values[$key]['customerNo'],
                                    'data['.(Int)$key.'].transDate' => $values[$key]['transDate'],
                                    'data['.(Int)$key.'].description' => implode("\n", $values[$key]['detailNotes']),
                                    // 'detailItem['.(Int)$key.'].salesQuotationNumber' => $SalesQuotationNumber,
                                    'data[0].detailItem['.(Int)$keys.'].itemNo' => $thisdataBatchItemTransports->masterItemIDACCURATE->itemID_accurate,
                                    'data[0].detailItem['.(Int)$keys.'].unitPrice' => $thisdataBatchItemTransports->harga,
                                    'data[0].detailItem['.(Int)$keys.'].quantity' => $thisdataBatchItemTransports->qty,
                                    'data[0].detailItem['.(Int)$keys.'].detailNotes' => $thisdataBatchItemTransports->detailnotes,
                                    '_ts' => $this->date

                            ];
                                /**
                                 * @Bulk key index from mArray
                                 */
                                $arry[] = [

                                    'data['.(int)$key.'].branchId',
                                    'data['.(int)$key.'].branchName',
                                    'data['.(int)$key.'].number',
                                    'data['.(int)$key.'].customerNo',
                                    'data['.(int)$key.'].description',
                                    'data['.(int)$key.'].transDate',
                                    // 'detailItem['.(Int)$key.'].salesQuotationNumber',
                                    'data[0].detailItem['.(Int)$keys.'].itemNo',
                                    'data[0].detailItem['.(Int)$keys.'].unitPrice',
                                    'data[0].detailItem['.(Int)$keys.'].quantity',
                                    'data[0].detailItem['.(Int)$keys.'].detailNotes',
                                    'session',
                                    '_ts'

                            ];
                            
                        }
                    }

                    // dd($mArray);
                    $needles = Arr::flatten($arry);
                    array_walk_recursive($mArray, function ($v, $k) use (&$sArray,$needles) {
                        if (in_array($k, $needles)) {
                            $sArray[$k]=$v;
                        }
                    });
                    ksort($sArray);

                
                $api = array_map('trim', $sArray);
            
                $data = '';
                foreach ( $api as $nama => $nilai ) {

                    if ($nilai == '') {

                        continue;

                    }
            
                        if ($data != '') {

                            $data .= '&';
                            
                        }

                    $data .= rawurlencode($nama).'='.rawurlencode($nilai);

                }
                
                $hash = hash_hmac('sha256', $data, self::signatureSecretKey , true);

                $signature = base64_encode($hash);

                // $client = new Client();
                // $response = $client->post(
                //         self::API_ACCURATE_SAVE_BULK_SALES_ORDER_URL,
                //         [
                //             'headers' => [
                //                             'Content-Type' => 'application/x-www-form-urlencoded',
                //                             'Authorization' =>'bearer'.self::access_token,
                //                             'Accept' => 'application/json'
                //                         ],
                //             'form_params' => 
                //                     [
                //                         'session' => $array_fetch_asort['session'],
                //                         'detailItem[0].itemNo' => $array_fetch_asort['detailItem[0].itemNo'],
                //                         'customerNo' => $array_fetch_asort['customerNo'],
                //                         'number' => $array_fetch_asort['number'],
                //                         'transDate' => $array_fetch_asort['transDate'],
                //                         'detailItem[0].salesQuotationNumber' => $array_fetch_asort['detailItem[0].salesQuotationNumber'],
                //                         'detailItem[0].unitPrice' => $array_fetch_asort['detailItem[0].unitPrice'],
                //                         'detailItem[0].quantity' => $array_fetch_asort['detailItem[0].quantity'],
                //                         '_ts' => $array_fetch_asort['_ts'],
                //                         'sign' => $signature
                //                     ]
                //         ]
                //     );

                //     $jsonArray = json_decode($response->getBody()->getContents(), true);

                //     $data_array2 = $jsonArray["r"]["number"];
                    
                // return response()->json($data_array2);

                // $sArray['sign'] = $signature;

                // dd($sArray);die;
                // $opts = array('http' =>
                //                 array(
                //                         'method'  => 'POST',
                //                         'header'  => "Authorization: bearer " . self::access_token . "\r\n" ."Content-Type: application/x-www-form-urlencoded\r\n",
                //                         'content' => http_build_query($sArray),
                //                         'ignore_errors' => true,
                //                 )
                //             );

                // $context  = stream_context_create($opts);

                // $response = file_get_contents(self::API_ACCURATE_SAVE_BULK_SALES_ORDER_URL, false, $context);

                // return response()->json($response);

                $queue = \GuzzleHttp\Promise\queue();
                
                    $client = new Client();
                        
                    $promise = $client->postAsync(self::API_ACCURATE_SAVE_BULK_SALES_ORDER_URL,
                        [

                            'headers' => 
                                [
                                    'Content-Type' => 'application/x-www-form-urlencoded',
                                    'Authorization' =>'bearer'.self::access_token,
                                    'X-Session-ID' => $this->FuncAlwaysOnSessionAccurateCluod(),
                                    'Accept' => 'application/json'
                                ],

                            'form_params' => $sArray
                                
                                ])->then(
                                    function (ResponseInterface $res){

                                        $response = json_decode($res->getBody()->getContents());
                                
                                        return response()->json($response);
                                    
                                },
                                    function (RequestException $e) {

                                        $response = [];
                                        $response[] = $e->getResponse()
                                                        ->getBody()
                                                        ->getContents();
                                    
                                    return response()->json($response);

                                }

                        );

                        $queue->run();
                        $response = $promise->wait();

                return $response;
            } 
                catch (\GuzzleHttp\Exception\ClientException $e) {
    
                    return $e->getResponse()
                            ->getBody()
                            ->getContents();
                        
        }

    }

    public function FuncOpenmoduleAccurateCloudSaveDeliveryOrders(
            $number,
            $customerno,
            $transDate, 
            $itemNo,
            $SalesQuotationNumber,
            $SalesOrdernumber,
            $itemUnit,
            $quantity,
            $price,
            $transport_id,
            $detailNotes
    )
        {

         try {

                // $array_fetch_asort = [
                //         'session' => $this->FuncAlwaysOnSessionAccurateCluod(),
                //         'number' => $number,
                //         'customerNo' => $customerno,
                //         'detailItem[0].itemNo' => $itemNo,
                //         'transDate' => $transDate,
                //         'detailItem[0].salesQuotationNumber' => $SalesQuotationNumber,
                //         'detailItem[0].salesOrderNumber' => $SalesOrdernumber,
                //         'detailItem[0].itemUnitName' => $itemUnit,
                //         'detailItem[0].quantity' => $quantity,
                //         'detailItem[0].unitPrice' => $price,
                //         '_ts' => $this->date
                //     ]
                // ;

                $datax = collect([
                            [
                                'number'=> $number,
                                'customerNo'=> $customerno,
                                'SalesQuotationNumber'=> $SalesQuotationNumber,
                                'SalesOrdernumber'=> $SalesOrdernumber,
                                'transDate'=> $transDate,
                                'itemNo'=> (array)$itemNo,
                                'detailNotes'=> (array)$detailNotes,
                                'unitPrice'=> (array)$price,
                                'quantity'=> (array)$quantity,
                                'itemUnitName'=> (array)$itemUnit
                            ]
                        ]
                    )
                ;

                $fetchBatchItemOrderDetail = $this->batch_item
                ->with(['transportsIDX','masterItemIDACCURATE'])
                    ->whereIn('transport_id',[$transport_id])
                        ->get();

                foreach ($datax as $key => $value) {
                    $values[$key] = $value;
                        foreach($fetchBatchItemOrderDetail as $keys => $thisdataBatchItemTransports){
                            $mArray[] = [
                                            'session' => $this->FuncAlwaysOnSessionAccurateCluod(),
                                            'data['.(Int)$key.'].number' => $values[$key]['number'],
                                            'data['.(Int)$key.'].customerNo' => $values[$key]['customerNo'],
                                            'data['.(Int)$key.'].transDate' => $values[$key]['transDate'],
                                            'data['.(Int)$key.'].SalesQuotationNumber' => $values[$key]['SalesQuotationNumber'],
                                            'data['.(Int)$key.'].SalesOrdernumber' => $values[$key]['SalesOrdernumber'],
                                            'data['.(Int)$key.'].description' => implode("\n", $values[$key]['detailNotes']),
                                            'data[0].detailItem['.(Int)$keys.'].itemNo' => $thisdataBatchItemTransports->masterItemIDACCURATE->itemID_accurate,
                                            'data[0].detailItem['.(Int)$keys.'].unitPrice' => $thisdataBatchItemTransports->harga,
                                            'data[0].detailItem['.(Int)$keys.'].quantity' => $thisdataBatchItemTransports->qty,
                                            'data[0].detailItem['.(Int)$keys.'].detailNotes' => $thisdataBatchItemTransports->detailnotes,
                                            'data[0].detailItem['.(Int)$keys.'].itemUnitName' => $thisdataBatchItemTransports->masterItemIDACCURATE->unit,
                                            '_ts' => $this->date
                                        ];

                            $arry[] = [
                                            'data['.(int)$key.'].number',
                                            'data['.(int)$key.'].customerNo',
                                            'data['.(int)$key.'].transDate',
                                            'data['.(Int)$key.'].SalesQuotationNumber',
                                            'data['.(Int)$key.'].SalesOrdernumber',
                                            'data['.(Int)$key.'].description',
                                            'data[0].detailItem['.(Int)$keys.'].itemNo',
                                            'data[0].detailItem['.(Int)$keys.'].unitPrice',
                                            'data[0].detailItem['.(Int)$keys.'].quantity',
                                            'data[0].detailItem['.(Int)$keys.'].itemUnitName',
                                            'data[0].detailItem['.(Int)$keys.'].detailNotes',
                                            'session',
                                            '_ts',
                                        ];
                            
                        }
                }

                // dd($mArray);
                $needles = Arr::flatten($arry);
                array_walk_recursive($mArray, function ($v, $k) use (&$sArray,$needles) {
                    if (in_array($k, $needles)) {
                        $sArray[$k]=$v;
                    }
                });

                ksort($sArray);
                
                $api = array_map('trim', $sArray);
            
                $data = '';
                foreach ( $api as $nama => $nilai ) {

                    if ($nilai == '') {

                        continue;

                    }
            
                        if ($data != '') {

                            $data .= '&';
                            
                        }

                    $data .= rawurlencode($nama).'='.rawurlencode($nilai);

                }
                
                $hash = hash_hmac('sha256', $data, self::signatureSecretKey , true);

                $signature = base64_encode($hash);
                $sArray['sign'] = $signature;
                // dd($sArray);
                // $client = new Client();
                // $response = $client->post(
                //         self::API_ACCURATE_SAVE_DELIVERY_BULK_ORDERS_URL,
                //         [
                //             'headers' => [
                //                             'Content-Type' => 'application/x-www-form-urlencoded',
                //                             'Authorization' =>'bearer'.self::access_token,
                //                             'Accept' => 'application/json'
                //                         ],
                //             'form_params' => 
                //                     [
                //                         'session' => $array_fetch_asort['session'],
                //                         'detailItem[0].itemNo' => $array_fetch_asort['detailItem[0].itemNo'],
                //                         'customerNo' => $array_fetch_asort['customerNo'],
                //                         'number' => $array_fetch_asort['number'],
                //                         'transDate' => $array_fetch_asort['transDate'],
                //                         'detailItem[0].salesQuotationNumber' => $array_fetch_asort['detailItem[0].salesQuotationNumber'],
                //                         'detailItem[0].salesOrderNumber' => $array_fetch_asort['detailItem[0].salesOrderNumber'],
                //                         'detailItem[0].itemUnitName' => $array_fetch_asort['detailItem[0].itemUnitName'],
                //                         'detailItem[0].quantity' => $array_fetch_asort['detailItem[0].quantity'],
                //                         'detailItem[0].unitPrice' => $array_fetch_asort['detailItem[0].unitPrice'],
                //                         '_ts' => $array_fetch_asort['_ts'],
                //                         'sign' => $signature
                //                     ]
                //         ]
                //     );

                //     $jsonArray = json_decode($response->getBody()->getContents(), true);
                
                //     $data_array2 = $jsonArray["r"]["number"];

                // return response()->json($data_array2);

                $queue = \GuzzleHttp\Promise\queue();

                $client = new Client();
                    
                    $promise = $client->postAsync(self::API_ACCURATE_SAVE_DELIVERY_BULK_ORDERS_URL,
                        [

                            'headers' => 
                                [
                                    'Content-Type' => 'application/x-www-form-urlencoded',
                                    'Authorization' =>'bearer'.self::access_token,
                                    'Accept' => 'application/json'
                                ],

                            'form_params' => $sArray
                                
                        ])->then(
                                    function (ResponseInterface $res){

                                        $response = json_decode($res->getBody()->getContents());
                                
                                    return response()->json($response);
                                    
                                },
                                    function (RequestException $e) {

                                        $response = [];

                                        $response[] = $e->getResponse()
                                                            ->getBody()
                                                                 ->getContents();
                                    
                                    return response()->json($response);

                                }
                            );

                        $queue->run();
                            
                    $response = $promise->wait();

                return $response;

            } 
                catch (\GuzzleHttp\Exception\ClientException $e) {
    
                    return $e->getResponse()
                            ->getBody()
                            ->getContents();
                        
        }

    }

    public function FuncOpenmoduleAccurateCloudSaveSalesInvoice($customerno, 
                        $itemNo,
                        $OrderDownPaymentNumber,
                        $reverseInvoice,
                        $taxDate,
                        $taxNumber,
                        $transDate,
                        $SO,
                        $SQ,
                        $DO,
                        $price,
                        $quantity,
                        $itemUnitName
                    )
     
        {

            try {

                $array_fetch_asort = [
                        'session' => $this->FuncAlwaysOnSessionAccurateCluod(),
                        'customerNo' => $customerno,
                        'detailItem[0].itemNo' => $itemNo,
                        'orderDownPaymentNumber' => $OrderDownPaymentNumber,
                        'reverseInvoice' => $reverseInvoice,
                        'taxDate' => $taxDate,
                        'taxNumber' => $taxNumber,
                        'transDate' => $transDate,
                        'detailItem[0].salesOrderNumber' => $SO,
                        'detailItem[0].salesQuotationNumber' => $SQ,
                        'detailItem[0].deliveryOrderNumber' => $DO,
                        'detailItem[0].unitPrice' => $price,
                        'detailItem[0].quantity' => $quantity,
                        'detailItem[0].itemUnitName' => $itemUnitName,
                        '_ts' => $this->date
                    ]
                ;

                ksort($array_fetch_asort);
                
                $api = array_map('trim', $array_fetch_asort);
            
                $data = '';
                foreach ( $array_fetch_asort as $nama => $nilai ) {

                    if ($nilai == '') {

                        continue;

                    }
            
                        if ($data != '') {

                            $data .= '&';
                            
                        }

                    $data .= rawurlencode($nama).'='.rawurlencode($nilai);

                }
                
                $hash = hash_hmac('sha256', $data, self::signatureSecretKey , true);

                $signature = base64_encode($hash);
                $client = new Client();
                $response = $client->post(
                        self::API_ACCURATE_SAVE_SALES_INVOICE_URL,
                        [
                            'headers' => [
                                            'Content-Type' => 'application/x-www-form-urlencoded',
                                            'Authorization' =>'bearer'.self::access_token,
                                            'Accept' => 'application/json'
                                        ],
                            'form_params' => 
                                    [
                                        'session' => $array_fetch_asort['session'],
                                        'detailItem[0].itemNo' => $array_fetch_asort['detailItem[0].itemNo'],
                                        'detailItem[0].salesOrderNumber' => $array_fetch_asort['detailItem[0].salesOrderNumber'],
                                        'detailItem[0].salesQuotationNumber' => $array_fetch_asort['detailItem[0].salesQuotationNumber'],
                                        'detailItem[0].deliveryOrderNumber' => $array_fetch_asort['detailItem[0].deliveryOrderNumber'],
                                        'detailItem[0].unitPrice' => $array_fetch_asort['detailItem[0].unitPrice'],
                                        'detailItem[0].quantity' => $array_fetch_asort['detailItem[0].quantity'],
                                        'detailItem[0].itemUnitName' => $array_fetch_asort['detailItem[0].itemUnitName'],
                                        'customerNo' => $array_fetch_asort['customerNo'],
                                        'orderDownPaymentNumber' => $array_fetch_asort['orderDownPaymentNumber'],
                                        'reverseInvoice' => $array_fetch_asort['reverseInvoice'],
                                        'taxDate' => $array_fetch_asort['taxDate'],
                                        'taxNumber' => $array_fetch_asort['taxNumber'],
                                        'transDate' => $array_fetch_asort['transDate'],
                                        '_ts' => $array_fetch_asort['_ts'],
                                        'sign' => $signature
                                    ]
                        ]
                    );

                    $jsonArray = json_decode($response->getBody()->getContents(), true);
                    
                    $data_array2 = $jsonArray["r"]["number"];

                return response()->json($data_array2);

            } 
                catch (\GuzzleHttp\Exception\ClientException $e) {
    
                    return $e->getResponse()
                            ->getBody()
                            ->getContents();
                        
        }

    }
    
    public function FuncOpenmoduleAccurateCloudAllMasterCustomerList($fields)
    {
        
        try 
            {

                $array_fetch_asort = [
                        'session' => $this->FuncAlwaysOnSessionAccurateCluod(),
                        'keywords' => $fields,
                        '_ts' => $this->date
                    ]
                ;
                    
                    ksort($array_fetch_asort);
                
                        $api = array_map('trim', $array_fetch_asort);
            
                $data = '';

                foreach ( $array_fetch_asort as $nama => $nilai ) {

                    if ($nilai == '') {

                        continue;

                    }
            
                        if ($data != '') {

                            $data .= '&';
                            
                        }

                    $data .= rawurlencode($nama).'='.rawurlencode($nilai);

                }
                
                $hash = hash_hmac('sha256', $data, self::signatureSecretKey , true );

                $signature = base64_encode($hash);

                    $client = new Client();
                    
                        $response = $client->post(
                                self::API_ACCURATE_CUSTOMER_LIST_URL,
                                [
                                    'headers' => [
                                                    'Content-Type' => 'application/x-www-form-urlencoded',
                                                    'Authorization' =>'bearer'.self::access_token,
                                                    'X-Session-ID' => $this->FuncAlwaysOnSessionAccurateCluod(),
                                                    'Accept' => 'application/json'
                                                ],
                                    'form_params' => 
                                    [
                                        // 'session' => $array_fetch_asort['session'],
                                        'keywords' => $array_fetch_asort['keywords']
                                        // '_ts' => $array_fetch_asort['_ts'],
                                        // 'sign' => $signature
                                    ]
                                ]
                            );

                    $jsonArray = json_decode($response->getBody()->getContents(), true);

                return response()->json($jsonArray);

        } 
            catch (\GuzzleHttp\Exception\ClientException $e) {
    
                return $e->getResponse()
                        ->getBody()
                        ->getContents();
                    
        }
        
    }

    public function FuncOpenmoduleAccurateCloudListBarangJasa($fields){
        
        try {
            
            $array_fetch_asort = [
                    'session' => $this->FuncAlwaysOnSessionAccurateCluod(),
                    'keywords' => $fields,
                    '_ts' => $this->date
                ]
            ;
                    ksort($array_fetch_asort);
                
                        $api = array_map('trim', $array_fetch_asort);
            
                $data = '';

                foreach ( $array_fetch_asort as $nama => $nilai ) {

                    if ($nilai == '') {

                        continue;

                    }
            
                        if ($data != '') {

                            $data .= '&';
                            
                        }

                    $data .= rawurlencode($nama).'='.rawurlencode($nilai);

                }
                
                $hash = hash_hmac('sha256', $data, self::signatureSecretKey , true );

                $signature = base64_encode($hash);

                    $client = new Client();
                    $queue = \GuzzleHttp\Promise\queue();
                    
                            $promise = $client->postAsync(self::API_ACCURATE_LIST_BARANGJASA_URL,
                                [

                                    'headers' => 
                                        [
                                            'Content-Type' => 'application/x-www-form-urlencoded',
                                            'Authorization' =>'bearer'.self::access_token,
                                            'X-Session-ID' => $this->FuncAlwaysOnSessionAccurateCluod(),
                                            'Accept' => 'application/json'
                                        ],

                                    'form_params' => 
                                        [
                                            // 'session' => $array_fetch_asort['session'],
                                            'keywords' => $array_fetch_asort['keywords']
                                            // '_ts' => $array_fetch_asort['_ts'],
                                            // 'sign' => $signature
                                        ]
                                        
                                ])->then(
                                    function (ResponseInterface $res){

                                        $response = json_decode($res->getBody()->getContents());
                                
                                        return response()->json($response);
                                      
                                },
                                    function (RequestException $e) {

                                        $response = [];
                                        $response[] = $e->getResponse()
                                                        ->getBody()
                                                        ->getContents();
                                    
                                        return response()->json($response);

                                }
                            );

                            $queue->run();
                            
                            $response = $promise->wait();

                // dd($response);
                return $response;

        } 
            catch (\GuzzleHttp\Exception\ClientException $e) {
    
                return $e->getResponse()
                        ->getBody()
                        ->getContents();
                    
        }
        
    }

    public function FuncOpenmoduleAccurateCloudfindMasterCustomerID($session, $id, $_ts)
    {
        
        try 
            {

                $array_fetch_asort = [
                        'session' => $this->FuncAlwaysOnSessionAccurateCluod(),
                        'id' => $id,
                        '_ts' => $_ts
                    ]
                ;
                    
                    ksort($array_fetch_asort);
                
                        $api = array_map('trim', $array_fetch_asort);
            
                $data = '';

                foreach ( $array_fetch_asort as $nama => $nilai ) {

                    if ($nilai == '') {

                        continue;

                    }
            
                        if ($data != '') {

                            $data .= '&';
                            
                        }

                    $data .= rawurlencode($nama).'='.rawurlencode($nilai);

                }
                
                $hash = hash_hmac('sha256', $data, self::signatureSecretKey , true );

                $signature = base64_encode($hash);

                    $client = new Client();
                    
                        $response = $client->post(
                                self::API_ACCURATE_FIND_MASTER_CUSTOMER_ID_URL,
                                [
                                    'headers' => [
                                                    'Content-Type' => 'application/x-www-form-urlencoded',
                                                    'Authorization' =>'bearer'.self::access_token,
                                                    'Accept' => 'application/json'
                                                ],
                                    'form_params' => 
                                    [
                                        'session' => $array_fetch_asort['session'],
                                        'id' => $array_fetch_asort['id'],
                                        '_ts' => $array_fetch_asort['_ts'],
                                        'sign' => $signature
                                    ]
                                ]
                            );

                    $jsonArray = json_decode($response->getBody()->getContents(), true);

                return response()->json($jsonArray);

        } 
            catch (\GuzzleHttp\Exception\ClientException $e) {
    
                return $e->getResponse()
                        ->getBody()
                        ->getContents();
                    
        }
        
    }

    public function FuncAlwaysOnSessionAccurateCluod(){

        return self::LiveAlwaysSessionAccurateCloud();

    }

    protected function LiveAlwaysSessionAccurateCloud(): String
    {
            if($this->funcModulesSessionAlwaysOn() == true):

                return self::sessionCloud;

                else:

                    return $this->FuncOpenmoduleAccurateCloudSession();

            endif;

    }

    public function FuncModulesSessionAlwaysOn()
    {
        
        try 
            {

                $array_fetch_asort = [
                        'session' => self::sessionCloud,
                        '_ts' => $this->date
                    ]
                ;
                    
                    ksort($array_fetch_asort);
                
                        $api = array_map('trim', $array_fetch_asort);
            
                $data = '';

                foreach ( $array_fetch_asort as $nama => $nilai ) {

                    if ($nilai == '') {

                        continue;

                    }
            
                        if ($data != '') {

                            $data .= '&';
                            
                        }

                    $data .= rawurlencode($nama).'='.rawurlencode($nilai);

                }
                
                $hash = hash_hmac('sha256', $data, self::signatureSecretKey , true );

                $signature = base64_encode($hash);

                    $client = new Client();
                    
                        $response = $client->get(
                                self::API_ACCURATE_CHECK_DB_SESSION_URL,
                                [
                                    'headers' => [
                                                    'Content-Type' => 'application/x-www-form-urlencoded',
                                                    'Authorization' =>'bearer'.self::access_token,
                                                    'Accept' => 'application/json'
                                                ],
                                    'form_params' => 
                                    [
                                        'session' => $array_fetch_asort['session'],
                                        '_ts' => $array_fetch_asort['_ts'],
                                        'sign' => $signature
                                    ]
                                ]
                            );

                    $jsonArray = json_decode($response->getBody()->getContents(), true);

                return $jsonArray["d"];


        } 
            catch (\GuzzleHttp\Exception\ClientException $e) {
    
                return $e->getResponse()
                        ->getBody()
                        ->getContents();
                    
        }
        
    }

    public function FuncModuleReceivedWebhook(Request $req)
    {
        
        try 
            {
                // $array_fetch_asort = [
                //         'id' => self::DBINDEXACCURATE__,
                //         'session' => $this->FuncAlwaysOnSessionAccurateCluod(),
                //         '_ts' => $this->date
                //     ]
                // ;
                //     ksort($array_fetch_asort);
                
                //         $api = array_map('trim', $array_fetch_asort);
            
                // $data = '';

                // foreach ( $array_fetch_asort as $nama => $nilai ) {

                //     if ($nilai == '') {

                //         continue;

                //     }
            
                //         if ($data != '') {

                //             $data .= '&';
                            
                //         }

                //     $data .= rawurlencode($nama).'='.rawurlencode($nilai);

                // }
                
                // $hash = hash_hmac('sha256', $data, self::signatureSecretKey , true );

                // $signature = base64_encode($hash);

                        
                    // $jsonArray = json_decode($client->getBody()->getContents(), true);
                    // $json = $promise;

                    // return response()->json($json);
                    // $client = new Client();
                    
                    // $request_body = file_get_contents('php://input');
                    // $json = json_decode($request_body, 1);
                    //  $headers = $this->requests->headers->all();
                    // return response()->json($request_body);


                //     if($json = json_decode(file_get_contents("php://input"), true)) {
                //         // print_r($json);
                //         $data = $json;
                //     } else {
                //         // print_r($req);
                //         $data = $req;
                //     }
                   
                // //    echo "Saving data ...\n";
                //    $url = 'http://your-api.co.id/webhooks';
                   
                //    $meta = ["received" => time(),
                //        "status" => "new",
                //        "agent" => $req->header('User-Agent')];
                   
                //    $options = ["http" => [
                //        "method" => "POST",
                //        "header" => ["Content-Type: application/json"],
                //        "content" => json_encode(["data" => $data, "meta" => $meta])]
                //        ];
                   
                //    $context = stream_context_create($options);
                //   $response = file_get_contents($url, false, $context);
                //   dd($req->all());

                    // $client->postAsync('http://webhook.site/961a995e-1ca6-464d-85e6-f9930bf402f5')->then(
                      
                    // );
                    // $promise1 = $client->request('POST', 'http://webhook.site/961a995e-1ca6-464d-85e6-f9930bf402f5', [
                    //     'curl' => [
                    //         CURLOPT_INTERFACE => '103.120.233.10'
                    //     ]
                    // ]);
                    
                  
                    // $response = $client->request('POST', $url,  ['headers' => [
                    //     'Content-Type' => 'application/json',
                    //     'x-forwarded-for' =>'103.120.233.10',
                    //     'user-agent' => 'Java/1.8.0_222',
                    //     'Accept' => 'text/html, image/gif, image/jpeg, *; q=.2, */*; q=.2'
                    // ]]);
                    // curl_init($url);
                    // curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept:application/json, Content-Type:application/json']);
                    // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                    // $statusCode = $response->getStatusCode();
                    // $content = $response->getBody();
                    //    return response()->json($response);
                    // $jsonArray = $client->post('http://webhook.site/961a995e-1ca6-464d-85e6-f9930bf402f5')->getBody();
                    // $promise1->then(function ($response) {
                    //     echo 'Got a response! ' . $response->getStatusCode();
                    // });
                    // $promise1->wait();
                    // $results = Promise\settle($promises)->wait();
                    // return response()->json($results);
                //     $promise = $client->postAsync('webhook');
                //     $promises = (function () use($client) {
                //         yield $client->postAsync('http://your-api.co.id/webhook');		
                //     })();
                //     $eachPromise = new EachPromise($promises, [
                //       'fulfilled' => function (Response $response) {
                //         if ($response->getStatusCode() == 200) {
                //           $user = json_decode($response->getBody(), true);
                //             return response()->json($user);

                //           }
                //         },
                //       'rejected' => function ($reason) {
                //         return response()->json(['dasdasd'=>$reason]);


                //       }
                //     ]);

                //    $sdas = $eachPromise->promise()->wait();
                    // echo $jsonArray;

        } 
            catch (\GuzzleHttp\Exception\ClientException $e) {
    
                return $e->getResponse()
                        ->getBody()
                        ->getContents();
                    
        }
        
    }

    public function FuncOpenmoduleAccurateCloudUpdateBarangJasaCustomers($id, $minimumQuantity, $Cost, $name){

        try {

                $array_fetch_asort = [
                        'session' => $this->FuncAlwaysOnSessionAccurateCluod(),
                        'detailOpenBalance[0].quantity' => $minimumQuantity === null ? 34550 : $minimumQuantity,
                        'detailOpenBalance[0].unitCost' => (Int)$Cost,
                        'name' => $name,
                        'id' => $id,
                        '_ts' => $this->date
                    ]
                ;
                    // dd($array_fetch_asort);die;
                // ksort($array_fetch_asort);
                
                // $api = array_map('trim', $array_fetch_asort);
            
                // $data = '';
                // foreach ( $array_fetch_asort as $nama => $nilai ) {

                //     if ($nilai == '') {

                //         continue;

                //     }
            
                //         if ($data != '') {

                //             $data .= '&';
                            
                //         }

                //     $data .= rawurlencode($nama).'='.rawurlencode($nilai);

                // }
                
                // $hash = hash_hmac('sha256', $data, self::signatureSecretKey , true);

                // $signature = base64_encode($hash);
                $client = new Client();
                $response = $client->post(
                        self::API_ACCURATE_SAVE_ITEMBARANGJASA_URL,
                        [
                            'headers' => [
                                            'Content-Type' => 'application/x-www-form-urlencoded',
                                            'Authorization' =>'bearer'.self::access_token,
                                            'X-Session-ID' => $this->FuncAlwaysOnSessionAccurateCluod(),
                                            'Accept' => 'application/json'
                                        ],
                            'form_params' => 
                                    [
                                        // 'session' => $array_fetch_asort['session'],
                                        'id' => $array_fetch_asort['id'],
                                        'name' => $array_fetch_asort['name'],
                                        'detailOpenBalance[0].quantity' => $array_fetch_asort['detailOpenBalance[0].quantity'],
                                        'detailOpenBalance[0].unitCost' => $array_fetch_asort['detailOpenBalance[0].unitCost']
                                        // '_ts' => $array_fetch_asort['_ts'],
                                        // 'sign' => $signature
                                    ]
                        ]
                    );

                    $jsonArray = json_decode($response->getBody()->getContents(), true);

                    $data_array2 = $jsonArray;

                return response()->json($data_array2);

            } 
                catch (\GuzzleHttp\Exception\ClientException $e) {
    
                    return $e->getResponse()
                            ->getBody()
                            ->getContents();
                        
        }

    }

}