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
        $flagCheckRequest = $this->checkRequest($request, $tipo_arquivo);
        if($flagCheckRequest){
            $file = $request->file('arquivo');
            $file->move(env('UPLOAD_FILE_PATH'), $file->getClientOriginalName());
            
            $dataFile = $this->loadDataFile($file, $tipo_arquivo);
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
	
    private function loadDataFile($file, $tipo_arquivo)
    {
    	$dataFile = null;
    	
    	switch($tipo_arquivo) {
    		case 'csv':
    			$dataFile = $this->readCsv($file);
    			break;
    			
    		case 'xml':
    			$dataFile =$this->readXml($file);
    			break;
    		
    		case 'json':
    			$dataFile =$this->readJson($file);
    			break;
    		
    		default:
    			$result = ['msg' => 'Formato de arquivo inválido.'];
    			$this->configResponse($result, 400);
    	}
    	
    	return $dataFile;
    }
    
    private function readCsv(){
    	/*
    	 // MÉTODO 1
    	 $csv = array_map('str_getcsv', file('C:/Users/b215496233/Desktop/test.csv'));
    	
    	 $key_explode = explode(';', $csv[0][0]);
    	 $csv_key = array();
    	
    	 foreach ($key_explode as $value){
    	 array_push($csv_key, $value);
    	 }
    	
    	 print_r($csv_key);
    	
    	 unset($csv[0]);
    	
    	 foreach ($csv as $line)
    	 {
    	 print_r(explode(';', $line[0]));
    	 }
    	 */
    	
		/*
    	 // MÉTODO 2
    	 $row = 1;
    	 if (($handle = fopen("test.csv", "r")) !== FALSE) {
    	 while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    	 $num = count($data);
    	 echo "<p> $num fields in line $row: <br /></p>\n";
    	 $row++;
    	 for ($c=0; $c < $num; $c++) {
    	 echo $data[$c] . "<br />\n";
    	 }
    	 }
    	 fclose($handle);
    	 }
    	
    	 // MÉTODO 3
    	 $file = new SplFileObject("data.csv");
    	 $file->setFlags(SplFileObject::READ_CSV);
    	 $file->setCsvControl(',', '"', '\\'); // this is the default anyway though
    	 foreach ($file as $row) {
    	 list ($fruit, $quantity) = $row;
    	 // Do something with values
    	 }
    	 */
    }
    
    private function readXml(){
    	
    }
    
    private function readJson(){
    	
    }
    
    private function checkData($dataFile){
    	
    }
}
