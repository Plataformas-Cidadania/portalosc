<?php

namespace App\Http\Services;

use App\Http\Model\ResultModel;

class Service
{
	protected $result = false;
	
	public function __construct(ResultModel $result)
	{
		$this->result = $result;
	}
	
	public function check($object)
	{
		return $this->result;
	}
	
	public function execute($object)
	{
		return $this->result;
	}
	
	public function response()
	{
		return $this->result;
	}
}