<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

use App\Services\Service;
use App\Dto\RequisicaoDto;
use App\Dto\RespostaDto;

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
	private $service;
	private $requisicao;
	private $resposta;
	
	public function __construct(Service $service, RequisicaoDto $requisicao, RespostaDto $resposta)
	{
	    $this->service = $service;
		$this->requisicao = $requisicao;
		$this->resposta = $resposta;
	}
	
	public function obterSobre()
	{
	    $sobre = [
	        'nome' => 'API Mapa OSC',
	        'versao' => '2.4.0'
	    ];
	    
	    $this->resposta->prepararResposta($sobre, 200);
	    return $this->getResponse();
	}
	
	public function executarService($service, $request, $extensaoConteudo = array())
	{
		#try{
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
		#}catch(\Exception $e){
		#	$this->resposta->prepararResposta(['msg' => 'Ocorreu um erro.'], 500);
		#}
	}
	
	public function getResponse($accept = 'application/json', $cabecalho = array())
    {
    	$conteudoResposta = null;
    	$contentType = $accept;
    	
    	$conteudo = $this->resposta->getConteudo();
		if($accept == 'application/json'){
			$conteudoResposta = json_encode($this->resposta->getConteudo());
		}else if($accept == 'text/csv'){
			$arrayConteudo = (array) $conteudo;
			$conteudoResposta = '"' . implode('";"', array_keys($arrayConteudo)) . '"' . '\n';
			
			$conteudoResposta .= '"';
			foreach($arrayConteudo as $key => $value){
				$conteudoResposta .= '"' . $conteudo->$key . '";';
			}
			$conteudoResposta = substr($conteudoResposta, 0, strlen($conteudoResposta) - 1);
		}else{
			$contentType = 'application/json';
			$conteudoResposta = json_encode($this->resposta->getConteudo());
		}
		
        if($this->resposta->getCodigo() == 204){
	        $response = Response(null, $this->resposta->getCodigo());
	    }else{
            $response = Response($conteudoResposta, $this->resposta->getCodigo());
	    }
        
	    $response->header('Content-Type', $contentType);
        foreach ($cabecalho as $key => $value){
            $response->header($key, $value);
        }
        
        return $response;
	}
	
	protected function ajustarParametroUrl($dado)
	{
	    $dado = urldecode($dado);
	    $dado = trim($dado);
	    $dado = str_replace([' ', '_', '"', '\''], '', $dado);
	    return $dado;
	}
}
