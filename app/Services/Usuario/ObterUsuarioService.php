<?php

namespace App\Services\Usuario;

use App\Services\Service;
use App\Models\Model;
use App\Dao\Usuario\UsuarioDao;
use App\Dao\OscDao;
use App\Dao\GeograficoDao;
use App\Enums\TipoUsuarioEnum;

class ObterUsuarioService extends Service
{
	public function executar()
	{
	    $estrutura = array(
	        'id_usuario' => [
				'apelidos' => ['idUsuario', 'id_usuario'], 
				'obrigatorio' => true, 
				'tipo' => 'integer'
			]
		);
		
		$requisicao = $this->requisicao->getConteudo();
		
		$modelo = new Model();
		$modelo->configurarEstrutura($estrutura);
    	$modelo->configurarRequisicao($requisicao);
		$modelo->analisarRequisicao();
	    
	    if($modelo->obterCodigoResposta() === 200){
			$requisicao = $modelo->obterRequisicao();
	        $usuario = (new UsuarioDao())->obterUsuario($requisicao->id_usuario);
	        
	        $flagUsuario = $this->analisarDaoObterUsuario($usuario);
	        
	        if($flagUsuario){
	            $usuarioRequisicao = $this->requisicao->getUsuario();
	            
	            if($usuario){
		            switch($usuario->cd_tipo_usuario){
		                case TipoUsuarioEnum::OSC:
		                    $usuario->representacao = (new OscDao())->obterIdNomeOscs($usuarioRequisicao->representacao);
		                    break;
		                    
		                case TipoUsuarioEnum::GOVERNO_MUNICIPAL:
		                    $usuario->localidade = (new GeograficoDao())->obterMunicipio($usuarioRequisicao->localidade);
		                    $usuario->localidade = 'Município de ' . $usuario->localidade->edmu_nm_municipio . ' - ' . $usuario->localidade->eduf_sg_uf;
		                    break;
		                    
		                case TipoUsuarioEnum::GOVERNO_ESTADUAL:
		                    $usuario->localidade = (new GeograficoDao())->obterEstado($usuarioRequisicao->localidade);
		                    $usuario->localidade = 'Estado de ' . $usuario->localidade->eduf_nm_uf;
		                    break;
		            }
		            
		            $conteudoResposta = $this->configurarConteudoResposta($usuario);
		            $this->resposta->prepararResposta($conteudoResposta, 200);
	            }else{
	            	$this->resposta->prepararResposta(null, 204);
	            }
	        }
	    }else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
	}
	
	private function analisarDaoObterUsuario($usuario){
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
	        	unset($resposta->tx_orgao_trabalha);
	        	unset($resposta->tx_telefone_1);
	        	unset($resposta->tx_telefone_2);
	        	unset($resposta->tx_dado_institucional);
	        	unset($resposta->tx_email_confirmacao);
	        	unset($resposta->bo_lista_atualizacao_trimestral);
	            unset($resposta->cd_municipio);
	            unset($resposta->cd_uf);
	            break;
            	
	        case TipoUsuarioEnum::OSC:
	        	unset($resposta->tx_orgao_trabalha);
	        	unset($resposta->tx_telefone_1);
	        	unset($resposta->tx_telefone_2);
	        	unset($resposta->tx_dado_institucional);
	        	unset($resposta->tx_email_confirmacao);
	        	unset($resposta->bo_lista_atualizacao_trimestral);
	            unset($resposta->cd_municipio);
	            unset($resposta->cd_uf);
	            break;
	            
	        case TipoUsuarioEnum::GOVERNO_MUNICIPAL:
	        	unset($resposta->cd_municipio);
	            unset($resposta->cd_uf);
	            break;
	            
	        case TipoUsuarioEnum::GOVERNO_ESTADUAL:
	            unset($resposta->cd_municipio);
	            unset($resposta->cd_uf);
	            break;
	    }
	    
	    $resposta->msg = 'Dados de usuário enviados.';
	    
	    return $resposta;
	}
}