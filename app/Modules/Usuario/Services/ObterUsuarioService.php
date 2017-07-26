<?php

namespace App\Components\Usuario\Services;

use App\Enums\TipoUsuarioEnum;

use App\Components\Service;
use App\Components\Usuario\Models\UsuarioModel;
use App\Components\Usuario\DAO\UsuarioDAO;

class ObterUsuarioService extends Service
{
	public function executar($requisicao)
	{
	    $usuario = $requisicao->obterUsuario();
	    $conteudo = $requisicao->obterConteudo();
	    
	    $model = new UsuarioModel();
	    $model->setId($conteudo->id_usuario);
	    
	    $model->verificarDadosObrigatorios();
	    
		$resultCheck = $this->verificarRequisicao();
		if($resultCheck){
		    $conteudoResposta->msg = $resultCheck;
		    $this->resposta->prepararResposta($conteudoResposta, 400);
		}else{
			$dao = new UsuarioDAO();
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
