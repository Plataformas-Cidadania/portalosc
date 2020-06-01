<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/api/', function () use ($router) {
    return ["description: API de dados do Mapa das Organizações da Sociedade Civil.",
    "version: 3.0.0",
    "homepage: https://mapaosc.ipea.gov.br/",
    "keywords: 'php', 'lumen', 'api', 'rest', 'server, 'http', 'json', 'mapaosc', 'ipea'",
    "license: LGPL-3.0",
    "authors: {Thiago Giannini Ramos}"
    ];
});

$router->post('/api/user/', 'UsuarioController@store');

$router->get('/api/representacoes/', 'RepresentacaoController@getAll');

$router->get('/api/osc/{id}', 'OscController@get');

$router->group(['prefix' => "/api/representacao/"], function() use ($router){
    $router->get("/{id}", 'RepresentacaoController@get');
    $router->post("/", "RepresentacaoController@store");
    $router->put("/{id}", "RepresentacaoController@update");
    $router->delete("/{id}", "RepresentacaoController@destroy");
});

$router->group(['prefix' => "/api/osc/"], function() use ($router){
    $router->get('/', 'OscController@getAll');
    $router->get("/{id}", 'OscController@get');
    $router->post("/", "OscController@store");
    $router->put("/{id}", "OscController@update");
    $router->delete("/{id}", "OscController@destroy");
});
/*
$router->group(['prefix' => "/api/osc/"], function () use ($router) {
    $router->get('/barratransparencia/{id_osc}', 'App\Http\Controllers\AnalisesController@obterBarraTransparenciaOsc');
    $router->get('/listaatualizadas', 'App\Http\Controllers\AnalisesController@obterListaOscsAtualizadas');
    $router->get('/listaatualizadas/{limit}', 'App\Http\Controllers\AnalisesController@obterListaOscsAtualizadas');
    $router->get('/listaareaatuacao/{cd_area_atuacao}', 'App\Http\Controllers\AnalisesController@obterListaOscsAreaAtuacao');
    $router->get('/listaareaatuacao/{cd_area_atuacao}/{limit}', 'App\Http\Controllers\AnalisesController@obterListaOscsAreaAtuacao');
    $router->get('/listaareaatuacao/{cd_area_atuacao}/municipio/{cd_municipio}', 'App\Http\Controllers\AnalisesController@obterListaOscsAreaAtuacaoMunicipio');
    $router->get('/listaareaatuacao/{cd_area_atuacao}/municipio/{cd_municipio}/{limit}', 'App\Http\Controllers\AnalisesController@obterListaOscsAreaAtuacaoMunicipio');
    $router->get('/listaareaatuacao/{cd_area_atuacao}/geolocalizacao/{latitude}/{longitude}', 'App\Http\Controllers\AnalisesController@obterListaOscsAreaAtuacaoGeolocalizacao');
    $router->get('/listaareaatuacao/{cd_area_atuacao}/geolocalizacao/{latitude}/{longitude}/{limit}', 'App\Http\Controllers\AnalisesController@obterListaOscsAreaAtuacaoGeolocalizacao');

    $router->get('/no_project/{id}', 'App\Http\Controllers\OscController@getOscNoProject');
    $router->get('/{id}', 'App\Http\Controllers\OscController@get');

    $router->get('/dataatualizacao/{id_osc}', 'App\Http\Controllers\OscController@obterDataAtualizacao');
    $router->get('/popup/{id_osc}', 'App\Http\Controllers\OscController@obterPopup');
    $router->get('/cabecalho/{id_osc}', 'App\Http\Controllers\OscController@obterCabecalho');
    $router->get('/dados_gerais/{id_osc}', 'App\Http\Controllers\OscController@obterDadosGerais');
    $router->get('/descricao/{id_osc}', 'App\Http\Controllers\OscController@obterDescricao');
    $router->get('/area_atuacao/{id_osc}', 'App\Http\Controllers\OscController@obterAreaAtuacao');
    $router->get('/certificado/{id_osc}', 'App\Http\Controllers\OscController@obterCertificados');
    $router->get('/participacao_social/{id_osc}', 'App\Http\Controllers\OscController@obterParticipacaoSocial');
    $router->get('/relacoes_trabalho_governanca/{id_osc}', 'App\Http\Controllers\OscController@obterRelacoesTrabalhoGovernanca');
    $router->get('/recursos/{id_osc}', 'App\Http\Controllers\OscController@obterRecursos');
    $router->get('/projeto/{id}', 'App\Http\Controllers\ProjetoController@obterProjetos');
    $router->get('/projeto_abreviado/{id}', 'App\Http\Controllers\ProjetoController@obterProjetos');
    $router->get('/{component}/{id}', 'App\Http\Controllers\OscController@getComponentOsc');

});

*/