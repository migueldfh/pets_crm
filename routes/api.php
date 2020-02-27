<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::get('refresh', 'AuthController@refresh');
    Route::get('user', 'AuthController@user');
    Route::post('logout', 'AuthController@logout');
});

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('users', 'UserController@index')->middleware('isAdmin');
    Route::get('subsidiaries', 'SubsidiaryController@getSubsidiaries')->middleware('isAdmin');
    Route::post('subsidiaries', 'SubsidiaryController@addSubsidiary')->middleware('isAdmin');
    Route::get('subsidiary/{id}/sales', 'SalesController@getSubsidiarySale');
    Route::get('zones/{id}', 'SubsidiaryController@getZones')->middleware('isAdmin');
    Route::post('zones', 'SubsidiaryController@addZone')->middleware('isAdmin');
    Route::get('cities/{id}', 'SubsidiaryController@getCities')->middleware('isAdmin');
    Route::post('cities', 'SubsidiaryController@addCity')->middleware('isAdmin');
    Route::get('users/{id}', 'UserController@show')->middleware('isAdminOrSelf');

    Route::get('subsidiary/{id}/clients', 'ClientController@getSubsidiaryClient');
    Route::post('clients', 'ClientController@addClient');

    Route::post('sales', 'SalesController@addSale');

    Route::get('subsidiary/{id}/sellers', 'SellerController@getSubsidiarySellers');
    Route::post('sellers', 'SellerController@addSeller');

    Route::post('pets', 'PetController@addPet');

    Route::get('countries', 'StateController@getCountries');
    Route::get('countries/{id}/states', 'StateController@getStates');
    Route::get('states/{id}/cities', 'StateController@getCities');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
