CREATE OR REPLACE FUNCTION portal.buscar_osc(param TEXT) RETURNS TABLE(
	id_osc INTEGER,
	tx_nome_osc TEXT,
	cd_identificador_osc NUMERIC(14, 0),
	tx_natureza_juridica_osc TEXT,
	tx_endereco_osc TEXT
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
			vw_osc_dados_gerais.id_osc,
			coalesce(vw_osc_dados_gerais.tx_nome_fantasia_osc::TEXT, vw_osc_dados_gerais.tx_razao_social_osc) AS tx_nome_osc,
			vw_osc_dados_gerais.cd_identificador_osc,
			vw_osc_dados_gerais.tx_natureza_juridica_osc,
			(
				replace(
					rtrim(
						ltrim(
							', ' || COALESCE(vw_osc_dados_gerais.tx_endereco::TEXT, '')
							|| ', ' || COALESCE(vw_osc_dados_gerais.nr_localizacao::TEXT, '')
							|| ', ' || COALESCE(vw_osc_dados_gerais.tx_endereco_complemento::TEXT, '')
							|| ', ' || COALESCE(vw_osc_dados_gerais.tx_bairro::TEXT, '')
							|| ', ' || COALESCE(vw_osc_dados_gerais.tx_municipio::TEXT, '')
							|| ', ' || COALESCE(vw_osc_dados_gerais.tx_uf::TEXT, '')
							|| ', ' || COALESCE(vw_osc_dados_gerais.nr_cep::TEXT, ''), ', '
						), ', '
					), ', , ', ''
				)
			) AS tx_endereco_osc
		FROM portal.vw_osc_dados_gerais
		WHERE vw_osc_dados_gerais.id_osc = id_osc_search;
	END LOOP;
END;
$$ LANGUAGE 'plpgsql'
