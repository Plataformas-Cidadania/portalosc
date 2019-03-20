<?php

namespace App\Services\Usuario\VerificarRepresentanteGovernoAtivo;

use App\Services\BaseService;
use App\Dao\Usuario\UsuarioDao;

class Service extends BaseService
{
	public function executar()
	{
		$requisicao = $this->requisicao->getConteudo();
		$modelo = new Model($requisicao);
	    
	    if($modelo->obterCodigoResposta() === 200){
	        $resultado = (new UsuarioDao())->verificarRepresentanteGovernoAtivo($modelo->obterRequisicao()->cd_localidade);
	        
	        $flagUsuario = $this->analisarDaoVerificadorGovernoAtivo($resultado);
	        
	        if($flagUsuario){
	            $this->resposta->prepararResposta($resultado, 200);
	        }
	    }else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
	}
	
	private function analisarDaoVerificadorGovernoAtivo($usuario){
	    $resultado = true;
	    
	    if(!$usuario){
	        $this->resposta->prepararResposta(['msg' => 'Usuário inválido.'], 401);
	        $this->flag = false;
	    }
	    
	    return $resultado;
	}
}