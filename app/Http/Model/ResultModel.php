<?php

namespace App\Http\Model;

class ResultModel
{
	private $code = 200;
	private $content = '';
	private $flag = true;
	
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
	
	public function setResult($content = null, $code = 200)
	{
		$this->code = $code;
		$this->content = $content;
		
		if($this->code == 200){
			$this->flag = true;
		}else{
			$this->flag = false;
		}
	}
}