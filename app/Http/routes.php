<?php

$app->get('/', function () use ($app) {
	return 'Mapa das Organiza��es da Sociedade Civil';
});

$app->get('osc/{id}', 'OscController@getOsc');