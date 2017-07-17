<?php

namespace App\Http\Services;

use App\Http\Model\RequestModel;
use App\Http\Model\ResponseModel;

class Service
{
	protected $request = false;
	protected $response = false;
	
	public function __construct(RequestModel $request, ResponseModel $response)
	{
		$this->request = $request;
		$this->response = $response;
	}
	
	public function execute($content, $user = null)
	{
		return $this->response;
	}
}