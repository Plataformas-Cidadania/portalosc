<?php

namespace App\Modules\Usuario\Services;

use App\Enums\TipoUsuarioEnum;
use App\Modules\Service;
use App\Modules\Usuario\Models\UsuarioModel;
use App\Modules\Usuario\Dao\LoginDao;

class LoginService extends Service
{
	private function configurarConteudoResposta($resultadoDao){
		$expiracao = strtotime('+15 minutes');
		
		$conteudo['msg'] = 'Login realizado com sucesso.';
		$conteudo['id_usuario'] = $resultadoDao->getId();
		$conteudo['tx_nome_usuario'] = $resultadoDao->getNome();
		$conteudo['cd_tipo_usuario'] = $resultadoDao->getTipoUsuario();
		
		if($resultadoDao->getTipoUsuario() == TipoUsuarioEnum::ADMINISTRADOR){
			$token = $resultadoDao->getId() . '_' . $resultadoDao->getTipoUsuario() . '_' . $expiracao;
		}else if($resultadoDao->getTipoUsuario() == TipoUsuarioEnum::OSC){
			$conteudo['representacao'] = $resultadoDao->getOscs();
			$token = $resultadoDao->getId() . '_' . $resultadoDao->getTipoUsuario() . '_' . implode(',', $resultadoDao->getOscs()) . '_' . $expiracao;
		}else if($resultadoDao->getTipoUsuario() == TipoUsuarioEnum::GOVERNO_MUNICIPAL){
			$conteudo['localidade'] = $resultadoDao->getCodigo();
			$token = $resultadoDao->getId() . '_' . $resultadoDao->getTipoUsuario() . '_' . $resultadoDao->getCodigo() . '_' . $expiracao;
		}else if($resultadoDao->getTipoUsuario() == TipoUsuarioEnum::GOVERNO_ESTADUAL){
			$conteudo['localidade'] = $resultadoDao->getCodigo();
			$token = $resultadoDao->getId() . '_' . $resultadoDao->getTipoUsuario() . '_' . $resultadoDao->getCodigo() . '_' . $expiracao;
		}
		
		$conteudo['access_token'] = openssl_encrypt($token, 'AES-128-ECB', getenv('KEY_ENCRYPTION'));
		$conteudo['token_type'] = 'Bearer';
		$conteudo['expires_in'] = $expiracao;
		
		return $conteudo;
	}
	
	public function executar($requisicao)
	{
	    $dadosObrigatorios = ['email', 'senha'];
	    
	    $model = new UsuarioModel();
	    $model->prepararObjeto($requisicao->obterConteudo());
	    
	    $dadosFaltantes = $model->verificarDadosObrigatorios($dadosObrigatorios);
	    $dadosInvalidos = $model->validarDadosObrigatorios($dadosObrigatorios);
	    
	    if($dadosFaltantes){
	        $this->resposta->prepararResposta(['msg' => 'Dado(s) obrigatório(s) não enviado(s).'], 400);
	    }else if($dadosInvalidos){
	        $this->resposta->prepararResposta(['msg' => 'Dado(s) obrigatório(s) inválido(s).'], 400);
	    }else{
	    	$dao = new LoginDao();
	    	$resultadoDao = $dao->login($model);
	    	
	    	if($resultadoDao){
	    		if($resultadoDao){
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
}
