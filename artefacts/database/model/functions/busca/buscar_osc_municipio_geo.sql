DROP FUNCTION IF EXISTS portal.buscar_osc_municipio_geo(param NUMERIC);

CREATE OR REPLACE FUNCTION portal.buscar_osc_municipio_geo(param NUMERIC) RETURNS TABLE(
	geo_posiciao_osc TEXT
) AS $$

DECLARE
	result_query TEXT;
	geo_posicao TEXT;
	
BEGIN
	RETURN QUERY
		SELECT
			'"' || vw_busca_resultado.id_osc::TEXT || '": [' || vw_busca_resultado.geo_lat::TEXT || ', ' || vw_busca_resultado.geo_lng::TEXT || ']' AS geo_posiciao_osc
		FROM
			portal.vw_busca_resultado
		WHERE
			vw_busca_resultado.id_osc IN (
				SELECT osc.id_osc FROM portal.buscar_osc_municipio(param) AS osc
			);
END;
$$ LANGUAGE 'plpgsql';