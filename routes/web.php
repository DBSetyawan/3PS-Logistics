<?php

use Carbon\Carbon;
use warehouse\User;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use Carbon\CarbonInterval;
use Illuminate\Support\Str;
use GuzzleHttp\HandlerStack;
use Illuminate\Http\Request;
use React\EventLoop\Factory;
use GuzzleHttp\Psr7\Response;
use warehouse\Models\WebhooksLog;
use warehouse\Events\WebhookEvents;
use Psr\Log\InvalidArgumentException;
use Illuminate\Support\Facades\Session;
use warehouse\Events\WebhookEventsProd;
use GuzzleHttp\Handler\CurlMultiHandler;
use warehouse\Http\Controllers\ManagementController;
use warehouse\Http\Controllers\Services\AccuratecloudInterface;

/* TODO: middleware authentication
|---------------- LARAVEL CORS MIDDLEWARE ------------------|
** Access-Control-Allow-Origin #modified
** Access-Control-Allow-Methods #modified
** See enable cors  http://enable-cors.org/ 
** Or https://laravel.com/docs/master/csrf
** Sometimes CORS is also associated with the protection methods of how to prevent CSRF attacks.
** The most typical way to mitigate the attack is to use anti-CSRF tokens but it is also possible to prevent the attack by checking.
** the Origin: or Referer: header which is related to CORS.

************************************************************
*** https://dom.spec.whatwg.org/#aborting-ongoing-activities 
************************************************************
*/

Auth::routes(['verify' => true]);

    Route::get('/', function (){
               
            return redirect("auth/login");
        }
    );
    
    Route::group(['middlewareGroups' => ['web','CekOpenedTransaction','BlockedBeforeSettingUser','verified']], function () {
        Route::middleware('verified')
            ->namespace('customer')
            ->group(function () {
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/list-item-alerts-customer','CustomerController@alert_customer_list')->name('system.alert.customers')->where('branch_id', '[0-9]+');
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/list-order-id/{id}/customer-warehouse-orders','CustomerController@automically_orders')->name('orders.customer')->where('branch_id','[0-9]+');
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/list-master-customer','CustomerController@index')->name('master.customer.list')->where('branch_id','[0-9]+');
            Route::post('/dashboard/find-branch-with-branch/branch-id/{branch_id}/import-master-customer','CustomerController@import_excel')->name('import.customer.list')->where('branch_id','[0-9]+');
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/detail-data-master-customer/{id}/update-data-customers','CustomerController@UpdateCustomerAsync')->name('update.data.cs')->where('branch_id','[0-9]+');
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/create-master-customer','CustomerController@create')->name('create.master.customer')->where('branch_id','[0-9]+');
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/detail-data-master-customer/{id}/update-data-customer','CustomerController@show')->name('update.master.customer')->where('branch_id','[0-9]+');
        });
    });

    Route::group(['middlewareGroups' => ['web']], function () {
        Route::middleware('verified')
        ->namespace('customer')
            ->group(function () {
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/obsfucator','CustomerController@obsc')->name('obsc')->where('branch_id', '[0-9]+');
        });
    });

    Route::group(['middlewareGroups' => ['web','BlockedBeforeSettingUser','verified']], function () {
        Route::middleware('verified')
            ->namespace('customer')
            ->group(function () {
                Route::get('/cari_province', 'CustomerController@loadDataProvins');
                Route::get('/type-pajak', 'CustomerController@TipePajakAccurateCloud');
                Route::get('/cari_province/find/{id}', 'CustomerController@loadDataCity');
                Route::resource('customerpics','CustomerpicsController');
                Route::get('/added_item_customer/{idx_item_customer}','CustomerController@showitiditemcustomertc')->name('add_item_customer.added');
                Route::get('/search/list_customers/{id}', 'CustomerController@something');
                Route::get('/search/list_items/{id}', 'CustomerController@something_awesome');
                Route::get('/search_type_of_business', 'CustomerController@loadData');
                Route::get('/customer','CustomerController@index');
                Route::get('/alert-customer-update/{id}','CustomerController@update_alert_customer');
                Route::get('/customer/registration','CustomerController@create');
                Route::get('/save-master-customer','CustomerController@saved_customerOfTransport');
                Route::get('trash_customers','CustomerController@trash_customers');
                Route::get('customer_trashed','CustomerController@trash_customers');
                Route::get('restoreall_customer','CustomerController@restoreall');
                Route::delete('restored/{id}','CustomerController@restored_customer')->name('stored');
                Route::resource('customer','CustomerController');
                Route::put('customer/{id}','CustomerController@show')->name('show_customer');
                Route::get('/loaded_auto_search_txt_cs/find/{indexid}','CustomerController@load_auto_move_cty');
        });
    });

    Route::group(['middlewareGroups' => ['web','CekOpenedTransaction','BlockedBeforeSettingUser','verified','role:super_users|3PL SURABAYA ALL PERMISSION|3PL - SURABAYA WAREHOUSE|administrator|3PL[OPRASONAL][TC]|3PL[OPRASONAL][WHS]|3PL[OPRASONAL][TC][WHS]|3PL[ACCOUNTING][TC]|3PL[ACCOUNTING][WHS][TC]|3PL[ACCOUNTING][WHS]']], function () {
        Route::middleware('CekOpenedTransaction','role:super_users|administrator|3PL[OPRASONAL][TC]|3PL[OPRASONAL][WHS]|3PL SURABAYA ALL PERMISSION|3PL - SURABAYA WAREHOUSE|3PL[OPRASONAL][TC][WHS]|3PL[ACCOUNTING][TC]|3PL[ACCOUNTING][WHS][TC]|3PL[ACCOUNTING][WHS]')
        ->namespace('item')
        ->group(function (){
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/list-service-items-warehouse','ItemController@index')->name('itemslist.show')->where('branch_id', '[0-9]+');
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/detail-service-item/{id}/update-detail-warehouse-item','ItemController@show')->name('update.item.service')->where('branch_id', '[0-9]+');
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/list-item-alerts-warehouse','ItemController@alert_item_list')->name('system.alert.item.whs')->where('branch_id', '[0-9]+');
        });
    });

    Route::group(['middlewareGroups' => ['web','CekOpenedTransaction','BlockedBeforeSettingUser','verified','role:super_users|3PL SURABAYA ALL PERMISSION|3PL - SURABAYA WAREHOUSE|administrator|3PL[OPRASONAL][TC]|3PL[OPRASONAL][WHS]|3PL[OPRASONAL][TC][WHS]|3PL[ACCOUNTING][TC]|3PL[ACCOUNTING][WHS][TC]|3PL[ACCOUNTING][WHS]']], function () {
        Route::middleware('CekOpenedTransaction','role:super_users|administrator|3PL[OPRASONAL][TC]|3PL[OPRASONAL][WHS]|3PL SURABAYA ALL PERMISSION|3PL - SURABAYA WAREHOUSE|3PL[OPRASONAL][TC][WHS]|3PL[ACCOUNTING][TC]|3PL[ACCOUNTING][WHS][TC]|3PL[ACCOUNTING][WHS]')
        ->namespace('MasterItemAccurate')
        ->group(function (){
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/list-master-item-accurate-cloud','MasterItemAccurate@index')->name('masterItemAccurate.index')->where('branch_id', '[0-9]+');
        });
    });
    
    Route::group(['middlewareGroups' => ['web','BlockedBeforeSettingUser','verified','role:super_users|3PL SURABAYA ALL PERMISSION|3PL - SURABAYA WAREHOUSE|administrator|3PL[OPRASONAL][TC]|3PL[OPRASONAL][WHS]|3PL[OPRASONAL][TC][WHS]|3PL[ACCOUNTING][TC]|3PL[ACCOUNTING][WHS][TC]|3PL[ACCOUNTING][WHS]']], function () {
        Route::middleware('CekOpenedTransaction','role:super_users|administrator|3PL[OPRASONAL][TC]|3PL[OPRASONAL][WHS]|3PL SURABAYA ALL PERMISSION|3PL - SURABAYA WAREHOUSE|3PL[OPRASONAL][TC][WHS]|3PL[ACCOUNTING][TC]|3PL[ACCOUNTING][WHS][TC]|3PL[ACCOUNTING][WHS]')
        ->namespace('item')
        ->group(function (){
            Route::resource('items','ItemController');
            Route::get('/loaded-items-list','ItemController@loaded_itemsss');
            Route::get('/alert-item-update/{id}','ItemController@update_alert_item');
        });
    });

    Route::group(['middlewareGroups' => ['web','CekOpenedTransaction','BlockedBeforeSettingUser','verified','role:3PL - SURABAYA WAREHOUSE|super_users|administrator|3PL - BANDUNG TRANSPORT']], function () {
        Route::middleware('role:super_users|administrator|3PL - SURABAYA WAREHOUSE|3PL - BANDUNG TRANSPORT')
        ->namespace('vendor')
        ->group(function (){
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/list-master-vendor','VendorController@index')->name('master.vendor.list')->where('branch_id', '[0-9]+');
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/detail-data-pemasok/{id}/update-success','VendorController@updatePemasok')->name('update.detail.d.pmsk')->where('branch_id', '[0-9]+');
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/create-master-vendor','VendorController@create')->name('create.master.vendor')->where('branch_id', '[0-9]+');
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/added-item-vendor/{idx_item_vendor}/detail-file-item-vendor','VendorController@showitiditemvendortc')->name('add_item_vendor.added')->where('branch_id', '[0-9]+');
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/detail-data-vendor/{id}/update-data-vendor','VendorController@show')->name('show.master.vendor')->where('branch_id', '[0-9]+');
        });
    });

    Route::group(['middlewareGroups' => ['web','BlockedBeforeSettingUser','verified','role:3PL - SURABAYA WAREHOUSE|super_users|administrator|3PL - BANDUNG TRANSPORT']], function () {
        Route::middleware('role:super_users|administrator|3PL - SURABAYA WAREHOUSE|3PL - BANDUNG TRANSPORT')
        ->namespace('vendor')
        ->group(function (){
            Route::resource('vendorx','VendorController');
            Route::get('/type-pajak-vendor', 'VendorController@TipePajakAccurateCloud');
            Route::get('/save-master-vendor','VendorController@saved_vendorOfTransport');
            Route::get('/cari_usaha', 'VendorController@loadData');
            Route::get('/cari-kota', 'VendorController@loadDataCity');
            Route::resource('vendorpics','VendorpicsController');
        });
    });

    Route::group(['middlewareGroups' => ['web','CekOpenedTransaction','BlockedBeforeSettingUser','verified','role:3PL - SURABAYA WAREHOUSE|super_users|administrator|3PL - BANDUNG TRANSPORT']], function () {
        Route::middleware('role:administrator|super_users|3PL - SURABAYA WAREHOUSE|3PL - BANDUNG TRANSPORT')
        ->namespace('sub_services')
        ->group(function (){
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/list-master-sub-services','SubservicesController@index')->name('master.sub_services.list')->where('branch_id', '[0-9]+');
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/detail-data-sub-services/{id}/update-data-sub-services','SubservicesController@show')->name('show.sub_services.list')->where('branch_id', '[0-9]+');
        });
    });

    Route::group(['middlewareGroups' => ['web','BlockedBeforeSettingUser','verified','role:3PL - SURABAYA WAREHOUSE|super_users|administrator|3PL - BANDUNG TRANSPORT']], function () {
        Route::middleware('role:administrator|super_users|3PL - SURABAYA WAREHOUSE|3PL - BANDUNG TRANSPORT')
        ->namespace('sub_services')
        ->group(function (){
            Route::resource('subservice','SubservicesController');
            Route::get('/sub-services-list','SubservicesController@index');
            Route::get('/sub-services/find','SubservicesController@loadDatas');
            Route::get('/load-compan/find','SubservicesController@loadCompn');
        });
    });

    Route::group(['middlewareGroups' => ['web','CekOpenedTransaction','BlockedBeforeSettingUser','verified','role:super_users|administrator|3PL - SURABAYA WAREHOUSE|3PL - BANDUNG TRANSPORT']], function () {
        Route::middleware('role:administrator|super_users|3PL - SURABAYA WAREHOUSE|3PL - BANDUNG TRANSPORT')
        ->namespace('Shipment_category')
        ->group(function (){
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/list-master-shipment-category','ShipmentcategoryController@index')->name('master.shipment.category.list')->where('branch_id', '[0-9]+');
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/detail-data-shipment-category/{id}/update-data-shipment-category','ShipmentcategoryController@show')->name('show.shipment.category.list')->where('branch_id', '[0-9]+');
        });
    });

    Route::group(['middlewareGroups' => ['web','BlockedBeforeSettingUser','verified','role:super_users|administrator|3PL - SURABAYA WAREHOUSE|3PL - BANDUNG TRANSPORT']], function () {
        Route::middleware('role:administrator|super_users|3PL - SURABAYA WAREHOUSE|3PL - BANDUNG TRANSPORT')
        ->namespace('Shipment_category')
        ->group(function (){
            Route::resource('shipmentscy','ShipmentcategoryController');
        });
    });

    Route::group(['middlewareGroups' => ['web','CekOpenedTransaction','BlockedBeforeSettingUser','verified','role:3PL - SURABAYA WAREHOUSE|super_users|administrator|3PL - BANDUNG TRANSPORT']], function () {
        Route::middleware('role:super_users|administrator|3PL - BANDUNG TRANSPORT|3PL - SURABAYA WAREHOUSE')
        ->namespace('Modas')
        ->group(function (){
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/list-master-moda','ModasController@index')->name('master.data.modas')->where('branch_id', '[0-9]+');
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/detail-data-moda/{id}/update-data-moda','ModasController@show')->name('show.data.modas')->where('branch_id', '[0-9]+');
        });
    });

    Route::group(['middlewareGroups' => ['web','BlockedBeforeSettingUser','verified','role:3PL - SURABAYA WAREHOUSE|super_users|administrator|3PL - BANDUNG TRANSPORT']], function () {
        Route::middleware('role:super_users|administrator|3PL - BANDUNG TRANSPORT|3PL - SURABAYA WAREHOUSE')
        ->namespace('Modas')
        ->group(function (){
            Route::resource('modasv','ModasController');
            Route::get('/moda-category-list','ModasController@index');
            Route::get('/sub-service-moda','ModasController@moda_load_sb');
        });
    });

    Route::group(['middlewareGroups' => ['web','CekOpenedTransaction','BlockedBeforeSettingUser','verified','role:administrator|3PL|3PE']], function () {
        Route::middleware('role:administrator|3PL|3PE')
        ->namespace('vendor_pic')
        ->group(function (){
            Route::resource('vendorpics','VendorpicsController');
        });
    });

    Route::group(['middlewareGroups' => ['web','CekOpenedTransaction','BlockedBeforeSettingUser','verified','role:3PL - SURABAYA WAREHOUSE|super_users|administrator|3PL - BANDUNG TRANSPORT']], function () {
        Route::middleware('role:super_users|administrator|3PL - SURABAYA WAREHOUSE|3PL - BANDUNG TRANSPORT')
        ->namespace('address_book')
        ->group(function (){
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/detail-data-address-book/{id}/update-data-address-book','AddressbookController@show')->name('update.data.address.book')->where('branch_id', '[0-9]+');
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/create-master-address-book','AddressbookController@create')->name('registration.address.book');
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/list-master-address-book','AddressbookController@index')->name('master.address.book');
        });
    });

    Route::group(['middlewareGroups' => ['web','permission:developer|transport|warehouse|accounting|superusers']], function () {
        Route::middleware('BlockedBeforeSettingUser','verified')
        ->namespace('address_book')
        ->group(function (){
            Route::get('/load-city-xs/find','AddressbookController@load_city');
            Route::get('/load-customers-xs/find','AddressbookController@load_customer');
            Route::resource('address_book','AddressbookController');
            Route::post('/registration/successfully','AddressbookController@stored_add_books')->name('saved.add_boo');
            Route::get('/loaded-city-releated/findit/{code}','AddressbookController@load_auto_releated_cty');
        });
    });

    Route::group(['middlewareGroups' => ['web','CekOpenedTransaction','BlockedBeforeSettingUser','verified','role:super_users|administrator|3PL - SURABAYA WAREHOUSE|3PL - BANDUNG TRANSPORT']], function () {
        Route::middleware('role:administrator|super_users|3PL - BANDUNG TRANSPORT|3PL - SURABAYA WAREHOUSE')
        ->namespace('Sales_order')
        ->group(function (){
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/list-master-sales-order','SalesController@index')->name('master.sales.order')->where('branch_id', '[0-9]+');
        });
    });

    Route::group(['middlewareGroups' => ['web','BlockedBeforeSettingUser','verified','role:super_users|administrator|3PL - SURABAYA WAREHOUSE|3PL[OPRASONAL][WHS]|3PL[OPRASONAL][TC]|3PL[OPRASONAL][TC][WHS]']], function () {
        Route::middleware('role:administrator|3PL[OPRASONAL][WHS]|super_users|3PL[OPRASONAL][TC]|3PL[OPRASONAL][TC][WHS]|3PL - SURABAYA WAREHOUSE')
        ->namespace('Sales_order')
        ->group(function (){
            Route::resource('sales_order_whs','SalesController');
            Route::get('/sales-find/{id}','SalesController@find_show_sales');
            Route::get('/sales-updated-named/{index}','SalesController@updated_sales_named');
        });
    });  

    Route::group(['middlewareGroups' => ['web','BlockedBeforeSettingUser','verified']], function () {
        Route::middleware('role:administrator|super_users|3PL SURABAYA ALL PERMISSION|3PL - JAKARTA ALL PERMISSION|3PL - SURABAYA TRANSPORT|3PL - SURABAYA WAREHOUSE|3PL - SURABAYA ACCOUNTING')
        ->group(function (){

            // https://github.com/ivanvermeyen/laravel-google-drive-demo/blob/master/routes/web.php

            // https://github.com/googleapis/google-api-php-client/issues/801

            // store on google drive ---
            // $disk = Storage::disk('google'); //for local, Storage::disk('local);
            // $disk->put($name, fopen($file, 'r+'));

            Route::get('/create-some', function() {
                Route::get('put', function() {
                    Storage::cloud()->put('test.txt', 'Hello World');
                    return 'File was saved to Google Drive';
                });
            });

            Route::get('put-existing', function() {
                $filename = 'vue.js';
                $filePath = public_path($filename);
                $fileData = File::get($filePath);
                Storage::cloud()->put($filename, $fileData);
                return 'File was saved to Google Drive';
            });

            Route::get('create-dir', function() {
                Storage::cloud()->makeDirectory('Test Dir');
                return 'Directory was created in Google Drive';
            });

            Route::get('/listing', function() {
                $dir = '/';
                $recursive = false; // Get subdirectories also?
                $contents = collect(Storage::cloud()->listContents($dir, $recursive));
                //return $contents->where('type', '=', 'dir'); // directories
                return $contents->where('type', '=', 'file'); // files
            });

            Route::get('list-folder-contents', function() {
                // The human readable folder name to get the contents of...
                // For simplicity, this folder is assumed to exist in the root directory.
                $folder = 'Test Dir';
                // Get root directory contents...
                $contents = collect(Storage::cloud()->listContents('/', false));
                // Find the folder you are looking for...
                $dir = $contents->where('type', '=', 'dir')
                    ->where('filename', '=', $folder)
                    ->first(); // There could be duplicate directory names!
                if ( ! $dir) {
                    return 'No such folder!';
                }
                // Get the files inside the folder...
                $files = collect(Storage::cloud()->listContents($dir['path'], false))
                    ->where('type', '=', 'file');
                return $files->mapWithKeys(function($file) {
                    $filename = $file['filename'].'.'.$file['extension'];
                    $path = $file['path'];
                    // Use the path to download each file via a generated link..
                    // Storage::cloud()->get($file['path']);
                    return [$filename => $path];
                });
            });

            Route::get('get', function() {
                $filename = 'test.txt';
                $dir = '/';
                $recursive = false; // Get subdirectories also?
                $contents = collect(Storage::cloud()->listContents($dir, $recursive));
                $file = $contents
                    ->where('type', '=', 'file')
                    ->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
                    ->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
                    ->first(); // there can be duplicate file names!
                //return $file; // array with file info
                $rawData = Storage::cloud()->get($file['path']);
                return response($rawData, 200)
                    ->header('ContentType', $file['mimetype'])
                    ->header('Content-Disposition', "attachment; filename='$filename'");
            });

            Route::get('/put-get-stream', function() {
                // Use a stream to upload and download larger files
                // to avoid exceeding PHP's memory limit.
                // Thanks to @Arman8852's comment:
                // https://github.com/ivanvermeyen/laravel-google-drive-demo/issues/4#issuecomment-331625531
                // And this excellent explanation from Freek Van der Herten:
                // https://murze.be/2015/07/upload-large-files-to-s3-using-laravel-5/
                // Assume this is a large file...
                $filename = 'laravel.png';
                $filePath = public_path($filename);
                // Upload using a stream...
                Storage::cloud()->put($filename, fopen($filePath, 'r+'));
                // Get file listing...
                $dir = '/';
                $recursive = false; // Get subdirectories also?
                $contents = collect(Storage::cloud()->listContents($dir, $recursive));
                // Get file details...
                $file = $contents
                    ->where('type', '=', 'file')
                    ->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
                    ->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
                    ->first(); // there can be duplicate file names!
                //return $file; // array with file info
                // Store the file locally...
                //$readStream = Storage::cloud()->getDriver()->readStream($file['path']);
                //$targetFile = storage_path("downloaded-{$filename}");
                //file_put_contents($targetFile, stream_get_contents($readStream), FILE_APPEND);
                // Stream the file to the browser...
                $readStream = Storage::cloud()->getDriver()->readStream($file['path']);
                return response()->stream(function () use ($readStream) {
                    fpassthru($readStream);
                }, 200, [
                    'Content-Type' => $file['mimetype'],
                    //'Content-disposition' => 'attachment; filename="'.$filename.'"', // force download?
                ]);
            });

            Route::get('/newest', function() {
                $filename = 'test.txt';
                Storage::cloud()->put($filename, \Carbon\Carbon::now()->toDateTimeString());
                $dir = '/';
                $recursive = false; // Get subdirectories also?
                $file = collect(Storage::cloud()->listContents($dir, $recursive))
                    ->where('type', '=', 'file')
                    ->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
                    ->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
                    ->sortBy('timestamp')
                    ->last();
                return Storage::cloud()->get($file['path']);
            });

            Route::get('/fetch-file', function() {
                $filename = 'angularjs.txt';
                $dir = '/';
                $recursive = false; // Get subdirectories also?
                $contents = collect(Storage::cloud()->listContents($dir, $recursive));
                $file = $contents
                    ->where('type', '=', 'file')
                    ->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
                    ->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
                    ->first(); // there can be duplicate file names!
                //return $file; // array with file info
                $rawData = Storage::cloud()->get($file['path']);
                return response($rawData, 200)
                    ->header('ContentType', $file['mimetype'])
                    ->header('Content-Disposition', "attachment; filename=$filename");
            });

        });
    });

    Route::group(['middlewareGroups' => ['web','settinguser','auth','verified','role:super_users']], function () {
        Route::middleware('permission:superusers')
        ->namespace('Admin')
        ->group(function (){
             Route::get('super-user-setting-up', 'UsersController@superuser');
        });   
     });

    Route::group(['middlewareGroups' => ['web','CekOpenedTransaction','BlockedBeforeSettingUser','verified','permission:developer|superusers']], function () {
        Route::middleware('permission:developer|superusers')
        ->namespace('Admin')
        ->group(function (){
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/edit-users/{id}/detail-data-users', 'UsersController@edit')->name('edit.master.users')->where('branch_id', '[0-9]+');
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/update-users/{id}', 'UsersController@update')->name('users.updated')->where('branch_id', '[0-9]+');
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/manage-users', 'UsersController@index')->name('users.list.index')->where('branch_id', '[0-9]+');
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/create-users', 'UsersController@create')->name('users.create.index')->where('branch_id', '[0-9]+');
            Route::post('/dashboard/find-branch-with-branch/branch-id/{branch_id}/stored-users', 'UsersController@createUserNew')->name('users.new.super.index')->where('branch_id', '[0-9]+');
            Route::post('/dashboard/find-branch-with-branch/branch-id/{branch_id}/stored-super-users', 'UsersController@store')->name('users.new.super.users.index')->where('branch_id', '[0-9]+');
            //permission
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/manage-permissions', 'PermissionsController@index')->name('permissions.list.index')->where('branch_id', '[0-9]+');
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/create-permissions', 'PermissionsController@create')->name('permissions.create.index')->where('branch_id', '[0-9]+');
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/edit-permissions/{id}', 'PermissionsController@edit')->name('permissions.edit.index')->where('branch_id', '[0-9]+');
            Route::post('/dashboard/find-branch-with-branch/branch-id/{branch_id}/destroy-permissions/{id}', 'PermissionsController@destroy')->name('destroy.permissions.index')->where('branch_id', '[0-9]+');

            //roles
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/manage-roles', 'RolesController@index')->name('roles.list.index')->where('branch_id', '[0-9]+');
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/create-roles', 'RolesController@create')->name('roles.create.index')->where('branch_id', '[0-9]+');
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/edit-roles/{id}', 'RolesController@editRoles')->name('roles.edit.index')->where('branch_id', '[0-9]+');
            Route::post('/dashboard/find-branch-with-branch/branch-id/{branch_id}/destroy-roles/{id}', 'RolesController@destroyRoles')->name('destroy.role.index')->where('branch_id', '[0-9]+');
            Route::post('/dashboard/find-branch-with-branch/branch-id/{branch_id}/store-roles', 'RolesController@store')->name('store.role.index')->where('branch_id', '[0-9]+');
            // Only User unactive
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/user-unactive-list', 'UsersController@userUnactived')->name('users.trashed')->where('branch_id', '[0-9]+');
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/user-unactive-list/{id}/user-restored', 'UsersController@restoreUsers')->name('users.restored.active')->where('branch_id','[0-9]+');
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/restored-all-users', 'UsersController@restoreAllUser')->name('users.restote.all.active')->where('branch_id','[0-9]+');
        });
    });

    Route::group(['middlewareGroups' => ['web','BlockedBeforeSettingUser','verified','permission:developer|superusers|transport|warehouse|accounting']], function () {
        Route::middleware('permission:developer|superusers|transport|warehouse|accounting')
        ->namespace('Admin')
        ->group(function (){
            Route::resource('permissions', 'PermissionsController');
            Route::resource('roles', 'RolesController');
            Route::resource('users', 'UsersController');

            Route::post('permissions_mass_destroy', ['uses' => 'PermissionsController@massDestroy', 'as' => 'permissions.mass_destroy']);
            Route::post('roles_mass_destroy', ['uses' => 'RolesController@massDestroy', 'as' => 'roles.mass_destroy']);
            Route::get('updated-api-setting-branch/find/{company}/find-branch/{branch}', 'UsersController@updateSettingUserBranch');
            Route::get('company-loaded-super-user/find/{id}', 'UsersController@loadcompanies');
            Route::get('companies-automatics/search/{id}', 'UsersController@searchbranchautomatic')->name('searchbranch');
            Route::get('add-company-request/{id}', 'UsersController@add_companyenv__');
            Route::get('roles-fetch-all', 'UsersController@searchroles');
            Route::get('Async-super-user-roles/roles/{roles}/role/{role}/branch/{branch}', 'UsersController@SettingSyncRoles');
            Route::get('Async-super-company-all/roles/{companyroles}/find/{role}', 'UsersController@SyncRoleCompanies');
            Route::get('find-request-companies/find/{compid}', 'UsersController@findcompanyId');
            Route::get('find-request-deleted-roles/find/{id}', 'UsersController@SuperUserDeletedRole');
            Route::get('request-find-company-branchs/find/{indexid}', 'UsersController@loopdataBranch');
            Route::get('find-request-branchs/find/{brnchid}', 'UsersController@findbranchId');
            Route::get('find-request-roles/find/{roleId}', 'UsersController@findrolesId');
            Route::get('request-form-roles-users', 'UsersController@AddRolesAccessSuperusers');
            Route::get('add-branch-request', 'UsersController@add_branchenv__');
            Route::get('add-role-branch-request', 'UsersController@add_role_branch');
            Route::get('request-deleted-companies/find/{id}', 'UsersController@deletecompanies');
            Route::get('request-deleted-supers-users/find/{id}', 'UsersController@superusersdeleteusers');
            Route::get('companies/find/{id}', 'UsersController@loadbyfindcompanies');
            Route::get('roles-load', 'UsersController@load_with_roles');
            Route::get('registerUsers', 'UsersController@registerUsers');
            Route::get('get-users/find/{id}', 'UsersController@getUser');
            Route::get('company-branchs/find/{id}', 'UsersController@loadbyfindbranch');
            Route::get('company-branchs-fetch/find/{id}', 'UsersController@byfindbranchsftech');
            Route::get('create-object-company/find/{id}', 'UsersController@create_object_company');
            Route::get('company-object', 'UsersController@CompanyObj');
            Route::get('company-brnch/find/{id}', 'UsersController@loadcompanybranch');
            Route::get('GetPersonalClient', 'UsersController@GetClientToken');
            Route::get('/loaded-company-branch', 'UsersController@loaded_company_branch');
            Route::get('/loaded-uuid-company-branch/find/{id}', 'UsersController@load_uuid_company_branch');
            Route::post('users_mass_destroy', ['uses' => 'UsersController@massDestroy', 'as' => 'users.mass_destroy']);
        });
    });

    Route::group(['middlewareGroups' => ['web','verified','permission:developer|superusers|transport|warehouse|accounting']], function () {
        Route::middleware('permission:developer|superusers|transport|warehouse|accounting')
        ->namespace('Admin')
        ->group(function (){
            Route::get('load-company-for-super-user', 'UsersController@loadCompanyReleatedSuperuser');
            Route::get('load-company-branch-with-super-user/find/{id}', 'UsersController@LoadBranchwithcompanysuperuser');
        });
    });

    Route::group(['middlewareGroups' => ['web','CekOpenedTransaction','BlockedBeforeSettingUser','verified']], function () {
        Route::middleware('permission:developer|superusers|warehouse|accounting|transport')
        ->namespace('Company')
        ->group(function (){
            Route::resource('Companys', 'CompaniesController');
        });
    });

    Route::group(['middlewareGroups' => ['web','CekOpenedTransaction','BlockedBeforeSettingUser','verified','role:administrator|super_users']], function () {
        Route::middleware('permission:developer|superusers|warehouse|accounting|transport')
        ->namespace('Branch')
        ->group(function (){
            Route::resource('Branchs', 'BranchController');
            Route::get('load-company', 'BranchController@loaded_company_branch');
        });
    });

    Route::group(['middlewareGroups' => ['web','BlockedBeforeSettingUser','verified','permission:developer|transport|accounting|superusers']], function () {
        Route::middleware('permission:developer|transport|accounting|superusers')
        ->namespace('history_order')
        ->group(function (){
            Route::get('/history-list', 'OrderHistoryController@index');
            Route::get('/history-find-it-details/{id}', 'OrderHistoryController@find_show_detail_status');
            Route::get('/history-find-it-details-tc/{id}', 'OrderHistoryController@find_show_detail_status_transports');
            Route::get('/history-find-it-details-jobs/{id}', 'OrderHistoryController@find_show_detail_status_Jobs');
            Route::resource('history_orders', 'OrderHistoryController');
        });
    });
    
    Route::group(['middlewareGroups' => ['web','CekOpenedTransaction','BlockedBeforeSettingUser','verified','role:3PL SURABAYA ALL PERMISSION|3PL - BANDUNG TRANSPORT|3PL - SURABAYA WAREHOUSE|super_users|administrator']], function () {
        Route::middleware('role:3PL - SURABAYA WAREHOUSE|3PL - BANDUNG TRANSPORT|super_users|administrator|3PL SURABAYA ALL PERMISSION|administrator')
        ->namespace('vehicle')
        ->group(function (){
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/detail-data-vehicle/{id}/update-data-vehicle', 'VehicleController@show')->name('update.master.vehicle')->where('branch_id', '[0-9]+');
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/list-master-vehicle', 'VehicleController@index')->name('list.master.vehicle')->where('branch_id', '[0-9]+');
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/registration-vehicle', 'VehicleController@create')->name('registration.vehicle')->where('branch_id', '[0-9]+');
        });
    });

    Route::group(['middlewareGroups' => ['web','BlockedBeforeSettingUser','verified','role:super_users']], function () {
        Route::middleware('role:super_users')
        ->namespace('vehicle')
        ->group(function (){
            Route::resource('vehicle_accociate', 'VehicleController');
            Route::get('/vehicle-list-internal-list', 'VehicleController@internal_vehicle_loader');
            Route::get('/vehicle-list-internal-find/{id}', 'VehicleController@internal_vehicle_find_it');
            Route::get('/rest-api-customer-vendor', 'VehicleController@choosen_vehicle__INV');
        });
    });

    Route::group(['middlewareGroups' => ['csrf','web','CekOpenedTransaction','BlockedBeforeSettingUser','verified','permission:warehouse|accounting|transport|superusers|developer']], function () {
        Route::middleware('CekOpenedTransaction','BlockedBeforeSettingUser','permission:warehouse|accounting|transport|superusers|developer')
        ->namespace('API')
        ->group(function (){
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/API-integration/v1/async-integrator-3permata', 'integrationAPIController@index')->name('api.ui')->where('branch_id', '[0-9]+');
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/API-integration', 'AccurateCloudAPIController@index')->name('api.accurate.cloud.id')->where('branch_id', '[0-9]+');
            Route::get('/aol-oauth-callbacks', 'AccurateCloudAPIController@AuthorizedAccurate')->name('api.accurate.authorize')->where('branch_id', '[0-9]+');
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/API-activation', 'integrationAPIController@APIs_interactive')->name('APIs');
            Route::post('/dashboard/find-branch-with-branch/branch-id/{branch_id}/db-list.do', 'AccurateCloudAPIController@ShowDatabaseAccurateCloud')->name('db.list.do');
            Route::post('/dashboard/find-branch-with-branch/branch-id/{branch_id}/open-db.do', 'AccurateCloudAPIController@getSessionDBAccurateCloud')->name('open.db.do');
            Route::post('/dashboard/find-branch-with-branch/branch-id/{branch_id}/check-session-db.do', 'AccurateCloudAPIController@AccurateCloudSessionModules')->name('check.session.db.do');
            Route::post('/dashboard/find-branch-with-branch/branch-id/{branch_id}/item-save/save.do', 'AccurateCloudAPIController@WiritingDBAccurateCloud')->name('save.item.do');
            Route::post('/dashboard/find-branch-with-branch/branch-id/{branch_id}/item-list/list.do', 'AccurateCloudAPIController@ItemListDBAccurateCloud')->name('item.list.do');
            Route::post('/dashboard/find-branch-with-branch/branch-id/{branch_id}/api/customer/list.do', 'AccurateCloudAPIController@MasterCustomerDBAccurateCloud')->name('customer.list.do');
            Route::post('/dashboard/find-branch-with-branch/branch-id/{branch_id}/detail-item-list/datail.do', 'AccurateCloudAPIController@DetailItemListDBAccurateCloud')->name('detail.item.list.do');
            Route::post('/dashboard/find-branch-with-branch/branch-id/{branch_id}/api/customer/save.do', 'AccurateCloudAPIController@SaveCustomerDBAccurateCloud')->name('save.customer.do');
            Route::post('/dashboard/find-branch-with-branch/branch-id/{branch_id}/api/sales-order/save.do', 'AccurateCloudAPIController@SaveSalesOrderDBAccurateCloud')->name('save.sales.order.do');
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/API-unactive', 'integrationAPIController@APIs_unactive')->name('APIs_un');
        });
    });

    //modules integration transport order list
    Route::get('/authorization/accurate-db-list-transport-list', function (Request $request) {

        try {

            if(Auth::User()->oauth_token_third_party == []){


                $request->session()->put('state', $state = Str::random(40));

                        $s = http_build_query([
                            'client_id' => session()->get('client_id'),
                            'redirect_uri' => 'http://your-api.co.id/3ps-oauth-callback',
                            'response_type' => 'code',
                            'scope' => '3PL 3PE',
                            'state' => $state,
                        ]);
            
                    return redirect('https://your-third-party/oauth/authorize?'.$s);
           
            } 

            if(Auth::User()->date_die_at > Carbon::Now()->format('d-m-Y')){

                $client = new Client();

                $response = $client->get(
                        "https://account.accurate.id/api/db-list.do",
                        [
                            'headers' => [
                                            'Content-Type' => 'application/x-www-form-urlencoded',
                                            'Authorization' =>'Bearer '.Auth::User()->oauth_accurate_token,
                                            'Accept' => 'application/json'
                                        ],
                        ]
                    );

                $jsonArray = json_decode($response->getBody()->getContents(), true);

                $db_index = $jsonArray["d"];
                session(['AccountAccurate' => $db_index]);
                
                if($db_index == []){

                    Session::flash('alert-db-access-not-allowed', "jika aplikasi accurate masih baru, harap membuat database terlebih dahulu.");

                    // return redirect()->route('api.accurate.cloud.id', session()->get('id'));
                    return redirect()->route('dashboard');


                }

                $user = \warehouse\User::findOrFail(Auth::User()->id);
                $user->oauth_accurate_db_list = $db_index;
                $fileDB = $user->oauth_accurate_db_list;
                $user->update();
                
                foreach($fileDB as $dataDB){
                    $list[] = $dataDB['id'];
                    $company[] = $dataDB['alias'];
                }

                session(['sessionID_accurate' => $list]);

                Session::flash('alert-success-db-accurate-index', implode(', ', $company) );

            return redirect()->route('transport.static', session()->get('id'));

        } 
            else {

                    Session::flash('alert-oauth-sso-expired-token', "Token has been expired or you can ask developer help.");

                    $user = \warehouse\User::findOrFail(Auth::User()->id);
                    $user->oauth_accurate_db_list = NULL;
                    $user->oauth_token_third_party = NULL;
                    $user->expires_in = NULL;
                    $user->date_die_at = NULL;
                    $user->refresh_token = NULL;
                    $user->oauth_accurate_token = NULL;
                    $user->update();
                 
                    // return redirect()->route('api.accurate.cloud.id', session()->get('id'));
                    return redirect()->route('dashboard');


                }
        
        } 
                catch (\GuzzleHttp\Exception\ClientException $e) {

                    Session::flash('alert-db-access-denied', json_decode($e->getResponse()->getBody()->getContents(), JSON_PRETTY_PRINT)['error']);

                // return redirect()->route('api.accurate.cloud.id', session()->get('id'));
                return redirect()->route('dashboard');


        }

    });

    //accurate integration modules
    Route::get('/authorization/accurate-db-list', function (Request $request) {

        $InterfaceRepository = app(AccuratecloudInterface::class)->FuncOpenmoduleAccurateCloudUsersBranchId();

        $branchAccruateId = $InterfaceRepository['d'][0]['id']; //Surabaya
        $branchAccruateIdJKT = $InterfaceRepository['d'][1]['id']; //Jakarta
        $branchAccruateIdKPG = $InterfaceRepository['d'][2]['id']; //Kupang
        $branchAccruateIdLodi = $InterfaceRepository['d'][3]['id']; //Lodi
        $branchAccruateIdSMG = $InterfaceRepository['d'][4]['id']; //Semarang
        $branchAccruateIdPusat = $InterfaceRepository['d'][5]['id']; //Pusat
        session(['UserMultiBranchAccurate' => $branchAccruateId]);
        session(['UserMultiBranchAccurateJKT' => $branchAccruateIdJKT]);
        session(['UserMultiBranchAccurateKPG' => $branchAccruateIdKPG]);
        session(['UserMultiBranchAccurateSMG' => $branchAccruateIdSMG]);
        session(['UserMultiBranchAccuratePusat' => $branchAccruateIdPusat]);
        session(['UserMultiBranchAccurateLodi' => $branchAccruateIdLodi]);

        try {

            if(Auth::User()->oauth_token_third_party == []){


                $request->session()->put('state', $state = Str::random(40));

                        $s = http_build_query([
                            'client_id' => session()->get('client_id'),
                            'redirect_uri' => 'http://your-api.co.id/3ps-oauth-callback',
                            'response_type' => 'code',
                            'scope' => '3PL 3PE',
                            'state' => $state,
                        ]);
            
                    return redirect('https://your-third-party/oauth/authorize?'.$s);
           
            } 

            if(Auth::User()->date_die_at < Carbon::Now()->format('d-m-Y')){

                $client = new Client();

                $response = $client->get(
                        "https://account.accurate.id/api/db-list.do",
                        [
                            'headers' => [
                                            'Content-Type' => 'application/x-www-form-urlencoded',
                                            'Authorization' =>'Bearer '.Auth::User()->oauth_accurate_token,
                                            'Accept' => 'application/json'
                                        ],
                        ]
                    );

                $jsonArray = json_decode($response->getBody()->getContents(), true);

                $db_index = $jsonArray["d"];
                session(['AccountAccurate' => $db_index]);
                
                if($db_index == []){

                    Session::flash('alert-db-access-not-allowed', "jika aplikasi accurate masih baru, harap membuat database terlebih dahulu.");

                    // return redirect()->route('api.accurate.cloud.id', session()->get('id'));
                    return redirect()->route('dashboard');

                }

                $user = \warehouse\User::findOrFail(Auth::User()->id);
                $user->oauth_accurate_db_list = $db_index;
                $fileDB = $user->oauth_accurate_db_list;
                $user->update();
                
                foreach($fileDB as $dataDB){
                    $list[] = $dataDB['id'];
                    $company[] = $dataDB['alias'];
                }

                session(['sessionID_accurate' => $list]);

                if(session()->get('id') == "41"){ //3PE
                    $user = User::findOrFail(Auth::User()->id);
                    $user->update([
                        'oauth_accurate_company' => session('sessionID_accurate')[1], //3PE
                        'oauth_accurate_branch' =>session('UserMultiBranchAccurate')
                    ]);
                }
        
                if(session()->get('id') == "42"){
                    $user = User::findOrFail(Auth::User()->id);
                    $user->update([
                        'oauth_accurate_company' => session('sessionID_accurate')[0], //3PL
                        'oauth_accurate_branch' =>session('UserMultiBranchAccurate')
                    ]);
                }   
        
                #GATE Surabaya
                /**
                 * branch company id : 43 === 3PL
                 */
                if(session()->get('id')  == "43"){ 
                    $user = User::findOrFail(Auth::User()->id);
                    $user->update([
                        'oauth_accurate_company' => session('sessionID_accurate')[0], //3PL
                        'oauth_accurate_branch' =>session('UserMultiBranchAccurateJKT')
                    ]);
                }
        
                 /**
                 * branch company id : 44 === 3PE
                 */
                if(session()->get('id')  == "44"){
                    $user = User::findOrFail(Auth::User()->id);
                    $user->update([
                        'oauth_accurate_company' => session('sessionID_accurate')[1], //3PE
                        'oauth_accurate_branch' =>session('UserMultiBranchAccurateJKT')
                    ]);
                }
                ################
        
                #GATE Kupang
                 /**
                 * branch company id : 45 === 3PE
                 */
                if(session()->get('id')  == "45"){
                    $user = User::findOrFail(Auth::User()->id);
                    $user->update([
                        'oauth_accurate_company' => session('sessionID_accurate')[1], //3PE
                        'oauth_accurate_branch' =>session('UserMultiBranchAccurateKPG')
                    ]);
                }
        
                 /**
                 * branch company id : 46 === 3PL
                 */
                if(session()->get('id') == "46"){
                    $user = User::findOrFail(Auth::User()->id);
                    $user->update([
                        'oauth_accurate_company' => session('sessionID_accurate')[0], //3PL
                        'oauth_accurate_branch' =>session('UserMultiBranchAccurateKPG')
                    ]);
                }
                ################
        
                #GATE Lodi
                 /**
                 * branch company id : 47 === 3PL
                 */
                if(session()->get('id') == "53"){ //3PE
                    $user = User::findOrFail(Auth::User()->id);
                    $user->update([
                        'oauth_accurate_company' => session('sessionID_accurate')[1], //3PL
                        'oauth_accurate_branch' =>session('UserMultiBranchAccurateLodi')
                    ]);
                }
        
                 /**
                 * branch company id : 48 === 3PE
                 */
                if(session()->get('id') == "54"){ //3PL
                    $user = User::findOrFail(Auth::User()->id);
                    $user->update([
                        'oauth_accurate_company' => session('sessionID_accurate')[0], //3PE
                        'oauth_accurate_branch' =>session('UserMultiBranchAccurateLodi')
                    ]);
                }
                ################
        
                #GATE Semarang
                 /**
                 * branch company id : 49 === 3PE
                 */
                if(session()->get('id') == "49"){ 
                    $user = User::findOrFail(Auth::User()->id);
                    $user->update([
                        'oauth_accurate_company' => session('sessionID_accurate')[1], //3PE
                        'oauth_accurate_branch' =>session('UserMultiBranchAccurateSMG')
                    ]);
                }
        
                 /**
                 * branch company id : 50 === 3PL
                 */
                if(session()->get('id') == "50"){ 
                    $user = User::findOrFail(Auth::User()->id);
                    $user->update([
                        'oauth_accurate_company' => session('sessionID_accurate')[0], //3PL
                        'oauth_accurate_branch' =>session('UserMultiBranchAccurateSMG')
                    ]);
                }
                ################
        
                #GATE Pusat
                 /**
                 * branch company id : 51 === 3PL
                 */
                if(session()->get('id') == "51"){
                    $user = User::findOrFail(Auth::User()->id);
                    $user->update([
                        'oauth_accurate_company' => session('sessionID_accurate')[0], //3PL
                        'oauth_accurate_branch' =>session('UserMultiBranchAccuratePusat')
                    ]);
                }
        
                 /**
                 * branch company id : 52 === 3PE
                 */
                if(session()->get('id') == "52"){ 
                    $user = User::findOrFail(Auth::User()->id);
                    $user->update([
                        'oauth_accurate_company' => session('sessionID_accurate')[1], //3PE
                        'oauth_accurate_branch' =>session('UserMultiBranchAccuratePusat')
                    ]);
                }
                ################

                Session::flash('alert-success-db-accurate-index', implode(', ', $company) );

                // return redirect()->route('api.accurate.cloud.id', session()->get('id'));
                return redirect()->route('dashboard');


        } 
            else {

                    Session::flash('alert-oauth-sso-expired-token', "Token has been expired or you can ask developer help.");

                    $user = \warehouse\User::findOrFail(Auth::User()->id);
                    $user->oauth_accurate_db_list = NULL;
                    $user->oauth_token_third_party = NULL;
                    $user->expires_in = NULL;
                    $user->date_die_at = NULL;
                    $user->refresh_token = NULL;
                    $user->oauth_accurate_token = NULL;
                    $user->update();
                 
                    // return redirect()->route('api.accurate.cloud.id', session()->get('id'));
                    return redirect()->route('dashboard');


                }
        
        } 
                catch (\GuzzleHttp\Exception\ClientException $e) {

                    Session::flash('alert-db-access-denied', json_decode($e->getResponse()->getBody()->getContents(), JSON_PRETTY_PRINT)['error']);

                // return redirect()->route('api.accurate.cloud.id', session()->get('id'));
                return redirect()->route('dashboard');


        }

    });

    Route::post('/authorization/accurate-account', function (Request $request) {

         try 
            {

            // if(Auth::User()->date_die_at > Carbon::Now()->format('d-m-Y')){
            //     dd(Auth::User()->date_die_at, Carbon::Now()->format('d-m-Y'));
            // } else {
            //     return "A";
            // }die;

                // dd(Auth::User()->date_die_at);
            if(Auth::User()->oauth_token_third_party == []){

                $request->session()->put('state', $state = Str::random(40));

                        $s = http_build_query([
                            'client_id' => session()->get('client_id'),
                            'redirect_uri' => 'http://your-api.co.id/3ps-oauth-callback',
                            'response_type' => 'code',
                            'scope' => '3PL 3PE',
                            'state' => $state,
                        ]);
            
                    return redirect('https://your-third-party/oauth/authorize?'.$s);
           
            } 

            if(Auth::User()->date_die_at < Carbon::Now()->format('d-m-Y')){

                 $loop = Factory::create();

                 $handler = new CurlMultiHandler();
                 $timer = $loop->addPeriodicTimer(1, \Closure::bind(function () use (&$timer) {
                         $this->tick();
                         if (empty($this->handles) && \GuzzleHttp\Promise\queue()->isEmpty()) {
                             $timer->cancel();
                         }
                     }, $handler, $handler)
                 );

                     $client = new Client(['handler' => HandlerStack::create($handler)]);
                     $response = $client->post(
                             'https://your-third-party/api/authorize-account',
                             [
                                 'headers' => [
                                        'Authorization' => 'Bearer '.Auth::User()->oauth_token_third_party,
                                        'Accept' => 'application/json'
                                     ],
                             ]
                     );
                
                $loop->run();
                
                Promise\settle($response)->wait(true);
                $data = json_decode($response->getBody(), true)['message'];

                session(['client_accurate_id' => $request->accurate_client_id]);

                 if($data == "berhasil diverifikasi") {
                     $response = $client->post(
                         'https://your-third-party/api/oauth-server-accurate',
                         [
                             'headers' => [
                                 'Authorization' => 'Bearer '.Auth::User()->oauth_token_third_party,
                                     'Accept' => 'application/json'
                                 ],
                                 'form_params' => [
                                     'client_id' => $request->accurate_client_id,
                                     'redirect_uri' => $request->redirect_uri,
                                     'response_type' => $request->response_type,
                                     'scope' => $request->scope
                                 ],
                         ]
                 );

                 
                 $payload_access_token = json_decode($response->getBody(), true )['build_query'];
                 $url_schema = parse_url($payload_access_token['redirect_uri']);

                     if(isset($url_schema['scheme'])) {

                                 $Parameters = http_build_query([
                                     'client_id' => $payload_access_token['client_id'],
                                     'redirect_uri' => $url_schema['scheme']."://".$url_schema['host']."/aol-oauth-callback",
                                     'response_type' => $payload_access_token['response_type'],
                                     'scope' => $payload_access_token['scope']
                                 ]);
                             
                             return redirect('https://account.accurate.id/oauth/authorize?'.$Parameters);
                     
                         } 
                             else {

                                //  return redirect()->route('api.accurate.cloud.id', session()->get('id'))->with('redirect_url_not_found', 
                                //  "redirect_uri can't found on server, please check credentials on accurate.");
                                 return redirect()->route('dashboard')->with('redirect_url_not_found', 
                                 "redirect_uri can't found on server, please check credentials on accurate.");
                                 
                         }

                     } 
                         else {
                         
                            //  return redirect()->route('api.accurate.cloud.id', session()->get('id'))->with('oauth_verify', 
                            //  "Sorry you can't access this application.");

                             return redirect()->route('dashboard')->with('oauth_verify', 
                             "Sorry you can't access this applications.");

                 }

            } 
                else {

                    $user = \warehouse\User::findOrFail(Auth::User()->id);
                    $user->oauth_accurate_db_list = NULL;
                    $user->oauth_token_third_party = NULL;
                    $user->expires_in = NULL;
                    $user->date_die_at = NULL;
                    $user->refresh_token = NULL;
                    $user->oauth_accurate_token = NULL;
                    $user->update();
    
                    // return redirect()->route('api.accurate.cloud.id', session()->get('id'))->with('TokenExpiredEventAccessAccurate', 
                    // "Sorry you can't access, because token has been expired, ask developer to help you.");

                    return redirect()->route('dashboard')->with('TokenExpiredEventAccessAccurate', 
                    "Sorry you can't access, because token has been expired, ask developer to help you.");

                }

            } 
                catch (\GuzzleHttp\Exception\ClientException $e) {

                    // dd(json_decode($e->getResponse()->getBody()->getContents(), JSON_PRETTY_PRINT));
                    Session::flash('alert-oauth-access-denied', json_decode($e->getResponse()->getBody()->getContents(), JSON_PRETTY_PRINT)['error']);

                // return redirect()->route('api.accurate.cloud.id', session()->get('id'));
                return redirect()->route('dashboard');


        }

    });

    Route::post('/authorization/token', function (Request $request) {
        
        session(['client_id'=> $request->client_id, 'client_sc' => $request->client_sc]);

    try 
        {

            if(Auth::User()->oauth_token_third_party == []){

                $request->session()->put('state', $state = Str::random(40));

                        $s = http_build_query([
                            'client_id' => session()->get('client_id'),
                            'redirect_uri' => 'http://your-api.co.id/3ps-oauth-callback',
                            'response_type' => 'code',
                            'scope' => '3PL 3PE',
                            'state' => $state,
                        ]);
            
                    return redirect('https://your-third-party/oauth/authorize?'.$s);
           
            } 

            if(Auth::User()->date_die_at > Carbon::Now()->format('d-m-Y')){

                $request->session()->put('state', $state = Str::random(40));

                $s = http_build_query([
                    'client_id' => session()->get('client_id'),
                    'redirect_uri' => 'http://your-api.co.id/3ps-oauth-callback',
                    'response_type' => 'code',
                    'scope' => '3PL 3PE',
                    'state' => $state,
                ]);
    
            return redirect('https://your-third-party/oauth/authorize?'.$s);

        }

            else {

                Session::flash('alert-oauth-sso-already-exists', 'Token has been expired');

                return redirect()->route('dashboard');
                // return redirect()->route('api.accurate.cloud.id', session()->get('id'));
                    
                }

            } catch (\GuzzleHttp\Exception\ClientException $e) {
                    
                Session::flash('alert-oauth-sso-invalid_client', json_decode($e->getResponse()->getBody()->getContents(), JSON_PRETTY_PRINT)['error_description']);

            // return redirect()->route('api.accurate.cloud.id', session()->get('id'));
                return redirect()->route('dashboard');

        }
        
    });

    Route::get('/3ps-oauth-callback', function (Request $request) {

        try {

            $state = $request->session()->pull('state');
            
            throw_unless(
                strlen($state) > 0 && $state === $request->state,
                InvalidArgumentException::class
            );
        
            $http = new Client();
            
                $response = $http->post('https://your-third-party/oauth/token', [
                    'form_params' => [
                        'grant_type' => 'authorization_code',
                        'client_id' => session()->get('client_id'),
                        'client_secret' => session()->get('client_sc'),
                        'redirect_uri' => 'http://your-api.co.id/3ps-oauth-callback',
                        'code' => $request->code,
                    ],
                ]);
                    
                $payload_access_token = json_decode((string) $response->getBody(), true)['access_token'];
                $refresh_token = json_decode((string) $response->getBody(), true)['refresh_token'];
                $expiredOn = json_decode((string) $response->getBody(), true)['expires_in'];

                $prs = Carbon::now()->addSecond($expiredOn);
                $dt_old = Carbon::now();
                $days = $prs->diffInDays($dt_old);
                
                $user = \warehouse\User::findOrFail(Auth::User()->id);
                $user->oauth_token_third_party = $payload_access_token;
                $user->refresh_token = $refresh_token;
                $user->expires_in = $expiredOn;
                $user->date_die_at = Now()->addDays($days)->format('d-m-Y');
                $user->update();
                
                Session::flash('alert-success', "Access token berhasil disimpan, Token anda berakhir pada tanggal : ".$user->date_die_at);

                // return redirect()->route('api.accurate.cloud.id', session()->get('id'));
                return redirect()->route('dashboard');


            } catch (\GuzzleHttp\Exception\ClientException $e) {

                Session::flash('alert-invalid-parameter', json_decode($e->getResponse()->getBody()->getContents(), JSON_PRETTY_PRINT)['error_description']);

                // return redirect()->route('api.accurate.cloud.id', session()->get('id'));
                return redirect()->route('dashboard');


        }

    });

    Route::get('/aol-oauth-callback', function (Request $request) {
    
    $credentials = base64_encode(session()->get('client_accurate_id').':this your client secret on accurate');
        try
            {
                $client = new Client();
                        $response = $client->post('https://account.accurate.id/oauth/token',
                        [  'headers' => [
                                'Content-Type' => 'application/x-www-form-urlencoded',
                                'Authorization' =>'Basic '.$credentials,
                                'Accept' => 'application/json'
                        ],
                        
                            'form_params' => [
                                'code' => $request->code,
                                'grant_type' => 'authorization_code',
                                'redirect_uri' => 'http://your-api.co.id/aol-oauth-callback',
                            ]
                        ]
                    );
                    $access_token = json_decode($response->getBody(), true, JSON_PRETTY_PRINT)['access_token'];
                $user = \warehouse\User::findOrFail(Auth::User()->id);
                $user->oauth_accurate_token = $access_token;
                $user->update();
                
                Session::flash('oauth_verify', $access_token);

                return redirect()->route('dashboard');
                // return redirect()->route('api.accurate.cloud.id', session()->get('id'));
                
            } catch (\GuzzleHttp\Exception\ClientException $e) {

                Session::flash('alert-danger', json_decode($e->getResponse()->getBody()->getContents(), JSON_PRETTY_PRINT)['error_description']);

            // return redirect()->route('api.accurate.cloud.id', session()->get('id'));
            return redirect()->route('dashboard');


        }
    });

    Route::group(['middlewareGroups' => ['json.response']], function () {
        Route::middleware('json.response')
        ->namespace('Services')
        ->group(function (){
            Route::get('/3PS-received-webhooks/{response}/{shipment_code}', 'IzzyTransportModules@ProcessingResponse');
            Route::get('/re-sync-accurate-cloud/{shipment_code}', 'IzzyTransportModules@ReSyncAccurate');
            Route::get('/re-sync--delivery-accurate-cloud/{shipment_code}', 'IzzyTransportModules@ReSyncAccurateDelivery');

        });
    });

    Route::get('/izzy-webhooks', function (Request $request) {
        session(['webhook' => $request->all()]);
        event(new WebhookEventsProd($request->all()));
    });

    Route::group(['middlewareGroups' => ['web','CekOpenedTransaction','BlockedBeforeSettingUser','verified','role:3PL SURABAYA ALL PERMISSION|3PL[SPV]|3PE[SPV]|3PL[DRIVERS]|3PE[DRIVERS]|3PL[OPRASONAL][KASIR]|3PE[OPRASONAL][KASIR]|administrator|super_users']], function () {
        Route::middleware('role:3PL[SPV]|3PE[SPV]|3PL[DRIVERS]|3PE[DRIVERS]|3PL[OPRASONAL][KASIR]|3PE[OPRASONAL][KASIR]|administrator|super_users|3PL SURABAYA ALL PERMISSION')
        ->namespace('Cash_advanced')
        ->group(function (){
            Route::resource('cash_advanced', 'CashadvancedController');
            Route::get('/cash-advanced-list/branchs-id/{branch_id}/master-cashbon', 'CashadvancedController@index')->name('cashadvanced.list')->where('branch_id', '[0-9]+');
            Route::get('/load-drivers-names', 'CashadvancedController@load_data_all_drivers');
            Route::get('/add-cash-advanced-r', 'CashadvancedController@add_cash_advanced');
            Route::get('/add-cash-advanced-transaction-inside', 'CashadvancedController@add_cash_advanced_transaction');
            Route::get('/add-cash-of-drivers', 'CashadvancedController@add_detail_drivers_of_cash');
            Route::get('/load-cost-cateogys-find', 'CashadvancedController@loads_categorys_cost');
            Route::get('/load-job-shipment-find', 'CashadvancedController@loads_jobshipments');
            Route::get('/load-status-cash-master/{id}', 'CashadvancedController@search_status_cash_master'); //find sattsu master advanced
            Route::get('/updated-status-cash-advanced/{id}', 'CashadvancedController@find_show_cash_advanced_index'); //find cash advanced
            Route::get('/update-status-ca/find/{id}/before/{idx}', 'CashadvancedController@updated_status_cash_advc_rpt'); //update status cash advanced
            Route::get('/find-cash-advanced-transaction-reports/id/{jobid}', 'CashadvancedController@search_cash_advanced');
        });
    });

    Route::group(['middlewareGroups' => ['web','CekOpenedTransaction','BlockedBeforeSettingUser']], function () {
        Route::middleware('verified')
        ->namespace('transport')
        ->group(function (){
                Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/viewDetailItemcustomer/{ItemId}','TransportController@__viewItemCustomer')->name('view.data.item.customer');
                Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/create-order-transport','TransportController@create')->name('transport.create.order');
                Route::get('/dashboard/find-branch-with-branch/branch-id/{id}/list-order-transport','TransportController@index')->name('transport.static');
                Route::get('/dashboard/find-branch-with-branch/branch-id/{id}/testlist','TransportController@me')->name('transports');
                Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/detail-transaction/{id}/edit-order-transaction','TransportController@show')->name('transport.show.detail.transaction');
                Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/surat-jalan/order-id/shipment-id/{id}','TransportController@report_transport')->name('shipment.surat.jalan');
                Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/transport-list-daterange','TransportController@display_date_range')->name('display.rate');
                Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/saved-order-transport','TransportController@savedTransports')->name('transport.stored.static');
            });
    });
    
    Route::group(['middlewareGroups' => ['web','BlockedBeforeSettingUser']], function () {
        // Route::middleware('permission:transport|accounting|developer|superusers')
        Route::middleware('verified')
        ->namespace('transport')
        ->group(function (){
            Route::get('/transports/updated-detail-transaction/{id}','TransportController@updateSyncTransports')->name('transport.updated.detail');
            Route::get('/list_cs_transports/find/{id}', 'TransportController@someone_cs');
            Route::get('/save-item-customer-ajax/saved', 'TransportController@add_item_ajax');
            
            Route::post('/dashboard/find-branch-with-branch/branch-id/{branch_id}/save-item-customer-ajax/saved','TransportController@add_item_ajax')->name('save.item.accurate.customer');
            Route::post('/dashboard/find-branch-with-branch/branch-id/{branch_id}/save-item-vendor-ajax/saved','TransportController@add_item_vendors')->name('save.item.accurate.vendor');

            Route::get('/load-sub-service-ex-md/find/{id}', 'TransportController@sub_service_exc_moda');
            Route::get('/rest-api-units', 'TransportController@choosen_unit_tc');
            Route::get('/cari_customers_transport/find', 'TransportController@cari_customers');
            Route::get('/cari_regions_transport/find', 'TransportController@search_region');
            Route::post('/master-accourate-cloud', 'TransportController@MascustomerCloud');
            Route::post('/find-id-customer-accourate-cloud', 'TransportController@findMasterCloudAccurate');
            Route::get('/get-id-customer-accourate-cloud/{id}', 'TransportController@getIDCusomterCloud');
            Route::get('/cari_customers_transport/find/{id}', 'TransportController@cari_customers_by_id');
            Route::get('/list_transport/find/{id}', 'TransportController@search_by_sub_service');
            Route::get('/list-by-sub-services-price/find/{id}', 'TransportController@search_id_by_sb_service_price');
            Route::get('/load_address_books_with_customers/find/{id}','TransportController@load_address_book_with_customers');
            Route::get('/load_address_books_with_customersx/find/{id}','TransportController@load_address_book_with_customersx');
            Route::get('/load_address_books/find/{id}','TransportController@load_address_book');
            Route::get('/load_item_transport/find','TransportController@load_item_transport');
            Route::get('/load_address_book/find/{id}','TransportController@address_common');
            Route::post('/save-address-book-form-transport','TransportController@saveAddressBookForms');
            Route::get('/search/list_customers_transports/{id}', 'TransportController@something');
            Route::get('/search/list_customers_transports-icl/{id}', 'TransportController@include_customers');
            Route::get('/load-city/find','TransportController@load_city');
            Route::resource('transport','TransportController');
            Route::get('/load-city/find/{id}','TransportController@load_city_by_id');
            Route::get('/cari_subservice/find', 'TransportController@cari_subservice');
            Route::get('/cari_subservice_without_customers/find/{id}/origin/{origin}/destination/{destination}', 'TransportController@search_by_customers');
            Route::get('/load-sub-item-transport-on-load/find/{id}', 'TransportController@searchonLoadItemTransport');
            Route::get('/search_by_items_tcss/find/{id}', 'TransportController@search_by_items_tcs');
            Route::get('/search_by_origin_item_transport/find/{id}', 'TransportController@address_by_item_transport');
            Route::get('/search_item_by_items_with_origin/find/{id}', 'TransportController@serch_item_tcs_with_saved_origin');
            Route::get('/search_address_book_with_customers/find/{id}', 'TransportController@address_book_with_customer_id');
            Route::get('/search_by_customers_with_origin_destinations/find/{id}/sb/{sb_services}/origin/{origin}/destination/{destination}','TransportController@search_by_customers_with_origin_destination');
            // Route::get('/search_by_customers_with_origin_destinations/find/{id}/sb/{sb_services}/origin/{origin}/destination/{destination}','TransportController@search_by_customers_with_origin_destination');
            Route::get('/search_by_value_selected_origin/find/{origin_id}/customerid/{customer_id}','TransportController@search_if_selected_value_origin');
            Route::get('/search_by_value_selected_destination/find/{destination_id}/customerid/{customer_id}','TransportController@search_if_selected_value_destination');
        });
    });


    Route::group(['middlewareGroups' => ['web','CekOpenedTransaction','BlockedBeforeSettingUser','verified','permission:developer|accounting|superusers|transport|warehouse']], function ()
    {
        Route::middleware('permission:developer|superusers|transport|warehouse|accounting')
            ->namespace('accurate')
            ->group(function ()
                {
                    Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/testingGetDBaccurate', 'AccurateController@index')->where('branch_id', '[0-9]+');
                    Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/SO', 'AccurateController@getSOnumber')->where('branch_id', '[0-9]+');
                    Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/BRG', 'AccurateController@__getBarangJasa')->where('branch_id', '[0-9]+');
                    Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/SQ', 'AccurateController@getSQNUMBER')->where('branch_id', '[0-9]+');
                    Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/xml/{index_order_id}/xml-result', 'AccurateController@xml_perfiles')->name('exports.perfiles.whs.list')->where('branch_id', '[0-9]+');
                    Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/list-order-for-accounting-view-warehouse', 'AccurateController@table_warehouse_order')->name('accwhs.static')->where('branch_id', '[0-9]+');
                    Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/list-order-for-accounting-view-transport', 'AccurateController@table_transport_order')->name('acctc.static')->where('branch_id', '[0-9]+');
                    Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/detail-data-order-xml/{id}/xml-file', 'AccurateController@show_it_isi_xml')->name('show_it_xml_order_list');
                    Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/list-order-for-accounting','AccurateController@table_exports')->name('exports.static')->where('branch_id', '[0-9]+');
                    Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/storage-path-download/{id}/download-file-xml', 'AccurateController@download_exports')->name('storage_path_download');
                    Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/export-warehouse-order', 'AccurateController@xml_files')->name('xml.files.http.only')->where('branch_id', '[0-9]+');
                    Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/export-list', 'AccurateController@xml_files_transport')->name('exports.tc.list')->where('branch_id', '[0-9]+');
                    Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/xml-export-perfiles/{index_transport_id}/accurate-transports', 'AccurateController@xml_perfiles_transport__')->name('xlsx_tc')->where('branch_id', '[0-9]+');
                    Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/warehouse-daterange-accounting','AccurateController@display_date_range_with_accounting')->name('display.whys')->where('branch_id', '[0-9]+');
                    Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/transport-list-daterange-accounting','AccurateController@display_date_range_with_accounting_transport')->name('display.trans')->where('branch_id', '[0-9]+');
                }
            );
        }
    );

     Route::group(['middlewareGroups' => ['web','BlockedBeforeSettingUser','verified','permission:developer|accounting|superusers|transport|warehouse']], function ()
    {
        Route::middleware('permission:developer|superusers|transport|warehouse|accounting')
            ->namespace('accurate')
            ->group(function ()
                {
                    Route::get('/exports_files','AccurateController@table_exports');
                    Route::get('/send/xlsx', 'AccurateController@export');
                    Route::get('/get-val-status-shipments-find/shipment/{idx}', 'AccurateController@getvalstatusshipment');
                    Route::get('/updated-status-order/{idwhs}/xml-file-id={index}', 'AccurateController@updated_status_order_idasdasdx');
                    Route::get('/updated-status-order-tc/{index}', 'AccurateController@updated_status_order_idx_tc');
                    Route::get('/load-status-order-warehouse-perfiles/{odpz}', 'AccurateController@loadDataStatusListOrderWarehouseAccounting');
                    Route::get('/load-status-order-transport-perfiles/{id_xml}', 'AccurateController@LoadDataStatusTransportAccounting');
                    Route::get('/load-status-tc-tbl-files/{id_xml}', 'AccurateController@LoadStatusFTC');
                    Route::get('/updated-status-name-order-whs-ops/{id}', 'AccurateController@find_show_status_order_3pl_whs_ops');
                    Route::get('/load-status-order-warehouse/{id_order}', 'AccurateController@LoadDataStatus');
                    Route::get('/updated-status-name-order/{id}', 'AccurateController@find_show_status_order');
                    Route::get('/updated-status-name-order-transports-accounting/{id}', 'AccurateController@findShowStatusOrderTransport');
                    Route::get('/updated-status-name-order-tc/{id}', 'AccurateController@find_show_transport_idx');
                    Route::get('/updated-status-order/{index}', 'AccurateController@updated_status_order_idx');
                    Route::get('/updated-transport-status-order/{index}', 'AccurateController@updateStatusTransportOrders');
                    Route::get('/updated-transport-tc-status/{index}/{status}', 'AccurateController@updateStatusTC');
                    Route::get('/find-id-transport-show-status/{id}', 'AccurateController@findIdSt');
                }
            );
        }
    );

    Route::group(['middlewareGroups' => ['web','verified','administrator']], function () {
            Route::get('/down', function() {
                Artisan::call('view:clear');
                return "(Y)";
            });
    });

    Route::group(['middlewareGroups' => ['web','BlockedBeforeSettingUser','verified']], function ()
    {
        Route::middleware('BlockedBeforeSettingUser','permission:developer|superusers|transport')
            ->namespace('Jobs')
            ->group(function ()
                {
                    Route::resource('jobs','JobsController');
                    Route::get('/showing-status-shipment/find/{idjob}', 'JobsController@showing_dynamic_status_shipment');
                    Route::get('/download-path-file-shipment/{id}/requestFILE/{requestID}', 'JobsController@download_file_shipment_id')->name('redirect.download.file')->where('id', '[0-9]+');
                    Route::get('/show-jobs-shipment-api-gdrive-v1/{job_no}', 'JobsController@list_gdrive_job_shipment')->where('job_no', '[0-9]+')->name('list.job.gdrive');
                    Route::get('/status-find-job-shipment/{id}', 'JobsController@find_status_jobs_shipment_idx');
                    Route::get('/status-find-transport-order-id-only/find/{job_shipment_order}', 'JobsController@search_id_is_draft_only');
                    Route::get('/get-equivalent-shipment-id', 'JobsController@add_shipment_id');
                    Route::get('/count-result-job-shipments/job-order/{job_id}/{col}/{vol}/{aw}', 'JobsController@UpdateTotalResultJobs');
                    Route::get('/reduce-result-job-shipments/job-order/{job_id}/{col}/{vol}/{aw}', 'JobsController@ReduceTotalResultJobs');
                    Route::get('/update-status-order-id/{id}', 'JobsController@update_status_transport_order_idx');
                    Route::get('/status-find-job-transport-slug/{id}', 'JobsController@find_status_jobs_shipment_with_transport_shipment_id');
                    Route::get('/updated-status-job-shipment/{index}', 'JobsController@update_status_job_shipment');
                    Route::get('/updated-status-transport-order-id/{index}', 'JobsController@update_status_transport_order_idx');
                    Route::get('/load_job_shipment/find/{id}','JobsController@load_uuid_job_shipment');
                    Route::get('/load_uuid_job_shipment_selected/find{id?}','JobsController@load_uuid_job_shipment_selected');
                    Route::get('/load_uuid_job_try_load/find{notid?}','JobsController@load_uuid_job_shipment_try_load');
                    Route::get('/job-show-eq/find/{permid}','JobsController@update_jcosts');
                    Route::post('/upload-file-shipment-id','JobsController@update_file_upload_shipment');
                    Route::get('/loaded-jobs-forloads-cost-category/find/','JobsController@loads_categorys_cost');
                    Route::get('/loaded-jobs-forloads-cost-category-of-cost/find/','JobsController@loads_categorys_cost_of_cost');
                    Route::get('/loaded-jobs-forloads-cost-category/find-it-with-fk/{id}','JobsController@loads_categorys_cost_with_fk');
                    Route::get('/loaded-vendor-item-transports/find/{id}','JobsController@loaded_vendor_item_transport_idx');
                    Route::get('/loaded-vendor-item-transports-with-vitem/find/{id}','JobsController@loaded_vendor_item_transportx');
                    Route::get('/jobs-list','JobsController@index');
                    Route::get('/shipment-filename/google-api/v3/{requestID}','JobsController@getpreviewsFilesGrive')->name('redirect.preview.filename')->where('id', '[0-9]+');
                    Route::get('/google-drive-file-list/{shipments}/find-file/{folderfile}','JobsController@guglesFileList');
                    Route::get('/datarealshipments/json/{id}','JobsController@load_json');
                    Route::get('/load-shipment-find/encode/{id}','JobsController@load_shipments_encode');
                    Route::get('/move-shipment/find/{shipment_index}','JobsController@move_shipment_ENV');
                    Route::get('/update-movements/find','JobsController@update_movements');
                    Route::get('/move-shipment-already-exists-movements/find','JobsController@sort_shipment_already_exists');
                    Route::get('/move-shipment-stop/find/{shipment_index}','JobsController@move_shipment_stopping_ENV');
                    Route::get('/jobs/{jobshipment}/deleted/{id}/details','JobsController@soft_deleting_cost')->name('deleting.details');
                    Route::get('/loaded-vendor/find','JobsController@vendor_jobs_loader');
                    Route::get('/get-code-job-shipment-equivalent','JobsController@add_data_job_cost_without_code_job_shipment');
                    Route::get('/get-transaction-details','JobsController@updated_jobtdetail_with_jobcosts_without_job_transport');
                    Route::get('/get-data-jobs-costs-details/findit/{cost_id}','JobsController@show_data_job_costs')->name('showing.data_job_costs');
                    Route::get('/get-job-shipment-job-costs-equivalent','JobsController@data_job_shipment_and_data_job_cost');
                    Route::get('/get-job-shipment-job-costs-equivalent-merged','JobsController@data_job_shipment_and_data_job_cost_merge_function');
                    Route::get('/get-job-shipment-job-costs-equivalent-merged-x-Request-cost','JobsController@data_job_shipment_and_data_job_cost_of_cost_merge_function');
                    Route::get('/save-shipment-idx','JobsController@add_job_shipment_inv');
                    Route::get('/req-add-shipment-id-saved','JobsController@add_shipment_inv');
                    Route::get('/job-shipment-delete/find/{id}','JobsController@deleteremovejobshipment');
                    Route::get('/job-transports-cost-delete/find/{id}','JobsController@deleteremovejobtransportcost');
                    Route::get('/job-cost-of-cost-delete/find/{id}','JobsController@deleteremovecostofcost');
                    Route::get('/loaded-transporter/find','JobsController@transport_loader');
                    Route::get('/loaded-named-category-name/find/{idx}','JobsController@loaded_named_category_name');
                    Route::get('/loaded-named-vendor-name/find/{idx}','JobsController@loaded_named_vendor_name');
                }
            );
        }
    );

    Route::group(['middlewareGroups' => ['web','CekOpenedTransaction','BlockedBeforeSettingUser','verified']], function ()
    {
        Route::middleware('CekOpenedTransaction','BlockedBeforeSettingUser','permission:developer|transport|superusers')
            ->namespace('Jobs')
            ->group(function ()
                {
                    Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/list-job-shipment/shipment-id/job-id/{id}', array('as'=>'listPekerjaan','uses'=>'JobsController@reportJobShipment'))->where('branch_id', '[0-9]+');
                    Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/getValueTransport-find', 'JobsController@getValueTransportUser');
                    Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/list-job-shipment','JobsController@shipment_jobs_list')->name('joblist.show')->where('branch_id', '[0-9]+');
                    Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/list-job-shipment/{id}/detail-job-shipments','JobsController@show')->name('joblist.vdetail')->where('branch_id', '[0-9]+');
                    Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/create-job-shipment','JobsController@delay_search_vendor')->name('create.job.transaction');
                    Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/history-job-shipments','JobsController@history_job_shipment_lister')->name('history.job.transaction');
                }
            );
        }
    );

    Route::group(['middlewareGroups' => ['web','verified']], function ()
    {
        Route::middleware('verified')
            ->namespace('DataTransport')
            ->group(function ()
                {
                    Route::resource('transport_item_vendor','DatavendortcController');
                    Route::resource('transport_item_customer','DatacustomertcController');
                    Route::get('/loaded_city','DatacustomertcController@load_city');
                    Route::get('/loaded_moda','DatacustomertcController@load_mods');
                    Route::get('/loads_moda/find/{modid}','DatacustomertcController@loaded_modas_idx');
                    Route::get('/loaded_shipments_category','DatacustomertcController@load_shipmentCatgry');
                    Route::get('/loaded_sub_services','DatacustomertcController@load_subservices');
                    Route::get('/loaded_sub_services_idx/find/{service_idx}','DatacustomertcController@loaded_idx_service');
                    Route::get('/loaded_shipments_category_idx/find/{shipments}','DatacustomertcController@loaded_shipment_category');
                    Route::get('/loaded_customer','DatacustomertcController@load_customer');
                    Route::get('/loaded-results-customers','DatacustomertcController@SearchloadResultsCustomer');
                    Route::get('/loaded_vendor','DatavendortcController@load_vendor');
                    Route::get('/alert-item-customer-tc-update/find/{id}','DatacustomertcController@update_alert_item_customer_tc');
                    Route::get('/alert-item-vendor-tc-update/find/{id}','DatavendortcController@update_alert_item_vendor_tc');
                    Route::get('/loaded_auto_search_txt/find/{indexid}','DatacustomertcController@load_auto_move_cty');
                }
            );
        }
    );

    Route::group(['middlewareGroups' => ['web','CekOpenedTransaction','BlockedBeforeSettingUser','verified']], function ()
    {
        Route::middleware('CekOpenedTransaction','BlockedBeforeSettingUser')
            ->namespace('DataTransport')
            ->group(function ()
                {
                    Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/detail-id-item-vendors/{id}/success-update','DatavendortcController@updateSyncDataVendor')->name('update.data.item.vendors')->where('branch_id', '[0-9]+');
                    Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/detail-id-item-customers/{id}','DatacustomertcController@updateDataItemCustomers')->name('update.data.item.customers')->where('branch_id', '[0-9]+');
                    Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/list-item-transport-vendor','DatavendortcController@index')->name('datavendor.show')->where('branch_id', '[0-9]+');
                    Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/detail-data-item-vendor/{id}/update-data-item-vendor-transport','DatavendortcController@show')->name('datavendor.updates')->where('branch_id', '[0-9]+');
                    Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/detail-data-item-customer/{id}/update-item-customer','DatacustomertcController@show')->name('update.item.customer')->where('branch_id', '[0-9]+');
                    Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/list-item-alerts-customer-transport','DatacustomertcController@alert_itemcustomerlist')->name('system.alert.customers.transports')->where('branch_id', '[0-9]+');
                    Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/list-item-alerts-vendor-transport','DatavendortcController@alert_itemvendorlist')->name('system.alert.vendors.transports')->where('branch_id', '[0-9]+');
                    Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/list-item-transport-customer','DatacustomertcController@index')->name('datacustomer.show')->where('branch_id', '[0-9]+');
                }
            );
        }
    );

    Route::group(['middlewareGroups' => ['web','BlockedBeforeSettingUser','verified','role:3PL SURABAYA ALL PERMISSION|3PL JAKARTA ALL PERMISSION|3PL - SURABAYA WAREHOUSE|super_users|3PL[ACCOUNTING][WHS][TC]|3PL[ACCOUNTING][WHS]|3PL[OPRASONAL][WHS]|3PL[OPRASONAL][TC][WHS]|administrator']], function () {
        Route::middleware('BlockedBeforeSettingUser','role:3PL SURABAYA ALL PERMISSION|3PL JAKARTA ALL PERMISSION|3PL - SURABAYA WAREHOUSE|super_users|3PL[OPRASONAL][WHS]|3PL[OPRASONAL][TC][WHS]|3PL[ACCOUNTING][WHS]|3PL[ACCOUNTING][WHS][TC]|administrator')
            ->namespace('warehouse')
            ->group(function (){
                Route::get('/search/loaded-sales/','WarehouseController@search_sales_name');
                Route::get('/get-all-whs','WarehouseController@getBasicData')->name('whs.id');
                Route::get('/load-status-order-list','WarehouseController@loadDataStatussx');
                Route::get('/updated-status-order-whs/{index}', 'WarehouseController@updated_status_order_idx');
                Route::get('/updated-status-name-order-whs/{id}', 'WarehouseController@find_show_status_order_whs');
                Route::get('/item_price/find/{id}', 'WarehouseController@price_items');
                Route::resource('warehouse','WarehouseController');
                Route::put('warehouse/{id}','WarehouseController@show')->name('show_warehouse');
                Route::get('invoice-customer/{id}', array('as'=>'invoice_warehouse',
                                                                'uses'=>'WarehouseController@htmltopdfview')
                                                        );
                Route::get('/send/email/{id}', 'WarehouseController@OrderShipped')->name('send_invoice');
                Route::get('/cari_sub_services', 'WarehouseController@cari_sub_services');
                Route::get('/cari_service', 'WarehouseController@loadData');
                Route::get('/cari_cbrnch', 'WarehouseController@Cari_branchs');
                Route::get('/cari_customers/find', 'WarehouseController@cari_customers');
                Route::get('/list_cs/find/{id}', 'WarehouseController@someone_cs');
                Route::get('/list_items/find/{id}', 'WarehouseController@someone_items');
                Route::get('/search/list_customers/{id}', 'WarehouseController@something');
                Route::get('/search/list_items/{id}', 'WarehouseController@something_awesome');
        });
    });

    Route::group(['middlewareGroups' => ['web','CekOpenedTransaction','BlockedBeforeSettingUser','verified','role:3PL SURABAYA ALL PERMISSION|3PL JAKARTA ALL PERMISSION|3PL - SURABAYA WAREHOUSE|super_users|administrator']], function () {
        Route::middleware('CekOpenedTransaction','BlockedBeforeSettingUser','role:3PL SURABAYA ALL PERMISSION|3PL JAKARTA ALL PERMISSION|3PL - SURABAYA WAREHOUSE|super_users|administrator')
            ->namespace('warehouse')
            ->group(function (){
            Route::get('/dashboard/find-branch-with-branch/branch-id/{id}/get-all-warehouse-ajax','WarehouseController@getAddEditRemoveColumnData')->name('warehouse.tbl');
            Route::get('warehouse-list/find-branch-with-branch/branch-id/{branch_id}/update-detail-data/{id}/completed','WarehouseController@update')->name('update.order.warehouse')->where('id', '[0-9]+');
            Route::get('/dashboard/find-branch-with-branch/branch-id/{id}/list-order-warehouse','WarehouseController@index')->name('warehouse.static');
            Route::get('/dashboard/find-branch-with-branch/branch-id/{id}/create-order-warehouse','WarehouseController@create')->name('warehouse.registration');
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/warehouse-data-detail/{id}/opened-detail-order-warehouse','WarehouseController@show')->name('warehouse.show.detail');
            Route::get('/dashboard/find-branch-with-branch/branch-id/{branch_id}/warehouse-daterange','WarehouseController@display_date_range')->name('display.rate.for.warehouse');
        });
    });
    
    Route::middleware('CekOpenedTransaction','BlockedBeforeSettingUser','role:3PL SURABAYA ALL PERMISSION|3PL JAKARTA ALL PERMISSION|3PL - SURABAYA WAREHOUSE|super_users|administrator')
        ->namespace('Interface')
        ->group(function (){
    });

    Route::group(['middlewareGroups' => ['web','verified','permission:superusers|developer|transport|warehouse|accounting']], function () {
        Route::get('/find/user-role-branch-id/branch-id/{id}', 'ManagementController@findbranchWithRoleBranchId')->name('showit.find')->where('id', '[0-9]+');
    });

    Route::group(['middlewareGroups' => ['cookieConsident','web','CekOpenedTransaction','verified','permission:superusers|developer|transport|warehouse|accounting']], function () {
        Route::get('/dashboard/user-role-branch/{branch_id}/verified-transaction', 'ManagementController@OpenTransaction')->name('role_branch_allowed.open')->where('branch_id', '[0-9]+');
        Route::get('/dashboard/user-role-branch/{branch_id}/indexs', 'ManagementController@spa');
        Route::get('/dashboard/user-role-branch/{branch_id}/promises', 'ManagementController@promises')->name('dashboard');
        Route::get('/dashboard/user-role-branch/{branch_id}/application', 'ManagementController@Reacts');
    });

    Route::group(['middlewareGroups' => ['web','CekOpenedTransaction','verified','auth']], function () {
        Route::get('/dashboard', 'ManagementController@index')->name('dashboard');
    });
    Route::group(['prefix' => 'auth', 'as' => 'auth.', ['middlewareGroups' => ['web',config('ipaddress.ip_address')]]], function () {
            Route::post('/login', 'LoginController@index')->name('login')->middleware('throttle:30,1');
            Route::get('/register/{token}','Auth\RegisterController@activating')->name('activating-account');
            Route::post('/password/email', 'Auth\ForgotPasswordController@getResetToken');
            Route::post('password/reset', 'Auth\ResetPasswordController@reset');
            Route::post('/register', 'Auth\RegisterController@registered');
            $this->get('/reset/change-password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
            $this->patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');
            Route::Auth();
        }
    );

    Route::middleware('web')
        ->group(function ()
            {
                Route::post('geolocation/tracking/{shipment}', 'geolocationservices\GeolocationServiceCTR@index')->name('tracking');
                Route::get('geolocation/tracking/address/{code}', 'geolocationservices\GeolocationServiceCTR@address')->name('address');
                Route::get('geolocation/tracking/detail-history/{code}', 'geolocationservices\GeolocationServiceCTR@detailHistory')->name('detailHistory');
                Route::get('tracking/shipment', 'geolocationservices\GeolocationServiceCTR@view')->name('view.tracking');
            }
    );

   