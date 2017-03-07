DROP FUNCTION IF EXISTS portal.buscar_osc_estado(param NUMERIC, limit_result INTEGER, offset_result INTEGER);

CREATE OR REPLACE FUNCTION portal.buscar_osc_estado(param NUMERIC, limit_result INTEGER, offset_result INTEGER) RETURNS TABLE(
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
				portal.vw_busca_osc_geo 
			WHERE 
				vw_busca_osc_geo.cd_estado = ' || param || '::NUMERIC(7, 0) ' 
			|| query_limit; 
END; 
$$ LANGUAGE 'plpgsql';
