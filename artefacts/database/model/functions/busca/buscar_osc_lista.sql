DROP FUNCTION IF EXISTS portal.buscar_osc_lista(param TEXT, limit_result INTEGER, offset_result INTEGER);

CREATE OR REPLACE FUNCTION portal.buscar_osc_lista(param TEXT, limit_result INTEGER, offset_result INTEGER) RETURNS TABLE(
	id_osc INTEGER, 
	tx_nome_osc TEXT, 
	cd_identificador_osc NUMERIC(14, 0), 
	tx_natureza_juridica_osc TEXT, 
	tx_endereco_osc TEXT, 
	geo_lat DOUBLE PRECISION, 
	geo_lng DOUBLE PRECISION
) AS $$ 

DECLARE 
	id_osc_search INTEGER;

BEGIN 
	FOR id_osc_search IN SELECT * FROM portal.buscar_osc(param, limit_result, offset_result) 
	LOOP 
		RETURN QUERY 
			SELECT 
				vw_resultado_busca.id_osc, 
				vw_resultado_busca.tx_nome_osc, 
				vw_resultado_busca.cd_identificador_osc, 
				vw_resultado_busca.tx_natureza_juridica_osc, 
				vw_resultado_busca.tx_endereco_osc, 
				vw_resultado_busca.geo_lat, 
				vw_resultado_busca.geo_lng 
			FROM 
				portal.vw_resultado_busca 
			WHERE 
				vw_resultado_busca.id_osc = id_osc_search; 
	END LOOP; 
END; 
$$ LANGUAGE 'plpgsql';
