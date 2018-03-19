<?php

namespace App\Services\Usuario;

use App\Services\Service;
use App\Models\Model;
use App\Dao\Usuario\UsuarioDao;

class VerificarRepresentanteGovernoAtivoService extends Service
{
	public function executar()
	{
		$estrutura = array(
	        'cd_localidade' => [
				'apelidos' => ['cd_localidade', 'localidade'], 
				'obrigatorio' => true, 
				'tipo' => 'localidade'
			]
		);
		
		$requisicao = $this->requisicao->getConteudo();
		
		$modelo = new Model();
		$modelo->configurarEstrutura($estrutura);
    	$modelo->configurarRequisicao($requisicao);
		$modelo->analisarRequisicao();
	    
	    if($modelo->obterCodigoResposta() === 200){
	        $resultado = (new UsuarioDao())->verificarRepresentanteGovernoAtivo($modelo->obterRequisicao()->localidade);
	        
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