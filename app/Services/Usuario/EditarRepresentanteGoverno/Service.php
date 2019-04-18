<?php

namespace App\Services\Usuario\EditarRepresentanteGoverno;

use App\Services\BaseService;
use App\Dao\Usuario\UsuarioDao;

class Service extends BaseService
{
	public function executar()
	{
		$requisicao = $this->requisicao->getConteudo();
        $modelo = new Model($requisicao);
		
	    if($modelo->obterCodigoResposta() === 200){
	        $edicaoRepresentanteGoverno = (new UsuarioDao())->editarRepresentanteGoverno($modelo->obterRequisicao());
    		
	        if($edicaoRepresentanteGoverno->flag){
	            $conteudoResposta = $this->configurarConteudoRespota();
	            $conteudoResposta->msg = $edicaoRepresentanteGoverno->mensagem;
	            
	            $this->resposta->prepararResposta($conteudoResposta, 200);
	        }else{
	            $this->resposta->prepararResposta(['msg' => $edicaoRepresentanteGoverno->mensagem], 400);
	        }
	    }else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
	}
	
	private function configurarConteudoRespota() {
	    $requisicao = $this->requisicao->getConteudo();
	    $usuario = $this->requisicao->getUsuario();
	    
	    $tempoExpiracaoToken = strtotime('+15 minutes');
	    
	    $token = $usuario->id_usuario . '_' . $usuario->tipo_usuario . '_' . $usuario->localidade . '_' . $tempoExpiracaoToken;
	    $token = $usuario->id_usuario . '|' . openssl_encrypt($token, 'AES-128-ECB', getenv('KEY_ENCRYPTION'));
	    
	    $conteudo = new \stdClass;
	    $conteudo->id_usuario = $usuario->id_usuario;
	    $conteudo->tx_nome_usuario = $requisicao->tx_nome_usuario;
	    $conteudo->cd_tipo_usuario = $usuario->tipo_usuario;
	    $conteudo->localidade = $usuario->localidade;
	    $conteudo->access_token = $token;
	    $conteudo->token_type = 'Bearer';
	    $conteudo->expires_in = $tempoExpiracaoToken;
	    
	    return $conteudo;
	}
}