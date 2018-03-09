<?php

namespace App\Models;

class IntegradorObjetos
{
    public function integrarObjetos($requisicao){
        return $this->integrarArray($requisicao);
    }

    private function integrarArray($requisicao){
        if(is_array($requisicao)){
            foreach($requisicao as $campo => $valor){
                $requisicao[$campo] = $this->integrarObject($valor);
            }
        }else{
            $requisicao = $this->integrarObject($requisicao);
        }
        return $requisicao;
    }

    private function integrarObject($requisicao){
        if(is_object($requisicao)){
            if(method_exists($requisicao, 'obterObjeto')){
                $requisicao = $requisicao->obterObjeto();
            }else{
                foreach($requisicao as $campo => $valor){
                    $requisicao->{$campo} = $this->integrarArray($valor);
                }
            }
        }
        return $requisicao;
    }
}