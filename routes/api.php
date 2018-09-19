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


//Auth::routes();

Route::middleware(['cors'])->group(function (){
    Route::post('/login','Api\AuthController@login');
    Route::post('/register','Api\AuthController@register');
});
Route::middleware(['cors','jwt.auth'])->group(function (){
    Route::post('/jointeam','Api\TeamController@joinTeam');
    Route::get('/myteam','Api\TeamController@myTeam');
    Route::get('/tuteam','Api\TeamController@tuTeam');
    Route::get('/team','Api\TeamController@allTeam');
    Route::post('/team','Api\TeamController@addTeam');
    //Route::post('/amigo','Api\FriendshipController@friend');
    //Route::get('/friendship/','Api\FriendshipController@allFriend');
    //Route::post('/friendship','Api\FriendshipController@addFriend');
    //Route::apiresource('/user','Api\UserController');
    //Route::apiresource('/post','Api\PostController');
    Route::apiresource('/profile','Api\ProfileController');
});

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/



