<?php

namespace App\Services\Usuario;

use App\Enums\NomenclaturaAtributoEnum;
use App\Enums\TipoUsuarioEnum;
use App\Services\Service;
use App\Services\Model;
use App\Services\Usuario\Dao\ObterUsuarioDao;

class ObterUsuarioService extends Service
{
	public function executar($requisicao)
	{
	    $contrato = [
	        'id_usuario' => ['apelidos' => NomenclaturaAtributoEnum::NOME_USUARIO, 'obrigatorio' => true, 'tipo' => 'email']
	    ];
	    
	    $model = new Model($contrato, $requisicao->obterConteudo());
	    $model->ajustarRequisicao();
	    $model->validarRequisição();
	    
	    if($model->getDadosFantantes()){
	        $this->resposta->prepararResposta(['msg' => 'Dado(s) obrigatório(s) não enviado(s).'], 400);
	    }else if($model->getDadosInvalidos()){
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
