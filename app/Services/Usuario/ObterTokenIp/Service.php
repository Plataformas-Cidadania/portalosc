<?php

namespace App\Services\Usuario\ObterTokenIp;

use App\Services\BaseService;
use App\Dao\Usuario\UsuarioDao;
use App\Enums\TipoUsuarioEnum;

class Service extends BaseService
{
	public function executar()
	{
	    $requisicao = $this->requisicao->getConteudo();
		$modelo = new Model($requisicao);
		
	    if($modelo->obterCodigoResposta() === 200){
			$usuario = $modelo->obterRequisicao();

			$ip = $usuario->ip;
			$dataExecucao = date("Y-m-d H:i:s");

			$stringToken = $ip . '_' . $dataExecucao;
			$tokenEncrypted = openssl_encrypt($stringToken, 'AES-128-ECB', getenv('KEY_ENCRYPTION'));
			$token = '__' . $tokenEncrypted;

			$usuarioDao = new UsuarioDao();			
			$dao = $usuarioDao->obterTokenIp($ip, $token);

			$conteudoResposta = $this->ajustarRespostaDao($dao);
			$this->resposta->prepararResposta($conteudoResposta, 200);
	    }else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
	}

	private function ajustarRespostaDao($dao)
	{
		$resultado = $dao;
		$token = json_decode($resultado->resultado);

		$resultado->token = $token->tx_token;
		$resultado->data_expiracao = $token->dt_data_expiracao;

		unset($resultado->resultado);

	    return $resultado;
	}
}