<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\Usuario\ObterUsuario\Service as ObterUsuario;
use App\Services\Usuario\EditarRepresentanteOsc\Service as EditarRepresentanteOsc;
use App\Services\Usuario\EditarRepresentanteGoverno\Service as EditarRepresentanteGoverno;
use App\Services\Usuario\Login\Service as Login;
use App\Services\Usuario\Logout\Service as Logout;
use App\Services\Usuario\CriarRepresentanteOsc\Service as CriarRepresentanteOsc;
use App\Services\Usuario\VerificarRepresentanteGovernoAtivo\Service as VerificarRepresentanteGovernoAtivo;
use App\Services\Usuario\CriarRepresentanteGoverno\Service as CriarRepresentanteGoverno;
use App\Services\Usuario\CriarAssinanteNewsletter\Service as CriarAssinanteNewsletter;
use App\Services\Usuario\SolicitarAlteracaoSenha\Service as SolicitarAlteracaoSenha;
use App\Services\Usuario\AlterarSenha\Service as AlterarSenha;
use App\Services\Usuario\AtivarUsuario\Service as AtivarUsuario;
use App\Services\Usuario\DesativarUsuario\Service as DesativarUsuario;
use App\Services\Usuario\EnviarContato\Service as EnviarContato;
use App\Services\Usuario\ObterTokenIp\Service as ObterTokenIp;

class UsuarioController extends Controller{
    public function obterUsuario(Request $request, $id_usuario, ObterUsuario $service){
    	$extensaoConteudo = ['id_usuario' => $id_usuario];
        $this->executarService($service, $request, $extensaoConteudo);
        
        $accept = $request->header('Accept');
        $response = $this->getResponse($accept);
        
        return $response;
    }
    
    public function criarRepresentanteOsc(Request $request, CriarRepresentanteOsc $service){
        $this->executarService($service, $request);
        return $this->getResponse();
    }
    
    public function verificarRepresentanteGovernoAtivoService(Request $request, $cd_localidade, VerificarRepresentanteGovernoAtivo $service){
    	$extensaoConteudo = ['cd_localidade' => $cd_localidade];
        $this->executarService($service, $request, $extensaoConteudo);
        return $this->getResponse();
    }
    
    public function criarRepresentanteGoverno(Request $request, CriarRepresentanteGoverno $service){
        $this->executarService($service, $request);
        return $this->getResponse();
    }
    
    public function criarAssinanteNewsletter(Request $request, CriarAssinanteNewsletter $service){
        $this->executarService($service, $request);
        return $this->getResponse();
    }
	
	public function editarRepresentanteOsc(Request $request, $id_usuario, EditarRepresentanteOsc $service){
		$extensaoConteudo = ['id_usuario' => $id_usuario];
	    $this->executarService($service, $request, $extensaoConteudo);
	    return $this->getResponse();
	}
	
	public function editarRepresentanteGoverno(Request $request, $id_usuario, EditarRepresentanteGoverno $service){
		$extensaoConteudo = ['id_usuario' => $id_usuario];
	    $this->executarService($service, $request, $extensaoConteudo);
	    return $this->getResponse();
	}
	
	public function login(Request $request, Login $service){
	    $this->executarService($service, $request);
	    return $this->getResponse();
	}
	
	public function logout(Request $request, $id_usuario, Logout $service){
		$extensaoConteudo = ['id_usuario' => $id_usuario];
	    $this->executarService($service, $request, $extensaoConteudo);
	    return $this->getResponse();
	}
	
	public function solicitarAlteracaoSenha(Request $request, SolicitarAlteracaoSenha $service){
	    $this->executarService($service, $request);
	    return $this->getResponse();
	}
	
	public function alterarSenha(Request $request, AlterarSenha $service){
	    $this->executarService($service, $request);
	    return $this->getResponse();
	}
	
	public function ativarUsuario(Request $request, $tx_token, AtivarUsuario $service){
	    $extensaoConteudo = ['tx_token' => $tx_token];
	    $this->executarService($service, $request, $extensaoConteudo);
	    return $this->getResponse();
	}
	
	public function desativarUsuario(Request $request, $tx_token, DesativarUsuario $service){
	    $extensaoConteudo = ['tx_token' => $tx_token];
	    $this->executarService($service, $request, $extensaoConteudo);
	    return $this->getResponse();
	}
	
	public function enviarContato(Request $request, EnviarContato $service){
	    $this->executarService($service, $request);
	    return $this->getResponse();
	}
	
	public function solicitarAtivacaoUsuario(Request $request, $tx_token, EnviarContato $service){
	    $extensaoConteudo = ['tx_token' => $tx_token];
	    $this->executarService($service, $request, $extensaoConteudo);
	    return $this->getResponse();
	}

	public function obterTokenIp(Request $request, ObterTokenIp $service){
	    $extensaoConteudo = ['ip' => $request->ip()];
	    $this->executarService($service, $request, $extensaoConteudo);
	    return $this->getResponse();
	}
}