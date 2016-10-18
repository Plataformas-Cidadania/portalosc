DROP FUNCTION IF EXISTS portal.buscar_osc(param TEXT);

CREATE OR REPLACE FUNCTION portal.buscar_osc(param TEXT) RETURNS TABLE(
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
	FOR id_osc_search IN
		SELECT vw_busca_osc.id_osc
		FROM portal.vw_busca_osc
		WHERE document @@ to_tsquery('portuguese_unaccent', param::TEXT)
		AND (
		   similarity(vw_busca_osc.cd_identificador_osc::TEXT, param::TEXT) > 0.8
		   or similarity(vw_busca_osc.tx_razao_social_osc::TEXT, param::TEXT) > 0.2
		   OR similarity(vw_busca_osc.tx_nome_fantasia_osc::TEXT, param::TEXT) > 0.2
		)
		ORDER BY GREATEST(
			similarity(vw_busca_osc.cd_identificador_osc::TEXT, param::TEXT),
			similarity(vw_busca_osc.tx_razao_social_osc::TEXT, param::TEXT),
			similarity(vw_busca_osc.tx_nome_fantasia_osc::TEXT, param::TEXT)
		) DESC
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
		FROM portal.vw_resultado_busca
		WHERE vw_resultado_busca.id_osc = id_osc_search;
	END LOOP;
END;
$$ LANGUAGE 'plpgsql';
