<?php

namespace App\Modules\Usuario\Dao;

use App\Enums\TipoUsuarioEnum;
use App\Modules\Usuario\Models\RepresentanteOscModel;
use App\Modules\Usuario\Models\RepresentanteGovernoMunicipioModel;
use App\Modules\Usuario\Models\RepresentanteGovernoEstadoModel;
use App\Modules\Dao;

class LoginDao extends Dao
{
	public function login($usuario)
	{
		$query = 'SELECT tb_usuario.id_usuario,
						tb_usuario.cd_tipo_usuario,
						tb_usuario.tx_nome_usuario,
        				tb_usuario.cd_municipio,
        				tb_usuario.cd_uf,
						tb_usuario.bo_ativo
					FROM
						portal.tb_usuario
					WHERE
						tx_email_usuario = ?::TEXT AND
						tx_senha_usuario = ?::TEXT;';
		
		$params = [$usuario->getEmail(), $usuario->getSenha()];
		$resultadoDao = $this->executarQuery($query, true, $params);
		
		if($resultadoDao){
			$usuario->prepararObjeto($resultadoDao);
			
			if($usuario->getTipoUsuario($usuario) == TipoUsuarioEnum::OSC){
				$usuario = $this->criarRepresentanteOsc($usuario);
			}else if($usuario->getTipoUsuario($usuario) == TipoUsuarioEnum::GOVERNO_MUNICIPAL){
				$usuario = $this->criarRepresentanteGovernoMunicipio($usuario);
				$usuario->setCodigo($resultadoDao->cd_municipio);
			}else if($usuario->getTipoUsuario($usuario) == TipoUsuarioEnum::GOVERNO_ESTADUAL){
				$usuario = $this->criarRepresentanteGovernoEstado($usuario);
				$usuario->setCodigo($resultadoDao->cd_uf);
			}
		}else{
			$usuario = null;
		}
		
		return $usuario;
	}
	
	private function criarRepresentanteOsc($usuario)
	{
		$representanteOSC = new RepresentanteOSCModel();
		$representanteOSC->clone($usuario);
		
		$query = 'SELECT id_osc FROM portal.tb_representacao WHERE id_usuario = ?::INTEGER;';
		$params = [$usuario->getId()];
		$resultadoDao = $this->executarQuery($query, false, $params);
		
		if($resultadoDao){
			$representacao = array_map(create_function('$o', 'return $o->id_osc;'), $resultadoDao);
			$representanteOSC->setOscs($representacao);
		}
		
		return $representanteOSC;
	}
	
	private function criarRepresentanteGovernoMunicipio($usuario)
	{
		$epresentanteGovernoMunicipio = new RepresentanteGovernoMunicipioModel();
		$epresentanteGovernoMunicipio->clone($usuario);
		
		return $epresentanteGovernoMunicipio;
	}
	
	private function criarRepresentanteGovernoEstado($usuario)
	{
		$representanteGovernoEstado = new RepresentanteGovernoEstadoModel();
		$representanteGovernoEstado->clone($usuario);
		
		return $representanteGovernoEstado;
	}
}
