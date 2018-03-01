<?php

namespace App\Dao\Osc;

use App\Dao\DaoPostgres;

class DadosGeraisOscDao extends DaoPostgres
{
    public function obterDadosGerais($param)
    {
    	$result = array();
    	
        $query = "SELECT * FROM portal.obter_osc_dados_gerais(?::TEXT);";
        $result = $this->executarQuery($query, true, [$param]);
        
        $query = "SELECT id_objetivo_osc, cd_objetivo_osc, tx_nome_objetivo_osc, cd_meta_osc, tx_nome_meta_osc, ft_objetivo_osc 
        			FROM portal.vw_osc_objetivo_osc WHERE id_osc = ?::INTEGER;";
        $objetivos = $this->executarQuery($query, false, [$param]);
        
        $result = array_merge((array) $result, ['objetivo_metas' => $objetivos]);
        
        return $result;
    }
	
    public function editarDadosGerais($identificador, $modelo)
    {
    	$fonte = 'Representante de OSC';
		$tipoIdentificador = 'id_osc';
    	$json = json_encode($modelo);
    	$nullValido = true;
    	$erroLog = true;
    	$idCarga = null;

		$paramsDadosGerais = [$fonte, $identificador, $tipoIdentificador, $json, $nullValido, $erroLog, $idCarga];
		$paramsContato = [$fonte, $identificador, $tipoIdentificador, $json, $nullValido, $erroLog, $idCarga];

		$queryDadosGerais = new \stdClass();
		$queryDadosGerais->query = 'SELECT * FROM portal.atualizar_dados_gerais_osc(?::TEXT, ?::NUMERIC, ?::TEXT, now()::TIMESTAMP, ?::JSONB, ?::BOOLEAN, ?::BOOLEAN, ?::INTEGER)';
		$queryDadosGerais->unique = true;
		$queryDadosGerais->params = $paramsDadosGerais;

		$queryContato = new \stdClass();
		$queryContato->query = 'SELECT * FROM portal.atualizar_contato_osc(?::TEXT, ?::NUMERIC, ?::TEXT, now()::TIMESTAMP, ?::JSONB, ?::BOOLEAN, ?::BOOLEAN, ?::INTEGER)';
		$queryContato->unique = true;
		$queryContato->params = $paramsContato;

		$querys = array($queryDadosGerais, $queryContato);
    	$resultadoQuerys = $this->executarQuerys($querys);

		$resultado = new \stdClass();
		$resultado->mensagem = '';

		foreach($resultadoQuerys as $resultadoQuery){			
			if($resultadoQuery->flag){
				if(isset($resultadoQuery->mensagem)){
					$resultado->mensagem = $resultado->mensagem . ' ' . $resultadoQuery->mensagem;
				}
				$resultado->flag = $resultadoQuery->flag;
			}else{
				$resultado = end($resultadoQuerys);
				break;
			}
		}

    	return $resultado;
    }
}
