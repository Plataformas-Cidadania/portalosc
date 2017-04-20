DROP FUNCTION IF EXISTS portal.buscar_osc_regiao(param NUMERIC, limit_result INTEGER, offset_result INTEGER);

CREATE OR REPLACE FUNCTION portal.buscar_osc_regiao(param NUMERIC, limit_result INTEGER, offset_result INTEGER) RETURNS TABLE(
	id_osc INTEGER
) AS $$ 

DECLARE 
	id_osc_search INTEGER; 
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
				vw_busca_osc_geo.id_osc 
			FROM 
				osc.vw_busca_osc_geo 
			WHERE 
				vw_busca_osc_geo.cd_regiao = ' || param || '::NUMERIC(1, 0) ' 
			|| query_limit; 
END; 
$$ LANGUAGE 'plpgsql';
