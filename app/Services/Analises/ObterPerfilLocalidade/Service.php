<?php

namespace App\Services\Analises\ObterPerfilLocalidade;

use App\Services\BaseService;
use App\Dao\Analises\PerfilLocalidadeDao;
use App\Util\FontesUtil;

class Service extends BaseService{
	public function executar(){
		$conteudoRequisicao = $this->requisicao->getConteudo();
		$modelo = new Model($conteudoRequisicao);
		
	    if($modelo->obterCodigoResposta() === 200){
	    	$requisicao = $modelo->obterRequisicao();
			$resultadoDao = (new PerfilLocalidadeDao())->obterPerfilLocalidade($requisicao);
			
	    	if($resultadoDao->codigo === 200){
				$resultado = json_decode($resultadoDao->resultado);

                $resultado->area_atuacao->fontes = FontesUtil::AgruparFontes($resultado->area_atuacao->fontes);

                $resultado->caracteristicas->ft_quantidade_projetos = FontesUtil::AgruparFontes($resultado->caracteristicas->ft_quantidade_projetos);

                $resultado->caracteristicas->ft_quantidade_trabalhadores = FontesUtil::AgruparFontes($resultado->caracteristicas->ft_quantidade_trabalhadores);

                $resultado->trabalhadores->fontes = FontesUtil::AgruparFontes($resultado->trabalhadores->fontes);

                $this->resposta->prepararResposta($resultado, 200);
	    	}else{
				$mensagem = $resultadoDao->mensagem;
				$codigo = $resultadoDao->codigo;
	    		$this->resposta->prepararResposta(['msg' => $mensagem], $codigo);
	    	}
	    }else{
			$mensagem = $modelo->obterMensagemResposta();
			$codigo = $modelo->obterCodigoResposta();
            $this->resposta->prepararResposta($mensagem, $codigo);
        }
	}
}