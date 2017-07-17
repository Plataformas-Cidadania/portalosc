<?php

namespace App\Http\Model;

class ResponseModel
{
	private $code = 404;
	private $content = ['msg' => 'Recurso não encontrado.'];
	private $flag = false;
	
	public function getCode()
	{
		return $this->code;
	}
	
	public function getContent()
	{
		return $this->content;
	}
	
	public function getFlag()
	{
		return $this->flag;
	}
	
	public function setResponse($content = null, $code = 200)
	{
		$this->code = $code;
		$this->content = $content;
		
		if($this->code == 200){
			$this->flag = true;
		}else{
			$this->flag = false;
		}
	}
	
	public function updateContent($newContent)
	{
		$this->content = array_merge($this->content, $newContent);
	}
}