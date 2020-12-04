<?php

namespace warehouse\Http\Controllers\Helper;

use warehouse\Http\Controllers\Services\AccurateCloudmodules;
use Illuminate\Support\Arr;

class BulkSaveAccurateCloud extends AccurateCloudmodules
{
    public function FuncOpenmoduletestingBulkBarangJasa()
    {
        try {

            /**
             * testing Bulk Save data[n].WithoutIndex
             * 
             * @author artexs  
             * @param collect data barang & jasa
             */
            #############=======================#############
            $datax = collect([['itemtype'=>'INVENTORY',
                    'name'=>'penggaris X-Z',
                    'detail'=>'100002',
                    'qty'=>'1230'],
                    ['itemtype'=>'SERVICE',
                    'name'=>'Pengiriman A - Z',
                    'detail'=>'100003',
                    'qty'=>'2300']
                ]);

            foreach ($datax as $key => $value) {
                # code...
                $values[$key] = $value;
                $newkey[] = sprintf('%s', $key);
                $mArray[] =[
                        'session' => $this->FuncAlwaysOnSessionAccurateCluod(),
                        'data['.$key.'].itemType' => $values[$key]['itemtype'],
                        'data['.$key.'].name' => $values[$key]['name'],
                        '_ts' => $this->date,
                        'data['.$key.'].detailGroup[0].itemNo' => $values[$key]['detail'],
                        'data['.$key.'].detailGroup[0].quantity' => $values[$key]['qty']
                     ];
                $arry[] =[
                            'data['.(int)$key.'].name',
                            'data['.(int)$key.'].itemType',
                            'data['.(int)$key.'].detailGroup[0].itemNo',
                            'data['.(int)$key.'].detailGroup[0].quantity',
                            'session',
                            '_ts',
                    ];
            }
            // foreach ($array_fetch_asort as $keys => $values) {
            //     # code...
            //     $sdasd[$keys] = $values;
            // }
            // $arr1 = Arr::add($arry, 'session', $this->FuncAlwaysOnSessionAccurateCluod());
            $needles = Arr::flatten($arry);
            array_walk_recursive($mArray, function ($v, $k) use (&$sArray,$needles) {
                if (in_array($k, $needles)) {
                    $sArray[$k]=$v;
                }
            });

            // var_export($sArray);
            // dd($sArray);die;
            // $dsa = array_merge_recursive($sdasd[0], $sdasd[1]);
            ksort($sArray);
            $api = array_map('trim', $sArray);
             
            $data = '';
            foreach ($sArray as $nama => $nilai) {
                if ($nilai == '') {
                    continue;
                }
            
                if ($data != '') {
                    $data .= '&';
                }
                $data .= rawurlencode($nama).'='.rawurlencode($nilai);
            }
               
             
            $hash = hash_hmac('sha256', $data, $this->signatureSecretKey, true);
            $signature = base64_encode($hash);
            // dd($data);die;
               
            $client = new Client();
            // $testingTs = array_merge_recursive($preg[0], $preg[1]);
            $intArray = array_map(
                    function ($value) {
                        return (int)$value;
                    },
                    $newkey
                );
            foreach ($intArray as $key => $value) {
                # code...
                // $dasd[] = $value;
                // $itemNo[] = ;
                // $session[] = $sArray['session'];
                // $_ts[] = $sArray['_ts'];
                $sdasx[] = array(
        '_ts' => $sArray['_ts'],
        'session' => $sArray['session'],
        'data['.$key.'].itemType' => $sArray['data['.$value.'].itemType'],
        'data['.$key.'].name' => $sArray['data['.$value.'].name'],
        'data['.$key.'].detailGroup[0].itemNo' => $sArray['data['.$value.'].detailGroup[0].itemNo'],
        'data['.$key.'].detailGroup[0].quantity' => $sArray['data['.$value.'].detailGroup[0].quantity'],
    );
            }
            $sArray['sign'] = $signature;
            // dd($data);die;
            // array_walk_recursive($sdasx,function($v,$k)use(&$sArray,$sdasx){if(in_array($k,$sdasx))$sArray[$k]=$v;});
            $opts = array('http' =>
array(
    'method'  => 'POST',
    'header'  => "Authorization: Bearer " . $this->access_token . "\r\n" ."Content-Type: application/x-www-form-urlencoded\r\n",
    'content' => http_build_query($sArray),
    'ignore_errors' => true,
)
);
            $context  = stream_context_create($opts);
            $response = file_get_contents('https://public.accurate.id/accurate/api/item/bulk-save.do', false, $context);
            // $parameter = [];
            // $parameter['_ts'] = gmdate('Y-m-d\TH:i:s\Z');
            // $parameter['session'] = $this->FuncAlwaysOnSessionAccurateCluod();
            // $parameter['data[0].itemType'] = "INVENTORY";
            // $parameter['data[0].name'] = "penggaris X-Z";
            // $parameter['data[0].detailGroup[0].itemNo'] = "123900";
            // $parameter['data[1].itemType'] = "SERVICE";
            // $parameter['data[1].name'] = "Pengiriman A-Z";
            // $parameter['data[1].detailGroup[0].itemNo'] = "209392";
            // $signatureSecret = '0843e6162e9893b12ba0c797c2f68a24';
            // // Create Signature
            // ksort($parameter);
            // $parameter = array_map('trim', $parameter);
            // $datas = '';
            // foreach ( $parameter as $nama => $nilai ) {
//     if ($nilai == '') {
//         continue;
//     }
//     if ($datas != '') {
//         $datas .= '&';
//     }
//     $datas .= rawurlencode($nama) . '=' . rawurlencode($nilai);
            // }
            // $hashs = hash_hmac('sha256', $datas, $signatureSecret, true );
            // $signatures = base64_encode($hashs);
            // $parameter['sign'] = $signatures;
            // Output
            // echo $response;
            return response()->json($response);
            die;
            $responses = array('http' => $client->post(
                    self::API_ACCURATE_SAVE_BULK_ITEM_URL,
                    [
                            'headers' => [
                                            'Content-Type' => 'application/x-www-form-urlencoded',
                                            'Authorization' =>'Bearer'.$this->access_token,
                                            'Accept' => 'application/json'
                                        ],
                            'form_params' => $sdasx
                        ]
                )
                );
            return response()->json($sArray);
            die;
            // $jsonArray = json_decode($response->getBody()->getContents(), true);
                 
            // parsing this id to db
            // $data_array2 = $jsonArray["r"]["no"];
            return response()->json($responses);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return $e->getResponse()
                        ->getBody()
                        ->getContents();
        }
    }
}