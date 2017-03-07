DROP FUNCTION IF EXISTS portal.obter_menu_estado(param TEXT);

CREATE OR REPLACE FUNCTION portal.obter_menu_estado(param TEXT, limit_result INTEGER, offset_result INTEGER) RETURNS TABLE(
	eduf_cd_uf NUMERIC(2),
	eduf_nm_uf CHARACTER VARYING(20)
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
				vw_spat_estado.eduf_cd_uf,
				vw_spat_estado.eduf_nm_uf
			FROM portal.vw_spat_estado
			WHERE vw_spat_estado.eduf_nm_uf_adjusted ILIKE UNACCENT(''' || param::TEXT || '%''::TEXT)
			OR vw_spat_estado.eduf_sg_uf = ''' || param::TEXT || '''
			ORDER BY vw_spat_estado.eduf_sg_uf DESC ' || query_limit;
END;
$$ LANGUAGE 'plpgsql';
