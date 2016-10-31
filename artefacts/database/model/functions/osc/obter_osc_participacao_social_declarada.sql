DROP FUNCTION IF EXISTS portal.obter_osc_participacao_social_declarada(param TEXT);

CREATE OR REPLACE FUNCTION portal.obter_osc_participacao_social_declarada(param TEXT) RETURNS TABLE (
	id_participacao_social_declarada INTEGER,
	tx_nome_participacao_social_declarada TEXT,
	ft_nome_participacao_social_declarada TEXT,
	tx_tipo_participacao_social_declarada TEXT,
	ft_tipo_participacao_social_declarada TEXT,
	dt_data_ingresso_participacao_social_declarada DATE,
	ft_data_ingresso_participacao_social_declarada TEXT
) AS $$ 
BEGIN 
	RETURN QUERY 
		SELECT 
			vw_osc_participacao_social_declarada.id_participacao_social_declarada, 
			vw_osc_participacao_social_declarada.tx_nome_participacao_social_declarada, 
			vw_osc_participacao_social_declarada.ft_nome_participacao_social_declarada, 
			vw_osc_participacao_social_declarada.tx_tipo_participacao_social_declarada, 
			vw_osc_participacao_social_declarada.ft_tipo_participacao_social_declarada, 
			vw_osc_participacao_social_declarada.dt_data_ingresso_participacao_social_declarada, 
			vw_osc_participacao_social_declarada.ft_data_ingresso_participacao_social_declarada 
		FROM
			portal.vw_osc_participacao_social_declarada 
		WHERE 
			vw_osc_participacao_social_declarada.id_osc::TEXT = param OR 
			vw_osc_participacao_social_declarada.tx_apelido_osc = param;
	RETURN;
END;
$$ LANGUAGE 'plpgsql';
