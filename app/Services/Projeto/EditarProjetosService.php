<?php

namespace App\Services\Projeto;

use App\Services\BaseService;
use App\Models\Projeto\ProjetosOscModel;
use App\Dao\Projeto\ProjetoDao;

class EditarProjetosService extends BaseService
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