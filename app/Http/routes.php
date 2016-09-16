<?php
$app->get('/', function () use ($app) {
	return 'Mapa das Organizações da Sociedade Civil';
});

$app->group(['prefix' => 'api/osc'], function () use ($app) {
	$app->get('cabecalho/{id}', 'App\Http\Controllers\OscController@getCabecalhoOsc');
	$app->get('dadosgerais/{id}', 'App\Http\Controllers\OscController@getDadosGerais');
	$app->get('areasatuacao/{id}', 'App\Http\Controllers\OscController@getAreasAtuacao');
	$app->get('descricao/{id}', 'App\Http\Controllers\OscController@getDescricao');
	$app->get('titulacoescertificacoes/{id}', 'App\Http\Controllers\OscController@getTitulacoesCertificacoes');
	$app->get('colaboradores/{id}', 'App\Http\Controllers\OscController@getColaboradores');
	$app->get('diretores/{id}', 'App\Http\Controllers\OscController@getDiretores');
	$app->get('recursos/{id}', 'App\Http\Controllers\OscController@getRecursos');
	$app->get('projetos/{id}', 'App\Http\Controllers\OscController@getProjetos');
	$app->get('espacosparticipacao/{id}', 'App\Http\Controllers\OscController@getEspacosParticipacao');
});

$app->get('organization/id/{id}', 'OscController@getOsc');
$app->get('dadosteste/id/{id}', 'OscController@getDadosTeste');
