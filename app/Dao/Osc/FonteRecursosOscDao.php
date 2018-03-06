<?php

namespace App\Dao\Osc;

use App\Dao\DaoPostgres;

class FonteRecursosOscDao extends DaoPostgres
{
    public function obterRecursosOsc($idOsc)
    {
    	$query = 'SELECT * FROM osc.tb_recursos_osc WHERE id_osc = ?::INTEGER;';
    	$params = [$idOsc];
    	return $this->executarQuery($query, false, $params);
    }

    public function excluirRecursosOsc($idOsc)
    {
    	$query = 'SELECT * FROM portal.excluir_recursos_osc(?::INTEGER);';
    	$params = [$idOsc];
    	return $this->executarQuery($query, true, $params);
    }
	
    public function atualizarRecursosOsc($recurso)
    {
    	$query = 'SELECT * FROM portal.atualizar_recursos_osc(?::INTEGER, ?::INTEGER, ?::INTEGER, ?::TEXT, ?::DATE, ?::TEXT, ?::DOUBLE PRECISION, ?::TEXT, ?::BOOLEAN, ?::TEXT);';
    	$params = [$recurso->id_recursos_osc, $recurso->id_osc, $recurso->cd_fonte_recursos_osc, $recurso->ft_fonte_recursos_osc, $recurso->dt_ano_recursos_osc, $recurso->ft_ano_recursos_osc, $recurso->nr_valor_recursos_osc, $recurso->ft_valor_recursos_osc, $recurso->bo_nao_possui, $recurso->ft_nao_possui];
    	return $this->executarQuery($query, true, $params);
    }
	
    public function inserirRecursosOsc($recurso)
    {
    	$query = 'SELECT * FROM portal.inserir_recursos_osc(?::INTEGER, ?::INTEGER, ?::INTEGER, ?::TEXT, ?::DATE, ?::TEXT, ?::DOUBLE PRECISION, ?::TEXT, ?::BOOLEAN, ?::TEXT);';
        $params = [$recurso->id_osc, $recurso->cd_origem_fonte_recursos_osc, $recurso->cd_fonte_recursos_osc, $recurso->ft_fonte_recursos_osc, $recurso->dt_ano_recursos_osc, $recurso->ft_ano_recursos_osc, $recurso->nr_valor_recursos_osc, $recurso->ft_valor_recursos_osc, $recurso->bo_nao_possui, $recurso->ft_nao_possui];
        
        print_r($params);
    	return $this->executarQuery($query, true, $params);
    }
	
    public function editarRecurso($identificador, $modelo)
    {
    	$modeloDao = array();
    	
    	foreach($modelo as $certificado){
    		$certificadoDao['cd_certificado'] = isset($certificado->certificado) ? $certificado->certificado : null;
    		$certificadoDao['dt_inicio_certificado'] = isset($certificado->dataInicio) ? $certificado->dataInicio : null;
    		$certificadoDao['dt_fim_certificado'] = isset($certificado->dataFim) ? $certificado->dataFim : null;
    		$certificadoDao['cd_municipio'] = isset($certificado->municipio) ? $certificado->municipio : null;
    		$certificadoDao['cd_uf'] = isset($certificado->estado) ? $certificado->estado : null;
    		
    		array_push($modeloDao, $certificadoDao);
    	}
    	
    	$fonte = 'Representante de OSC';
    	$tipoIdentificador = 'id_osc';
    	$json = json_encode($modeloDao);
    	$nullValido = true;
    	$deleteValido = true;
    	$erroLog = true;
    	$idCarga = null;
    	$tipoBusca = 2;
    	
    	$params = [$fonte, $identificador, $tipoIdentificador, $json, $nullValido, $deleteValido, $erroLog, $idCarga, $tipoBusca];
    	
    	$query = 'SELECT * FROM portal.atualizar_certificado_osc(?::TEXT, ?::NUMERIC, ?::TEXT, now()::TIMESTAMP, ?::JSONB, ?::BOOLEAN, ?::BOOLEAN, ?::BOOLEAN, ?::INTEGER, ?::INTEGER)';
    	$result = $this->executarQuery($query, true, $params);
    	
    	return $result;
    }
}