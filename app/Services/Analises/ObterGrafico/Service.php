<?php

namespace App\Services\Analises\ObterGrafico;

use App\Services\BaseService;

class Service extends BaseService{
	public function executar(){
		$conteudoRequisicao = $this->requisicao->getConteudo();
		
		$grafico = null;
		if(isset($conteudoRequisicao->grafico)){
			$grafico = $conteudoRequisicao->grafico;
			
			$resposta = ['grafico' => $grafico];
			$this->resposta->prepararResposta($resposta, 200);
		}else{
			$this->resposta->prepararResposta(null, 204);
		}
	}
}