<?php

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('refresh', 'AuthController@refresh');
    Route::post('login', 'AuthController@login');
    // Route::apiResource('kits', 'GeneratorController');
    Route::post('get-kits', 'GeneratorController@getKits');
    Route::apiResource('projects', 'ProjectController');

    Route::get('files/{path_file}/{file}', function($path_file = null, $file = null) {
        $path = storage_path().'/files/uploads/'.$path_file.'/'.$file;
        if(file_exists($path)) {
            return Response::download($path);
        }
    });
    Route::post('product-import', 'ImportExcelController@fileImport');
});

Route::group(['middleware' => 'auth:api'], function(){
    Route::prefix('v1')->group(function () {        
        
        Route::apiResource('users', 'UserController');
        Route::apiResource('products', 'ProductController');
        
        Route::post('logout', 'AuthController@logout');
        
        Route::apiResource('clients', 'ClientController');
        Route::apiResource('config-admin', 'ConfigAdminController');
        Route::get('get-agent-clients/{agent}', 'ClientController@getByAgent');
        
        Route::apiResource('provinces', 'ProvinceController');
        Route::apiResource('cities', 'CityController');
        Route::apiResource('agents', 'AgentController');
        // Route::apiResource('departments', 'DepartmentController');
        // Route::apiResource('statuses', 'StatusController');
        Route::apiResource('products-custon', 'ProductCustonController');
        

        Route::apiResource('pre-inspections', 'PreInspectionController');
        Route::apiResource('inspections', 'InspectionController');

        Route::post('rejected-attachemnt/{attachment}', 'PreInspectionController@rejected');
        Route::post('upload', 'FileEntryController@uploadFile');
        
        // Route::get('files/{path_file}/{file}', function($path_file = null, $file = null) {
        //     $path = storage_path().'/files/uploads/'.$path_file.'/'.$file;
        //     if(file_exists($path)) {
        //         return Response::download($path);
        //     }
        // });
    });
});


