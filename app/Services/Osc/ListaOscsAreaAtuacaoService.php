<?php

namespace App\Services\Osc;

use App\Enums\NomenclaturaAtributoEnum;
use App\Services\Service;
use App\Services\Model;
use App\Dao\OscDao;

class ListaOscsAreaAtuacaoService extends Service
{
	public function executar()
	{
	    $contrato = [
	        'area_atuacao' => ['apelidos' => ['area_atuacao', 'cd_area_atuacao', 'areaAtuacao'], 'obrigatorio' => true, 'tipo' => 'integer'],
	        'cd_uf' => ['apelidos' => ['cd_uf', 'cd_estado', 'uf', 'estado'], 'obrigatorio' => false, 'tipo' => 'integer']
	        'latitude' => ['apelidos' => ['latitude'], 'obrigatorio' => false, 'tipo' => 'float']
	        'longetude' => ['apelidos' => ['longetude'], 'obrigatorio' => false, 'tipo' => 'float']
	        'limit' => ['apelidos' => ['limit', 'quantidade'], 'obrigatorio' => false, 'tipo' => 'integer']
	    ];
	    
	    $model = new Model($contrato, $this->requisicao->getConteudo());
	    $flagModel = $this->analisarModel($model);
	    
	    if($flagModel){
	    	$requisicao = $model->getRequisicao();
	    	$barraTransparenciaOsc = (new OscDao())->obterBarraTransparenciaOsc($model->getRequisicao()->id_osc);
	    	
	    	if($barraTransparenciaOsc){
	    		$this->resposta->prepararResposta($barraTransparenciaOsc, 200);
	    	}else{
	    		$mensagem = 'Não existe dados sobre a barra de transparência desta OSC no banco de dados.';
	    		$this->resposta->prepararResposta(['msg' => $mensagem], 400);
	    	}
	    }
	}
}
