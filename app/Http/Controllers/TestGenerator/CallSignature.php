<?php

namespace warehouse\Http\Controllers\TestGenerator;

use GuzzleHttp\Promise\EachPromise;
use GuzzleHttp\Promise\FulfilledPromise;
use GuzzleHttp\Psr7\Response;
use Cache;
use GuzzleHttp\Promise\Promise;

Trait CallSignature
{

    public function test()
    {
       
        $users = ['one', 'two', 'three'];
        $cache = new Cache();
        $promises = (function () use ($users, $cache) {
        foreach ($users as $user) {
            
            if ($cache->hasItem('cache_user_' . $user)) {
            $profile = $cache->getItem($user)->get();
            yield new FulfilledPromise($profile);
            continue;
        }
            yield $this->getAsync($url. $user)
            ->then(function (Response $response) use ($cache, $user) {
                
                $profile = json_decode($response->getBody(), true);
                $cache->put('cache_user_' . $user, $profile, $expiry = 300);
                return $profile;
            });
        }
        })();
            $eachPromise = new EachPromise($promises, [
            'concurrency' => 4,
            'fulfilled' => function ($profile) {
                },
            'rejected' => function ($reason) {
            }
        ]);

        $eachPromise->promise()->wait();

    }

    public function GeneratorFetchJustTime(){

        $date = gmdate('Y-m-d\TH:i:s\Z');
        $array_fetch_asort = [
            '_ts' => $date
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

    
    $hash = hash_hmac('sha256', $data, "5c68abd1f4cff8c9b55351ae6cbb7bf5", true );
    $signature = base64_encode($hash);
            
       return response()->json(['sign' => $signature, '_ts' => $array_fetch_asort]);
         
    }  

    public function BinaryEncoderDecoder()
    {
        if(isset($request->encode)) {

            $words = (isset($request->encode) ? $request->encode : null) ;
            $encoded = "";

            $len = strlen($words);
            $i=0;

            for($i=0;$i<$len;$i++)
            {
                $itg = ord($words[$i]);  
                $bin = decbin($itg); 
                $new = str_pad($bin, 8, "0", STR_PAD_LEFT); 
                $encoded .= $new; 
            }
                
                echo "<center>";
                echo "<h3>Result : </h3>";
                echo "<textarea rows='15' cols='50' name='result'>";
                echo "$encoded";
                echo "</textarea>";
                echo "</center>";
                
            } 
                else if(isset($request->decode))
                {
                    
                    $bin = (isset($request->decode) ? $request->decode : null) ;
                    $decoded = "";
                    $arr = str_split($bin, 8);
                    $size = count($arr);
                    $i=0;
                    for($i=0;$i<$size;$i++)
                    {
                        $dec = bindec($arr[$i]); 
                        $char = chr($dec); 
                        $decoded .= $char;
                    }

                    echo "<center>";
                    echo "<h3>Result : </h3>";
                    echo "<textarea rows='15' cols='50' name='result'>";
                    echo "$decoded";
                    echo "</textarea>";
                    echo "</center>";
                    
                }
                    else if(isset($request->decode) && isset($request->encode)) {
                        echo "<script>alert('ERROR!')</script>";
                    }

    }

}
