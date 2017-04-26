DROP FUNCTION IF EXISTS portal.buscar_osc_autocomplete(param TEXT, limit_result INTEGER, offset_result INTEGER, similarity_result DOUBLE PRECISION);

CREATE OR REPLACE FUNCTION portal.buscar_osc_autocomplete(param TEXT, limit_result INTEGER, offset_result INTEGER, similarity_result DOUBLE PRECISION) RETURNS TABLE(
	tx_nome_osc TEXT
) AS $$

BEGIN
	RETURN QUERY
		SELECT
			LOWER(vw_busca_resultado.tx_nome_osc)
		FROM
			osc.vw_busca_resultado
		WHERE
			vw_busca_resultado.id_osc IN (
				SELECT id_osc FROM portal.buscar_osc(param, limit_result, offset_result, similarity_result)
			)
		GROUP BY LOWER(vw_busca_resultado.tx_nome_osc);
END;
$$ LANGUAGE 'plpgsql';
