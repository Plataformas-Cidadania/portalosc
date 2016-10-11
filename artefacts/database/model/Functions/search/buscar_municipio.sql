CREATE OR REPLACE FUNCTION portal.buscar_municipio(param TEXT) RETURNS TABLE(
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
		WHERE document @@ to_tsquery('portuguese_unaccent', param::TEXT)
		AND (
		   similarity(vw_spat_municipio.edmu_nm_municipio::TEXT, param::TEXT) > 0.2
		)
		ORDER BY GREATEST(
			similarity(vw_spat_municipio.edmu_nm_municipio::TEXT, param::TEXT)
		) DESC;
END;
$$ LANGUAGE 'plpgsql'