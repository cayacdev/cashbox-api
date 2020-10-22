<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return App::version();
});


Route::group([
    'prefix' => 'v1/auth'
], function ($router) {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::put('changePassword', 'AuthController@changePassword');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
});

Route::group([
    'prefix' => 'v1/cash-boxes'
], function ($router) {
    Route::group([
        'prefix' => '{cashBoxId}/plans'
    ], function ($router) {
        Route::group(['prefix' => '{planId}/entries'], function ($router) {
            Route::post('', 'CashBoxBudgetPlanEntryController@store');
            Route::put('{id}', 'CashBoxBudgetPlanEntryController@update');
            Route::delete('{id}', 'CashBoxBudgetPlanEntryController@destroy');
        });
        Route::get('', 'CashBoxBudgetPlanController@index');
        Route::get('active', 'CashBoxBudgetPlanController@active');
        Route::get('{id}/reports', 'CashBoxBudgetPlanController@showReports');
        Route::get('{id}', 'CashBoxBudgetPlanController@show');
        Route::post('', 'CashBoxBudgetPlanController@store');
        Route::put('{id}', 'CashBoxBudgetPlanController@update');
        Route::delete('{id}', 'CashBoxBudgetPlanController@destroy');
    });
    Route::get('', 'CashBoxController@index');
    Route::get('{id}', 'CashBoxController@show');
    Route::post('', 'CashBoxController@store');
    Route::put('{id}', 'CashBoxController@update');
    Route::delete('{id}', 'CashBoxController@destroy');
});
