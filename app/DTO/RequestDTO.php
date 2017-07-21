<?php

namespace App\Http\Model;

use App\Http\Util\DataValidatorUtil;

class RequestModel
{
	private $attributes = array();
	private $content = array();
	private $user = null;
	private $flag = true;
	private $message = '';
	
	public function getUserFlag()
	{
		return $this->user;
	}
	
	public function getContent()
	{
		return $this->content;
	}
	
	public function getFlag()
	{
		return $this->flag;
	}
	
	public function getMessage()
	{
		return $this->message;
	}
	
	private function invalidateData($message = null){
		$this->flag = false;
		$this->message = $message;
	}
	
	private function checkRequiredData()
	{
		$missing = array();
		foreach($this->attributes as $attrKey => $attrValue){
			if($attrValue['required']){
				if(!array_key_exists($attrKey, $this->content)){
					array_push($missing, $attrKey);
				}
			}
		}
		
		if($missing){
			$this->invalidateData('Dados obrigatórios não enviados.');
		}
	}
	
	private function validateData()
	{
		$dataValidator = new DataValidatorUtil();
		
		if(array_key_exists('cpf', $this->content) && !$dataValidator->validateCPF($this->content['cpf'])){
			$this->invalidateData('CPF inválido.');
		}else if(array_key_exists('email', $this->content) && !$dataValidator->validateEmail($this->content['email'])){
			$this->invalidateData('E-mail inválido.');
		}else if(array_key_exists('tx_email_usuario', $this->content) && !$dataValidator->validateEmail($this->content['tx_email_usuario'])){
			$this->invalidateData('E-mail inválido.');
		}else if(array_key_exists('id_user', $this->content) && !$dataValidator->validateNumber($this->content['id_user'])){
			$this->invalidateData('ID de usuário inválido.');
		}else if(array_key_exists('id_osc', $this->content) && !$dataValidator->validateNumber($this->content['id_osc'])){
			$this->invalidateData('ID de OSC inválido.');
		}else if(array_key_exists('localidade', $this->content) && !(strlen($this->content['localidade']) == 2 || strlen($this->content['localidade']) == 7)){
			$this->invalidateData('Código de localidade inválido.');
		}
	}
	
	public function setRequest($attributes, $content = array(), $user = null)
	{
		$this->attributes = $attributes;
		$this->content = $content;
		$this->user = $user;
		
		if($this->flag) $this->checkRequiredData($content);
		if($this->flag) $this->validateData($content);
	}
}
