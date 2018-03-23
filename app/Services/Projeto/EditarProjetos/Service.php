<?php

namespace App\Services\Projeto\EditarProjetos;

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
            $projetos = $modelo->obterRequisicao();
            $dao = (new ProjetoDao)->editarProjetos($usuario->id_usuario, $requisicao->id_osc, $projetos);
		    $this->analisarDao($dao);
        }else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
    }
}