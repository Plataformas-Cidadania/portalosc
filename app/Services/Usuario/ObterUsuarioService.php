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
	        $usuarioDao = new UsuarioDao();
	        $usuario = $usuarioDao->obterUsuario($model->getRequisicao());
	        
	        $flagUsuario = $this->analisarDao($usuario);
	        
	        if($flagUsuario){
	            switch($usuario->cd_tipo_usuario){
	                case TipoUsuarioEnum::OSC:
	                    $usuario->representacao = $this->obterOscsRepresentante($this->requisicao->getUsuario());
	                    break;
	                    
	                case TipoUsuarioEnum::GOVERNO_MUNICIPAL:
	                    $usuario->localidade = $this->obterMunicipioRepresentante($this->requisicao->getUsuario());
	                    break;
	                    
	                case TipoUsuarioEnum::GOVERNO_ESTADUAL:
	                    $usuario->localidade = $this->obterEstadoRepresentante($this->requisicao->getUsuario());
	                    break;
	            }
	            
	            $conteudoResposta = $this->configurarConteudoResposta($usuario);
                $this->resposta->prepararResposta($conteudoResposta, 200);
	        }
	    }
	}
	
	private function obterOscsRepresentante($usuario){
	    return (new OscDao())->obterIdNomeOscs($usuario);
	}
	
	private function obterMunicipioRepresentante($usuario){
	    $requisicao = new \stdClass();
	    $requisicao->cd_municipio = $usuario->localidade;
	    
	    $geograficoDao = new GeograficoDao();
	    return $geograficoDao->obterMunicipio($requisicao);
	}
	
	private function obterEstadoRepresentante($usuario){
	    $requisicao = new \stdClass();
	    $requisicao->cd_uf = $usuario->localidade;
	    
	    $geograficoDao = new GeograficoDao();
	    return $geograficoDao->obterEstado($requisicao);
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
