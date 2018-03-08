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
        
        $this->integrarRequisicao($modelo->obterObjeto());
        
        if($modelo->obterCodigo() === 200){
            $dao = (new FonteRecursosOscDao)->editarRecursos($modelo->obterObjeto());
		    $this->analisarDao($dao);
        }else{
            $this->resposta->prepararResposta($modelo->obterMensagem(), $modelo->obterCodigo());
        }
    }

    private function integrarRequisicao($requisicao){
        foreach($requisicao as $key => $teste){
            if(gettype($teste) == 'array'){
                print_r($key . ' | ' . gettype($teste) . '<br>');
                $this->integrarRequisicao($teste);
            }else if(gettype($teste) == 'object'){
                print_r($key . ' | ' . gettype($teste) . '<br>');
                if(method_exists($teste, 'obterObjeto')){
                    $this->integrarRequisicao($teste->obterObjeto());
                }else{
                    $this->integrarRequisicao((array) $teste);
                }
            }else{
                print_r($key . ': ' . $teste . ' | ' . gettype($teste) . '<br>');
            }
        }
    }
}