<?php

namespace App\Services\Usuario;

use App\Services\Service;
use App\DAO\Usuario\ObterUsuarioDAO;

class ObterUsuarioService extends Service
{
	private function obterModelo()
	{
		$objeto = array();
		
		$objeto['id_usuario'] = ['obrigatorio' => true];
		$objeto['tx_email_usuario'] = ['obrigatorio' => true];
		$objeto['tx_nome_usuario'] = ['obrigatorio' => true];
		$objeto['tx_senha_usuario'] = ['obrigatorio' => true];
		$objeto['representacao'] = ['obrigatorio' => true];
		
		return $objeto;
	}
	
	public function executar($requisicao)
	{
		$this->atributos = $this->obterModelo();
		
		$content['msg'] = 'Usuário obtido com sucesso.';
		$this->resposta->setResponse($content, 200);
		
		$resultCheck = $this->verificarRequisicao();
		if($resultCheck){
			$content['msg'] = $resultCheck;
			$this->resposta->setResponse($content, 400);
		}else{
			$dao = new ObterUsuarioDAO();
			$resultDao = $dao->executar($requisicao);
			
			if($resultDao){
				$this->resposta->updateContent($resultDao);
			}else{
				$content['msg'] = 'Usuário não encontrado.';
				$this->resposta->setResponse($content, 400);
			}
		}
		
		return $this->resposta;
	}
}
