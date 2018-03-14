<?php

namespace App\Services\Projeto;

use App\Services\Service;
use App\Models\Osc\ProjetosOscModel;
use App\Dao\Projeto\ProjetoDao;

class EditarProjetoService extends Service
{
    public function executar()
    {
        $usuario = $this->requisicao->getUsuario();
        $requisicao = $this->requisicao->getConteudo();

        $modelo = new ProjetosOscModel($requisicao);

        if($modelo->obterCodigoResposta() === 200){
            $projetos = $modelo->obterRequisicao();
            $dao = (new ProjetoDao)->editarProjetos($usuario->id_usuario, $requisicao->id_osc, $projetos);
		    $this->analisarDao($dao);
        }else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
    }
}