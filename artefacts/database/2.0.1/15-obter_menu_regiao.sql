DROP FUNCTION IF EXISTS portal.obter_menu_regiao(param TEXT);

CREATE OR REPLACE FUNCTION portal.obter_menu_regiao(param TEXT, limit_result INTEGER, offset_result INTEGER) RETURNS TABLE(
	edre_cd_regiao NUMERIC(1),
	edre_nm_regiao CHARACTER VARYING(20)
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
				vw_spat_regiao.edre_cd_regiao,
				vw_spat_regiao.edre_nm_regiao
			FROM spat.vw_spat_regiao
			WHERE vw_spat_regiao.edre_nm_regiao_adjusted ILIKE UNACCENT(''' || param::TEXT || '%''::TEXT)
			ORDER BY vw_spat_regiao.edre_nm_regiao DESC ' || query_limit;
END;
$$ LANGUAGE 'plpgsql';
