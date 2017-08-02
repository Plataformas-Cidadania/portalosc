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

class UsuarioController extends Controller
{
    public function obterUsuario(Request $request, $id_usuario, ObterUsuarioService $service)
    {
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
	
	public function editarRepresentanteOsc(Request $request, $id_usuario, EditarRepresentanteOscService $service)
	{
		$extensaoConteudo = ['id_usuario' => $id_usuario];
	    $this->executarService($service, $request, $extensaoConteudo);
	    return $this->getResponse();
	}
	
	public function editarRepresentanteGoverno(Request $request, $id_usuario, EditarRepresentanteGovernoService $service)
	{
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
		$extensaoConteudo = ['id_usuario' => $id_usuario];
	    $this->executarService($service, $request, $extensaoConteudo);
	    return $this->getResponse();
	}
}
