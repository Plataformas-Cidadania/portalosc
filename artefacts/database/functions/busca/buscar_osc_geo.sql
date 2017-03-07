DROP FUNCTION IF EXISTS portal.buscar_osc_geo(TEXT, INTEGER, INTEGER);

CREATE OR REPLACE FUNCTION portal.buscar_osc_geo(param TEXT, limit_result INTEGER, offset_result INTEGER) RETURNS TABLE(
	id_osc INTEGER,
	geo_lat DOUBLE PRECISION,
	geo_lng DOUBLE PRECISION
) AS $$

BEGIN
	RETURN QUERY
		SELECT
			vw_busca_resultado.id_osc,
			vw_busca_resultado.geo_lat,
			vw_busca_resultado.geo_lng
		FROM
			portal.vw_busca_resultado
		WHERE
			vw_busca_resultado.id_osc IN (
				SELECT a.id_osc FROM portal.buscar_osc(param, limit_result, offset_result) a
			);
END;
$$ LANGUAGE 'plpgsql';
