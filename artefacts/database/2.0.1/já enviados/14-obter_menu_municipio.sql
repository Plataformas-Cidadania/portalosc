DROP FUNCTION IF EXISTS portal.obter_menu_municipio(param TEXT);

CREATE OR REPLACE FUNCTION portal.obter_menu_municipio(param TEXT, limit_result INTEGER, offset_result INTEGER) RETURNS TABLE(
	edmu_cd_municipio NUMERIC(7),
	edmu_nm_municipio CHARACTER VARYING(50),
	eduf_sg_uf CHARACTER VARYING(2)
) AS $$

DECLARE 
	query_limit TEXT; 

BEGIN	
	IF offset_result > 0 THEN 
		query_limit := 'LIMIT ' || limit_result || ' OFFSET ' || offset_result || ';'; 
	ELSIF limit_result > 0 THEN 
		query_limit := 'LIMIT ' || limit_result || ';'; 
	ELSE 
		query_limit := ';'; 
	END IF; 
	
	RETURN QUERY
		EXECUTE 
			'SELECT
				vw_spat_municipio.edmu_cd_municipio,
				vw_spat_municipio.edmu_nm_municipio,
				vw_spat_municipio.eduf_sg_uf
			FROM spat.vw_spat_municipio
			WHERE vw_spat_municipio.edmu_nm_municipio_adjusted ILIKE UNACCENT(''' || param::TEXT || '%''::TEXT)
			ORDER BY vw_spat_municipio.edmu_nm_municipio DESC ' || query_limit;
END;
$$ LANGUAGE 'plpgsql';
