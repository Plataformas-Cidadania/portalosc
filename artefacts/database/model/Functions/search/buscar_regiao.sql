CREATE OR REPLACE FUNCTION portal.buscar_regiao(param TEXT) RETURNS TABLE(
	edre_cd_regiao NUMERIC(1),
	edre_nm_regiao CHARACTER VARYING(20)
) AS $$
BEGIN
	RETURN QUERY
		SELECT
			vw_spat_regiao.edre_cd_regiao,
			vw_spat_regiao.edre_nm_regiao
		FROM portal.vw_spat_regiao
		WHERE document @@ to_tsquery('portuguese_unaccent', param::TEXT)
		AND (
		   similarity(vw_spat_regiao.edre_nm_regiao::TEXT, param::TEXT) > 0.2
		)
		ORDER BY GREATEST(
			similarity(vw_spat_regiao.edre_nm_regiao::TEXT, param::TEXT)
		) DESC;
END;
$$ LANGUAGE 'plpgsql'