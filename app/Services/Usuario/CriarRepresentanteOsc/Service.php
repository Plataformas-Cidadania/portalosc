<?php

namespace App\Services\Usuario\CriarRepresentanteOsc;

use App\Services\BaseService;
use App\Dao\Usuario\UsuarioDao;
use App\Dao\OscDao;
use App\Email\AtivacaoUsuarioEmail;
use App\Email\InformeCadastroRepresentanteOscEmail;
use App\Email\InformeCadastroRepresentanteOscIpeaEmail;

class Service extends BaseService{
    public function executar(){
    	$requisicao = $this->requisicao->getConteudo();
        $modelo = new Model($requisicao);
        
        if($modelo->obterCodigoResposta() === 200){
        	$representanteOsc = $modelo->obterRequisicao();
			
            # Ajuste na API para facilitar a utilização do serviço pelo client do Mapa OSC
            $representanteOsc->representacao = [$representanteOsc->representacao];
            
            $representanteOsc->token = md5($representanteOsc->cpf . time());
            
            $dao = (new UsuarioDao())->criarRepresentanteOsc($representanteOsc);
            
            if($dao->flag){
                $assuntoUsuario = 'Ativação do cadastro no Mapa das Organizações da Sociedade Civil';
            	$confirmacaoUsuarioEmail = (new AtivacaoUsuarioEmail())->enviar($representanteOsc->email, $assuntoUsuario, $representanteOsc->nome, $representanteOsc->token);
            	
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
				
                $this->resposta->prepararResposta(['msg' => $dao->mensagem], 201);
            }else{
                //$this->resposta->prepararResposta(['msg' => $dao->mensagem], 400);
                $this->resposta->prepararResposta(['msg' => $dao->mensagem], 200);
            }
        }else{
            $this->resposta->prepararResposta($modelo->obterMensagemResposta(), $modelo->obterCodigoResposta());
        }
    }
}