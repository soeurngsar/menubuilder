<?php

Route::group(['middleware' => config('menu.middleware')], function () {
    $path = rtrim(config('menu.route_path'));
    Route::get($path . '/menu-builder', array('uses'=>'\SoeurngSar\MenuBuilder\app\Http\Controllers\MenuController@index'));
    Route::post($path . '/addcustommenu', array('as' => 'haddcustommenu', 'uses' => '\SoeurngSar\MenuBuilder\app\Http\Controllers\MenuController@addcustommenu'));
    Route::post($path . '/deleteitemmenu', array('as' => 'hdeleteitemmenu', 'uses' => '\SoeurngSar\MenuBuilder\app\Http\Controllers\MenuController@deleteitemmenu'));
    Route::post($path . '/deletemenug', array('as' => 'hdeletemenug', 'uses' => '\SoeurngSar\MenuBuilder\app\Http\Controllers\MenuController@deletemenug'));
    Route::post($path . '/createnewmenu', array('as' => 'hcreatenewmenu', 'uses' => '\SoeurngSar\MenuBuilder\app\Http\Controllers\MenuController@createnewmenu'));
    Route::post($path . '/generatemenucontrol', array('as' => 'hgeneratemenucontrol', 'uses' => '\SoeurngSar\MenuBuilder\app\Http\Controllers\MenuController@generatemenucontrol'));
    Route::post($path . '/updateitem', array('as' => 'hupdateitem', 'uses' => '\SoeurngSar\MenuBuilder\app\Http\Controllers\MenuController@updateitem'));
});
