<?php
$app->group(['prefix' => 'api/osc'], function () use ($app) {
	$app->get('{id}', 'App\Http\Controllers\OscController@getOsc');
	$app->get('{component}/{id}', 'App\Http\Controllers\OscController@getComponentOsc');
});
