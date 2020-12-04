<?php

namespace warehouse\Jobs;

use Auth;
use Carbon\Carbon;
use warehouse\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use warehouse\Models\Transport_orders;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use warehouse\Models\Order_transport_history;
use Illuminate\Foundation\Auth\User as Authenticatable;
use warehouse\Http\Controllers\Helper\UpdateOrCreatedHelpers;
use warehouse\Models\Order_transport_history as TrackShipments;

class HVMVPODWebhookTransport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $webhooks = array();

    public $userspop;

    public function __construct($webhooks, $userspop)
    {
        $this->webhooks = $webhooks;

        $this->userspop = $userspop;
    }

    public function handle()
    {

        $transport = Transport_orders::where('order_id', '=', $this->webhooks)->first();
        
        $checking_status = TrackShipments::where('order_id','=', $transport['id'])
                            ->where('status','=', '4')->first();

                    if($checking_status){

                        } 
                            else {

                                Order_transport_history::insert(
                                    [
                                        'user_id' => $this->userspop,
                                        'order_id' => $transport['id'],
                                        'status' => '4',
                                        'datetime' => Carbon::now(),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now()
                                    ]
                            );

                                Transport_orders::whereIn('order_id', [$this->webhooks])->update(
                                [
                                    'method_izzy' => 'POD',
                                    'status_order_id' => '4',
                                    'recovery_SO' => $this->webhooks
                                        ]
                                    )
                                ;

                        }

            return response()->json($this->webhooks);

    }

}
