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
    	$requisicao = $this->requisicao->getConteudo();
    	
    	$representanteOsc = new RepresentanteOscModel($requisicao);
    	$flagModel = $this->analisarModel($representanteOsc);
        
        if($flagModel){
        	$representanteOsc = $representanteOsc->getModel();
			
            # Ajuste na API para facilitar a utilização do serviço pelo client do Mapa OSC
            $representanteOsc->representacao = [$representanteOsc->representacao];
            
            $representanteOsc->token = md5($representanteOsc->cpf . time());
            
            $resultadoDao = (new UsuarioDao())->criarRepresentanteOsc($representanteOsc);
            
            if($resultadoDao->flag){
            	$confirmacaoUsuarioEmail = (new AtivacaoRepresentanteOscEmail())->enviar($representanteOsc->email, 'Confirmação de Cadastro Mapa das Organizações da Sociedade Civil', $representanteOsc->nome, $representanteOsc->token);
            	
                $nomeEmailOscs = (new OscDao())->obterNomeEmailOscs($representanteOsc->representacao);
                
                foreach($nomeEmailOscs as $osc) {
                    $emailIpea = 'mapaosc@ipea.gov.br';
                    $tituloEmail = 'Notificação de cadastro de representante no Mapa das Organizações da Sociedade Civil';
                    
                    if($osc->tx_email){
                        $informeIpeaEmail = (new InformeCadastroRepresentanteOscIpeaEmail())->enviar($emailIpea, $tituloEmail, $representanteOsc, $osc);
                        $informeOscEmail = (new InformeCadastroRepresentanteOscEmail())->enviar($osc->tx_email, $tituloEmail, $representanteOsc, $osc->tx_nome_osc);
                    }else{
                        $informeIpeaEmail = (new InformeCadastroRepresentanteOscIpeaEmail())->enviar($emailIpea, $tituloEmail, $representanteOsc, $osc);
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
