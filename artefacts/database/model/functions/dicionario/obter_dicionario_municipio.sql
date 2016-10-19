DROP FUNCTION IF EXISTS portal.obter_dicionario_municipio(param TEXT);

CREATE OR REPLACE FUNCTION portal.obter_dicionario_municipio(param TEXT) RETURNS TABLE(
	edmu_cd_municipio NUMERIC(7),
	edmu_nm_municipio CHARACTER VARYING(50),
	eduf_sg_uf CHARACTER VARYING(2)
) AS $$
BEGIN
	RETURN QUERY
		SELECT
			vw_spat_municipio.edmu_cd_municipio,
			vw_spat_municipio.edmu_nm_municipio,
			vw_spat_municipio.eduf_sg_uf
		FROM portal.vw_spat_municipio
		WHERE vw_spat_municipio.edmu_nm_municipio_adjusted ILIKE UNACCENT(param::TEXT)||'%'
		ORDER BY vw_spat_municipio.edmu_nm_municipio DESC
		LIMIT 5;
END;
$$ LANGUAGE 'plpgsql';
