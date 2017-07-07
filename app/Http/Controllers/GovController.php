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
            
            $dataFile = $this->loadDataFile($file_path, $tipo_arquivo);
            $flagCheckRequiredData = $this->checkRequiredDataCsv($dataFile);
            
            if($flagCheckRequiredData){
            	$this->configResponse($result, 200);
            	
            	$flagCheckData = $this->convertCsvToJson($dataFile);
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
	
    private function loadDataFile($file_path, $tipo_arquivo)
    {
    	$dataFile = null;
    	
    	switch($tipo_arquivo) {
    		case 'csv':
    			$dataFile = $this->readCsv($file_path);
    			break;
    		
    		case 'json':
    			$dataFile =$this->readJson($file_path);
    			break;
    		
    		default:
    			$result = ['msg' => 'Formato de arquivo inválido.'];
    			$this->configResponse($result, 400);
    	}
    	
    	return $dataFile;
    }
    
    private function readCsv($file_path){
    	$result = array();
    	
    	$csv = array_map('str_getcsv', file($file_path));
    	foreach ($csv as $line){
    		array_push($result, str_replace('"', '', explode(';', $line[0])));
    	}
    	
    	return $result;
    }
    
    private function readJson($file_path){
    	$result = array();
    	
    	$result = file_get_contents('http://example.com/example.json/');
    	
    	return $result;
    }
    
    private function checkRequiredDataCsv($dataFile){
    	$resultCheck = false;
    	
    	$required = ["numero_parceria", "cnpj_proponente", "data_inicio", "data_conclusao", "situacao_parceria", "tipo_parceria", "valor_total", "valor_pago"];
    	
    	$checkRequired = count(array_intersect($required, $dataFile[0])) == count($required);
    	
    	if($checkRequired){
    		$resultCheck = true;
    	}else{
    		$result = ['msg' => 'Dados obrigatórios não enviados.'];
    		$this->configResponse($result, 400);
    	}
    	
    	return $resultCheck;
    }
    
    private function convertCsvToJson($dataFile){
    	$result = array();
    	
    	$title = $dataFile[0];
    	unset($dataFile[0]);
    	
    	foreach ($dataFile as $dataKey => $dataValue){
	    	$array = array();
	    	foreach ($dataValue as $key => $value){
	    		$array[$title[$key]] = $value;
	    	}
	    	array_push($result, $array);
	    }
	    
	    return $result;
    }
}
