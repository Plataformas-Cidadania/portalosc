<?php
$app->group(['prefix' => 'api/osc', 'middleware' => 'cors'], function () use ($app) {
	$app->get('{component}/{id}', 'App\Http\Controllers\OscController@getComponentOsc');
	$app->get('{id}', 'App\Http\Controllers\OscController@getOsc');
	
	$app->put('dadosgerais/{id}', 'App\Http\Controllers\OscController@updateDadosGerais');
	$app->put('contatos/{id}', 'App\Http\Controllers\OscController@updateContatos');
	$app->put('areaatuacaodeclarada/{id}', 'App\Http\Controllers\OscController@updateAreaAtuacaoDeclarada');
	$app->put('descricao/{id}', 'App\Http\Controllers\OscController@updateDescricao');
	$app->put('vinculos/{id}', 'App\Http\Controllers\OscController@updateVinculos');
	$app->put('dirigente/{id}', 'App\Http\Controllers\OscController@updateDirigente');
	$app->put('conselho/{id}', 'App\Http\Controllers\OscController@updateConselho');
	$app->put('conferencia/{id}', 'App\Http\Controllers\OscController@updateConferencia');
	$app->put('outraparticipacaosocial/{id}', 'App\Http\Controllers\OscController@updateOutraParticipacaoSocial');
	$app->put('linkrecursos/{id}', 'App\Http\Controllers\OscController@updateLinkRecursos');
	$app->put('conselhocontabil/{id}', 'App\Http\Controllers\OscController@updateConselhoContabil');
	$app->put('projeto/{id}', 'App\Http\Controllers\OscController@updateProjeto');

	$app->post('areaatuacaodeclarada', 'App\Http\Controllers\OscController@setAreaAtuacaoDeclarada');
	$app->post('dirigente', 'App\Http\Controllers\OscController@setDirigente');
	$app->post('conselho', 'App\Http\Controllers\OscController@setConselho');
	$app->post('conferencia', 'App\Http\Controllers\OscController@setConferencia');
	$app->post('outraparticipacaosocial', 'App\Http\Controllers\OscController@setOutraParticipacaoSocial');
	$app->post('conselhocontabil', 'App\Http\Controllers\OscController@setConselhoContabil');
	$app->post('projeto', 'App\Http\Controllers\OscController@setProjeto');

	$app->delete('areaatuacaodeclarada/{id}', 'App\Http\Controllers\OscController@deleteAreaAtuacaoDeclarada');
	$app->delete('dirigente/{id}', 'App\Http\Controllers\OscController@deleteDirigente');
	$app->delete('conselho/{id}', 'App\Http\Controllers\OscController@deleteConselho');
	$app->delete('conferencia/{id}', 'App\Http\Controllers\OscController@deleteConferencia');
	$app->delete('outraparticipacaosocial/{id}', 'App\Http\Controllers\OscController@deleteOutraParticipacaoSocial');
	$app->delete('conselhocontabil/{id}', 'App\Http\Controllers\OscController@deleteConselhoContabil');
});

$app->group(['prefix' => 'api/geo', 'middleware' => 'cors'], function () use ($app) {
	$app->get('osc/brasil', 'App\Http\Controllers\GeoController@getOscCountry');
	$app->get('osc/{region}/{id}', 'App\Http\Controllers\GeoController@getOscRegion');
	$app->get('osc/{north}/{south}/{west}/{east}', 'App\Http\Controllers\GeoController@getOscArea');
	$app->get('cluster/{region}', 'App\Http\Controllers\GeoController@getClusterRegion');
	$app->get('fronteira/{region}', 'App\Http\Controllers\GeoController@getBoundaryRegion');
	$app->get('fronteira/{region}/{id}', 'App\Http\Controllers\GeoController@getBoundaryRegionId');
});

$app->group(['prefix' => 'api/user', 'middleware' => 'cors'], function () use ($app) {
	$app->get('{id}', 'App\Http\Controllers\UserController@getUser');
	/*
    $app->post('/', 'App\Http\Controllers\UserController@createUser');
    $app->put('{id}', ['middleware' => 'auth', 'App\Http\Controllers\UserController@updateUser']);
	$app->post('login', 'App\Http\Controllers\UserController@loginUser');
	$app->get('logout', 'App\Http\Controllers\UserController@logoutUser');
	*/
});
