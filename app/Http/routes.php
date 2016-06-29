<?php

$app->get('/', function () use ($app) {
	return 'Mapa das Organizações da Sociedade Civil';
});

$app->get('osc/{id}', 'OscController@getOsc');