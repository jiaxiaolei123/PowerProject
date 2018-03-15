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



Route::group(['middleware'=>'login'],function(){
    Route::get('/', function(){return view('web/index');});
	Route::get('log',['uses'=>'LogController@powerlog']);
	Route::get('common/{Pid}/{stationId}',['uses'=>'CommonController@common']);
	Route::get('historyLine/{stationId}',['uses'=>'CommonController@historyLine']);
	Route::post('historyLine/getParams',['uses'=>'CommonController@getParams']);
	Route::post('historyLine/ajaxhistoryLine',['uses'=>'CommonController@ajaxhistoryLine']);
	Route::get('loginOut',['uses'=>'LoginController@outlogin']);
	Route::get('powermanager',['uses'=>'CommonController@powermanager']);
	Route::get('editor/{UID}',['uses'=>'CommonController@editormanager']);
	Route::post('editormanager',['uses'=>'CommonController@editorajax']);
	Route::get('delete/{UID}',['uses'=>'CommonController@deletemanager']);
	Route::post('creatajax',['uses'=>'CommonController@creatajax']);
	Route::get('createmanagerBlade',function(){
		return view('web/blade/createmanager');
	});
	Route::post('creatmanager',['uses'=>'CommonController@creatmanager']);
	Route::get('rolemanager',['uses'=>'CommonController@rolemanager']);
	Route::get('editorrole/{Rid}',['uses'=>'CommonController@editorrole']);
	Route::post('ajaxrole',['uses'=>'CommonController@ajaxrole']);
	Route::get('creatrole',['uses'=>'CommonController@creatrole']);
	Route::post('creatroleAjax',['uses'=>'CommonController@creatroleAjax']);
	Route::get('deleterole/{Rid}',['uses'=>'CommonController@deleterole']);
	Route::get('powerredis/{stationId}',['uses'=>'CommonController@powerredis']);
	Route::post('getredis',['uses'=>'CommonController@getredis']);
	Route::get('redis/{data}',['uses'=>'CommonController@redis']);
	Route::post('getredisdata',['uses'=>'CommonController@getredisdata']);

});

Route::get('login','LoginController@login');
Route::post('dologin','LoginController@dologin');

