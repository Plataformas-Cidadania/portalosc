<?php

namespace App\Services\Usuario;

use App\Enums\NomenclaturaAtributoEnum;
use App\Services\Service;
use App\Services\Model;
use App\Dao\UsuarioDao;

class VerificarRepresentanteGovernoAtivoService extends Service
{
	public function executar()
	{
	    $contrato = [
	        'localidade' => ['apelidos' => NomenclaturaAtributoEnum::LOCALIDADE, 'obrigatorio' => true, 'tipo' => 'localidade']
	    ];
	    
	    $model = new Model($contrato, $this->requisicao->getConteudo());
	    $flagModel = $this->analisarModel($model);
		
	    if($flagModel){
	        $resultado = (new UsuarioDao())->verificarRepresentanteGovernoAtivo($model->getRequisicao()->localidade);
	        
	        $flagUsuario = $this->analisarDao($resultado);
	        
	        if($flagUsuario){
	            $this->resposta->prepararResposta($resultado, 200);
	        }
	    }
	}
	
	private function analisarDao($usuario){
	    $resultado = true;
	    
	    if(!$usuario){
	        $this->resposta->prepararResposta(['msg' => 'Usuário inválido.'], 401);
	        $this->flag = false;
	    }
	    
	    return $resultado;
	}
}
