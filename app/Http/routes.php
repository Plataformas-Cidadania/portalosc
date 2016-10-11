<?php

$app->group(['prefix' => 'api/osc', 'middleware' => 'cors'], function () use ($app) {
	$app->get('{component}/{id}', 'App\Http\Controllers\OscController@getComponentOsc');
	$app->get('{id}', 'App\Http\Controllers\OscController@getOsc');

	$app->put('dadosgerais/{id}', 'App\Http\Controllers\OscController@updateDadosGerais');
	$app->put('contatos/{id}', 'App\Http\Controllers\OscController@contatos');
	$app->put('areaatuacaofasfil/{id}', 'App\Http\Controllers\OscController@updateAreaAtuacaoFasfil');
	$app->put('descricao/{id}', 'App\Http\Controllers\OscController@updateDescricao');
	$app->put('vinculos/{id}', 'App\Http\Controllers\OscController@vinculos');
	$app->put('dirigente/{id}', 'App\Http\Controllers\OscController@updateDirigente');
	$app->put('participacaosocialconselho/{id}', 'App\Http\Controllers\OscController@updateParticipacaoSocialConselho');
	$app->put('participacaosocialconferencia/{id}', 'App\Http\Controllers\OscController@updateParticipacaoSocialConferencia');
	$app->put('outraparticipacaosocial/{id}', 'App\Http\Controllers\OscController@updateOutraParticipacaoSocial');
	$app->put('linkrecursos/{id}', 'App\Http\Controllers\OscController@updateLinkRecursos');
	$app->put('conselhocontabil/{id}', 'App\Http\Controllers\OscController@updateConselhoContabil');
	$app->put('projeto/{id}', 'App\Http\Controllers\OscController@updateProjeto');
	$app->put('publicobeneficiado/{id_publico}', 'App\Http\Controllers\OscController@updatePublicoBeneficiado');
	$app->put('areaautodeclaradaprojeto/{id_area}', 'App\Http\Controllers\OscController@updateAreaAutoDeclaradaProjeto');

	$app->post('areaatuacaofasfil', 'App\Http\Controllers\OscController@setAreaAtuacaoFasfil');
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

	$app->delete('areaatuacaofasfil/{id}', 'App\Http\Controllers\OscController@deleteAreaAtuacaoFasfil');
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

$app->group(['prefix' => 'api/geo', 'middleware' => 'cors'], function () use ($app) {
	$app->get('osc', 'App\Http\Controllers\GeoController@getOscCountry');
	$app->get('osc/{id}', 'App\Http\Controllers\GeoController@getOsc');
	$app->get('osc/{region}/{id}', 'App\Http\Controllers\GeoController@getOscRegion');
	$app->get('osc/{north}/{south}/{west}/{east}', 'App\Http\Controllers\GeoController@getOscArea');
	$app->get('cluster/{region}', 'App\Http\Controllers\GeoController@getClusterRegion');
	$app->get('fronteira/{region}', 'App\Http\Controllers\GeoController@getBoundaryRegion');
	$app->get('fronteira/{region}/{id}', 'App\Http\Controllers\GeoController@getBoundaryRegionId');
});

$app->group(['prefix' => 'api/user', 'middleware' => 'cors'], function () use ($app) {
	$app->get('{id}', ['middleware' => 'auth', 'App\Http\Controllers\UserController@getUser']);
	$app->post('/', 'App\Http\Controllers\UserController@createUser');
	$app->put('/', 'App\Http\Controllers\UserController@updateUser');
	$app->post('login', 'App\Http\Controllers\UserController@loginUser');
	$app->get('logout/{id}', 'App\Http\Controllers\UserController@logoutUser');
});

/*
$app->group(['prefix' => 'api/user', 'middleware' => 'cors', 'middleware' => 'auth'], function () use ($app) {
	$app->get('{id}', 'App\Http\Controllers\UserController@getUser');
});
*/


$app->group(['prefix' => 'api/search', 'middleware' => 'cors'], function () use ($app) {
	$app->get('osc/{param}', 'App\Http\Controllers\SearchController@getSearchOsc');
	$app->get('{region}/{param}', 'App\Http\Controllers\SearchController@getSearchRegion');
});
