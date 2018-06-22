<?php

$app->get('/', function () { return 'API Mapa OSC'; });
$app->get('api', function () { return 'API Mapa OSC'; });

$app->group(['prefix' => 'api', 'middleware' => ['cors']], function () use ($app) {
    $app->get('sobre', 'App\Http\Controllers\Controller@obterSobre');
});

$app->group(['prefix' => 'api/gov', 'middleware' => ['cors', 'auth-user']], function () use ($app) {
	$app->post('carregararquivoparcerias', 'App\Http\Controllers\GovernoController@carregarArquivo');
});

$app->group(['prefix' => 'api/osc', 'middleware' => ['cors']], function () use ($app) {
	$app->get('barratransparencia/{id_osc}', 'App\Http\Controllers\AnalisesController@obterBarraTransparenciaOsc');
    $app->get('listaatualizadas', 'App\Http\Controllers\AnalisesController@obterListaOscsAtualizadas');
	$app->get('listaatualizadas/{limit}', 'App\Http\Controllers\AnalisesController@obterListaOscsAtualizadas');
    $app->get('listaareaatuacao/{cd_area_atuacao}', 'App\Http\Controllers\AnalisesController@obterListaOscsAreaAtuacao');
	$app->get('listaareaatuacao/{cd_area_atuacao}/{limit}', 'App\Http\Controllers\AnalisesController@obterListaOscsAreaAtuacao');
    $app->get('listaareaatuacao/{cd_area_atuacao}/municipio/{cd_municipio}', 'App\Http\Controllers\AnalisesController@obterListaOscsAreaAtuacaoMunicipio');
    $app->get('listaareaatuacao/{cd_area_atuacao}/municipio/{cd_municipio}/{limit}', 'App\Http\Controllers\AnalisesController@obterListaOscsAreaAtuacaoMunicipio');
    $app->get('listaareaatuacao/{cd_area_atuacao}/geolocalizacao/{latitude}/{longitude}', 'App\Http\Controllers\AnalisesController@obterListaOscsAreaAtuacaoGeolocalizacao');
	$app->get('listaareaatuacao/{cd_area_atuacao}/geolocalizacao/{latitude}/{longitude}/{limit}', 'App\Http\Controllers\AnalisesController@obterListaOscsAreaAtuacaoGeolocalizacao');

	$app->get('no_project/{id}', 'App\Http\Controllers\OscController@getOscNoProject');
	$app->get('{id}', 'App\Http\Controllers\OscController@getOsc');
	
	$app->get('dataatualizacao/{id_osc}', 'App\Http\Controllers\OscController@obterDataAtualizacao');
	$app->get('popup/{id_osc}', 'App\Http\Controllers\OscController@obterPopup');
	$app->get('cabecalho/{id_osc}', 'App\Http\Controllers\OscController@obterCabecalho');
	$app->get('dados_gerais/{id_osc}', 'App\Http\Controllers\OscController@obterDadosGerais');
	$app->get('descricao/{id_osc}', 'App\Http\Controllers\OscController@obterDescricao');
	$app->get('area_atuacao/{id_osc}', 'App\Http\Controllers\OscController@obterAreaAtuacao');
	$app->get('certificado/{id_osc}', 'App\Http\Controllers\OscController@obterCertificados');
	$app->get('participacao_social/{id_osc}', 'App\Http\Controllers\OscController@obterParticipacaoSocial');
	$app->get('relacoes_trabalho_governanca/{id_osc}', 'App\Http\Controllers\OscController@obterRelacoesTrabalhoGovernanca');
	$app->get('recursos/{id_osc}', 'App\Http\Controllers\OscController@obterRecursos');
	$app->get('projeto/{id_osc}', 'App\Http\Controllers\ProjetoController@obterProjetos');
	$app->get('projeto_abreviado/{id_osc}', 'App\Http\Controllers\ProjetoController@obterProjetosAbreviados');
	$app->get('{component}/{id}', 'App\Http\Controllers\OscController@getComponentOsc');
});

$app->group(['prefix' => 'api/osc', 'middleware' => ['cors', 'auth-user']], function () use ($app) {
	$app->post('dadosgerais/{id_osc}', 'App\Http\Controllers\OscController@editarDadosGerais');
	$app->post('area_atuacao/{id_osc}', 'App\Http\Controllers\OscController@setAreaAtuacao');
	$app->post('descricao/{id_osc}', 'App\Http\Controllers\OscController@editarDescricao');
	$app->post('certificado/{id_osc}', 'App\Http\Controllers\OscController@editarCertificado');
	$app->post('dirigente/{id_osc}', 'App\Http\Controllers\OscController@setDirigente');
	$app->post('membroconselho/{id_osc}', 'App\Http\Controllers\OscController@updateMembroConselho');
	$app->post('relacoestrabalho/{id_osc}', 'App\Http\Controllers\OscController@setRelacoesTrabalho');
	$app->post('relacoestrabalhooutra/{id_osc}', 'App\Http\Controllers\OscController@outrosTrabalhadores');
	$app->post('participacaosocialconselho/{id_osc}', 'App\Http\Controllers\OscController@setParticipacaoSocialConselho');
	$app->post('participacaosocialconferencia/{id_osc}', 'App\Http\Controllers\OscController@setParticipacaoSocialConferencia');
	$app->post('participacaosocialdeclarada/{id_osc}', 'App\Http\Controllers\OscController@updateParticipacaoSocialDeclarada');
	$app->post('participacaosocialoutra/{id_osc}', 'App\Http\Controllers\OscController@setParticipacaoSocialOutra');
	$app->post('linkrecursos/{id_osc}', 'App\Http\Controllers\OscController@updateLinkRecursos');
	$app->post('conselhofiscal/{id_osc}', 'App\Http\Controllers\OscController@setConselhoFiscal');
	$app->post('projeto/{id_osc}', 'App\Http\Controllers\ProjetoController@editarProjetos');
	$app->post('recursososc/{id_osc}', 'App\Http\Controllers\OscController@editarRecursos');
	$app->post('recursosoutroosc/{id_osc}', 'App\Http\Controllers\OscController@updateRecursosOutroOsc');
	$app->post('relacoes_trabalho_governanca/{id_osc}', 'App\Http\Controllers\OscController@RelacoesTrabalhoGovernanca');
	$app->post('areaatuacaooutra', 'App\Http\Controllers\OscController@setAreaAtuacaoOutra');
	$app->post('participacaosocialdeclarada', 'App\Http\Controllers\OscController@setParticipacaoSocialDeclarada');
	$app->post('recursosoutroosc', 'App\Http\Controllers\OscController@setRecursosOutroOsc');
	$app->delete('areaatuacaooutra/{id_areaoutra}/{id}', 'App\Http\Controllers\OscController@deleteAreaAtuacaoOutra');
	$app->delete('membroconselho/{id_membro}/{id}', 'App\Http\Controllers\OscController@deleteMembroConselho');
	$app->delete('participacaosocialdeclarada/{id_declarada}/{id}', 'App\Http\Controllers\OscController@deleteParticipacaoSocialDeclarada');
	$app->delete('recursosoutroosc/{id_recursosoutro}/{id}', 'App\Http\Controllers\OscController@deleteRecursosOutroOsc');

	$app->post('projeto/insert/{id_osc}', 'App\Http\Controllers\ProjetoController@editarProjetos');
	$app->post('projeto/{id_projeto}/{id_osc}', 'App\Http\Controllers\ProjetoController@deletarProjeto');
});

$app->group(['prefix' => 'api/geo', 'middleware' => ['cors']], function () use ($app) {
	$app->get('osc', 'App\Http\Controllers\GeograficoController@obterTodasOscs');
	$app->get('osc/{id_osc}', 'App\Http\Controllers\GeograficoController@obterOsc');
	$app->get('osc/{tipo_regiao}/{id_regiao}', 'App\Http\Controllers\GeograficoController@obterOscsRegiao');
	$app->get('osc/{norte}/{sul}/{leste}/{oeste}', 'App\Http\Controllers\GeograficoController@obterOscsArea');
	$app->get('cluster/{tipo_regiao}', 'App\Http\Controllers\GeograficoController@obterCluster');
	$app->get('cluster/{tipo_regiao}/{id_regiao}', 'App\Http\Controllers\GeograficoController@obterCluster');
	$app->get('localidade/{tipo_regiao}/{latitude}/{longitude}', 'App\Http\Controllers\GeograficoController@obterNomeLocalidade');
});

$app->group(['prefix' => 'api/user', 'middleware' => ['cors']], function () use ($app) {
	$app->get('ativarcadastro/{tx_token}', 'App\Http\Controllers\UsuarioController@ativarUsuario');
	$app->get('solicitarativacao/{tx_token}', 'App\Http\Controllers\UsuarioController@solicitarAtivacaoUsuario');
});

$app->group(['prefix' => 'api/user', 'middleware' => ['cors']], function () use ($app) {
	$app->get('governo/ativo/localidade/{cd_localidade}', 'App\Http\Controllers\UsuarioController@verificarRepresentanteGovernoAtivoService');
	$app->post('/', 'App\Http\Controllers\UsuarioController@criarRepresentanteOsc');
	$app->post('osc', 'App\Http\Controllers\UsuarioController@criarRepresentanteOsc');
	$app->post('governo', 'App\Http\Controllers\UsuarioController@criarRepresentanteGoverno');
	$app->post('login', 'App\Http\Controllers\UsuarioController@login');
	$app->post('contato', 'App\Http\Controllers\UsuarioController@enviarContato');
	$app->post('alterarsenha', 'App\Http\Controllers\UsuarioController@alterarSenha');
	$app->post('esquecisenha', 'App\Http\Controllers\UsuarioController@solicitarAlteracaoSenha');
	$app->post('newsletter', 'App\Http\Controllers\UsuarioController@criarAssinanteNewsletter');
});

$app->group(['prefix' => 'api/user', 'middleware' => ['cors', 'auth-user']], function () use ($app) {
	$app->get('logout/{id_usuario}', 'App\Http\Controllers\UsuarioController@logout');
	$app->get('{id_usuario}', 'App\Http\Controllers\UsuarioController@obterUsuario');
	$app->post('{id_usuario}', 'App\Http\Controllers\UsuarioController@editarRepresentanteOsc');
	$app->post('osc/{id_usuario}', 'App\Http\Controllers\UsuarioController@editarRepresentanteOsc');
	$app->post('governo/{id_usuario}', 'App\Http\Controllers\UsuarioController@editarRepresentanteGoverno');
});

$app->group(['prefix' => 'api/search', 'middleware' => ['cors']], function () use ($app) {
	$app->get('all/{type_result}', 'App\Http\Controllers\SearchController@getSearchList');
	$app->get('all/{type_result}/{limit}', 'App\Http\Controllers\SearchController@getSearchList');
	$app->get('all/{type_result}/{limit}/{offset}', 'App\Http\Controllers\SearchController@getSearchList');
	$app->get('advanced/{type_result}/{limit}/{offset}', 'App\Http\Controllers\SearchController@getAdvancedSearch');
	$app->post('advanced/{type_result}/{limit}/{offset}', 'App\Http\Controllers\SearchController@getAdvancedSearch');
	$app->get('{type_search}/{type_result}/{param}', 'App\Http\Controllers\SearchController@getSearch');
	$app->get('{type_search}/{type_result}/{param}/{limit}', 'App\Http\Controllers\SearchController@getSearch');
	$app->get('{type_search}/{type_result}/{param}/{limit}/{offset}', 'App\Http\Controllers\SearchController@getSearch');
	$app->get('{type_search}/{type_result}/{param}/{limit}/{offset}/{tipoBusca}', 'App\Http\Controllers\SearchController@getSearch');

	//$app->get('{recurso}/{tipoResultado}/{parametro}/{limite}/{deslocamento}/{tipoBusca}', 'App\Http\Controllers\BuscaController@obterBuscaComum');
});

$app->group(['prefix' => 'api/menu', 'middleware' => ['cors']], function () use ($app) {
	$app->get('osc/{menu}', 'App\Http\Controllers\MenuController@obterMenuOsc');
	$app->get('osc/{menu}/{parametro}', 'App\Http\Controllers\MenuController@obterMenuOsc');
    $app->get('geo/{tipo_regiao}/{parametro}', 'App\Http\Controllers\MenuController@obterMenuGeografico');
	$app->get('geo/{tipo_regiao}/{parametro}/{limit}', 'App\Http\Controllers\MenuController@obterMenuGeografico');
	$app->get('geo/{tipo_regiao}/{parametro}/{limit}/{offset}', 'App\Http\Controllers\MenuController@obterMenuGeografico');
});

$app->group(['prefix' => 'api/edital', 'middleware' => ['cors']], function () use ($app) {
	$app->get('/', 'App\Http\Controllers\EditalController@obterEditais');
});

$app->group(['prefix' => 'api/edital', 'middleware' => ['cors', 'auth-user']], function () use ($app) {
	$app->post('/', 'App\Http\Controllers\EditalController@criarEdital');
	$app->post('adicionar', 'App\Http\Controllers\EditalController@criarEdital');
});

$app->group(['prefix' => 'api', 'middleware' => ['cors']], function () use ($app) {
    $app->get('projeto/{id_projeto}', 'App\Http\Controllers\ComponentController@getProjeto');
});

$app->group(['prefix' => 'api/admin', 'middleware' => ['cors', 'auth-user']], function () use ($app) {
	$app->get('ativarusuario/{tx_token}', 'App\Http\Controllers\UsuarioController@ativarUsuario');
	$app->get('desativarusuario/{tx_token}', 'App\Http\Controllers\UsuarioController@desativarUsuario');
	$app->post('carregararquivoparceriasestadomunicipio', 'App\Http\Controllers\GovernoController@carregarArquivo');
});

$app->group(['prefix' => 'api/analises', 'middleware' => ['cors']], function () use ($app) {
	$app->get('/', 'App\Http\Controllers\AnalisesController@obterGrafico');
});

$app->group(['prefix' => '', 'middleware' => ['cors']], function () use ($app) {
	$route = str_replace(url(), '', URL::full());
    $app->get($route, function () use ($app) {
		$pathUrl = str_replace(url(), '', URL::full());

		if(strpos($pathUrl, '.') !== false){
			$endereco = base_path() . '\public' . $pathUrl;
		}else{
			$endereco = base_path() . '\public' . $pathUrl . '.html';
		}

		return file_get_contents($endereco);
	});
});