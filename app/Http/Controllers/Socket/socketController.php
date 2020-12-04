<?php

namespace warehouse\Http\Controllers\Socket;

use warehouse\Http\Requests;
use warehouse\Http\Controllers\Controller;
use Request;
use LRedis;
 
class SocketController extends Controller {

    public function __construct()
    {
    // $this->middleware('guest');
    }

    public function index()
    {
        return view('admin.index');
    }

    public function writemessage()
    {
        return view('writemessage');
    }

    public function sendMessage(){
        $redis = LRedis::connection();
        $redis->publish('message', Request::input('message'));
        return redirect('admin.index');
    }

}