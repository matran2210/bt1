<?php

$module_namespace = "App\Modules\Cms\Controllers";

Route::group([
    'module' => 'Cms',
    'namespace' => $module_namespace], function () {
    Route::get('/', 'HomeController@index')->name('index');
    Route::post('/send-email', 'HomeController@sendEmail')->name('send_email');

    //user
    Route::get('/get-list-user', 'UserController@getListUser')->name('get_list_user');
    Route::post('/add-user', 'UserController@addUser')->name('add_user');
    Route::get('/get-view-edit-user', 'UserController@getViewEditUser');
    Route::post('/edit-user', 'UserController@editUser')->name('edit_user');
    Route::post('/delete-user', 'UserController@deleteUser')->name('delete_user');
    Route::get('/export-pdf', 'UserController@exportPDF')->name('export_pdf');
    Route::get('/export-excel', 'UserController@exportExcel')->name('export_excel');
    Route::post('/import-excel', 'UserController@importExcel')->name('import_excel');

    });
