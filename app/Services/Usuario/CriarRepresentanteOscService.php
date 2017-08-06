<?php

namespace App\Services\Usuario;

use App\Enums\NomenclaturaAtributoEnum;
use App\Services\Service;
use App\Services\Model;
use App\Dao\UsuarioDao;

class CriarRepresentanteOscService extends Service
{
    public function executar()
    {
        $contrato = [
            'tx_email_usuario' => ['apelidos' => NomenclaturaAtributoEnum::EMAIL, 'obrigatorio' => true, 'tipo' => 'email'],
            'tx_senha_usuario' => ['apelidos' => NomenclaturaAtributoEnum::SENHA, 'obrigatorio' => true, 'tipo' => 'senha'],
            'tx_nome_usuario' => ['apelidos' => NomenclaturaAtributoEnum::NOME_USUARIO, 'obrigatorio' => true, 'tipo' => 'string'],
            'nr_cpf_usuario' => ['apelidos' => NomenclaturaAtributoEnum::CPF, 'obrigatorio' => true, 'tipo' => 'cpf'],
            'bo_lista_email' => ['apelidos' => NomenclaturaAtributoEnum::LISTA_EMAIL, 'obrigatorio' => true, 'tipo' => 'boolean'],
            'representacao' => ['apelidos' => NomenclaturaAtributoEnum::REPRESENTACAO, 'obrigatorio' => true, 'tipo' => 'arrayInteger']
        ];
        
        $requisicao = $this->requisicao->getConteudo();
        
        $model = new Model($contrato, $requisicao);
        $flagModel = $this->analisarModel($model);
        
        if($flagModel){
            $requisicao->token = md5($requisicao->nr_cpf_usuario . time());
            
            $resultadoDao = (new UsuarioDao())->criarRepresentanteOsc($requisicao);
            
            if($resultadoDao->flag){
                $this->resposta->prepararResposta(['msg' => $resultadoDao->mensagem], 200);
            }else{
                $this->resposta->prepararResposta(['msg' => $resultadoDao->mensagem], 400);
            }
        }
    }
}
