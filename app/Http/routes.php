<?php

$app->group(['prefix' => 'api', 'middleware' => ['cors']], function () use ($app) {
	$app->get('projeto/{id_projeto}', 'App\Http\Controllers\ComponentController@getProjeto');

	$app->get('test', 'App\Http\Controllers\GeoController@getTestCluster');
});

$app->group(['prefix' => 'api/osc', 'middleware' => ['cors']], function () use ($app) {
	$app->get('no_project/{id}', 'App\Http\Controllers\OscController@getOscNoProject');
	$app->get('{id}', 'App\Http\Controllers\OscController@getOsc');
	$app->get('popup/{id}', 'App\Http\Controllers\OscController@getPopupOsc');
	$app->get('{component}/{id}', 'App\Http\Controllers\OscController@getComponentOsc');
});

$app->group(['prefix' => 'api/osc', 'middleware' => ['cors', 'auth']], function () use ($app) {
	$app->put('dadosgerais/{id}', 'App\Http\Controllers\OscController@updateDadosGerais');
	$app->put('areaatuacao/{id}', 'App\Http\Controllers\OscController@AreaAtuacao');
	$app->put('descricao/{id}', 'App\Http\Controllers\OscController@updateDescricao');
	$app->put('certificado/{id}', 'App\Http\Controllers\OscController@updateCertificado');
	$app->put('dirigente/{id}', 'App\Http\Controllers\OscController@updateDirigente');
	$app->put('membroconselho/{id}', 'App\Http\Controllers\OscController@updateMembroConselho');
	$app->put('relacoestrabalho/{id}', 'App\Http\Controllers\OscController@trabalhadores');
	$app->put('relacoestrabalhooutra/{id}', 'App\Http\Controllers\OscController@outrosTrabalhadores');
	$app->put('participacaosocialconselho/{id}', 'App\Http\Controllers\OscController@updateParticipacaoSocialConselho');
	$app->put('participacaosocialconferencia/{id}', 'App\Http\Controllers\OscController@updateParticipacaoSocialConferencia');
	$app->put('participacaosocialconferenciaoutra/{id}', 'App\Http\Controllers\OscController@updateParticipacaoSocialConferenciaOutra');
	$app->put('participacaosocialdeclarada/{id}', 'App\Http\Controllers\OscController@updateParticipacaoSocialDeclarada');
	$app->put('outraparticipacaosocial/{id}', 'App\Http\Controllers\OscController@updateOutraParticipacaoSocial');
	$app->put('linkrecursos/{id}', 'App\Http\Controllers\OscController@updateLinkRecursos');
	$app->put('conselhofiscal/{id}', 'App\Http\Controllers\OscController@updateConselhoFiscal');
	$app->put('projeto/{id}', 'App\Http\Controllers\OscController@updateProjeto');
	$app->put('recursososc/{id}', 'App\Http\Controllers\OscController@updateRecursosOsc');
	$app->put('recursosoutroosc/{id}', 'App\Http\Controllers\OscController@updateRecursosOutroOsc');

	$app->post('areaatuacaooutra', 'App\Http\Controllers\OscController@setAreaAtuacaoOutra');
	$app->post('certificado', 'App\Http\Controllers\OscController@setCertificado');
	$app->post('dirigente', 'App\Http\Controllers\OscController@setDirigente');
	$app->post('membroconselho', 'App\Http\Controllers\OscController@setMembroConselho');
	$app->post('participacaosocialconselho', 'App\Http\Controllers\OscController@setParticipacaoSocialConselho');
	$app->post('participacaosocialconferencia', 'App\Http\Controllers\OscController@setParticipacaoSocialConferencia');
	$app->post('participacaosocialconferenciaoutra', 'App\Http\Controllers\OscController@setParticipacaoSocialConferenciaOutra');
	$app->post('participacaosocialdeclarada', 'App\Http\Controllers\OscController@setParticipacaoSocialDeclarada');
	$app->post('outraparticipacaosocial', 'App\Http\Controllers\OscController@setOutraParticipacaoSocial');
	$app->post('conselhofiscal', 'App\Http\Controllers\OscController@setConselhoFiscal');
	$app->post('projeto', 'App\Http\Controllers\OscController@setProjeto');
	$app->post('recursososc', 'App\Http\Controllers\OscController@setRecursosOsc');
	$app->post('recursosoutroosc', 'App\Http\Controllers\OscController@setRecursosOutroOsc');

	$app->delete('areaatuacao/{id_areaatuacao}/{id}', 'App\Http\Controllers\OscController@deleteAreaAtuacao');
	$app->delete('areaatuacaooutra/{id_areaoutra}/{id}', 'App\Http\Controllers\OscController@deleteAreaAtuacaoOutra');
	$app->delete('certificado/{id_certificado}/{id}', 'App\Http\Controllers\OscController@deleteCertificado');
	$app->delete('dirigente/{id_dirigente}/{id}', 'App\Http\Controllers\OscController@deleteDirigente');
	$app->delete('membroconselho/{id_membro}/{id}', 'App\Http\Controllers\OscController@deleteMembroConselho');
	$app->delete('participacaosocialconselho/{id_conselho}/{id}', 'App\Http\Controllers\OscController@deleteParticipacaoSocialConselho');
	$app->delete('participacaosocialconferencia/{id_conferencia}/{id}', 'App\Http\Controllers\OscController@deleteParticipacaoSocialConferencia');
	$app->delete('participacaosocialconferenciaoutra/{id_conferenciaoutra}/{id}', 'App\Http\Controllers\OscController@deleteParticipacaoSocialConferenciaOutra');
	$app->delete('participacaosocialdeclarada/{id_declarada}/{id}', 'App\Http\Controllers\OscController@deleteParticipacaoSocialDeclarada');
	$app->delete('outraparticipacaosocial/{id_outraparticipacao}/{id}', 'App\Http\Controllers\OscController@deleteOutraParticipacaoSocial');
	$app->delete('conselhofiscal/{id_conselhofiscal}/{id}', 'App\Http\Controllers\OscController@deleteConselhoFiscal');
	$app->delete('publicobeneficiado/{id_beneficiado}/{id}', 'App\Http\Controllers\OscController@deletePublicoBeneficiado');
	$app->delete('areaatuacaoprojeto/{id_areaprojeto}/{id}', 'App\Http\Controllers\OscController@deleteAreaAtuacaoProjeto');
	$app->delete('areaatuacaooutraprojeto/{id_areaoutraprojeto}/{id}', 'App\Http\Controllers\OscController@deleteAreaAtuacaoOutraProjeto');
	$app->delete('localizacaoprojeto/{id_localizacao}/{id}', 'App\Http\Controllers\OscController@deleteLocalizacaoProjeto');
	$app->delete('objetivoprojeto/{id_objetivo}/{id}', 'App\Http\Controllers\OscController@deleteObjetivoProjeto');
	$app->delete('parceiraprojeto/{id_parceira}/{id}', 'App\Http\Controllers\OscController@deleteParceiraProjeto');
	$app->delete('recursososc/{id_recursos}/{id}', 'App\Http\Controllers\OscController@deleteRecursosOsc');
	$app->delete('recursosoutroosc/{id_recursosoutro}/{id}', 'App\Http\Controllers\OscController@deleteRecursosOutroOsc');
});

$app->group(['prefix' => 'api/geo', 'middleware' => ['cors']], function () use ($app) {
	$app->get('osc', 'App\Http\Controllers\GeoController@getOscCountry');
	$app->get('osc/{id}', 'App\Http\Controllers\GeoController@getOsc');
	$app->get('osc/{region}/{id}', 'App\Http\Controllers\GeoController@getOscRegion');
	$app->get('osc/{north}/{south}/{west}/{east}', 'App\Http\Controllers\GeoController@getOscArea');
	$app->get('cluster/{region}', 'App\Http\Controllers\GeoController@getClusterRegion');
	$app->get('cluster/{region}/{id}', 'App\Http\Controllers\GeoController@getClusterRegion');
});

$app->group(['prefix' => 'api/user', 'middleware' => ['cors']], function () use ($app) {
	$app->post('/', 'App\Http\Controllers\UserController@createUser');
	$app->post('login', 'App\Http\Controllers\UserController@loginUser');
	$app->post('contato', 'App\Http\Controllers\UserController@contato');
	$app->get('ativarcadastro/{id}/{token}', 'App\Http\Controllers\UserController@activateUser');
	$app->put('alterarsenha/{id}', 'App\Http\Controllers\UserController@updatePassword');
	$app->get('validartoken/{id}/{token}', 'App\Http\Controllers\UserController@validateToken');
	$app->post('esquecisenha', 'App\Http\Controllers\UserController@forgotPassword');
	$app->post('newsletter', 'App\Http\Controllers\UserController@createSubscriber');
});

$app->group(['prefix' => 'api/user', 'middleware' => ['cors', 'auth']], function () use ($app) {
	$app->get('logout/{id}', 'App\Http\Controllers\UserController@logoutUser');
	$app->get('{id}', 'App\Http\Controllers\UserController@getUser');
	$app->put('{id}', 'App\Http\Controllers\UserController@updateUser');
});

$app->group(['prefix' => 'api/search', 'middleware' => ['cors']], function () use ($app) {
	$app->get('{type_search}/{type_result}/{param}', 'App\Http\Controllers\SearchController@getSearchOsc');
	$app->get('{type_search}/{type_result}/{param}/{limit}', 'App\Http\Controllers\SearchController@getSearchOsc');
	$app->get('{type_search}/{type_result}/{param}/{limit}/{offset}', 'App\Http\Controllers\SearchController@getSearchOsc');
});

$app->group(['prefix' => 'api/menu', 'middleware' => ['cors']], function () use ($app) {
	$app->get('osc/{menu}', 'App\Http\Controllers\MenuController@getMenuOsc');
	$app->get('osc/{menu}/{param}', 'App\Http\Controllers\MenuController@getMenuOsc');
    $app->get('geo/{region}/{param}', 'App\Http\Controllers\MenuController@getMenuGeo');
	$app->get('geo/{region}/{param}/{limit}', 'App\Http\Controllers\MenuController@getMenuGeo');
	$app->get('geo/{region}/{param}/{limit}/{offset}', 'App\Http\Controllers\MenuController@getMenuGeo');
});

$app->group(['prefix' => 'api/edital', 'middleware' => ['cors']], function () use ($app) {
	$app->get('/', 'App\Http\Controllers\EditalController@getEditais');
});

$app->group(['prefix' => 'api/edital', 'middleware' => ['cors', 'auth']], function () use ($app) {
	$app->post('adicionar', 'App\Http\Controllers\EditalController@createEdital');
});
