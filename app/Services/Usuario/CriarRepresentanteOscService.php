<?php

namespace App\Services\Usuario;

use App\Enums\NomenclaturaAtributoEnum;
use App\Services\Service;
use App\Services\Model;
use App\Dao\UsuarioDao;
use App\Dao\OscDao;
use App\Email\InformeCadastroRepresentanteOscEmail;
use App\Email\InformeCadastroRepresentanteOscIpeaEmail;

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
        
        $model = new Model($contrato, $requisicao);
        $flagModel = $this->analisarModel($model);
        $requisicao = $model->getRequisicao();
        
        if($flagModel){
            $requisicao->token = md5($requisicao->nr_cpf_usuario . time());
            
            $resultadoDao = (new UsuarioDao())->criarRepresentanteOsc($requisicao);
            
            if($resultadoDao->flag){
                $nomeEmailOscs = (new OscDao())->obterNomeEmailOscs($oscsInsert);
                
                foreach($nomeEmailOscs as $osc) {
                    $osc = ['nomeOsc' => $osc->tx_nome_osc, 'emailOsc' => $osc->tx_email];
                    $user = ['nome' => $requisicao->tx_nome_usuario, 'email' => $requisicao->tx_email_usuario, 'cpf' => $cpfUsuario];
                    $emailIpea = 'mapaosc@ipea.gov.br';
                    
                    if($osc->tx_email){
                        $ipeaEmail = new InformeCadastroRepresentanteOscIpeaEmail();
                        $ipeaEmail->enviarEmail($emailIpea, "Notificação de cadastro de representante no Mapa das Organizações da Sociedade Civil", $ipeaEmail->obterConteudo());
                        
                        $oscEmail = new InformeCadastroRepresentanteOscEmail();
                        $oscEmail->enviarEmail($emailIpea, "Notificação de cadastro de representante no Mapa das Organizações da Sociedade Civil", $oscEmail->obterConteudo());
                    }else{
                        $ipeaEmail = new InformeCadastroRepresentanteOscIpeaEmail();
                        $ipeaEmail->enviarEmail($emailIpea, "Notificação de cadastro de representante no Mapa das Organizações da Sociedade Civil", $ipeaEmail->obterConteudo());
                    }
                }
				
                $this->resposta->prepararResposta(['msg' => $resultadoDao->mensagem], 200);
            }else{
                $this->resposta->prepararResposta(['msg' => $resultadoDao->mensagem], 400);
            }
        }
    }
}
