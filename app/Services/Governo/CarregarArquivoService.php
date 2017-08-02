<?php

namespace App\Services\Governo;

use App\Enums\NomenclaturaAtributoEnum;
use App\Services\Service;
use App\Services\Model;

class CarregarArquivoService extends Service
{
	public function executar()
	{
		$requisicao = $this->requisicao->getConteudo();
    	$id_usuario = $this->requisicao->getUsuario()->id_usuario;
    	
		$file = $requisicao->arquivo;
        $type_file = $requisicao->tipo_arquivo;
		
		$file_path = $file->getPathName();
		
		$data = null;
        switch($type_file) {
        	case 'csv':
            	$csvData = $this->readCheckCsv($file_path);
            	if($csvData){
            		$data = $this->convertCsv($csvData);
				}
            	break;
				
			case 'json':
            	$data = $this->readCheckJson($file_path);
            	break;
				
            	
			default:
            	$result = ['msg' => 'Formato de arquivo inválido.'];
            	$this->configResponse($result, 400);
		}
		
		if($data){
        	$flagCheckData = $this->checkData($data);
			
            if($flagCheckData){
            	if(env('UPLOAD_FILE_PATH') == null){
            		$file_directory = realpath(__DIR__ . '/../../../') . '/storage/app/gov/' . $id_usuario;
				}else{
            		$file_directory = env('UPLOAD_FILE_PATH') . '/' . $id_usuario;
				}
				
            	$filename = time() . '__' . $file->getClientOriginalName();
            	$file->move($file_directory, $filename);
				
            	//$data = $this->prepareData($data);
            	//$this->dao->setDataStateCounty($data);
				
            	$this->resposta->prepararResposta(['msg' => 'Upload do arquivo realiado com sucesso.'], 500);
			}
		}else{
        	$this->resposta->prepararResposta(['msg' => 'Ocorreu um erro na leitura do arquivo.'], 500);
		}
    }
    
    private function checkRequest($request){
    	$result = true;
    	
    	$content = $request->all();
    	
    	$msg = '';
    	if(!$request->hasFile('arquivo')) {
    		$msg = 'Ocorreu um erro no envio do arquivo.';
    	}else if(!$request->file('arquivo')->isValid()){
    		$msg = 'Ocorreu um erro no envio do arquivo.';
    	}else if(!array_key_exists('tipo_arquivo', $content)){
    		$msg = 'Formato de arquivo não identificado.';
    	}
    	
    	if($msg){
    		$this->resposta->prepararResposta(['msg' => $msg], 400);
    		$result = false;
    	}
    	
    	return $result;
    }
    
    private function trimData($data){
    	$result = trim($data);
    	
    	$result = rtrim($result, '\'');
    	$result = ltrim($result, '\'');
    	$result = rtrim($result, '"');
    	$result = ltrim($result, '"');
    	
    	return $result;
    }
    
    private function readCheckCsv($file_path){
    	$result = array();
    	$delimitor = ';';
    	
    	$data = file($file_path);
    	$title = explode($delimitor, $data[0]);
    	
    	$checkRequiredData = $this->checkRequiredData($title);
    	if($checkRequiredData){
	    	foreach ($data as $value){
	    		array_push($result, explode($delimitor, trim($value)));
	    	}
    	}
    	
    	return $result;
    }
    
    private function readCheckJson($file_path){
    	$result = array();
    	
    	$data = file_get_contents($file_path);
    	$data = json_decode($data);
    	
    	if(is_object($data)){
    		$result = $data->parcerias;
    	}else if(is_array($data)){
    		$result = $data;
    	}
    	
    	return $result;
    }
    
    private function checkRequiredData($title){
    	$result = false;
    	
    	$title_prepared = array();
    	foreach ($title as $key => $value){
    		array_push($title_prepared, $this->trimData($value));
    	}
    	
    	$required = ["numero_parceria", "cnpj_proponente", "data_inicio", "data_conclusao", "situacao_parceria", "tipo_parceria", "valor_total", "valor_pago"];
    	$checkRequired = count(array_intersect($required, $title_prepared)) == count($required);
    	
    	if($checkRequired){
    		$result = true;
    	}else{
    		$msg = ['msg' => 'Dados obrigatórios não enviados.'];
    		$this->configResponse($msg, 400);
    	}
    	
    	return $result;
    }
    
    private function convertCsv($dataFile){
    	$result = array();
    	
    	$title = array();
    	foreach ($dataFile[0] as $value){
    		array_push($title, $this->trimData($value));
    	}
    	unset($dataFile[0]);
    	
    	foreach ($dataFile as $dataKey => $dataValue){
	    	$array = array();
	    	foreach ($dataValue as $key => $value){
	    		$key = $this->trimData($key);
	    		$value = $this->trimData($value);
	    		$array[$title[$key]] = $value;
	    	}
	    	array_push($result, (object) $array);
	    }
	    
	    return $result;
    }
    
    private function checkData($data){
    	$result = true;
    	
    	$separatorDate = '(\/|-|\.)';
    	$patternDate = '/^(?:(?:31'.$separatorDate.'(?:0?[13578]|1[02]))\1|(?:(?:29|30)'.$separatorDate.'(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{4})$|^(?:29'.$separatorDate.'0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])'.$separatorDate.'(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{4})$/';
    	
    	$separatorCnpj = '(\/|-|\.)';
    	$patternCnpj = '/^(([0-9]{2})'.$separatorCnpj.'([0-9]{3})'.$separatorCnpj.'([0-9]{3})'.$separatorCnpj.'([0-9]{4})'.$separatorCnpj.'([0-9]{2})|([0-9]{2})'.$separatorCnpj.'([0-9]{3})'.$separatorCnpj.'([0-9]{3})'.$separatorCnpj.'([0-9]{4})([0-9]{2})|([0-9]{8})'.$separatorCnpj.'([0-9]{4})'.$separatorCnpj.'([0-9]{2})|(([0-9]{8})'.$separatorCnpj.'([0-9]{4}))|([0-9]{12})'.$separatorCnpj.'([0-9]{2})|([0-9]{14})|([0-9]{12}))$/';
    	
    	$currencySymbol = '(([Rr]{1}[$]{1})|([$]{1}))?([ ]*)?';
    	$patternCurrency = '/^(('.$currencySymbol.'(\d{1,3}(?:[\.]?\d{3})*)([,]{1}\d{2})?)|('.$currencySymbol.'(\d*)([\.]{1})(\d{1,2})?))$/';
    	
    	$invalidLineData = array();
    	foreach ($data as $key => $value){
    		$checkDataInicio = preg_match_all($patternDate, $value->data_inicio);    		
    		$checkDataConclusao = preg_match_all($patternDate, $value->data_conclusao);
    		$checkCnpj = preg_match_all($patternCnpj, $value->cnpj_proponente);
    		$checkValorTotal = preg_match_all($patternCurrency, $value->valor_total);
    		$checkValorPago = preg_match_all($patternCurrency, $value->valor_pago);
    		
    		$error = array();
    		if(!$checkDataInicio){
    			array_push($error, 'data_inicio');
    		}
    		
    		if(!$checkDataConclusao){
    			array_push($error, 'data_conclusao');
    		}
    		
    		if(!$checkCnpj){
    			array_push($error, 'cnpj_proponente');
    		}
    		
    		if(!$checkValorTotal){
    			array_push($error, 'valor_total');
    		}
    		
    		if(!$checkValorPago){
    			array_push($error, 'valor_pago');
    		}
    		
    		if($error){
    			array_push($invalidLineData, ['line' => $value->numero_parceria, 'error' => $error]);
    		}
    	}
    	
    	if($invalidLineData){
    		$msg = ['msg' => 'Dados não validados.', 'error_line' => $invalidLineData];
    		$this->resposta->prepararResposta(['msg' => $msg], 400);
    		
    		$result = false;
    	}
    	
    	return $result;
    }
    
    private function prepareData($data){
    	foreach ($data as $key => $value){
    		$data[$key]->data_inicio = $this->prepareDate($value->data_inicio);
    		$data[$key]->data_conclusao = $this->prepareDate($value->data_conclusao);
    		$data[$key]->cnpj_proponente = $this->prepareNonNumeric($value->cnpj_proponente);
    		$data[$key]->valor_total= $this->prepareCurrency($value->valor_total);
    		$data[$key]->valor_pago= $this->prepareCurrency($value->valor_pago);
    	}
    	
    	return $data;
    }
    
    private function prepareDate($data){
    	$data = preg_replace('/[-\.]/', '/', $data);
    	
    	return $data;
    }
    
    private function prepareNonNumeric($data){
    	$data = preg_replace('/[^0-9]/', '', $data);
    	
    	return $data;
    }
    
    private function prepareCurrency($data){
    	$data = preg_replace('/[Rr$ ]/', '', $data);
    	
    	if(!preg_match('/^((.*)([\.]{1})(\d{1,2})?)$/', $data)){
    		$data = preg_replace('/[\.]/', '', $data);
    		$data = preg_replace('/[,]/', '.', $data);
    	}
    	
    	return $data;
    }
}
