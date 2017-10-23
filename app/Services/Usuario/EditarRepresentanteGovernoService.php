<?php

namespace App\Services\Usuario;

use App\Enums\NomenclaturaAtributoEnum;
use App\Services\Service;
use App\Services\Model;
use App\Dao\UsuarioDao;

class EditarRepresentanteGovernoService extends Service
{
	public function executar()
	{
	    $contrato = [
	        'id_usuario' => ['apelidos' => NomenclaturaAtributoEnum::ID_USUARIO, 'obrigatorio' => true, 'tipo' => 'numeric'],
	        'tx_email_usuario' => ['apelidos' => NomenclaturaAtributoEnum::EMAIL, 'obrigatorio' => true, 'tipo' => 'email'],
	        'tx_senha_usuario' => ['apelidos' => NomenclaturaAtributoEnum::SENHA, 'obrigatorio' => true, 'tipo' => 'string'],
	        'tx_nome_usuario' => ['apelidos' => NomenclaturaAtributoEnum::NOME_USUARIO, 'obrigatorio' => true, 'tipo' => 'string'],
        	'tx_telefone_1' => ['apelidos' => NomenclaturaAtributoEnum::TELEFONE_USUARIO_1, 'obrigatorio' => true, 'tipo' => 'string'],
	        'tx_telefone_2' => ['apelidos' => NomenclaturaAtributoEnum::TELEFONE_USUARIO_2, 'obrigatorio' => false, 'tipo' => 'string'],
	        'tx_orgao_usuario' => ['apelidos' => NomenclaturaAtributoEnum::ORGAO_USUARIO, 'obrigatorio' => true, 'tipo' => 'string'],
	        'tx_dado_institucional' => ['apelidos' => NomenclaturaAtributoEnum::DADO_INSTITUCIONAL, 'obrigatorio' => false, 'tipo' => 'string'],
	        'bo_lista_email' => ['apelidos' => NomenclaturaAtributoEnum::LISTA_EMAIL, 'obrigatorio' => false, 'tipo' => 'boolean', 'default' => false],
	        'bo_lista_atualizacao_trimestral' => ['apelidos' => NomenclaturaAtributoEnum::LISTA_ATUALIZACAO_TRIMESTRAL, 'obrigatorio' => false, 'tipo' => 'boolean', 'default' => false]
	    ];
	    
	    $model = new Model($contrato, $this->requisicao->getConteudo());
	    $flagModel = $this->analisarModel($model);
		
	    if($flagModel){
	        $edicaoRepresentanteGoverno = (new UsuarioDao())->editarRepresentanteGoverno($model->getRequisicao());
    		
	        if($edicaoRepresentanteGoverno->flag){
	            $conteudoResposta = $this->configurarConteudoRespota();
	            $conteudoResposta->msg = $edicaoRepresentanteGoverno->mensagem;
	            
	            $this->resposta->prepararResposta($conteudoResposta, 200);
	        }else{
	            $this->resposta->prepararResposta(['msg' => $edicaoRepresentanteGoverno->mensagem], 400);
	        }
	    }
	}
	
	public function configurarConteudoRespota() {
	    $requisicao = $this->requisicao->getConteudo();
	    $usuario = $this->requisicao->getUsuario();
	    
	    $tempoExpiracaoToken = strtotime('+15 minutes');
	    
	    $token = $usuario->id_usuario . '_' . $usuario->tipo_usuario . '_' . $usuario->localidade . '_' . $tempoExpiracaoToken;
	    $token = openssl_encrypt($token, 'AES-128-ECB', getenv('KEY_ENCRYPTION'));
	    
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
