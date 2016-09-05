<?php

$app->get('/', function () use ($app) {
	return 'Mapa das Organizações da Sociedade Civil';
});

$app->get('organization/id/{id}', 'OscController@getOsc');
