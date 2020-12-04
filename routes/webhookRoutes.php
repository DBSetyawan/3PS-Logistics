
<?php

use Illuminate\Http\Request;

// Route::name('webhooks.server')->post('/webhooks', 'handWbserver@handle');
Route::post('api/v2/webhooks', function (Request $request) {
    return $request->all();
});