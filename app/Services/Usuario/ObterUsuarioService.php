<?php

namespace App\Services\Usuario;

use App\Enums\NomenclaturaAtributoEnum;
use App\Enums\TipoUsuarioEnum;
use App\Services\Service;
use App\Services\Model;
use App\Dao\UsuarioDao;
use App\Dao\OscDao;
use App\Dao\GeograficoDao;

class ObterUsuarioService extends Service
{
	public function executar()
	{
	    $contrato = [
	        'id_usuario' => ['apelidos' => NomenclaturaAtributoEnum::ID_USUARIO, 'obrigatorio' => true, 'tipo' => 'numeric']
	    ];
	    
	    $model = new Model($contrato, $this->requisicao->getConteudo());
	    $flagModel = $this->analisarModel($model);
	    
	    if($flagModel){
	        $usuario = (new UsuarioDao())->obterUsuario($model->getRequisicao());
	        
	        $flagUsuario = $this->analisarDao($usuario);
	        
	        if($flagUsuario){
	            $usuarioRequisicao = $this->requisicao->getUsuario();
	            
	            switch($usuario->cd_tipo_usuario){
	                case TipoUsuarioEnum::OSC:
	                    $usuario->representacao = (new OscDao())->obterIdNomeOscs($usuarioRequisicao->representacao);
	                    break;
	                    
	                case TipoUsuarioEnum::GOVERNO_MUNICIPAL:
	                    $usuario->localidade = (new GeograficoDao())->obterMunicipio($usuarioRequisicao->localidade);
	                    break;
	                    
	                case TipoUsuarioEnum::GOVERNO_ESTADUAL:
	                    $usuario->localidade = (new GeograficoDao())->obterEstado($usuarioRequisicao->localidade);
	                    break;
	            }
	            
	            $conteudoResposta = $this->configurarConteudoResposta($usuario);
                $this->resposta->prepararResposta($conteudoResposta, 200);
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
	
	private function configurarConteudoResposta($resposta){
	    unset($resposta->bo_ativo);
	    
	    switch($resposta->cd_tipo_usuario){
	        case TipoUsuarioEnum::ADMINISTRADOR:
	            unset($resposta->cd_municipio);
	            unset($resposta->cd_uf);
	            break;
            
	        case TipoUsuarioEnum::OSC:
	            unset($resposta->cd_municipio);
	            unset($resposta->cd_uf);
	            break;
	            
	        case TipoUsuarioEnum::GOVERNO_MUNICIPAL:
	            unset($resposta->cd_uf);
	            break;
	            
	        case TipoUsuarioEnum::GOVERNO_ESTADUAL:
	            unset($resposta->cd_municipio);
	            break;
	    }
	    
	    $resposta->msg = 'Dados de usuário enviados.';
	    
	    return $resposta;
	}
}
