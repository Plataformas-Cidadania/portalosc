<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\Usuario\ObterUsuarioService;
use App\Services\Usuario\EditarRepresentanteOscService;
use App\Services\Usuario\EditarRepresentanteGovernoService;
use App\Services\Usuario\LoginService;
use App\Services\Usuario\LogoutService;
use App\Services\Usuario\CriarRepresentanteOscService;
use App\Services\Usuario\CriarRepresentanteGovernoService;
use App\Services\Usuario\CriarAssinanteNewsletterService;
use App\Services\Usuario\SolicitarAlteracaoSenhaService;
use App\Services\Usuario\AlterarSenhaService;
use App\Services\Usuario\AtivarUsuarioService;
use App\Services\Usuario\DesativarUsuarioService;
use App\Services\Usuario\EnviarContatoService;

class UsuarioController extends Controller
{
    public function obterUsuario(Request $request, $id_usuario, ObterUsuarioService $service)
    {
        $id_usuario = $this->ajustarParametroUrl($id_usuario);
        
    	$extensaoConteudo = ['id_usuario' => $id_usuario];
        $this->executarService($service, $request, $extensaoConteudo);
        return $this->getResponse();
    }
    
    public function criarRepresentanteOsc(Request $request, CriarRepresentanteOscService $service)
    {
        $this->executarService($service, $request);
        return $this->getResponse();
    }
    
    public function criarRepresentanteGoverno(Request $request, CriarRepresentanteGovernoService $service)
    {
        $this->executarService($service, $request);
        return $this->getResponse();
    }
    
    public function criarAssinanteNewsletter(Request $request, CriarAssinanteNewsletterService $service)
    {
        $this->executarService($service, $request);
        return $this->getResponse();
    }
	
	public function editarRepresentanteOsc(Request $request, $id_usuario, EditarRepresentanteOscService $service)
	{
	    $id_usuario = $this->ajustarParametroUrl($id_usuario);
	    
		$extensaoConteudo = ['id_usuario' => $id_usuario];
	    $this->executarService($service, $request, $extensaoConteudo);
	    return $this->getResponse();
	}
	
	public function editarRepresentanteGoverno(Request $request, $id_usuario, EditarRepresentanteGovernoService $service)
	{
	    $id_usuario = $this->ajustarParametroUrl($id_usuario);
	    
		$extensaoConteudo = ['id_usuario' => $id_usuario];
	    $this->executarService($service, $request, $extensaoConteudo);
	    return $this->getResponse();
	}
	
	public function login(Request $request, LoginService $service)
	{
	    $this->executarService($service, $request);
	    return $this->getResponse();
	}
	
	public function logout(Request $request, $id_usuario, LogoutService $service)
	{
	    $id_usuario = $this->ajustarParametroUrl($id_usuario);
	    
		$extensaoConteudo = ['id_usuario' => $id_usuario];
	    $this->executarService($service, $request, $extensaoConteudo);
	    return $this->getResponse();
	}
	
	public function solicitarAlteracaoSenha(Request $request, SolicitarAlteracaoSenhaService $service)
	{
	    $this->executarService($service, $request);
	    return $this->getResponse();
	}
	
	public function alterarSenha(Request $request, AlterarSenhaService $service)
	{
	    $this->executarService($service, $request);
	    return $this->getResponse();
	}
	
	public function ativarUsuario(Request $request, $tx_token, AtivarUsuarioService $service)
	{
	    $tx_token = $this->ajustarParametroUrl($tx_token);
	    
	    $extensaoConteudo = ['tx_token' => $tx_token];
	    $this->executarService($service, $request, $extensaoConteudo);
	    return $this->getResponse();
	}
	
	public function desativarUsuario(Request $request, $tx_token, DesativarUsuarioService $service)
	{
	    $tx_token = $this->ajustarParametroUrl($tx_token);
	    
	    $extensaoConteudo = ['tx_token' => $tx_token];
	    $this->executarService($service, $request, $extensaoConteudo);
	    return $this->getResponse();
	}
	
	public function enviarContato(Request $request, EnviarContatoService $service)
	{
	    $this->executarService($service, $request);
	    return $this->getResponse();
	}
	
	public function solicitarAtivacaoUsuario(Request $request, $tx_token, EnviarContatoService $service)
	{
	    $tx_token = $this->ajustarParametroUrl($tx_token);
	    
	    $extensaoConteudo = ['tx_token' => $tx_token];
	    $this->executarService($service, $request, $extensaoConteudo);
	    return $this->getResponse();
	}
}
