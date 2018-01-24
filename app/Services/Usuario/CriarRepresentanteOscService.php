<?php

namespace App\Services\Usuario;

use App\Services\Service;
use App\Models\RepresentanteOscModel;
use App\Dao\UsuarioDao;
use App\Dao\OscDao;
use App\Email\AtivacaoRepresentanteOscEmail;
use App\Email\InformeCadastroRepresentanteOscEmail;
use App\Email\InformeCadastroRepresentanteOscIpeaEmail;
use App\Enums\NomenclaturaAtributoEnum;

class CriarRepresentanteOscService extends Service
{
    public function executar()
    {
    	$model = new RepresentanteOscModel($this->requisicao->getConteudo());
        $flagModel = $this->analisarModel($model);
        
        if($flagModel){
            $requisicao = $model->getRequisicao();
			
            # Ajuste na API para facilitar a utilização do serviço pelo client do Mapa OSC
            $requisicao->representacao = [$requisicao->representacao];
            
            $requisicao->token = md5($requisicao->nr_cpf_usuario . time());
            
            $resultadoDao = (new UsuarioDao())->criarRepresentanteOsc($requisicao);
            
            if($resultadoDao->flag){
            	$confirmacaoUsuarioEmail = (new AtivacaoRepresentanteOscEmail())->enviar($requisicao->tx_email_usuario, 'Confirmação de Cadastro Mapa das Organizações da Sociedade Civil', $requisicao->tx_nome_usuario, $requisicao->token);
            	
                $nomeEmailOscs = (new OscDao())->obterNomeEmailOscs($requisicao->representacao);
                
                foreach($nomeEmailOscs as $osc) {
                    $emailIpea = 'mapaosc@ipea.gov.br';
                    $tituloEmail = 'Notificação de cadastro de representante no Mapa das Organizações da Sociedade Civil';
                    
                    if($osc->tx_email){
                        $informeIpeaEmail = (new InformeCadastroRepresentanteOscIpeaEmail())->enviar($emailIpea, $tituloEmail, $requisicao, $osc);
                        $informeOscEmail = (new InformeCadastroRepresentanteOscEmail())->enviar($osc->tx_email, $tituloEmail, $requisicao, $osc->tx_nome_osc);
                    }else{
                        $informeIpeaEmail = (new InformeCadastroRepresentanteOscIpeaEmail())->enviar($emailIpea, $tituloEmail, $requisicao, $osc);
                    }
                }
				
                $this->resposta->prepararResposta(['msg' => $resultadoDao->mensagem], 201);
            }else{
                //$this->resposta->prepararResposta(['msg' => $resultadoDao->mensagem], 400);
                $this->resposta->prepararResposta(['msg' => $resultadoDao->mensagem], 200);
            }
        }
    }
}
