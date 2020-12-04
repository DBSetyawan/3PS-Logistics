<?php
namespace warehouse\Http\Controllers\geolocationservices;

use Closure;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use GuzzleHttp\HandlerStack;
use Illuminate\Http\Request;
use React\EventLoop\Factory;
use GuzzleHttp\Psr7\Response;
use Geocoder\StatefulGeocoder;
use OpenCage\Geocoder\Geocoder;
use Geocoder\Query\GeocodeQuery;
use Geocoder\Query\ReverseQuery;
use warehouse\Models\Transport_orders;
use GuzzleHttp\Promise\RejectedPromise;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Handler\CurlMultiHandler;
use Illuminate\Database\Eloquent\Builder;
use GuzzleHttp\Exception\RequestException;
use warehouse\Http\Controllers\Controller;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
use warehouse\Http\Controllers\TestGenerator\CallSignature;
use warehouse\Http\Controllers\Helper\BulkSaveAccurateCloud;
use warehouse\Models\Order_transport_history as TrackShipments;

class GeolocationServiceCTR extends Controller
{
    use CallSignature;
    /**
     * Display a listing of the resource. refs : https://github.com/geocoder-php/Geocoderf
     * for testing API geolocation https://opencagedata.com/
     * @return \Illuminate\Http\Response
     */
    private $TrackShipments;
    private $bs;
    private $tcs;

    public function __construct(TrackShipments $tr, Transport_orders $tcs, BulkSaveAccurateCloud $bs){
        $this->TrackShipments = $tr;
        $this->bs = $bs;
        $this->tcs = $tcs;
    }

    public function index($shipment)
    {
        return self::geocoding($shipment);
    }

    public function address(Transport_orders $orders, $code){
      
        $data = $orders->with('cek_status_transaction','city_origin','city_destination','address')
                        ->where('id','=', $code)
                        ->first();
        
        return response()->json($data);

    }
    
    public function detailHistory(Transport_orders $orders, $code, TrackShipments $history){

            $data = $orders->with('cek_status_transaction','city_origin','city_destination','address')->
                    when($code, function ($selfQuery) use ($code, $history){
                        return $history->with('statusHistoryName')->whereIn('order_id', [$code]);
                        return $selfQuery->whereIn('order_id',[$code]);
                    }   
                )->get()
            ;

        return response()->json($data);

    }
    
    private function geocoding($shipment){

        /**
         * Ref: https://www.php.net/manual/en/closure.bind.php |
         * issues : https://github.com/guzzle/guzzle/issues/2070 | 
         * guzzdoc GuzzleHttp\Psr7 : http://docs.guzzlephp.org/en/stable/psr7.html
         */
        $loop = Factory::create();

        $handler = new CurlMultiHandler();
        $timer = $loop->addPeriodicTimer(0, \Closure::bind(function () use (&   $timer) {
                $this->tick();
                if (empty($this->handles) && \GuzzleHttp\Promise\queue()->isEmpty()) {
                    $timer->cancel();
                }
            }, $handler, $handler)
        );

            $client = new Client(['auth' => ['samsunguser', 'asdf123'], 'handler' => HandlerStack::create($handler)]);
            $promisesList[] = $client->getAsync('http://api.trial.izzytransport.com/customer/v1/shipment',
                    [  'headers' => [
                            'X-IzzyTransport-Token' => 'ab567919190b1b8df2b089c02e0eb3321124cf6f.1575862464',
                            'Accept' => 'application/json'],
                            'query' => ['code' => $shipment]
                    ]
                )->then(
                    function (Response $response) {

                        // $jsonArray = json_decode($resp->getBody()->getContents(), true);
                        // echo 'Response: '.$status->getBody();
                        // $jsonArray = json_decode($resp->getBody()->getContents(), true);
                        $data = $response->getBody()->getContents();
                        // $body = $resp->getBody()->getContents();
                        // // Implicitly cast the body to a string and echo it
                        // echo $body;
                        // // Explicitly cast the body to a string
                        // $stringBody = (array) $body;
                        // // Read 10 bytes from the body
                        // $tenBytes = $body->read(10);
                        // // Read the remaining contents of the body as a string
                        // $remainingBytes = $body->getContents();
                        return response()->json($data);
                    },
                    function (\Exception $response) {
                        // return response($promise);
                        $data = $response;
                        // $body = $resp->getBody()->getContents();
                        // // Implicitly cast the body to a string and echo it
                        // echo $body;
                        // // Explicitly cast the body to a string
                        // $stringBody = (array) $body;
                        // // Read 10 bytes from the body
                        // $tenBytes = $body->read(10);
                        // // Read the remaining contents of the body as a string
                        // $remainingBytes = $body->getContents();
                        return response()->json($data);
                        
                        // return response($e->getMessage().$e->getRequest()->getMethod());
                    }
            );

            $loop->run();
            // dd("success");
            $results = Promise\settle($promisesList)->wait(true);
            // dd($results);
            // $queue = \GuzzleHttp\Promise\queue();
            // $loop = \React\EventLoop\Factory::create();
            // $loop->addPeriodicTimer(2000, [$queue, 'run']);
            // dd($results);die;$loop->run();
            $jsonArray = $results[0]["value"];
            // if(method_exists($this, 'test'))
            // echo 'a::test() exists!';
            //  else
            // echo 'a::test() doesn\'t exists';
            $data = $jsonArray ? $jsonArray : $jsonArray->original;
            $fetchData = $data;
            $check = (array) $fetchData->getData();
            // dd(check);
            if(!$check){
                // return "ga ada";
                $result = $jsonArray->original;
                // $result = $result->getResponse()->getReasonPhrase();
                $resultD = $result->getResponse()->getReasonPhrase();
                // dd($result);
                // return response()->json(['data' => $result]);
                // $resultD;

            }   else {
                // return "ada";
                $dd = json_decode($fetchData->getData(), true);
                $resultD = $dd["Shipment"]["code"];
                // return response()->json(['data' => $dd["Shipment"]["code"]]);

                // dd($resultD);

            }
            // $self = $resultD;
            $id = $this->tcs->whereIn('order_id', [$resultD])->first()["id"];
            $dataSHIPMENTS = $this->TrackShipments
                            ->with('user_order_transport_history','statusHistoryName')
                            ->whereIn('order_id', [$id])
                            ->first();
            // foreach ($dataSHIPMENTS as $key => $value) {
            // //     # code...
            //     $status_orders[] = $value->statusHistoryName;
            // //     $shipment[] = $value;
            // }
            // dd($dataSHIPMENTS);

            return response()->json($dataSHIPMENTS);
            die;
            // if($fetchData->getData()){
            //     return "ada";
            // } 

            // if($fetchData->getResponse()->getStatusCode()){
            //     return "asda";
            // } 
            // if($responses["status"] == 200){
            //     return "asdasd";
            // } else {
            //     return "asdasdsdxcc";
            // }
            // $result = $fetchData->getResponse()->getStatusCode();
            // $fetchData = $jsonArray->original;
            // dd($fetchData);die;
            // if(isset($result) == 404){
            //     return  "failed";
            //     // return response()->json(['shipments' => $fetchData]);
            // } else {
            //     return  "berhasil";

            // }

        //     } catch (\GuzzleHttp\Exception\ClientException $e) {
                            
        //         return $e->getResponse()
        //                 ->getBody()
        //                 ->getContents();
        // }

        $geocoder = new \OpenCage\Geocoder\Geocoder('59340569a67d4a54acb1c2d03fc63ba9');
        $result = $geocoder->geocode('-7.9493, 112.6294561'); # latitude,longitude (y,x)
        // print $result['results'][0]['formatted'];
        $alamat = $result['results'][0]['formatted'];
        $addresses = $alamat;
        $results = [];

        // foreach ($addresses as $address) {
        $result = $geocoder->geocode($addresses);
        $msg = $result['status']['message'];

        if ($msg == 'OK'){
            $results[] = $result['results'][0]['components']['state'];
            $results[] = $result['results'][0]['components']['state_district'];
        } else {
            error_log("gagal menyambung method geocode '$addresses' : $msg");
        }
        
        // return $results;
      
        // $geocoder = new \OpenCage\Geocoder\Geocoder('59340569a67d4a54acb1c2d03fc63ba9');
        // $result = $geocoder->geocode('1 Hacker Way, Menlo Park, 94025');
        // if ($result && $result['total_results'] > 0) {
        //     $first = $result['results'][0];
        //     echo json_encode([
        //         'lat' => $first['geometry']['lat'],
        //         'lon' => $first['geometry']['lng'],
        //     ]);

        // }
        // die;
        // $adapter  = new GuzzleAdapter();
        // $providers = new \OpenCage\Geocoder\Geocoder($adapter, '59340569a67d4a54acb1c2d03fc63ba9');
        // // dd($provider);
        // $geocoder = new \Geocoder\StatefulGeocoder($providers, 'en');
        // // $results = $geocoder->geocodeQuery(GeocodeQuery::create('1 Hacker Way, Menlo Park, 94025'));
        // $results = $geocoder->reverseQuery(ReverseQuery::fromCoordinates(37.4856225, -122.1468803));
        // echo $results->first()->getStreetName() . "\n";
        // // $result = $geocoder->geocode('82 Clerkenwell Road, London');
        // // $coords = $results->first()->getCoordinates();

        // // echo json_encode([ 'lat' => $coords->getLatitude(), 'lon' => $coords->getLongitude() ]) . "\n";
        // // print_r($result);
        // // $results = $geocoder->reverseQuery(ReverseQuery::fromCoordinates(37.4856225, -122.1468803));
        // # print_r($results);

        // echo $results->first()->getStreetName() . "\n";
        // die;
        // $provider = new Geocoder($adapter,'59340569a67d4a54acb1c2d03fc63ba9');
        // // $providers = $provider->geocode($adapter,'59340569a67d4a54acb1c2d03fc63ba9'); 
        // $geocoder = new \Geocoder\StatefulGeocoder($provider, 'en'); 

        // $results = $geocoder->geocodeQuery(GeocodeQuery::create('1 Hacker Way, Menlo Park, 94025'));
        // # print_r($results);

        // $coords = $results->first()->getCoordinates();

        // echo json_encode([ 'lat' => $coords->getLatitude(), 'lon' => $coords->getLongitude() ]) . "\n";
                // return view('geolocation.geolocation');

    }

    public function viewers(){
        return view('viewers.viewers');

    }

    public function view(){
        // public functiosn view(TrackShipments $TrackShipments){
        // $shipment_code = elf::geocoding($code);
        // $dataSHIPMENTS = $orders->with('cek_status_transaction','city_origin','city_destination','address')->whereIn('order_id',[$shipement_code])->get();

        // dd($shipement_code);
      
        // dd($status_orders);
        // if($status_orders[0] == "done"){
        //     return "draft";
        // } else if($status_orders[1] == "new"){
        //     return "new";
        // }else {
        //     return "tidak cocok";
        // }die;
        // $geocode = implode(", ", (array) $dataSHIPMENTS);

        // return response()->json($dataSHIPMENTS);
        return view('geolocation.geolocation');
    }

}
