<?php

namespace App\Http\Services\User;

use App\Http\Services\Service;
use App\Http\Util\CheckRequestUtil;
use App\Http\Dao\User\GetUserOscDao;

class GetUserOscService extends Service
{
	private function check($object)
	{
		$result = null;
		
		$checkRequestUtil = new CheckRequestUtil();
		
		$requiredData = ['id_usuario'];
		$result = $checkRequestUtil->checkRequiredData($requiredData, $object);
		
		if(!$result){
			$result = $checkRequestUtil->checkData($object);
		}
		
		return $result;
	}
	
	public function execute($object)
	{
		$content['msg'] = 'Usuário obtido com sucesso.';
		$this->response->setResponse($content, 200);
		
		$resultCheck = $this->check($object);
		if($resultCheck){
			$content['msg'] = $resultCheck;
			$this->response->setResponse($content, 400);
		}else{
			$dao = new GetUserOscDao();
			$resultDao = $dao->execute($object);
			
			if($resultDao){
				$this->response->updateContent($resultDao);
			}else{
				$content['msg'] = 'Usuário não encontrado.';
				$this->response->setResponse($content, 400);
			}
		}
		
		return $this->response;
	}
}