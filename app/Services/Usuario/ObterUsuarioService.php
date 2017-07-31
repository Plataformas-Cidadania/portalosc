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
	public function executar($requisicao)
	{
	    $contrato = [
	        'id_usuario' => ['apelidos' => NomenclaturaAtributoEnum::ID_USUARIO, 'obrigatorio' => true, 'tipo' => 'numeric']
	    ];
	    
	    $model = new Model($contrato, $requisicao->obterConteudo());
	    $model->ajustarRequisicao();
	    $model->validarRequisição();
	    
	    if($model->getDadosFantantes()){
	        $this->resposta->prepararResposta(['msg' => 'Dado(s) obrigatório(s) não enviado(s).'], 400);
	    }else if($model->getDadosInvalidos()){
	        $this->resposta->prepararResposta(['msg' => 'Dado(s) obrigatório(s) inválido(s).'], 400);
	    }else{
	        $usuarioDao = new UsuarioDao();
	        $resultadoDao = $usuarioDao->obterUsuario($model->getRequisicao());
	        
	        if($resultadoDao){
	            switch($resultadoDao->cd_tipo_usuario){
	                case TipoUsuarioEnum::OSC:
	                    $oscs = array();
	                    foreach($requisicao->obterUsuario()->representacao as $key => $value){
	                        array_push($oscs, (new OscDao())->obterIdNomeOsc((object) ['id_osc' => $value]));
	                    }
	                    
	                    $resultadoDao->representacao = $oscs;
	                    break;
	                    
	                case TipoUsuarioEnum::GOVERNO_MUNICIPAL:
	                    $requisicao = (object) ['cd_municipio' => $requisicao->obterUsuario()->localidade];
	                    $resultadoDao->localidade = (new GeograficoDao())->obterMunicipio($requisicao);
	                    break;
	                    
	                case TipoUsuarioEnum::GOVERNO_ESTADUAL:
	                    $requisicao = (object) ['cd_uf' => $requisicao->obterUsuario()->localidade];
	                    $resultadoDao->localidade = (new GeograficoDao())->obterEstado($requisicao);
	                    break;
	            }
	            
                $conteudoResposta = $this->configurarConteudoResposta($resultadoDao);
                $this->resposta->prepararResposta($conteudoResposta, 200);
	        }else{
	            $this->resposta->prepararResposta(['msg' => 'Usuário inválido.'], 401);
	        }
	    }
	    
		return $this->resposta;
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
