<?php

namespace warehouse\Http\Controllers\Services;

use Illuminate\Http\Request;
use warehouse\Models\Transport_orders;

interface IzzytransportsHooks
{

    public function ProcessingResponse(Transport_orders $req, $receivedSocketWebhooks, $receivedSocketWebhooksShipment);
    
}