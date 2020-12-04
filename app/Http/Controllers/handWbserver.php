<?php

namespace warehouse\Http\Controllers;

use Illuminate\Http\Request;
use warehouse\Http\Controllers\Controller;
use warehouse\Http\Controllers\Services\AccuratecloudInterface;

class handWbserver extends Controller {

    private $openModulesAccurateCloud;

    public function __construct(Request $GETclient, AccuratecloudInterface $APInterfacecloud)
    {
        $this->openModulesAccurateCloud = $APInterfacecloud;
    }
    
    public function handle(Request $req){
            
            $token = "*********";
            $getCloudAccurate = $this->openModulesAccurateCloud
            ->FuncModuleReceivedWebhook($req);
    
                $request_body = file_get_contents('php://input');
                $json = json_decode($request_body, 1);
                $headers = $request->headers->all();

                $provided_signature = $headers["Webhook-Signature"];
                $calculated_signature = hash_hmac("sha256",$raw_payload,$token);
                if ($provided_signature == $calculated_signature) {
            
                $payload = json_decode($raw_payload, true);
          
          
            foreach ($payload["WebhooksEvents"] as $event) {
          
                switch ($event["resource_type"]) {
                    
                        case "CREATE":
                            process_create_events($event);
                        break;

                        case "POD":
                            process_pod_events($event);
                        break;

                        case "POP":
                            process_pop_events($event);
                        break; 

                }

           }
          
                header("HTTP/1.1 200 OK");
          
        } 
            else {
                    
                    header("HTTP/1.1 498 Invalid Request");
            
        }
          
          
          
            return response()->json($payload);
         
        }
}