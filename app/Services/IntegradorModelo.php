<?php

namespace App\Services;

class IntegradorModelo{
    public function integrarRequisicao($modelo){
        return $this->integrarArray($modelo);
    }

    private function integrarArray($modelo){
        if(is_array($modelo)){
            foreach($modelo as $campo => $valor){
                $modelo[$campo] = $this->integrarObject($valor);
            }
        }else{
            $modelo = $this->integrarObject($modelo);
        }
        
        return $modelo;
    }

    private function integrarObject($modelo){
        if(is_object($modelo)){
            if(method_exists($modelo, 'obterRequisicao')){
                $modelo = $modelo->obterRequisicao();
            }else{
                foreach($modelo as $campo => $valor){
                    $modelo->{$campo} = $this->integrarArray($valor);
                }
            }
        }

        return $modelo;
    }
}