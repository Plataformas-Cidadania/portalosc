<?php

$app->group(['prefix' => 'api/osc', 'middleware' => ['cors']], function () use ($app) {
	$app->get('{component}/{id}', 'App\Http\Controllers\OscController@getComponentOsc');
	$app->get('{id}', 'App\Http\Controllers\OscController@getOsc');

	$app->put('dadosgerais/{id}', 'App\Http\Controllers\OscController@updateDadosGerais');
	$app->put('areaatuacao/{id}', 'App\Http\Controllers\OscController@AreaAtuacao');
	$app->put('descricao/{id}', 'App\Http\Controllers\OscController@updateDescricao');
	$app->put('dirigente/{id}', 'App\Http\Controllers\OscController@updateDirigente');
	$app->put('vinculos/{id}', 'App\Http\Controllers\OscController@vinculos');
	$app->put('participacaosocialconselho/{id}', 'App\Http\Controllers\OscController@updateParticipacaoSocialConselho');
	$app->put('participacaosocialconferencia/{id}', 'App\Http\Controllers\OscController@updateParticipacaoSocialConferencia');
	$app->put('outraparticipacaosocial/{id}', 'App\Http\Controllers\OscController@updateOutraParticipacaoSocial');
	$app->put('linkrecursos/{id}', 'App\Http\Controllers\OscController@updateLinkRecursos');
	$app->put('conselhocontabil/{id}', 'App\Http\Controllers\OscController@updateConselhoContabil');
	$app->put('projeto/{id}', 'App\Http\Controllers\OscController@updateProjeto');
	$app->put('publicobeneficiado/{id_publico}', 'App\Http\Controllers\OscController@updatePublicoBeneficiado');
	$app->put('areaautodeclaradaprojeto/{id_area}', 'App\Http\Controllers\OscController@updateAreaAutoDeclaradaProjeto');
	
	$app->post('areaatuacaooutra', 'App\Http\Controllers\OscController@setAreaAtuacaoOutra');
	$app->post('dirigente', 'App\Http\Controllers\OscController@setDirigente');
	$app->post('participacaosocialconselho', 'App\Http\Controllers\OscController@setParticipacaoSocialConselho');
	$app->post('participacaosocialconferencia', 'App\Http\Controllers\OscController@setParticipacaoSocialConferencia');
	$app->post('outraparticipacaosocial', 'App\Http\Controllers\OscController@setOutraParticipacaoSocial');
	$app->post('conselhocontabil', 'App\Http\Controllers\OscController@setConselhoContabil');
	$app->post('projeto', 'App\Http\Controllers\OscController@setProjeto');
	$app->post('publicobeneficiadoprojeto', 'App\Http\Controllers\OscController@setPublicoBeneficiadoProjeto');
	$app->post('areaautodeclaradaprojeto', 'App\Http\Controllers\OscController@setAreaAutoDeclaradaProjeto');
	$app->post('localizacaoprojeto', 'App\Http\Controllers\OscController@setLocalizacaoProjeto');
	$app->post('parceiraprojeto', 'App\Http\Controllers\OscController@setParceiraProjeto');

	$app->delete('areaatuacao/{id}', 'App\Http\Controllers\OscController@deleteAreaAtuacao');
	$app->delete('areaatuacaooutra/{id}', 'App\Http\Controllers\OscController@deleteAreaAtuacaoOutra');
	$app->delete('dirigente/{id}', 'App\Http\Controllers\OscController@deleteDirigente');
	$app->delete('participacaosocialconselho/{id}', 'App\Http\Controllers\OscController@deleteParticipacaoSocialConselho');
	$app->delete('participacaosocialconferencia/{id}', 'App\Http\Controllers\OscController@deleteParticipacaoSocialConferencia');
	$app->delete('outraparticipacaosocial/{id}', 'App\Http\Controllers\OscController@deleteOutraParticipacaoSocial');
	$app->delete('conselhocontabil/{id}', 'App\Http\Controllers\OscController@deleteConselhoContabil');
	$app->delete('publicobeneficiado/{id}/{id_projeto}', 'App\Http\Controllers\OscController@deletePublicoBeneficiado');
	$app->delete('areaautodeclaradaprojeto/{id}', 'App\Http\Controllers\OscController@deleteAreaAutoDeclaradaProjeto');
	$app->delete('localizacaoprojeto/{id}', 'App\Http\Controllers\OscController@deleteLocalizacaoProjeto');
	$app->delete('parceiraprojeto/{id}', 'App\Http\Controllers\OscController@deleteParceiraProjeto');
});

$app->group(['prefix' => 'api/geo', 'middleware' => ['cors']], function () use ($app) {
	$app->get('osc', 'App\Http\Controllers\GeoController@getOscCountry');
	$app->get('osc/{id}', 'App\Http\Controllers\GeoController@getOsc');
	$app->get('osc/{region}/{id}', 'App\Http\Controllers\GeoController@getOscRegion');
	$app->get('osc/{north}/{south}/{west}/{east}', 'App\Http\Controllers\GeoController@getOscArea');
	$app->get('cluster/{region}', 'App\Http\Controllers\GeoController@getClusterRegion');
	$app->get('cluster/{region}/{id}', 'App\Http\Controllers\GeoController@getClusterRegion');
	$app->get('fronteira/{region}', 'App\Http\Controllers\GeoController@getBoundaryRegion');
	$app->get('fronteira/{region}/{id}', 'App\Http\Controllers\GeoController@getBoundaryRegionId');
});

$app->group(['prefix' => 'api/user', 'middleware' => ['cors']], function () use ($app) {
	$app->post('/', 'App\Http\Controllers\UserController@createUser');
	$app->post('login', 'App\Http\Controllers\UserController@loginUser');
	$app->post('contato', 'App\Http\Controllers\UserController@contato');
	$app->put('ativarcadastro/{id}/{token}', 'App\Http\Controllers\UserController@activateUser');
	$app->put('alterarsenha/{id}', 'App\Http\Controllers\UserController@updatePassword');
	$app->put('validartoken/{id}/{token}', 'App\Http\Controllers\UserController@validateToken');
	$app->put('esquecisenha/', 'App\Http\Controllers\UserController@forgotPassword');
});

$app->group(['prefix' => 'api/user', 'middleware' => ['cors', 'auth']], function () use ($app) {
	$app->get('{id}', 'App\Http\Controllers\UserController@getUser');
	$app->put('/', 'App\Http\Controllers\UserController@updateUser');
	$app->get('logout/{id}', 'App\Http\Controllers\UserController@logoutUser');
});

$app->group(['prefix' => 'api/search', 'middleware' => ['cors']], function () use ($app) {
	$app->get('{type_search}/{type_result}/{param}', 'App\Http\Controllers\SearchController@getSearchOsc');
	$app->get('{type_search}/{type_result}/{param}/{limit}', 'App\Http\Controllers\SearchController@getSearchOsc');
	$app->get('{type_search}/{type_result}/{param}/{limit}/{offset}', 'App\Http\Controllers\SearchController@getSearchOsc');
});

$app->group(['prefix' => 'api/menu', 'middleware' => ['cors']], function () use ($app) {
	$app->get('osc/{menu}', 'App\Http\Controllers\MenuController@getMenuOsc');
	$app->get('geo/{region}/{param}', 'App\Http\Controllers\MenuController@getMenuGeo');
});

$app->group(['prefix' => 'api/edital', 'middleware' => ['cors']], function () use ($app) {
	$app->get('/', 'App\Http\Controllers\EditalController@getEditais');
});

$app->group(['prefix' => 'api/edital', 'middleware' => ['cors', 'auth']], function () use ($app) {
	$app->post('adicionar', 'App\Http\Controllers\EditalController@createEdital');
});
