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
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::group([
    'prefix' => 'v1/cash-boxes'
], function ($router) {
    Route::get('', 'CashBoxController@index');
    Route::get('{id}', 'CashBoxController@show');
    Route::post('', 'CashBoxController@store');
    Route::put('{id}', 'CashBoxController@update');
    Route::delete('{id}', 'CashBoxController@destroy');
});
