<?php

namespace App\Models;

use App\Models\AjustadorDados;
use App\Models\IntegradorModelo;
use App\Models\ValidadorDados;

class Model
{
	private $estrutura;
    private $corpoRequisicao;
    private $atributosFaltantes;
    private $valoresInvalidos;
    private $codigoResposta;
    private $mensagemResposta;

    public function configurarEstrutura($estrutura)
    {
    	$this->estrutura = $estrutura;
    }

    public function configurarCorpoRequisicao($corpoRequisicao)
    {
        $this->corpoRequisicao = $corpoRequisicao;
    }

    public function obterCorpoRequisicao()
    {
    	return $this->corpoRequisicao;
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
        $this->integrarCorpoRequisicao();
        $this->configurarResultado();
    }

    private function aplicarAjustes()
    {
        $corpoRequisicaoAjustada = new \stdClass();

        foreach($this->estrutura as $nomeAtributo => $restricoesAtributo){
        	$atributoNaoEnviado = true;

            foreach($this->corpoRequisicao as $atributo => $valor){
            	if(in_array($atributo, $restricoesAtributo['apelidos'])){
                    $tipo = $restricoesAtributo['tipo'];
                    $modelo = isset($restricoesAtributo['modelo']) ? $restricoesAtributo['modelo'] : null;

                    $objetoAjustado = (new AjustadorDados)->ajustarDado($valor, $tipo, $modelo);
                    $corpoRequisicaoAjustada->{$nomeAtributo} = $objetoAjustado;

                    $atributoNaoEnviado = true;
                }
            }

            if($atributoNaoEnviado){
            	$nomeRestricoes = array_keys($restricoesAtributo);
            	if(in_array('default', $nomeRestricoes)){
            		$default = $restricoesAtributo['default'];
            		$corpoRequisicaoAjustada->{$nomeAtributo} = $restricoesAtributo['default'];
            	}
            }
        }

        $this->corpoRequisicao = $corpoRequisicaoAjustada;
    }

    private function validarRequisicao()
    {
        $this->atributosFaltantes = $this->estrutura;
        $this->valoresInvalidos = $this->estrutura;
        
        foreach($this->estrutura as $nomeAtributo => $restricoesAtributo){
            $atributoObrigatorio = isset($restricoesAtributo['obrigatorio']) ? $restricoesAtributo['obrigatorio'] : false;

            if($atributoObrigatorio){
                if(property_exists($this->corpoRequisicao, $nomeAtributo)){
                    if($this->corpoRequisicao->{$nomeAtributo}){
                        unset($this->atributosFaltantes[$nomeAtributo]);
                    }

                    $dado = $this->corpoRequisicao->{$nomeAtributo};
                    if((new ValidadorDados())->validarDado($dado, $restricoesAtributo['tipo'])){
                        unset($this->valoresInvalidos[$nomeAtributo]);
                    }
                }else{
                    unset($this->valoresInvalidos[$nomeAtributo]);
                }
            }else{
                unset($this->atributosFaltantes[$nomeAtributo]);
                unset($this->valoresInvalidos[$nomeAtributo]);
            }

            if(isset($restricoesAtributo['modelo'])){
                if($restricoesAtributo['tipo'] === 'arrayObject'){
                    $modeloPrincipal = $this->corpoRequisicao->{$nomeAtributo};
                    foreach($modeloPrincipal as $modeloInterno){
                        $this->integrarModeloInterno($modeloInterno);
                        
                        if($this->codigoResposta != 200){
                            break;
                        }
                    }
                }else{
                    $modeloInterno = $this->corpoRequisicao->{$nomeAtributo};
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

    private function integrarCorpoRequisicao(){
        $this->corpoRequisicao = (new IntegradorModelo())->integrarCorpoRequisicao($this->corpoRequisicao);
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