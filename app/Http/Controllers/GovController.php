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
    	//$id_usuario = $request->user()->id;
    	$id_usuario = 1;
    	
        $flagCheckRequest = $this->checkRequest($request, $tipo_arquivo);
        if($flagCheckRequest){
            $file = $request->file('arquivo');
            
            $file_directory = env('UPLOAD_FILE_PATH') . '/' . $id_usuario;
            $filename = $filename = time() . '__' . $file->getClientOriginalName();
            $file_path = $file_directory . '/' . $filename;
            
            $file->move($file_directory, $filename);
            
            $dataFile = $this->loadDataFile($file_path, $tipo_arquivo);
            $flagCheckData = $this->checkData($dataFile);
            if($flagCheckRequest){
    	        //$resultDao = $this->dao->setDataGov($file);
	            //$this->configResponse($resultDao);
            }
        }
		
        return $this->response();
    }
    
    private function checkRequest($request, $tipo_arquivo){
    	$result = false;
    	
    	if(!$request->hasFile('arquivo')) {
    		$result = ['msg' => 'Arquivo não enviado.'];
    		$this->configResponse($result, 400);
    	}else if(!$request->file('arquivo')->isValid()){
    		$result = ['msg' => 'Ocorreu um erro no carregamento do arquivo.'];
    		$this->configResponse($result, 400);
    	}else if(!in_array($tipo_arquivo , ['csv', 'xml', 'json'])){
    		$result = ['msg' => 'Formato de arquivo inválido.'];
    		$this->configResponse($result, 400);
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
    			
    		case 'xml':
    			$dataFile =$this->readXml($file_path);
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
    	$key_explode = explode(';', $csv[0][0]);
    	
    	$csv_key = array();
    	foreach ($key_explode as $value){
    		array_push($csv_key, $value);
    	}
    	
    	unset($csv[0]);
    	foreach ($csv as $line){
    		array_push($result, explode(';', $line[0]));
    	}
    	
    	return $result;
    }
    
    private function readXml($file_path){
    	
    }
    
    private function readJson($file_path){
    	
    }
    
    private function checkData($dataFile){
    	$result = false;
    	
    	if($dataFile != null){
    		$result = true;
    	}
    	
    	return $result;
    }
}
