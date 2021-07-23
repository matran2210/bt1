<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$module_namespace = "App\Modules\Api\Controllers";
Route::group([
    'module' => 'Api',
    'middleware' => 'api-middleware',
    'namespace' => $module_namespace], function () {
    Route::resource('/api/users','UserApiController');
});
