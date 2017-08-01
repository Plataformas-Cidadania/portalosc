<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

use App\Services\Service;
use App\DTO\RequisicaoDTO;
use App\DTO\RespostaDTO;

class Controller extends BaseController
{
	private $service = false;
	private $requisicao = false;
	private $resposta = false;
	
	public function __construct(Service $service, RequisicaoDTO $requisicao, RespostaDTO $resposta)
	{
	    $this->service = $service;
		$this->requisicao = $requisicao;
		$this->resposta = $resposta;
	}
	
	public function executarService($service, $request, $parametrosURL = array())
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
	    foreach($parametrosURL as $key => $value){
	        $conteudo[$key] = $value;
	    }
	    
	    $this->requisicao->prepararRequisicao($conteudo, $usuario);
	    $this->service->setRequisicao($this->requisicao);
	    $this->service->executar();
	    $this->resposta = $this->service->getResposta();
	}
	
	public function getResponse($cabecalho = array())
    {
        $response = Response(json_encode($this->resposta->getConteudo()), $this->resposta->getCodigo());
    	
        $response->header('Content-Type', 'application/json');
        foreach ($cabecalho as $key => $value){
            $response->header($key, $value);
        }
        
        return $response;
	}
}
