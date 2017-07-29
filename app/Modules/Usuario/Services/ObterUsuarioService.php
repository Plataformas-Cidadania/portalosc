<?php

namespace App\Modules\Usuario\Services;

use App\Enums\TipoUsuarioEnum;
use App\Modules\Service;
use App\Modules\Usuario\Models\UsuarioModel;
use App\Modules\Usuario\Dao\ObterUsuarioDao;

class ObterUsuarioService extends Service
{
	public function executar($requisicao)
	{
	    $dadosObrigatorios = ['id'];
	    
	    $usuarioModel = new UsuarioModel();
	    $usuarioModel->prepararObjeto($requisicao->obterConteudo());
	    
	    $dadosFaltantes = $usuarioModel->verificarDadosObrigatorios($dadosObrigatorios);
	    $dadosInvalidos = $usuarioModel->validarDadosObrigatorios($dadosObrigatorios);
	    
	    if($dadosFaltantes){
	        $this->resposta->prepararResposta(['msg' => 'Dado(s) obrigatório(s) não enviado(s).'], 400);
	    }else if($dadosInvalidos){
	        $this->resposta->prepararResposta(['msg' => 'Dado(s) obrigatório(s) inválido(s).'], 400);
	    }else{
	        $obterUsuarioDao = new ObterUsuarioDao();
	        $resultadoDao = $obterUsuarioDao->executar($usuarioModel);
	        
	        if($resultadoDao){
                $conteudoResposta = $this->configurarConteudoResposta($resultadoDao);
                $this->resposta->prepararResposta($conteudoResposta, 200);
	        }else{
	            $this->resposta->prepararResposta(['msg' => 'Usuário inválido.'], 401);
	        }
	    }
	    
	    
	    
	    /*
		$dao = new UsuarioDAO();
		$conteudoResposta = $dao->executar($conteudo);
		
		if($conteudoResposta){
		    switch($conteudoResposta->cd_tipo_usuario){
		        case TipoUsuarioEnum::OSC:
		            $dao = new OSCDAO();
		            $representacao = $dao->buscarOSCsDeUsuario($usuario);
		            $conteudoResposta->representacao = $representacao;
		            break;
		            
		        case TipoUsuarioEnum::GOVERNO_MUNICIPAL:
		            $dao = new MunicipioDAO();
		            $localidade = $dao->buscarMunicipioPorCodigo($usuario->localidade);
		            $conteudoResposta->localidade = $localidade;
		            break;
		            
		        case TipoUsuarioEnum::GOVERNO_ESTADUAL:
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
		*/
		
		
		
		return $this->resposta;
	}
	
	private function configurarConteudoResposta($resultadoDao){
	    $conteudo['msg'] = 'Dados de usuário enviados.';
	    $conteudo['tx_email_usuario'] = $resultadoDao->getEmail();
	    $conteudo['tx_nome_usuario'] = $resultadoDao->getNome();
	    $conteudo['nr_cpf_usuario'] = $resultadoDao->getCpf();
	    $conteudo['bo_lista_email'] = $resultadoDao->getEmail();
	    $conteudo['cd_tipo_usuario'] = $resultadoDao->getTipoUsuario();
	    
	    if($resultadoDao->getTipoUsuario() == TipoUsuarioEnum::OSC){
	        $representacao = array_map(create_function('$o', 'return [\'id_osc\' => $o->getId(), \'tx_nome_osc\' => $o->getNome()];'), $resultadoDao->getOscs());
	        $conteudo['representacao'] = $representacao;
	    }else if($resultadoDao->getTipoUsuario() == TipoUsuarioEnum::GOVERNO_MUNICIPAL){
	        $conteudo['localidade'] = $resultadoDao->getCodigo();
	    }else if($resultadoDao->getTipoUsuario() == TipoUsuarioEnum::GOVERNO_ESTADUAL){
	        $conteudo['localidade'] = $resultadoDao->getCodigo();
	    }
	    
	    return $conteudo;
	}
}
