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

BEGIN 
	RETURN QUERY 
		SELECT 
			vw_busca_resultado.id_osc, 
			vw_busca_resultado.tx_nome_osc, 
			vw_busca_resultado.cd_identificador_osc, 
			vw_busca_resultado.tx_natureza_juridica_osc, 
			vw_busca_resultado.tx_endereco_osc, 
			vw_busca_resultado.geo_lat, 
			vw_busca_resultado.geo_lng 
		FROM 
			portal.vw_busca_resultado 
		WHERE 
			vw_busca_resultado.id_osc IN (
				SELECT * FROM portal.buscar_osc(param, limit_result, offset_result)
			); 
END; 
$$ LANGUAGE 'plpgsql';
