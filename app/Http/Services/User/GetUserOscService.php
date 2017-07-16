<?php

namespace App\Http\Services\User;

use App\Http\Services\Service;
use App\Http\Util\CheckRequestUtil;
use App\Http\Dao\User\GetUserOscDao;

class GetUserOscService extends Service
{
	private function check($object)
	{
		$checkRequestUtil = new CheckRequestUtil();
		
		$requiredData = ['id_usuario'];
		$msgCheckData = $checkRequestUtil->checkRequiredData($requiredData, $object);
		
		if($msgCheckData){
			$content['msg'] = $msgCheckData;
			$this->response->setResponse($content, 400);
		}else{
			$msgCheckData = $checkRequestUtil->checkData($object);
			
			if($msgCheckData){
				$content['msg'] = $msgCheckData;
				$this->response->setResponse($content, 400);
			}
		}
	}
	
	private function execute($object)
	{
		$dao = new GetUserOscDao();
		
		$resultDao = $dao->run($object);
		
		if($resultDao){
			$this->response->updateContent($resultDao);
		}else{
			$content['msg'] = 'Usuário não encontrado.';
			$this->response->setResponse($content, 400);
		}
	}
	
	public function run($object = [])
	{
		$content['msg'] = 'Usuário obtido com sucesso.';
		$this->response->setResponse($content, 200);
		
		$this->check($object);
		if($this->response->getFlag()){
			$this->execute($object);
		}
		
		return $this->response;
	}
}