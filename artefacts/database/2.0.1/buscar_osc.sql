DROP FUNCTION IF EXISTS portal.buscar_osc(param TEXT, limit_result INTEGER, similarity_result DOUBLE PRECISION);

CREATE OR REPLACE FUNCTION portal.buscar_osc(param TEXT, limit_result INTEGER, offset_result INTEGER, similarity_result DOUBLE PRECISION) RETURNS TABLE(
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
	
	param := LOWER(param); 
	
	RETURN QUERY 
		EXECUTE 
			'SELECT vw_busca_osc.id_osc 
			FROM osc.vw_busca_osc 
			WHERE 
			(
				similarity(vw_busca_osc.cd_identificador_osc::TEXT, LTRIM(''' || param::TEXT || ''', ''0'')) >= 0.25 
				AND vw_busca_osc.cd_identificador_osc::TEXT ILIKE LTRIM(''' || param::TEXT || ''', ''0'') || ''%''
			) 
			OR 
			(
				document @@ to_tsquery(''portuguese_unaccent'', ''' || param::TEXT || ''') 
				AND 
				(
					similarity(vw_busca_osc.tx_razao_social_osc::TEXT, ''' || param::TEXT || ''') > ' || similarity_result::DOUBLE PRECISION || ' OR 
					similarity(vw_busca_osc.tx_nome_fantasia_osc::TEXT, ''' || param::TEXT || ''') > ' || similarity_result::DOUBLE PRECISION || '
				) 
			) 
			OR 
			(
				CHAR_LENGTH(''' || param::TEXT || ''') > 4 AND 
				(
					vw_busca_osc.tx_razao_social_osc::TEXT ILIKE ''%' || TRANSLATE(param::TEXT, '+', ' ') || '%'' OR 
					vw_busca_osc.tx_nome_fantasia_osc::TEXT ILIKE ''%' || TRANSLATE(param::TEXT, '+', ' ') || '%''
				)
			)
			ORDER BY GREATEST(
				similarity(vw_busca_osc.cd_identificador_osc::TEXT, LTRIM(''' || param::TEXT || ''', ''0'')), 
				similarity(vw_busca_osc.tx_razao_social_osc::TEXT, ''' || param::TEXT || '''), 
				similarity(vw_busca_osc.tx_nome_fantasia_osc::TEXT, ''' || param::TEXT || ''')
			) DESC ' || query_limit; 
END; 
$$ LANGUAGE 'plpgsql';