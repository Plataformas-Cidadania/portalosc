<?php
$app->group(['prefix' => 'api/osc'], function () use ($app) {
	$app->get('{id}', 'App\Http\Controllers\OscController@getOsc2');
	$app->get('{component}/{id}', 'App\Http\Controllers\OscController@getComponentOsc');
});

$app->get('organization/id/{id}', 'OscController@getOsc');