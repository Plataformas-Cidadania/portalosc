<?php

namespace App\Services\Projeto;

use App\Services\BaseService;
use App\Services\BaseModel;
use App\Dao\Projeto\ProjetoDao;

class DeletarProjetoService extends BaseService
{
    public function executar()
    {
        $estrutura = array(
	        'id_projeto' => [
				'apelidos' => ['id_projeto', 'idProjeto'], 
				'obrigatorio' => true, 
				'tipo' => 'integer'
            ],
	        'id_osc' => [
				'apelidos' => ['id_osc', 'idOsc'], 
				'obrigatorio' => true, 
				'tipo' => 'integer'
			]
		);
		
		$requisicao = $this->requisicao->getConteudo();
		
		$modelo = new Model();
		$modelo->configurarEstrutura($estrutura);
    	$modelo->configurarRequisicao($requisicao);
		$modelo->analisarRequisicao();
	    
	    if($modelo->obterCodigoResposta() === 200){
			$requisicao = $modelo->obterRequisicao();
            $dao = (new ProjetoDao)->deletarProjeto($usuario->id_usuario, $requisicao->id_osc, $requisicao->id_projeto);
		    $this->analisarDao($dao);
        }else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
    }
}