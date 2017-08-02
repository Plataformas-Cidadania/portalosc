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
	    $this->analisarModel($model);
	    
	    if($this->flag){
	        $usuarioDao = new UsuarioDao();
	        
	        $usuarioDao->setRequisicao($model->getRequisicao());
	        $usuarioDao->obterUsuario();
	        $usuario = $usuarioDao->getResposta();
	        
	        $this->analisarDao($usuario);
	        
	        if($this->flag){
	            
	            switch($usuario->cd_tipo_usuario){
	                case TipoUsuarioEnum::OSC:
	                    $usuario->representacao = $this->obterOscsRepresentante();
	                    break;
	                    
	                case TipoUsuarioEnum::GOVERNO_MUNICIPAL:
	                    $usuario->localidade = $this->obterMunicipioRepresentante();
	                    break;
	                    
	                case TipoUsuarioEnum::GOVERNO_ESTADUAL:
	                    $usuario->localidade = $this->obterEstadoRepresentante();
	                    break;
	            }
	            
	            $conteudoResposta = $this->configurarConteudoResposta($usuario);
                $this->resposta->prepararResposta($conteudoResposta, 200);
	        }
	    }
	}
	
	private function obterOscsRepresentante(){
	    $representacao = $this->requisicao->getUsuario()->representacao;
	    $representacao = '{' . implode(",", $representacao) . '}';
	    
	    $requisicao = new \stdClass();
	    $requisicao->representacao = $representacao;
	    
	    $oscDao = new OscDao();
	    $oscDao->setRequisicao($requisicao);
	    $oscDao->obterIdNomeOscs();
	    return $oscDao->getResposta();
	}
	
	private function obterMunicipioRepresentante(){
	    $requisicao = new \stdClass();
	    $requisicao->cd_municipio = $this->requisicao->getUsuario()->localidade;
	    
	    $geograficoDao = new GeograficoDao();
	    $geograficoDao->setRequisicao($requisicao);
	    $geograficoDao->obterMunicipio();
	    return $geograficoDao->getResposta();
	}
	
	private function obterEstadoRepresentante(){
	    $requisicao = new \stdClass();
	    $requisicao->cd_uf = $this->requisicao->getUsuario()->localidade;
	    
	    $geograficoDao = new GeograficoDao();
	    $geograficoDao->setRequisicao($requisicao);
	    $geograficoDao->obterEstado();
	    return $geograficoDao->getResposta();
	}
	
	private function analisarDao($usuario){
	    if(!$usuario){
	        $this->resposta->prepararResposta(['msg' => 'Usuário inválido.'], 401);
	        $this->flag = false;
	    }
	}
	
	private function configurarConteudoResposta($resposta){
	    unset($resposta->bo_ativo);
	    
	    if($resposta->cd_tipo_usuario == TipoUsuarioEnum::ADMINISTRADOR){
	        unset($resposta->cd_municipio);
	        unset($resposta->cd_uf);
	    }else if($resposta->cd_tipo_usuario == TipoUsuarioEnum::OSC){
	        unset($resposta->cd_municipio);
	        unset($resposta->cd_uf);
	    }else if($resposta->cd_tipo_usuario == TipoUsuarioEnum::GOVERNO_MUNICIPAL){
	        unset($resposta->cd_uf);
	    }else if($resposta->cd_tipo_usuario == TipoUsuarioEnum::GOVERNO_ESTADUAL){
	        unset($resposta->cd_municipio);
	    }
	    
	    $resposta->msg = 'Dados de usuário enviados.';
	    
	    return $resposta;
	}
}
