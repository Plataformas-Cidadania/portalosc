<?php

namespace App\Modules\Usuario\Services;

use App\Enums\TipoUsuarioEnum;
use App\Modules\Service;
use App\Modules\Usuario\Models\UsuarioModel;
use App\Modules\Usuario\Dao\LoginDao;

class LoginService extends Service
{
	public function executar($requisicao)
	{
	    $dadosObrigatorios = ['email', 'senha'];
	    
	    $usuarioModel = new UsuarioModel();
	    $usuarioModel->prepararObjeto($requisicao->obterConteudo());
	    
	    $dadosFaltantes = $usuarioModel->verificarDadosObrigatorios($dadosObrigatorios);
	    $dadosInvalidos = $usuarioModel->validarDadosObrigatorios($dadosObrigatorios);
	    
	    if($dadosFaltantes){
	        $this->resposta->prepararResposta(['msg' => 'Dado(s) obrigatório(s) não enviado(s).'], 400);
	    }else if($dadosInvalidos){
	        $this->resposta->prepararResposta(['msg' => 'Dado(s) obrigatório(s) inválido(s).'], 400);
	    }else{
	        $loginDao = new LoginDao();
	        $resultadoDao = $loginDao->executar($usuarioModel);
	    	
	    	if($resultadoDao){
	    		if(!$resultadoDao->getAtivo()){
	    			$conteudoResposta = $this->configurarConteudoResposta($resultadoDao);
	    			$this->resposta->prepararResposta($conteudoResposta, 200);
	    		}else{
	    			$this->resposta->prepararResposta(['msg' => 'Usuário não ativado.'], 403);
	    		}
	    	}else{
	    		$this->resposta->prepararResposta(['msg' => 'Usuário inválido.'], 401);
	    	}
	    }
	    
	    return $this->resposta;
	}
	
	private function configurarConteudoResposta($resultadoDao)
	{
	    $expiracao = strtotime('+15 minutes');
	    
	    $conteudo['msg'] = 'Login realizado com sucesso.';
	    $conteudo['id_usuario'] = $resultadoDao->getId();
	    $conteudo['tx_nome_usuario'] = $resultadoDao->getNome();
	    $conteudo['tipo_usuario'] = $resultadoDao->getTipoUsuario();
	    
	    if($resultadoDao->getTipoUsuario() == TipoUsuarioEnum::ADMINISTRADOR){
	        $token = $resultadoDao->getId() . '_' . $resultadoDao->getTipoUsuario() . '_' . $expiracao;
	    }else if($resultadoDao->getTipoUsuario() == TipoUsuarioEnum::OSC){
	        $conteudo['representacao'] = '[' . implode(',', $resultadoDao->getOscs()) . ']';
	        $token = $resultadoDao->getId() . '_' . $resultadoDao->getTipoUsuario() . '_' . $conteudo['representacao'] . '_' . $expiracao;
	    }else if($resultadoDao->getTipoUsuario() == TipoUsuarioEnum::GOVERNO_MUNICIPAL){
	        $conteudo['localidade'] = $resultadoDao->getCodigo();
	        $token = $resultadoDao->getId() . '_' . $resultadoDao->getTipoUsuario() . '_' . $conteudo['localidade'] . '_' . $expiracao;
	    }else if($resultadoDao->getTipoUsuario() == TipoUsuarioEnum::GOVERNO_ESTADUAL){
	        $conteudo['localidade'] = $resultadoDao->getCodigo();
	        $token = $resultadoDao->getId() . '_' . $resultadoDao->getTipoUsuario() . '_' . $conteudo['localidade'] . '_' . $expiracao;
	    }
	    
	    $conteudo['access_token'] = openssl_encrypt($token, 'AES-128-ECB', getenv('KEY_ENCRYPTION'));
	    $conteudo['token_type'] = 'Bearer';
	    $conteudo['expires_in'] = $expiracao;
	    
	    return $conteudo;
	}
}
