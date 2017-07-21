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
	
	public function __construct(RequisicaoDTO $requisicao, RespostaDTO $resposta)
	{
		$this->requisicao = $requisicao;
		$this->resposta = $resposta;
	}
	
    public function setResponse($response, $paramsHeader = [])
    {
    	$response = Response(json_encode($response->getContent()), $response->getCode());
    	
        $response->header('Content-Type', 'application/json');
        foreach ($paramsHeader as $key => $value){
            $response->header($key, $value);
        }
        
        return $response;
    }
    
    public function executar(Service $service, $request, $atributosURL = array()){
    	$usuario['id_usuario'] = $request->user()->id;
    	$usuario['tipo_usuario'] = $request->user()->tipo;
    	$usuario['representacao'] = $request->user()->representacao;
    	$usuario['localidade'] = $request->user()->localidade;
    	
    	$conteudo = $request->all();
    	foreach($atributosURL as $key => $value){
    		$conteudo[$key] = $value;
    	}
    	
    	$this->requisicao->definirRequisicao($conteudo, $usuario);
    	$service->executar($this->requisicao);
    }
}
