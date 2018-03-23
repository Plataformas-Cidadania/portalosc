<?php

namespace App\Services\Projeto\DeletarProjeto;

use App\Services\BaseService;
use App\Dao\Projeto\ProjetoDao;

class Service extends BaseService
{
    public function executar()
    {
        $usuario = $this->requisicao->getUsuario();
        $requisicao = $this->requisicao->getConteudo();
		$modelo = new Model($requisicao);
	    
	    if($modelo->obterCodigoResposta() === 200){
			$requisicao = $modelo->obterRequisicao();
            $dao = (new ProjetoDao)->deletarProjeto($usuario->id_usuario, $requisicao->id_osc, $requisicao->id_projeto);
		    $this->analisarDao($dao);
        }else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
    }
}