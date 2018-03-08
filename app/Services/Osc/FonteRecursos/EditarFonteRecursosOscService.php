<?php

namespace App\Services\Osc\FonteRecursos;

use App\Services\Service;
use App\Models\Osc\FonteRecursosOscModel;
use App\Dao\Osc\FonteRecursosOscDao;

class EditarFonteRecursosOscService extends Service
{
    public function executar()
    {
        $conteudoRequisicao = $this->requisicao->getConteudo();

		$modelo = new FonteRecursosOscModel($conteudoRequisicao);
        
        if($modelo->obterCodigo() === 200){
            $dao = (new FonteRecursosOscDao)->editarRecursos($modelo->obterObjeto());
		    $this->analisarDao($dao);
        }else{
            $this->resposta->prepararResposta($modelo->obterMensagem(), $modelo->obterCodigo());
        }
    }
}