<?php

namespace App\Services\Edital\ObterEditais;

use App\Services\BaseService;
use App\Dao\Edital\EditalDao;

class Service extends BaseService{
	public function executar(){
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