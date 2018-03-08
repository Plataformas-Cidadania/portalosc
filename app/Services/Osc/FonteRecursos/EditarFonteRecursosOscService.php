<?php

namespace App\Services\Osc\FonteRecursos;

use App\Services\Service;
use App\Services\Model;
use App\Models\Osc\FonteRecursosOscModel;
use App\Models\Osc\RecursosOscModel;
use App\Dao\Osc\FonteRecursosOscDao;

class EditarFonteRecursosOscService extends Service
{
    public function executar()
    {
        $conteudoRequisicao = $this->requisicao->getConteudo();

		$flag = true;
        $listaRecursos = array();
        
		$objeto = new FonteRecursosOscModel($conteudoRequisicao);
        
        if($objeto->obterCodigo() === 200){
            $resultadoDao = (new FonteRecursosOscDao)->editarRecursos($idOsc, $listaRecursos);
		    $this->analisarDao($resultadoDao);
        }else{
            $this->resposta->prepararResposta($objeto->obterMensagem(), $objeto->obterCodigo());
        }
    }
}