<?php

namespace App\Services;

use App\Services\AjustadorDados;
use App\Services\IntegradorModelo;
use App\Services\ValidadorDados;

class BaseModel
{
	private $estrutura;
    private $requisicao;
    private $atributosFaltantes;
    private $valoresInvalidos;
    private $codigoResposta;
    private $mensagemResposta;

    public function configurarEstrutura($estrutura)
    {
    	$this->estrutura = $estrutura;
    }

    public function configurarRequisicao($requisicao)
    {
        $requisicaoAjustada = $requisicao;
        
        if(is_array($requisicaoAjustada)){
            $requisicaoAjustada = (object) $requisicaoAjustada;
        }

        $this->requisicao = $requisicaoAjustada;
    }

    public function obterRequisicao()
    {
    	return $this->requisicao;
    }

    public function obterAtributosFaltantes()
    {
        return $this->atributosFaltantes;
    }

    public function obterValoresInvalidos()
    {
        return $this->valoresInvalidos;
    }

    public function obterCodigoResposta()
    {
    	return $this->codigoResposta;
    }

    public function obterMensagemResposta()
    {
    	return $this->mensagemResposta;
    }

    public function analisarRequisicao()
    {
        $this->aplicarAjustes();
        $this->validarRequisicao();
        $this->integrarRequisicao();
        $this->configurarResultado();
    }

    private function aplicarAjustes()
    {
        $requisicaoAjustada = new \stdClass();
        
        foreach($this->estrutura as $nomeAtributo => $restricoesAtributo){
        	$atributoNaoEnviado = true;
            $tipo = $restricoesAtributo['tipo'];
            
            foreach($this->requisicao as $atributo => $valor){
            	if(in_array($atributo, $restricoesAtributo['apelidos'])){
                    $modelo = isset($restricoesAtributo['modelo']) ? $restricoesAtributo['modelo'] : null;
                    
                    $objetoAjustado = (new AjustadorDados)->ajustarDado($valor, $tipo, $modelo);
                    $requisicaoAjustada->{$nomeAtributo} = $objetoAjustado;
                    
                    $atributoNaoEnviado = false;
                }
            }
            
            if($atributoNaoEnviado){
                $default = null;
                if($tipo === 'array' || $tipo === 'arrayObject' || $tipo === 'arrayArray'){
                    $default = array();
                }else if($tipo === 'object'){
                    $default = new \stdClass();
                }
                
                $nomeRestricoes = array_keys($restricoesAtributo);
            	if(in_array('default', $nomeRestricoes)){
            		$default = $restricoesAtributo['default'];
                }
                
                $requisicaoAjustada->{$nomeAtributo} = $default;
            }
        }
        
        $this->requisicao = $requisicaoAjustada;
    }

    private function validarRequisicao()
    {
        $this->atributosFaltantes = $this->estrutura;
        $this->valoresInvalidos = $this->estrutura;

        foreach($this->estrutura as $nomeAtributo => $restricoesAtributo){
            $atributoObrigatorio = isset($restricoesAtributo['obrigatorio']) ? $restricoesAtributo['obrigatorio'] : false;

            $dado = null;
            if(property_exists($this->requisicao, $nomeAtributo)){
                $dado = $this->requisicao->{$nomeAtributo};
            }

            if($atributoObrigatorio){
                if(property_exists($this->requisicao, $nomeAtributo)){
                    if($this->requisicao->{$nomeAtributo} !== null){
                        unset($this->atributosFaltantes[$nomeAtributo]);
                    }
                }
            }else{
                unset($this->atributosFaltantes[$nomeAtributo]);
            }

            if($dado == null || (new ValidadorDados())->validarDado($dado, $restricoesAtributo['tipo'])){
                unset($this->valoresInvalidos[$nomeAtributo]);
            }

            if(isset($restricoesAtributo['modelo'])){
                if($restricoesAtributo['tipo'] === 'arrayObject'){
                    $modeloPrincipal = $this->requisicao->{$nomeAtributo};
                    if(is_object($modeloPrincipal)){
                        foreach($modeloPrincipal as $modeloInterno){
                            $this->integrarModeloInterno($modeloInterno);
                            
                            if($this->codigoResposta != 200){
                                break;
                            }
                        }
                    }
                }else{
                    $modeloInterno = $this->requisicao->{$nomeAtributo};
                    $this->integrarModeloInterno($modeloInterno);
                }
            }
        }
    }

    private function integrarModeloInterno($modelo)
    {
        $this->atributosFaltantes = $modelo->obterAtributosFaltantes();
        $this->valoresInvalidos = $modelo->obterValoresInvalidos();
        $this->codigoResposta = $modelo->obterCodigoResposta();
        $this->mensagemResposta = $modelo->obterMensagemResposta();
    }

    private function integrarRequisicao()
    {
        $this->requisicao = (new IntegradorModelo())->integrarRequisicao($this->requisicao);
    }

	protected function configurarResultado()
	{
	    if($this->atributosFaltantes && $this->valoresInvalidos){
            $this->mensagemResposta['atributos_faltantes'] = $this->atributosFaltantes;
            $this->mensagemResposta['dados_invalidos'] = $this->valoresInvalidos;
            $this->mensagemResposta['msg'] = 'Atributos(s) obrigatório(s) não enviado(s) e valor(es) inválido(s).';
            $this->codigoResposta = 400;
	    }else if($this->atributosFaltantes){
            $this->mensagemResposta['atributos_faltantes'] = $this->atributosFaltantes;
            $this->mensagemResposta['msg'] = 'Atributos(s) obrigatório(s) não enviado(s).';
            $this->codigoResposta = 400;
	    }else if($this->valoresInvalidos){
            $this->mensagemResposta['dados_invalidos'] = $this->valoresInvalidos;
            $this->mensagemResposta['msg'] = 'Valor(es) obrigatório(s) inválido(s).';
            $this->codigoResposta = 400;
	    }else{
            $this->mensagemResposta['msg'] = 'Corpo da requisição válida.';
            $this->codigoResposta = 200;
        }
	}
}