DROP FUNCTION IF EXISTS portal.buscar_osc(param TEXT, limit_result INTEGER, offset_result INTEGER);

CREATE OR REPLACE FUNCTION portal.buscar_osc(param TEXT, limit_result INTEGER, offset_result INTEGER) RETURNS TABLE(
	id_osc INTEGER 
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
			'SELECT vw_busca_osc.id_osc
			FROM portal.vw_busca_osc
			WHERE document @@ to_tsquery(''portuguese_unaccent'', LTRIM(''' || param::TEXT || ''', ''0''))
			AND (
			   similarity(vw_busca_osc.cd_identificador_osc::TEXT, LTRIM(''' || param::TEXT || ''', ''0'')) > 0.8 OR
			   similarity(vw_busca_osc.tx_razao_social_osc::TEXT, ''' || param::TEXT || ''') > 0.2 OR
			   similarity(vw_busca_osc.tx_nome_fantasia_osc::TEXT, ''' || param::TEXT || ''') > 0.2
			)
			ORDER BY GREATEST(
				similarity(vw_busca_osc.cd_identificador_osc::TEXT, LTRIM(''' || param::TEXT || ''', ''0'')),
				similarity(vw_busca_osc.tx_razao_social_osc::TEXT, ''' || param::TEXT || '''),
				similarity(vw_busca_osc.tx_nome_fantasia_osc::TEXT, ''' || param::TEXT || ''')
			) DESC ' || query_limit; 
END; 
$$ LANGUAGE 'plpgsql';