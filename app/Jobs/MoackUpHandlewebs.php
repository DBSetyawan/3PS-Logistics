<?php

namespace warehouse\Jobs;

use Auth;
use Carbon\Carbon;
use warehouse\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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


class MoackUpHandlewebs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $webhooks = array();
    public $tries = 5;
    public $users;

    public function __construct($webhooks, $users)
    {
        $this->webhooks = $webhooks;

        $this->users = $users;

    }

    public function handle()
    {

        $transport = Transport_orders::where('order_id', '=', $this->webhooks)->first();
        
        $checking_status = TrackShipments::where('order_id','=', $transport['id'])
                            ->where('status','=', '8')->first();

                    if($checking_status){

                        } 
                            else {

                                Order_transport_history::insert(
                                    [
                                        'user_id' => $this->users,
                                        'order_id' => $transport['id'],
                                        'status' => '8',
                                        'datetime' => Carbon::now(),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now()
                                    ]
                            );

                                Transport_orders::whereIn('order_id', [$this->webhooks])->update(
                                [
                                    'method_izzy' => 'CREATED',
                                    'status_order_id' => '8',
                                    'recovery_SO' => $this->webhooks
                                        ]
                                    )
                                ;

                        }

            return response()->json($this->webhooks);
    }

}
