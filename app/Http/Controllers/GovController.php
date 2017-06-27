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
            //$flagCheckData = $this->checkData($dataFile);
            
            if($flagCheckRequest){
            	$this->configResponse($result, 200);	
            }else{
            	$result = ['msg' => 'Arquivo enviado não contém os dados obrigatórios.'];
            	$this->configResponse($result, 400);
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
    	
    	foreach ($csv as $line){
    		print_r(explode(';', $line[0]));
    		array_push($result, str_replace('"', '', explode(';', $line[0])));
    	}
    	
    	return $result;
    }
    
    private function readXml($file_path){
    	$xml = simplexml_load_file($file_path);
    	foreach ($xml->parceria as $parceria){    		
    		$id = property_exists($parceria, 'id');
    		$nome_osc = property_exists($parceria,'nome_osc');
    		$data_inicio = property_exists($parceria, 'data_inicio');
    		$data_fim = property_exists($parceria, 'data_fim');
    		
    		//print_r(['id' => $id, 'nome_osc' => $nome_osc, 'data_inicio' => $data_inicio, 'data_fim' => $data_fim]);
    		print_r($parceria->{'nome_osc'});
    	};
    }
    
    private function readJson($file_path){
    	
    }
    
    private function checkData($dataFile){
    	$result = false;
    	
    	$checkRequired = ["id", "data_inicio", "data_fim", "situacao", "tipo", "valor_total", "valor_pago", "proponente"];
    	
    	$title = $dataFile[0];
    	foreach ($title as $value){
    		print_r($value);
    	}
    	unset($dataFile[0]);
    	
    	foreach ($dataFile as $value){
    		print_r($value);
    	}
    	
    	return $result;
    }
}
