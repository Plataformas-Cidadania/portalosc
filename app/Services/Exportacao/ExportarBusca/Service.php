<?php

namespace App\Services\Exportacao\ExportarBusca;

use App\Services\BaseService;
use App\Dao\Cache\CacheExportarDao;
use App\Dao\Exportacao\ExportacaoBuscaDao;

class Service extends BaseService{
	public function executar(){
		$conteudoRequisicao = $this->requisicao->getConteudo();
		
		$modelo = new Model($conteudoRequisicao);
		
		if($modelo->obterCodigoResposta() == 200){
			$requisicao = $modelo->obterRequisicao();
			
			$cacheExportarDao = (new CacheExportarDao())->obterExportar($requisicao);

			if($cacheExportarDao->codigo === 200){
				$requisicao->listaOsc = $cacheExportarDao->resultado;
				$resultadoDao = (new ExportacaoBuscaDao())->exportarBusca($requisicao);

				if($resultadoDao->codigo === 200){
					$resultado = json_decode($resultadoDao->resultado);
					$this->resposta->prepararResposta($resultado, 200);
				}else{
					$mensagem = $resultadoDao->mensagem;
					$codigo = $resultadoDao->codigo;
					$this->resposta->prepararResposta(['msg' => $mensagem], $codigo);
				}
			}else{
				$mensagem = $cacheExportarDao->mensagem;
				$codigo = $cacheExportarDao->codigo;
				$this->resposta->prepararResposta(['msg' => $mensagem], $codigo);
			}
        }else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
	}
}