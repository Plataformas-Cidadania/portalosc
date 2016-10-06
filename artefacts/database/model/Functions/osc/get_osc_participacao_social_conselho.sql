CREATE OR REPLACE FUNCTION portal.get_osc_participacao_social_conselho(id_request INTEGER) RETURNS TABLE (
	id_conselho INTEGER,
	tx_nome_conselho CHARACTER VARYING(100),
	ft_conselho TEXT,
	nr_numero_assentos INTEGER,
	ft_numero_assentos TEXT,
	tx_periodicidade_reuniao TEXT,
	ft_periodicidade_reuniao TEXT,
	cd_tipo_participacao INTEGER,
	nm_tipo_participacao CHARACTER VARYING(100),
	ft_tipo_participacao TEXT
) AS $$
BEGIN
	RETURN QUERY
		SELECT
			vw_osc_participacao_social_conselho.id_conselho,
			vw_osc_participacao_social_conselho.tx_nome_conselho,
			vw_osc_participacao_social_conselho.ft_conselho,
			vw_osc_participacao_social_conselho.nr_numero_assentos,
			vw_osc_participacao_social_conselho.ft_numero_assentos,
			vw_osc_participacao_social_conselho.tx_periodicidade_reuniao,
			vw_osc_participacao_social_conselho.ft_periodicidade_reuniao,
			vw_osc_participacao_social_conselho.cd_tipo_participacao,
			vw_osc_participacao_social_conselho.nm_tipo_participacao,
			vw_osc_participacao_social_conselho.ft_tipo_participacao
		FROM portal.vw_osc_participacao_social_conselho
		WHERE vw_osc_participacao_social_conselho.id_osc = id_request;
	RETURN;
END;
$$ LANGUAGE 'plpgsql'