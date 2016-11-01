-- Function: portal.buscar_osc_geo(text, integer, integer)

DROP FUNCTION portal.buscar_osc_geo(text, integer, integer);

CREATE OR REPLACE FUNCTION portal.buscar_osc_geo(
    IN param text,
    IN limit_result integer,
    IN offset_result integer)
  RETURNS TABLE(id_osc integer, geo_lat double precision, geo_lng double precision) AS
$BODY$

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
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION portal.buscar_osc_geo(text, integer, integer)
  OWNER TO i3geo;
