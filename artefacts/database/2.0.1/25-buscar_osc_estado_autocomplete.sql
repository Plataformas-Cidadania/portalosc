DROP FUNCTION IF EXISTS portal.buscar_osc_estado_autocomplete(param NUMERIC, limit_result INTEGER, offset_result INTEGER);

CREATE OR REPLACE FUNCTION portal.buscar_osc_estado_autocomplete(param NUMERIC, limit_result INTEGER, offset_result INTEGER) RETURNS TABLE(
	id_osc INTEGER,
	tx_nome_osc TEXT
) AS $$
DECLARE
	id_osc_search INTEGER;
BEGIN
	RETURN QUERY
		SELECT
			vw_busca_resultado.id_osc,
			vw_busca_resultado.tx_nome_osc
		FROM
			osc.vw_busca_resultado
		WHERE vw_busca_resultado.id_osc IN (
			SELECT a.id_osc FROM portal.buscar_osc_estado(param, limit_result, offset_result) a
		);
END;
$$ LANGUAGE 'plpgsql';
