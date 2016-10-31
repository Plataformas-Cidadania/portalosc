DROP FUNCTION IF EXISTS portal.obter_osc_participacao_social_conferencia(param TEXT);

CREATE OR REPLACE FUNCTION portal.obter_osc_participacao_social_conferencia(param TEXT) RETURNS TABLE (
	id_conferencia INTEGER, 
	tx_nome_conferencia TEXT, 
	ft_nome_conferencia TEXT, 
	dt_ano_realizacao DATE, 
	ft_ano_realizacao TEXT, 
	tx_nome_forma_participacao_conferencia TEXT, 
	ft_forma_participacao_conferencia TEXT
) AS $$ 
BEGIN 
	RETURN QUERY 
		SELECT 
			vw_osc_participacao_social_conferencia.id_conferencia, 
			vw_osc_participacao_social_conferencia.tx_nome_conferencia, 
			vw_osc_participacao_social_conferencia.ft_nome_conferencia, 
			vw_osc_participacao_social_conferencia.dt_ano_realizacao, 
			vw_osc_participacao_social_conferencia.ft_ano_realizacao, 
			vw_osc_participacao_social_conferencia.tx_nome_forma_participacao_conferencia, 
			vw_osc_participacao_social_conferencia.ft_forma_participacao_conferencia 
		FROM 
			portal.vw_osc_participacao_social_conferencia 
		WHERE 
			vw_osc_participacao_social_conferencia.id_osc::TEXT = param OR 
			vw_osc_participacao_social_conferencia.tx_apelido_osc = param;
	RETURN;
END;
$$ LANGUAGE 'plpgsql';
