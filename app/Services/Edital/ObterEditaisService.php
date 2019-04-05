<?php

namespace App\Services\Edital;

use App\Services\Service;
use App\Dao\EditalDao;

class ObterEditaisService extends Service
{
	public function executar()
	{
	    $editalDao = new EditalDao();
	    $editaisAbertos = $editalDao->obterEditaisAbertos();
	    $editaisEncerrados = $editalDao->obterEditaisEncerrados();
	    
	    $conteudoResposta = new \stdClass();
	    
	    if($editaisAbertos || $editaisEncerrados){
    	    $conteudoResposta->ativos = $editaisAbertos;
    	    $conteudoResposta->encerrados = $editaisEncerrados;
    	    $conteudoResposta->msg = 'Editais enviados.';
	    }else{
	        $conteudoResposta->msg = 'Não há editais cadastrados.';
	    }
	    
	    $this->resposta->prepararResposta($conteudoResposta, 200);
	}
}
