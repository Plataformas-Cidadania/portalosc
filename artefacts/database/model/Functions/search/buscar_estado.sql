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
		WHERE vw_spat_estado.eduf_nm_uf ILIKE param::TEXT||'%'
		OR vw_spat_estado.eduf_sg_uf = param::TEXT
		ORDER BY vw_spat_estado.eduf_sg_uf DESC
		LIMIT 5;
END;
$$ LANGUAGE 'plpgsql'