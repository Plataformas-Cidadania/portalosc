<?php
$app->group(['prefix' => 'api'], function () use ($app) {
	$app->get('osc/{id}', 'App\Http\Controllers\OscController@getOsc');
	$app->get('osc/{component}/{id}', 'App\Http\Controllers\OscController@getComponentOsc');

	$app->get('geo/{id}', 'App\Http\Controllers\GeoController@getLocalizationOscInRegion');
	$app->get('geo/{component}/{id}', 'App\Http\Controllers\GeoController@getOscInState');
});
