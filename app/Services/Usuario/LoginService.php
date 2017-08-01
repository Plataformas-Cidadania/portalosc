<?php

namespace App\Services\Usuario;

use App\Enums\NomenclaturaAtributoEnum;
use App\Enums\TipoUsuarioEnum;
use App\Services\Service;
use App\Services\Model;
use App\Dao\UsuarioDao;

class LoginService extends Service
{
	public function executar()
	{
	    $contrato = [
	        'tx_email_usuario' => ['apelidos' => NomenclaturaAtributoEnum::EMAIL, 'obrigatorio' => true, 'tipo' => 'email'],
	        'tx_senha_usuario' => ['apelidos' => NomenclaturaAtributoEnum::SENHA, 'obrigatorio' => true, 'tipo' => 'senha']
	    ];
	    
	    $model = new Model($contrato, $this->requisicao->getConteudo());
	    
	    if($model->getDadosFantantes()){
	        $this->resposta->prepararResposta(['msg' => 'Dado(s) obrigatório(s) não enviado(s).'], 400);
	    }else if($model->getDadosInvalidos()){
	        $this->resposta->prepararResposta(['msg' => 'Dado(s) obrigatório(s) inválido(s).'], 400);
	    }else{
	        $usuarioDao = new UsuarioDao();
	        
	        $usuarioDao->setRequisicao($model->getRequisicao());
	        $usuarioDao->login();
	        $usuario = $usuarioDao->getResposta();
	        
	        if($usuario){
	            if($usuario->bo_ativo){
	                if($usuario->cd_tipo_usuario == TipoUsuarioEnum::OSC){
	                    $usuarioDao->setRequisicao($usuario);
	                    $usuarioDao->obterIdOscsDeRepresentante();
	                    $usuario->representacao = $usuarioDao->getResposta();
	                }
	                
	                $conteudoResposta = $this->configurarConteudoResposta($usuario);
	    			$this->resposta->prepararResposta($conteudoResposta, 200);
	    		}else{
	    			$this->resposta->prepararResposta(['msg' => 'Usuário não ativado.'], 403);
	    		}
	    	}else{
	    		$this->resposta->prepararResposta(['msg' => 'E-mail e/ou senha incorreto(s).'], 401);
	    	}
	    }
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
	    
	    $resposta->access_token = openssl_encrypt($token, 'AES-128-ECB', getenv('KEY_ENCRYPTION'));
	    $resposta->token_type = 'Bearer';
	    $resposta->expires_in = $expiracao;
	    $resposta->msg = 'Login realizado com sucesso.';
	    
	    return $resposta;
	}
}
