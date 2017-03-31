DROP FUNCTION IF EXISTS portal.buscar_osc_cnpj(text, integer, integer);

CREATE OR REPLACE FUNCTION portal.buscar_osc_cnpj(param text, limit_result integer, offset_result integer) RETURNS TABLE(
	id_osc INTEGER, 
	tx_nome_osc TEXT
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
			'SELECT vw_busca_osc.id_osc, vw_busca_osc.tx_razao_social_osc as tx_nome_osc
			FROM portal.vw_busca_osc
			WHERE 
			(
				similarity(vw_busca_osc.cd_identificador_osc::TEXT, LTRIM(''' || param::TEXT || ''', ''0'')) >= 0.25 
				AND vw_busca_osc.cd_identificador_osc::TEXT ILIKE LTRIM(''' || param::TEXT || ''', ''0'') || ''%''
			) 
			OR 
			(
				document @@ to_tsquery(''portuguese_unaccent'', ''' || param::TEXT || ''')
				AND (
					similarity(vw_busca_osc.tx_razao_social_osc::TEXT, ''' || param::TEXT || ''') > 0.05 OR
					similarity(vw_busca_osc.tx_nome_fantasia_osc::TEXT, ''' || param::TEXT || ''') > 0.05
				)
			)
			ORDER BY GREATEST(
				similarity(vw_busca_osc.cd_identificador_osc::TEXT, LTRIM(''' || param::TEXT || ''', ''0'')),
				similarity(vw_busca_osc.tx_razao_social_osc::TEXT, ''' || param::TEXT || '''),
				similarity(vw_busca_osc.tx_nome_fantasia_osc::TEXT, ''' || param::TEXT || ''')
			) DESC ' || query_limit; 
END;
$$ LANGUAGE 'plpgsql';