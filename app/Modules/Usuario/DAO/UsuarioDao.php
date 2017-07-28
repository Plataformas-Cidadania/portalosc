<?php

namespace App\Modules\Usuario\Dao;

use App\Enums\TipoUsuarioEnum;
use App\Modules\Usuario\Models\RepresentanteOSCModel;
use App\Modules\Dao;

class UsuarioDao extends Dao
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
				$this->buscarOscsDeUsuario($usuario);
			}
		}
		
		return $usuario;
	}
	
	public function buscarOscs($usuario)
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
		
		print_r($representanteOSC);
		
		return $representanteOSC;
	}
	
	public function obterRepresentante($object)
	{
	    $resultado = array();
		
		$query = 'SELECT * FROM portal.obter_representante(?::INTEGER);';
		$params = [$object->id_usuario];
		$resultado = $this->executeQuery($query, true, $params);
		
		return $resultado;
	}
	
	public function editarRepresentanteOSC($object)
	{
		$result = array();
		
		$listOsc = array();
		foreach($object['representacao'] as $key => $value) {
			array_push($listOsc, $value['id_osc']);
		}
		$object['representacao'] = '{'.implode(',', $listOsc).'}';
		
		$query = 'SELECT * FROM portal.atualizar_representante(?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?);';
		$params = [$object['id_usuario'], $object['tx_email_usuario'], sha1($object['tx_senha_usuario']), $object['tx_nome_usuario'], $object['representacao']];
		$result = $this->executeQuery($query, true, $params);
		
		$resultQuery = $this->obterUsuario($object);
		$result = array_merge($result, $resultQuery);
		
		if($result['nova_representacao']){
			$novaRepresentacao = array();
			foreach(explode(',', substr($result['nova_representacao'], 1, -1)) as $id_osc){
				$resultQuery = $this->getDataOsc($id_osc);
				array_push($novaRepresentacao, ['id_osc' => $id_osc, 'tx_razao_social_osc' => $resultQuery['tx_razao_social_osc'], 'tx_email' => $resultQuery['tx_email']]);
			};
			$result['nova_representacao'] = $novaRepresentacao;
		}
		
		return $result;
	}
	
	public function editarRepresentanteGoverno($object)
	{
		$resultQuery = array();
		/*
		$query = 'SELECT * FROM portal.atualizar_representante_governo(?::INTEGER, ?::TEXT, ?::TEXT, ?::TEXT, ?::INTEGER);';
		$params = [$object['id_usuario'], $object['tx_email_usuario'], sha1($object['tx_senha_usuario']), $object['tx_nome_usuario'], $object['localidade']];
		$resultQuery = $this->execute($query, true, $params);
		*/
		return $resultQuery;
	}
}
