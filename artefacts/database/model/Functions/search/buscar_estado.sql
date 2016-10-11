CREATE OR REPLACE FUNCTION portal.buscar_estado(param TEXT) RETURNS TABLE(
	eduf_cd_uf NUMERIC(2),
	eduf_nm_uf CHARACTER VARYING(20)
) AS $$
BEGIN
	RETURN QUERY
		SELECT
			vw_spat_estado.eduf_cd_uf,
			vw_spat_estado.eduf_nm_uf
		FROM portal.vw_spat_estado
		WHERE document @@ to_tsquery('portuguese_unaccent', param::TEXT)
		AND (
		   similarity(vw_spat_estado.eduf_nm_uf::TEXT, param::TEXT) > 0.2
		   OR similarity(vw_spat_estado.eduf_sg_uf::TEXT, param::TEXT) > 0.2
		)
		ORDER BY GREATEST(
			similarity(vw_spat_estado.eduf_nm_uf::TEXT, param::TEXT),
			similarity(vw_spat_estado.eduf_sg_uf::TEXT, param::TEXT)
		) DESC;
END;
$$ LANGUAGE 'plpgsql'