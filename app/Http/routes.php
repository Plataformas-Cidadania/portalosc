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
	$app->put('participacaosocialconferencia/{id}', 'App\Http\Controllers\OscController@updateParticipacaoSocialConferencia');
	$app->put('outraparticipacaosocial/{id}', 'App\Http\Controllers\OscController@updateOutraParticipacaoSocial');
	$app->put('linkrecursos/{id}', 'App\Http\Controllers\OscController@updateLinkRecursos');
	$app->put('conselhocontabil/{id}', 'App\Http\Controllers\OscController@updateConselhoContabil');
	$app->put('projeto/{id}', 'App\Http\Controllers\OscController@updateProjeto');
	$app->put('areaautodeclaradaprojeto', 'App\Http\Controllers\OscController@updateAreaAutoDeclaradaProjeto');
	
	$app->post('areaatuacaofasfil', 'App\Http\Controllers\OscController@setAreaAtuacaoFasfil');
	$app->post('dirigente', 'App\Http\Controllers\OscController@setDirigente');
	$app->post('participacaosocialconselho', 'App\Http\Controllers\OscController@setParticipacaoSocialConselho');
	$app->post('participacaosocialconferencia', 'App\Http\Controllers\OscController@setParticipacaoSocialConferencia');
	$app->post('outraparticipacaosocial', 'App\Http\Controllers\OscController@setOutraParticipacaoSocial');
	$app->post('conselhocontabil', 'App\Http\Controllers\OscController@setConselhoContabil');
	$app->post('projeto', 'App\Http\Controllers\OscController@setProjeto');
	$app->post('publicobeneficiado', 'App\Http\Controllers\OscController@setPublicoBeneficiado');
	$app->post('areaautodeclaradaprojeto', 'App\Http\Controllers\OscController@setAreaAutoDeclaradaProjeto');
	
	$app->delete('areaatuacaofasfil/{id}', 'App\Http\Controllers\OscController@deleteAreaAtuacaoFasfil');
	$app->delete('dirigente/{id}', 'App\Http\Controllers\OscController@deleteDirigente');
	$app->delete('participacaosocialconselho/{id}', 'App\Http\Controllers\OscController@deleteParticipacaoSocialConselho');
	$app->delete('participacaosocialconferencia/{id}', 'App\Http\Controllers\OscController@deleteParticipacaoSocialConferencia');
	$app->delete('outraparticipacaosocial/{id}', 'App\Http\Controllers\OscController@deleteOutraParticipacaoSocial');
	$app->delete('conselhocontabil/{id}', 'App\Http\Controllers\OscController@deleteConselhoContabil');
	$app->delete('publicobeneficiado/{id}', 'App\Http\Controllers\OscController@deletePublicoBeneficiado');
	$app->delete('areaautodeclaradaprojeto/{id}', 'App\Http\Controllers\OscController@deleteAreaAutoDeclaradaProjeto');
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
	$app->get('{id}', ['middleware' => 'auth', 'App\Http\Controllers\UserController@getUser']);
	$app->post('/', 'App\Http\Controllers\UserController@createUser');
	$app->put('/', 'App\Http\Controllers\UserController@updateUser');
	$app->post('login', 'App\Http\Controllers\UserController@loginUser');
	$app->get('logout/{id}', 'App\Http\Controllers\UserController@logoutUser');
});
