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

		$idOsc = $conteudoRequisicao->id_osc;
		
		$fonteRecursos = new FonteRecursosOscModel($conteudoRequisicao);
        $flag = $this->analisarModel($fonteRecursos);
        
        if($flag){
            foreach($conteudoRequisicao->recursos as $recurso){
				$modelo = new RecursosOscModel($recurso);
				$flag = $this->analisarModel($modelo);
				
				if($flag){
                    array_push($listaRecursos, $modelo->getModel());
                }else{
					break;
				}
            }
            
            if($flag){
                $this->executarDao($idOsc, $listaRecursos);
            }
        }
    }
	
	private function executarDao($idOsc, $listaRecursos){
		$resultadoDao = (new FonteRecursosOscDao)->editarCertificado($idOsc, $listaRecursos);
		$this->analisarDao($resultadoDao);
	}
}
