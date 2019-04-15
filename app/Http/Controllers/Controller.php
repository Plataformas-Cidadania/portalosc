<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

use App\Services\BaseService;
use App\Dto\RequisicaoDto;
use App\Dto\RespostaDto;

class Controller extends BaseController
{
    private $content_response = ["msg" => "Recurso não encontrado"];
	private $http_code = 404;
	private $headersDefault = array(
		'Cache-Control' => 'public, max-age=3600'
	);
    
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
		
		foreach ($this->headersDefault as $key => $value){
            $response->header($key, $value);
		}
        
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
	
	public function __construct(BaseService $service, RequisicaoDto $requisicao, RespostaDto $resposta){
	    $this->service = $service;
		$this->requisicao = $requisicao;
		$this->resposta = $resposta;
	}
	
	public function obterSobre(){
	    $sobre = [
	        'nome' => 'API Mapa das OSCs',
	        'versao' => '2.7.2'
	    ];
	    
	    $this->resposta->prepararResposta($sobre, 200);
	    return $this->getResponse();
	}
	
	public function executarService($service, $request, $extensaoConteudo = array()){
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
			$conteudo[$key] = $this->ajustarParametroUrl($value);
		}
		
		$this->requisicao->prepararRequisicao($conteudo, $usuario);
		$this->service->setRequisicao($this->requisicao);
		$this->service->executar();
		
		$this->resposta = $this->service->getResposta();
	}
	
	public function getResponse($accept = 'application/json', $cabecalho = array()){
    	$conteudoResposta = null;
    	$contentType = $accept;
    	
    	$conteudo = $this->resposta->getConteudo();

		if($accept == 'application/json'){
			$conteudoResposta = json_encode($this->resposta->getConteudo());
		}else if($accept == 'text/csv'){
			if(gettype($conteudo) == 'array'){
				$conteudoAjustado = $conteudo;
			}else{
				$conteudoAjustado = array($conteudo);
			}

			$headArray = array();
			foreach($conteudoAjustado[0] as $key => $value){
				array_push($headArray, $key);
			}

			$csv = '"' . implode('";"', array_values($headArray)) . '"' . '\n';

			foreach($conteudoAjustado as $object){
				$line = '';
				
				foreach($headArray as $index => $csvColumnName){
					if(isset($object->{$csvColumnName})){
						$line .= '"' . $object->{$csvColumnName} . '"';
					}else{
						$line .= '""';
					}

					$line .= ';';
				}

				$line = rtrim($line, ';');
				$csv .= $line . '\n';
			}

			$conteudoResposta = $csv;
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
		
		foreach ($this->headersDefault as $key => $value){
            $response->header($key, $value);
		}
		
        foreach ($cabecalho as $key => $value){
            $response->header($key, $value);
        }
        
        return $response;
	}
	
	private function ajustarParametroUrl($dado){
	    $dado = urldecode($dado);
	    $dado = trim($dado);
	    $dado = str_replace([' ', '_', '"', '\''], '', $dado);
	    return $dado;
	}
}