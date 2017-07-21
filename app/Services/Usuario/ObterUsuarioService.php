<?php

namespace App\Services\User;

use App\Services\Service;
use App\Util\CheckRequestUtil;
use App\Dao\User\GetUserDAO;

class GetUserService extends Service
{
	private function check($object)
	{
		$result = null;
		
		$checkRequestUtil = new CheckRequestUtil();
		
		$requiredData = ['id_usuario'];
		$result = $checkRequestUtil->checkRequiredData($requiredData, $object);
		
		return $result;
	}
	
	public function executar($object)
	{
		$content['msg'] = 'Usuário obtido com sucesso.';
		$this->response->setResponse($content, 200);
		
		$resultCheck = $this->check($object);
		if($resultCheck){
			$content['msg'] = $resultCheck;
			$this->response->setResponse($content, 400);
		}else{
			$dao = new GetUserDAO();
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
