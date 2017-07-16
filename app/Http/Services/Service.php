<?php

namespace App\Http\Services;

use App\Http\Model\ResponseModel;

class Service
{
	protected $response = false;
	
	public function __construct(ResponseModel $response)
	{
		$this->response = $response;
	}
	
	public function run($object)
	{
		return $this->response;
	}
}