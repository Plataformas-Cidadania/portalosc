CREATE OR REPLACE FUNCTION portal.get_dictionary_regiao(param TEXT) RETURNS TABLE(
	edre_cd_regiao NUMERIC(1),
	edre_nm_regiao CHARACTER VARYING(20)
) AS $$
BEGIN
	RETURN QUERY
		SELECT
			vw_spat_regiao.edre_cd_regiao,
			vw_spat_regiao.edre_nm_regiao
		FROM portal.vw_spat_regiao
		WHERE vw_spat_regiao.edre_nm_regiao ILIKE param::TEXT||'%'
		ORDER BY vw_spat_regiao.edre_nm_regiao DESC
		LIMIT 5;
END;
$$ LANGUAGE 'plpgsql'