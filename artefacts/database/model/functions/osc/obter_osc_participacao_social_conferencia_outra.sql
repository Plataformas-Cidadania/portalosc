DROP FUNCTION IF EXISTS portal.obter_osc_participacao_social_conferencia_outra(param TEXT);

CREATE OR REPLACE FUNCTION portal.obter_osc_participacao_social_conferencia_outra(param TEXT) RETURNS TABLE (
	id_conferencia_outra INTEGER, 
	id_conferencia_declarada INTEGER, 
	tx_nome_conferencia_declarada TEXT, 
	ft_conferencia_declarada TEXT, 
	dt_ano_realizacao TEXT, 
	ft_ano_realizacao TEXT, 
	cd_forma_participacao_conferencia INTEGER, 
	tx_nome_forma_participacao_conferencia TEXT, 
	ft_forma_participacao_conferencia TEXT
) AS $$ 
BEGIN 
	RETURN QUERY 
		SELECT 
			vw_osc_participacao_social_conferencia_outra.id_conferencia_outra, 
			vw_osc_participacao_social_conferencia_outra.id_conferencia_declarada, 
			vw_osc_participacao_social_conferencia_outra.tx_nome_conferencia_declarada, 
			vw_osc_participacao_social_conferencia_outra.ft_conferencia_declarada, 
			vw_osc_participacao_social_conferencia_outra.dt_ano_realizacao, 
			vw_osc_participacao_social_conferencia_outra.ft_ano_realizacao, 
			vw_osc_participacao_social_conferencia_outra.cd_forma_participacao_conferencia, 
			vw_osc_participacao_social_conferencia_outra.tx_nome_forma_participacao_conferencia, 
			vw_osc_participacao_social_conferencia_outra.ft_forma_participacao_conferencia 
		FROM 
			portal.vw_osc_participacao_social_conferencia_outra 
		WHERE 
			vw_osc_participacao_social_conferencia_outra.id_osc::TEXT = param OR 
			vw_osc_participacao_social_conferencia_outra.tx_apelido_osc = param;
	RETURN;
END;
$$ LANGUAGE 'plpgsql';
