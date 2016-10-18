DROP FUNCTION IF EXISTS portal.buscar_osc_municipio(param NUMERIC);

CREATE OR REPLACE FUNCTION portal.buscar_osc_municipio(param NUMERIC) RETURNS TABLE(
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
	RETURN QUERY 
	SELECT 
		vw_resultado_busca.id_osc, 
		vw_resultado_busca.tx_nome_osc, 
		vw_resultado_busca.cd_identificador_osc, 
		vw_resultado_busca.tx_natureza_juridica_osc, 
		vw_resultado_busca.tx_endereco_osc, 
		vw_resultado_busca.geo_lat, 
		vw_resultado_busca.geo_lng 
	FROM portal.vw_resultado_busca 
	WHERE vw_resultado_busca.id_osc IN ( 
		SELECT 
			vw_busca_osc_geo.id_osc 
		FROM 
			portal.vw_busca_osc_geo 
		WHERE 
			vw_busca_osc_geo.cd_municipio = param::NUMERIC(7, 0)
	);
END;
$$ LANGUAGE 'plpgsql';
