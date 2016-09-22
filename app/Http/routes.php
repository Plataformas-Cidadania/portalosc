<?php
$app->group(['prefix' => 'api/osc', 'middleware' => 'cors'], function () use ($app) {
	$app->get('{id}', 'App\Http\Controllers\OscController@getOsc');
	$app->get('{component}/{id}', 'App\Http\Controllers\OscController@getComponentOsc');
});

$app->group(['prefix' => 'api/geo', 'middleware' => 'cors'], function () use ($app) {
	$app->get('osc/brasil', 'App\Http\Controllers\GeoController@getOscCountry');
	$app->get('osc/{region}/{id}', 'App\Http\Controllers\GeoController@getOscRegion');
	$app->get('osc/{north}/{south}/{west}/{east}', 'App\Http\Controllers\GeoController@getOscArea');
	$app->get('cluster/{region}', 'App\Http\Controllers\GeoController@getClusterRegion');
	$app->get('fronteira/{region}', 'App\Http\Controllers\GeoController@getBoundaryRegion');
	$app->get('fronteira/{region}/{id}', 'App\Http\Controllers\GeoController@getBoundaryRegionId');
});
