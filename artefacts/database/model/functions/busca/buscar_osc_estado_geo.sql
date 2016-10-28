DROP FUNCTION IF EXISTS portal.buscar_osc_estado_geo(param NUMERIC);

CREATE OR REPLACE FUNCTION portal.buscar_osc_estado_geo(param NUMERIC) RETURNS TEXT AS $$

DECLARE
	result_query TEXT;
	geo_posicao TEXT;
	
BEGIN
	FOR result_query IN 
		SELECT
			'"' || vw_busca_resultado.id_osc::TEXT || '": [' || vw_busca_resultado.geo_lat::TEXT || ', ' || vw_busca_resultado.geo_lng::TEXT || ']' AS geo_posiciao_osc
		FROM
			portal.vw_busca_resultado
		WHERE
			vw_busca_resultado.id_osc IN (
				SELECT a.id_osc FROM portal.buscar_osc_estado(param) a
			)
	LOOP
		geo_posicao := concat(geo_posicao, result_query, ', ');
	END LOOP;
	
	RETURN concat('{', rtrim(geo_posicao, ', '), '}');
END;
$$ LANGUAGE 'plpgsql';
