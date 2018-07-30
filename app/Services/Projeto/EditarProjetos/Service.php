<?php

namespace App\Services\Projeto\EditarProjetos;

use App\Services\BaseService;
use App\Dao\Projeto\ProjetoDao;

class Service extends BaseService{
    public function executar(){
        $usuario = $this->requisicao->getUsuario();
        $requisicao = $this->requisicao->getConteudo();
        
        if(isset($requisicao->projeto) || isset($requisicao->projetos)){
            $modelo = new Model($requisicao);
        }else{
            $requisicaoAjustada = new \stdClass();
            $requisicaoAjustada->id_osc = isset($requisicao->id_osc) ? $requisicao->id_osc : null;
            $requisicaoAjustada->bo_nao_possui_projeto = isset($requisicao->bo_nao_possui_projeto) ? $requisicao->bo_nao_possui_projeto : null;
            
            $projetosArray = (array) $requisicao;
            unset($projetosArray['id_osc']);
            unset($projetosArray['bo_nao_possui_projeto']);

            $requisicaoAjustada->projetos = [$projetosArray];
            
            $modelo = new Model($requisicaoAjustada);
        }
        
        if($modelo->obterCodigoResposta() === 200){
            $projetos = $modelo->obterRequisicao();
            
            $dao = (new ProjetoDao)->editarProjetos($usuario->id_usuario, $requisicao->id_osc, $projetos);
		    $this->analisarDao($dao);
        }else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
    }
}