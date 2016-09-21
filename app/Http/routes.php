<?php
$app->group(['prefix' => 'api/osc', 'middleware' => 'cors'], function () use ($app) {
	$app->get('{id}', 'App\Http\Controllers\OscController@getOsc');
	$app->get('{component}/{id}', 'App\Http\Controllers\OscController@getComponentOsc');
});

$app->group(['prefix' => 'api/geo'], function () use ($app) {
	$app->get('{id}', 'App\Http\Controllers\GeoController@getLocalizationOscInRegion');
	$app->get('{component}/{id}', 'App\Http\Controllers\GeoController@getOscInState');
});
