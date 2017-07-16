<?php

namespace App\Http\Util;

use App\Http\Util\DataValidatorUtil;

class CheckRequestUtil
{	
	private $dataValidator;
	
	public function __construct()
	{
		$this->dataValidator = new DataValidatorUtil();
	}
	
	public function checkRequiredData($required, $object)
	{
		$result = null;
		
		$keys = array_keys($object);
		$checkRequired = count(array_intersect($required, $keys)) == count($required);
		
		if(!$checkRequired){
			$result = 'Dados obrigatórios não enviados.';
		}
		
		return $result;
	}
	
	public function checkData($object)
	{
		$result = null;
		
		if(array_key_exists('cpf', $object) && !$this->dataValidator->validateCPF($object['cpf'])){
			$result = 'CPF inválido.';
		}else if(array_key_exists('email', $object) && !$this->dataValidator->validateEmail($object['email'])){
			$result = 'E-mail inválido.';
		}else if(array_key_exists('tx_email_usuario', $object) && !$this->dataValidator->validateEmail($object['tx_email_usuario'])){
			$result = 'E-mail inválido.';
		}else if(array_key_exists('localidade', $object) && !(strlen($object['localidade']) == 2 || strlen($object['localidade']) == 7)){
			$result = 'Código de localidade inválido.';
		}
		
		return $result;
	}
}