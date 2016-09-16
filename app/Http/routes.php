<?php
$app->get('/', function () use ($app) {
	return 'Mapa das Organizações da Sociedade Civil';
});
$app->get('organization/id/{id}', 'OscController@getOsc');
$app->get('dadosgerais/id/{id}', 'OscController@getDadosGerais');
$app->get('dadosteste/id/{id}', 'OscController@getDadosTeste');
