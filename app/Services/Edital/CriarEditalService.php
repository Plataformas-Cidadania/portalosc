<?php

namespace App\Services\Edital;

use App\Enums\NomenclaturaAtributoEnum;
use App\Services\Service;
use App\Services\Model;
use App\Dao\EditalDao;

class CriarEditalService extends Service
{
	public function executar()
	{
	    $contrato = [
	        'tx_orgao' => ['apelidos' => NomenclaturaAtributoEnum::ORGAO, 'obrigatorio' => true, 'tipo' => 'string'],
	        'tx_programa' => ['apelidos' => NomenclaturaAtributoEnum::PROGRAMA, 'obrigatorio' => true, 'tipo' => 'string'],
	        'tx_area_interesse' => ['apelidos' => NomenclaturaAtributoEnum::AREA_INTERESSE, 'obrigatorio' => true, 'tipo' => 'string'],
	        'dt_data_vencimento' => ['apelidos' => NomenclaturaAtributoEnum::DATA_VENCIMENTO, 'obrigatorio' => true, 'tipo' => 'date'],
	        'tx_link' => ['apelidos' => NomenclaturaAtributoEnum::LINK, 'obrigatorio' => true, 'tipo' => 'string'],
	        'tx_numero_chamada' => ['apelidos' => NomenclaturaAtributoEnum::NUMERO_CHAMADA, 'obrigatorio' => true, 'tipo' => 'string']
	    ];
	    
	    $model = new Model($contrato, $this->requisicao->getConteudo());
	    $flagModel = $this->analisarModel($model);
	    
	    if($flagModel){
	        $requisicao = $model->getRequisicao();
	        $resultadoDao = (new EditalDao())->criarEdital($requisicao);
	        
	        if($resultadoDao->flag){
	            $this->resposta->prepararResposta(['msg' => $resultadoDao->mensagem], 200);
	        }else{
	            $this->resposta->prepararResposta(['msg' => $resultadoDao->mensagem], 400);
	        }
	    }
	}
}
