<?php

$app->get('atualizar_views', 'App\Http\Controllers\GovController@loadDataFile');

//$app->group(['prefix' => 'api', 'middleware' => ['cors', 'auth-ip']], function () use ($app) {
$app->group(['prefix' => 'api', 'middleware' => ['cors']], function () use ($app) {
	$app->get('projeto/{id_projeto}', 'App\Http\Controllers\ComponentController@getProjeto');
	$app->get('test', 'App\Http\Controllers\GovController@loadDataFile');
});

//$app->group(['prefix' => 'api/osc', 'middleware' => ['cors', 'auth-ip']], function () use ($app) {
$app->group(['prefix' => 'api/osc', 'middleware' => ['cors']], function () use ($app) {
	$app->get('no_project/{id}', 'App\Http\Controllers\OscController@getOscNoProject');
	$app->get('{id}', 'App\Http\Controllers\OscController@getOsc');
	$app->get('popup/{id}', 'App\Http\Controllers\OscController@getPopupOsc');
	$app->get('{component}/{id}', 'App\Http\Controllers\OscController@getComponentOsc');
});

//$app->group(['prefix' => 'api/osc', 'middleware' => ['cors', 'auth-ip', 'auth-user']], function () use ($app) {
$app->group(['prefix' => 'api/osc', 'middleware' => ['cors', 'auth-user']], function () use ($app) {
	$app->post('dadosgerais/{id_osc}', 'App\Http\Controllers\OscController@setDadosGerais');
	$app->post('area_atuacao/{id_osc}', 'App\Http\Controllers\OscController@setAreaAtuacao');
	$app->post('descricao/{id_osc}', 'App\Http\Controllers\OscController@setDescricao');
	$app->post('certificado/{id_osc}', 'App\Http\Controllers\OscController@setCertificado');
	$app->post('dirigente/{id_osc}', 'App\Http\Controllers\OscController@setDirigente');
	$app->post('membroconselho/{id_osc}', 'App\Http\Controllers\OscController@updateMembroConselho');
	$app->post('relacoestrabalho/{id_osc}', 'App\Http\Controllers\OscController@setRelacoesTrabalho');
	$app->post('relacoestrabalhooutra/{id_osc}', 'App\Http\Controllers\OscController@outrosTrabalhadores');
	$app->post('participacaosocialconselho/{id_osc}', 'App\Http\Controllers\OscController@setParticipacaoSocialConselho');
	$app->post('participacaosocialconselhooutro/{id_osc}', 'App\Http\Controllers\OscController@setParticipacaoSocialConselhoOutro');
	$app->post('participacaosocialconferencia/{id_osc}', 'App\Http\Controllers\OscController@setParticipacaoSocialConferencia');
	$app->post('participacaosocialconferenciaoutra/{id_osc}', 'App\Http\Controllers\OscController@setParticipacaoSocialConferenciaOutra');
	$app->post('participacaosocialdeclarada/{id_osc}', 'App\Http\Controllers\OscController@updateParticipacaoSocialDeclarada');
	$app->post('participacaosocialoutra/{id_osc}', 'App\Http\Controllers\OscController@setParticipacaoSocialOutra');
	$app->post('linkrecursos/{id_osc}', 'App\Http\Controllers\OscController@updateLinkRecursos');
	$app->post('conselhofiscal/{id_osc}', 'App\Http\Controllers\OscController@setConselhoFiscal');
	$app->post('projeto/{id_osc}', 'App\Http\Controllers\OscController@updateProjeto');
	$app->post('recursososc/{id_osc}', 'App\Http\Controllers\OscController@setRecursosOsc');
	$app->post('recursosoutroosc/{id_osc}', 'App\Http\Controllers\OscController@updateRecursosOutroOsc');
	$app->post('relacoes_trabalho_governanca/{id_osc}', 'App\Http\Controllers\OscController@RelacoesTrabalhoGovernanca');

	$app->post('areaatuacaooutra', 'App\Http\Controllers\OscController@setAreaAtuacaoOutra');
	$app->post('participacaosocialdeclarada', 'App\Http\Controllers\OscController@setParticipacaoSocialDeclarada');
	$app->post('projeto/insert/{id_osc}', 'App\Http\Controllers\OscController@setProjeto');
	$app->post('recursosoutroosc', 'App\Http\Controllers\OscController@setRecursosOutroOsc');

	$app->delete('projeto/{id_projeto}/{id}', 'App\Http\Controllers\OscController@deleteProjeto');
	$app->delete('areaatuacaooutra/{id_areaoutra}/{id}', 'App\Http\Controllers\OscController@deleteAreaAtuacaoOutra');
	$app->delete('membroconselho/{id_membro}/{id}', 'App\Http\Controllers\OscController@deleteMembroConselho');
	$app->delete('participacaosocialdeclarada/{id_declarada}/{id}', 'App\Http\Controllers\OscController@deleteParticipacaoSocialDeclarada');
	$app->delete('recursosoutroosc/{id_recursosoutro}/{id}', 'App\Http\Controllers\OscController@deleteRecursosOutroOsc');
});

//$app->group(['prefix' => 'api/geo', 'middleware' => ['cors', 'auth-ip']], function () use ($app) {
$app->group(['prefix' => 'api/geo', 'middleware' => ['cors']], function () use ($app) {
	$app->get('osc', 'App\Http\Controllers\GeoController@getOscCountry');
	$app->get('osc/{id}', 'App\Http\Controllers\GeoController@getOsc');
	$app->get('osc/{region}/{id}', 'App\Http\Controllers\GeoController@getOscRegion');
	$app->get('osc/{north}/{south}/{west}/{east}', 'App\Http\Controllers\GeoController@getOscArea');
	$app->get('cluster/{region}', 'App\Http\Controllers\GeoController@getClusterRegion');
	$app->get('cluster/{region}/{id}', 'App\Http\Controllers\GeoController@getClusterRegion');
});

//$app->group(['prefix' => 'api/user', 'middleware' => ['cors', 'auth-ip']], function () use ($app) {
$app->group(['prefix' => 'api/user', 'middleware' => ['cors']], function () use ($app) {
	$app->get('ativarcadastro/{token}', 'App\Http\Controllers\UserController@activateUser');
	$app->get('validartoken/{id}/{token}', 'App\Http\Controllers\UserController@validateToken');
});

//$app->group(['prefix' => 'api/user', 'middleware' => ['cors', 'auth-ip']], function () use ($app) {
$app->group(['prefix' => 'api/user', 'middleware' => ['cors']], function () use ($app) {
	$app->post('/', 'App\Http\Controllers\UserController@createUser');
	$app->post('login', 'App\Http\Controllers\UserController@loginUser');
	$app->post('contato', 'App\Http\Controllers\UserController@contato');
	$app->post('alterarsenha', 'App\Http\Controllers\UserController@updatePassword');
	$app->post('esquecisenha', 'App\Http\Controllers\UserController@forgotPassword');
	$app->post('newsletter', 'App\Http\Controllers\UserController@createSubscriber');
});

//$app->group(['prefix' => 'api/user', 'middleware' => ['cors', 'auth-ip', 'auth-user']], function () use ($app) {
$app->group(['prefix' => 'api/user', 'middleware' => ['cors', 'auth-user']], function () use ($app) {
	$app->get('logout/{id}', 'App\Http\Controllers\UserController@logoutUser');
	$app->get('{id}', 'App\Http\Controllers\UserController@getUser');
	$app->post('{id}', 'App\Http\Controllers\UserController@updateUser');
});

//$app->group(['prefix' => 'api/search', 'middleware' => ['cors', 'auth-ip']], function () use ($app) {
$app->group(['prefix' => 'api/search', 'middleware' => ['cors']], function () use ($app) {
	$app->get('all/{type_result}', 'App\Http\Controllers\SearchController@getSearchList');
	$app->get('all/{type_result}/{limit}', 'App\Http\Controllers\SearchController@getSearchList');
	$app->get('all/{type_result}/{limit}/{offset}', 'App\Http\Controllers\SearchController@getSearchList');
	$app->get('{type_search}/{type_result}/{param}', 'App\Http\Controllers\SearchController@getSearch');
	$app->get('{type_search}/{type_result}/{param}/{limit}', 'App\Http\Controllers\SearchController@getSearch');
	$app->get('{type_search}/{type_result}/{param}/{limit}/{offset}', 'App\Http\Controllers\SearchController@getSearch');
	$app->get('{type_search}/{type_result}/{param}/{limit}/{offset}/{similarity}', 'App\Http\Controllers\SearchController@getSearch');
});

//$app->group(['prefix' => 'api/menu', 'middleware' => ['cors', 'auth-ip']], function () use ($app) {
$app->group(['prefix' => 'api/menu', 'middleware' => ['cors']], function () use ($app) {
	$app->get('osc/{menu}', 'App\Http\Controllers\MenuController@getMenuOsc');
	$app->get('osc/{menu}/{param}', 'App\Http\Controllers\MenuController@getMenuOsc');
    $app->get('geo/{region}/{param}', 'App\Http\Controllers\MenuController@getMenuGeo');
	$app->get('geo/{region}/{param}/{limit}', 'App\Http\Controllers\MenuController@getMenuGeo');
	$app->get('geo/{region}/{param}/{limit}/{offset}', 'App\Http\Controllers\MenuController@getMenuGeo');
});

//$app->group(['prefix' => 'api/edital', 'middleware' => ['cors', 'auth-ip']], function () use ($app) {
$app->group(['prefix' => 'api/edital', 'middleware' => ['cors']], function () use ($app) {
	$app->get('/', 'App\Http\Controllers\EditalController@getEditais');
});

//$app->group(['prefix' => 'api/edital', 'middleware' => ['cors', 'auth-ip', 'auth-user']], function () use ($app) {
$app->group(['prefix' => 'api/edital', 'middleware' => ['cors', 'auth-user']], function () use ($app) {
	$app->post('adicionar', 'App\Http\Controllers\EditalController@createEdital');
});
