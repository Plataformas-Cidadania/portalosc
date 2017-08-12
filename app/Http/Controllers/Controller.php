<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

use App\Services\Service;
use App\DTO\RequisicaoDTO;
use App\DTO\RespostaDTO;

class Controller extends BaseController
{
    private $content_response = ["msg" => "Recurso não encontrado"];
    private $http_code = 404;
    
    private function configHttpCode(){
        if($this->content_response){
            $this->http_code = 200;
        }else{
            $this->http_code = 204;
        }
    }
    
    public function configResponse($result, $code_http = 0){
    	$this->content_response = $result;
    	
    	if($code_http){
    		$this->http_code = $code_http;
    	}else{
    		$this->configHttpCode();
    	}
    }
    
    public function response($paramsHeader = []){
        $response = Response(json_encode($this->content_response), $this->http_code);
        $response->header('Content-Type', 'application/json');
        foreach ($paramsHeader as $key => $value){
            $response->header($key, $value);
        }
        return $response;
    }
	
	/*
	 * ====================================================================================================
	 * Refactoring
	 * ====================================================================================================
	 */
	private $service = false;
	private $requisicao = false;
	private $resposta = false;
	
	public function __construct(Service $service, RequisicaoDTO $requisicao, RespostaDTO $resposta)
	{
	    $this->service = $service;
		$this->requisicao = $requisicao;
		$this->resposta = $resposta;
	}
	
	public function executarService($service, $request, $extensaoConteudo = array())
	{
	    $this->service = $service;
	    
	    $usuario = new \stdClass();
	    if($request->user()){
	        $usuario->id_usuario = $request->user()->id;
	        $usuario->tipo_usuario = $request->user()->tipo;
	        $usuario->representacao = $request->user()->representacao;
	        $usuario->localidade = $request->user()->localidade;
	    }
	    
	    $conteudo = $request->all();
	    foreach($extensaoConteudo as $key => $value){
	        $conteudo[$key] = $value;
	    }
	    
	    $this->requisicao->prepararRequisicao($conteudo, $usuario);
	    
	    $this->service->setRequisicao($this->requisicao);
	    $this->service->executar();
	    
	    $this->resposta = $this->service->getResposta();
	}
	
	public function getResponse($cabecalho = array())
    {
        if($this->resposta->getCodigo() == 204){
	        $response = Response(null, $this->resposta->getCodigo());
	    }else{
            $response = Response(json_encode($this->resposta->getConteudo()), $this->resposta->getCodigo());
	    }
        
        $response->header('Content-Type', 'application/json');
        foreach ($cabecalho as $key => $value){
            $response->header($key, $value);
        }
        
        return $response;
	}
	
	protected function ajustarParametroUrl($dado)
	{
	    $dado = urldecode($dado);
	    $dado = trim($dado);
	    $dado = str_replace([' ', '_', '-', '"', '\''], '', $dado);
	    return $dado;
	}
}
