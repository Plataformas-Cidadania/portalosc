<?php

namespace App\Services\Usuario\Login;

use App\Services\BaseService;
use App\Dao\Usuario\LoginDao;
use App\Enums\TipoUsuarioEnum;

class Service extends BaseService
{
	public function executar()
	{
	    $requisicao = $this->requisicao->getConteudo();
		$modelo = new Model($requisicao);
		
	    if($modelo->obterCodigoResposta() === 200){
	        $loginDao = new LoginDao();
			
			$login = $modelo->obterRequisicao();
	        $dao = $loginDao->login($login);
	        
	        $flagUsuario = $this->analisarRespostaDao($dao);
	        
	        if($flagUsuario){
                if($dao->cd_tipo_usuario == TipoUsuarioEnum::OSC){
                    $dao->representacao = $loginDao->obterIdOscsDeRepresentante($dao->id_usuario);
                }
                
                $conteudoResposta = $this->configurarConteudoResposta($dao);
    			$this->resposta->prepararResposta($conteudoResposta, 200);
    		}
	    }else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
	}
	
	private function analisarRespostaDao($dao)
	{
	    $resultado = true;
	    
	    if(!$dao){
	        $this->resposta->prepararResposta(['msg' => 'E-mail e/ou senha incorreto(s).'], 401);
	        $resultado = false;
	    }else if(!$dao->bo_ativo){
	        $this->resposta->prepararResposta(['msg' => 'Usuário não ativado.'], 403);
	        $resultado = false;
	    }else if(!$dao->bo_email_confirmado){
	        $this->resposta->prepararResposta(['msg' => 'Usuário com e-mail não confirmado.'], 403);
	        $resultado = false;
	    }
	    
	    return $resultado;
	}
	
	private function configurarConteudoResposta($resposta)
	{
	    unset($resposta->bo_ativo);
	    
	    $expiracao = strtotime('+15 minutes');
	    
	    switch($resposta->cd_tipo_usuario){
	        case TipoUsuarioEnum::ADMINISTRADOR:
	            unset($resposta->representacao);
	            unset($resposta->cd_municipio);
	            unset($resposta->cd_uf);
	            
	            $token = $resposta->id_usuario . '_' . $resposta->cd_tipo_usuario . '_' . $expiracao;
	            break;
	            
	        case TipoUsuarioEnum::OSC:
	            unset($resposta->cd_municipio);
	            unset($resposta->cd_uf);
	            
	            $resposta->representacao = '[' . implode(',', array_map(function($o) { return $o->id_osc; }, $resposta->representacao)) . ']';
	            $token = $resposta->id_usuario . '_' . $resposta->cd_tipo_usuario . '_' . $resposta->representacao . '_' . $expiracao;
	            break;
	            
	        case TipoUsuarioEnum::GOVERNO_MUNICIPAL:
	            unset($resposta->representacao);
	            unset($resposta->cd_uf);
	            
	            $localidade = $resposta->cd_municipio;
	            $token = $resposta->id_usuario . '_' . $resposta->cd_tipo_usuario . '_' . $localidade . '_' . $expiracao;
	            break;
	            
	        case TipoUsuarioEnum::GOVERNO_ESTADUAL:
	            unset($resposta->representacao);
	            unset($resposta->cd_municipio);
	            
	            $localidade = $resposta->cd_uf;
	            $token = $resposta->id_usuario . '_' . $resposta->cd_tipo_usuario . '_' . $localidade . '_' . $expiracao;
	            break;
	    }
	    
	    $resposta->access_token = $resposta->id_usuario . '|' . openssl_encrypt($token, 'AES-128-ECB', getenv('KEY_ENCRYPTION'));
	    $resposta->token_type = 'Bearer';
	    $resposta->expires_in = $expiracao;
	    $resposta->msg = 'Login realizado com sucesso.';
	    
	    return $resposta;
	}
}