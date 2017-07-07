<?php

namespace App\Http\Controllers;

use App\Http\Controllers\EmailController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Dao\GovDao;

class GovController extends Controller
{
	private $dao;
	private $email;
	
	public function __construct()
	{
		$this->dao = new GovDao();
		$this->email = new EmailController();
	}
	
    public function uploadFile(Request $request, $tipo_arquivo)
    {
    	$result = ['msg' => 'Upload do arquivo realiado com sucesso.'];
    	$id_usuario = $request->user()->id;
    	
        $flagCheckRequest = $this->checkRequest($request, $tipo_arquivo);
        if($flagCheckRequest){
            $file = $request->file('arquivo');
            
            if(env('UPLOAD_FILE_PATH') == null){
            	$file_directory = realpath(__DIR__ . '/../../../') . '/storage/app/gov/' . $id_usuario;
            }else{
            	$file_directory = env('UPLOAD_FILE_PATH') . '/' . $id_usuario;
            }
            
            $filename = $filename = time() . '__' . $file->getClientOriginalName();
            $file_path = $file_directory . '/' . $filename;
            
            $file->move($file_directory, $filename);
            
            $data = null;
            switch($tipo_arquivo) {
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
            	
            	$this->configResponse($result, 200);
            }
        }
		
        return $this->response();
    }
    
    private function checkRequest($request, $tipo_arquivo){
    	$result = false;
    	
    	if(!$request->hasFile('arquivo')) {
    		$msg = ['msg' => 'Arquivo não enviado.'];
    		$this->configResponse($msg, 400);
    	}else if(!$request->file('arquivo')->isValid()){
    		$msg = ['msg' => 'Ocorreu um erro no carregamento do arquivo.'];
    		$this->configResponse($msg, 400);
    	}else if(!in_array($tipo_arquivo , ['csv', 'xml', 'json'])){
    		$msg = ['msg' => 'Formato de arquivo inválido.'];
    		$this->configResponse($msg, 400);
    	}else{
    		$result = true;
    	}
    	
    	return $result;
    }
    
    private function readCheckCsv($file_path){
    	$result = array();
    	$delimitor = ';';
    	
    	$data = array_map('str_getcsv', file($file_path));
    	$title = str_replace('"', '', explode($delimitor, $data[0][0]));
    	
    	$checkRequiredData = $this->checkRequiredData($title);
    	if($checkRequiredData){
	    	foreach ($data as $value){
	    		array_push($result, str_replace('"', '', explode($delimitor, $value[0])));
	    	}
    	}
    	
    	return $result;
    }
    
    private function readCheckJson($file_path){
    	$result = array();
    	
    	$result = file_get_contents('http://example.com/example.json/');
    	
    	return $result;
    }
    
    private function checkRequiredData($title){
    	$result = false;
    	
    	$required = ["numero_parceria", "cnpj_proponente", "data_inicio", "data_conclusao", "situacao_parceria", "tipo_parceria", "valor_total", "valor_pago"];
    	
    	$checkRequired = count(array_intersect($required, $title)) == count($required);
    	
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
    	
    	$title = $dataFile[0];
    	unset($dataFile[0]);
    	
    	foreach ($dataFile as $dataKey => $dataValue){
	    	$array = array();
	    	foreach ($dataValue as $key => $value){
	    		$array[$title[$key]] = $value;
	    	}
	    	array_push($result, (object) $array);
	    }
	    
	    return $result;
    }
    
    private function checkData($data){
    	$result = true;
    	/*
    	//$patternDate = '^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$';
    	$patternDate = "/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/";
    	
    	foreach ($data as $key => $value){
    		print_r($value->data_inicio);
    		$checkDataInicio = preg_match($value->data_inicio, $patternDate);
    		if($checkDataInicio){
    			print_r('Ok');
    		}else{
    			print_r('Error');
    		}
    	}
    	*/
    	return $result;
    }
}
