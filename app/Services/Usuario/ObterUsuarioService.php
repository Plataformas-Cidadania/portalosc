<?php

namespace App\Services\Usuario;

use App\Services\Service;
use App\DAO\Usuario\ObterUsuarioDAO;
use App\DAO\OSC\OSCDAO;
use App\DAO\Municipio\MunicipioDAO;
use App\DAO\Estado\EstadoDAO;
use App\Enums\TipoUsuarioEnum;

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
	    $usuario = $requisicao->obterUsuario();
	    $conteudo = $requisicao->obterConteudo();
	    
		$this->atributos = $this->obterModelo();
		
		$resultCheck = $this->verificarRequisicao();
		if($resultCheck){
		    $conteudoResposta->msg = $resultCheck;
		    $this->resposta->prepararResposta($conteudoResposta, 400);
		}else{
			$dao = new ObterUsuarioDAO();
			$conteudoResposta = $dao->executar($conteudo);
			
			if($conteudoResposta){
			    switch($conteudoResposta->cd_tipo_usuario){
			        case TipoUsuarioEnum::OSC:
			            $dao = new OSCDAO();
			            $representacao = $dao->buscarOSCsDeUsuario($usuario);
			            $conteudoResposta->representacao = $representacao;
			            break;
			            
			        case TipoUsuarioEnum::GovernoMunicipal:
			            $dao = new MunicipioDAO();
			            $localidade = $dao->buscarMunicipioPorCodigo($usuario->localidade);
			            $conteudoResposta->localidade = $localidade;
			            break;
			            
			        case TipoUsuarioEnum::GovernoEstadual:
			            $dao = new EstadoDAO();
			            $localidade = $dao->buscarEstadoPorCodigo($usuario->localidade);
			            $conteudoResposta->localidade = $localidade;
			            break;
			    }
			    
			    $conteudoResposta->msg = 'Usuário obtido com sucesso.';
			    $this->resposta->prepararResposta($conteudoResposta, 200);
			}else{
			    $conteudoResposta->msg = 'Usuário não encontrado.';
			    $this->resposta->prepararResposta($conteudoResposta, 400);
			}
		}
		
		return $this->resposta;
	}
}
