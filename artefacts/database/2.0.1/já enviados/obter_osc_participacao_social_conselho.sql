DROP FUNCTION IF EXISTS portal.obter_osc_participacao_social_conselho(param TEXT);

CREATE OR REPLACE FUNCTION portal.obter_osc_participacao_social_conselho(param TEXT) RETURNS TABLE (
	id_conselho INTEGER, 
	cd_conselho INTEGER, 
	tx_nome_conselho text, 
	ft_conselho TEXT, 
	cd_tipo_participacao INTEGER, 
	tx_nome_tipo_participacao CHARACTER VARYING(30), 
	ft_tipo_participacao TEXT, 
	tx_periodicidade_reuniao TEXT, 
	ft_periodicidade_reuniao TEXT, 
	dt_data_inicio_conselho TEXT, 
	ft_data_inicio_conselho TEXT, 
	dt_data_fim_conselho TEXT, 
	ft_data_fim_conselho TEXT
) AS $$ 
BEGIN 
	RETURN QUERY 
		SELECT 
			vw_osc_participacao_social_conselho.id_conselho, 
			vw_osc_participacao_social_conselho.cd_conselho, 
			vw_osc_participacao_social_conselho.tx_nome_conselho, 
			vw_osc_participacao_social_conselho.ft_conselho, 
			vw_osc_participacao_social_conselho.cd_tipo_participacao, 
			vw_osc_participacao_social_conselho.tx_nome_tipo_participacao, 
			vw_osc_participacao_social_conselho.ft_tipo_participacao, 
			vw_osc_participacao_social_conselho.tx_periodicidade_reuniao, 
			vw_osc_participacao_social_conselho.ft_periodicidade_reuniao, 
			vw_osc_participacao_social_conselho.dt_data_inicio_conselho,
			vw_osc_participacao_social_conselho.ft_data_inicio_conselho,
			vw_osc_participacao_social_conselho.dt_data_fim_conselho,
			vw_osc_participacao_social_conselho.ft_data_fim_conselho
		FROM 
			portal.vw_osc_participacao_social_conselho 
		WHERE 
			vw_osc_participacao_social_conselho.id_osc::TEXT = param OR 
			vw_osc_participacao_social_conselho.tx_apelido_osc = param;
	RETURN;
END;
$$ LANGUAGE 'plpgsql';
