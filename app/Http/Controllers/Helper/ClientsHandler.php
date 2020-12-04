<?php
namespace warehouse\Http\Controllers\ClientsHandler;

$serverUrl = 'this host';

$curl = new GuzzleHttp\Handler\CurlMultiHandler();
$handler = GuzzleHttp\HandlerStack::create($curl);
$client = new GuzzleHttp\Client(['handler' => $handler]);
$request = new \GuzzleHttp\Psr7\Request('GET', $serverUrl);
$promise = $client->sendAsync($request)->then(function ($response) {
    echo 'I completed at ' . microtime(true) . '! ' . $response->getBody() . PHP_EOL;
});
echo 'Ticking...' . microtime(true) . PHP_EOL;
$curl->tick();
echo 'Ticked!' . microtime(true) . PHP_EOL;

sleep(2);
$beforeTime = microtime(true);
// echo 'Client microtime before `wait` is: ' . $beforeTime . PHP_EOL;
// $r = $promise->wait(true);
$afterTime = microtime(true);
// echo 'Client microtime after `wait` is: ' . $afterTime . PHP_EOL;
// print_r($r);
$touchedTime = file_get_contents('./touched');
echo 'Server\'s microtime: ' . $touchedTime . PHP_EOL;
echo 'Touched - Before: ' . ($touchedTime - $beforeTime) * 1000 . PHP_EOL;