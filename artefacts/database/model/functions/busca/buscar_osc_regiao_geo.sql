DROP FUNCTION IF EXISTS portal.buscar_osc_regiao_geo(param NUMERIC, limit_result INTEGER, offset_result INTEGER);

CREATE OR REPLACE FUNCTION portal.buscar_osc_regiao_geo(param NUMERIC, limit_result INTEGER, offset_result INTEGER) RETURNS TABLE(
	id_osc INTEGER,
	geo_lat DOUBLE PRECISION,
	geo_lng DOUBLE PRECISION
) AS $$

BEGIN
	RETURN QUERY
		SELECT
			vw_busca_resultado.id_osc,
			round(vw_busca_resultado.geo_lat::decimal, 6)::double precision,
			round(vw_busca_resultado.geo_lng::decimal, 6)::double precision
		FROM
			portal.vw_busca_resultado
		WHERE vw_busca_resultado.id_osc IN (
			SELECT a.id_osc FROM portal.buscar_osc_regiao(param, limit_result, offset_result) a
		);
END;
$$ LANGUAGE 'plpgsql';
