DROP FUNCTION IF EXISTS portal.buscar_osc_lista(TEXT, INTEGER, INTEGER);

CREATE OR REPLACE FUNCTION portal.buscar_osc_lista(param TEXT, limit_result INTEGER, offset_result INTEGER) RETURNS TABLE(
	id_osc INTEGER,
	tx_nome_osc TEXT,
	cd_identificador_osc NUMERIC,
	tx_natureza_juridica_osc TEXT,
	tx_endereco_osc TEXT,
	tx_nome_atividade_economica TEXT
) AS $$

BEGIN
	RETURN QUERY
		SELECT
			vw_busca_resultado.id_osc,
			vw_busca_resultado.tx_nome_osc,
			vw_busca_resultado.cd_identificador_osc,
			vw_busca_resultado.tx_natureza_juridica_osc,
			vw_busca_resultado.tx_endereco_osc,
			vw_busca_resultado.tx_nome_atividade_economica
		FROM
			portal.vw_busca_resultado
		WHERE
			vw_busca_resultado.id_osc IN (
				SELECT a.id_osc FROM portal.buscar_osc(param, limit_result, offset_result) a
			);
END;
$$ LANGUAGE 'plpgsql';
