DROP FUNCTION IF EXISTS portal.obter_osc_participacao_social_conferencia_outra(param TEXT);

CREATE OR REPLACE FUNCTION portal.obter_osc_participacao_social_conferencia_outra(param TEXT) RETURNS TABLE (
	id_conferencia_outra INTEGER, 
	tx_nome_conferencia TEXT, 
	ft_nome_conferencia TEXT, 
	dt_data_inicio_conferencia DATE, 
	ft_data_inicio_conferencia TEXT, 
	dt_data_fim_conferencia DATE, 
	ft_data_fim_conferencia TEXT, 
	tx_nome_forma_participacao_conferencia TEXT, 
	ft_forma_participacao_conferencia TEXT
) AS $$ 
BEGIN 
	RETURN QUERY 
		SELECT 
			vw_osc_participacao_social_conferencia_outra.id_conferencia_outra, 
			vw_osc_participacao_social_conferencia_outra.tx_nome_conferencia, 
			vw_osc_participacao_social_conferencia_outra.ft_nome_conferencia, 
			vw_osc_participacao_social_conferencia_outra.dt_data_inicio_conferencia, 
			vw_osc_participacao_social_conferencia_outra.ft_data_inicio_conferencia, 
			vw_osc_participacao_social_conferencia_outra.dt_data_fim_conferencia, 
			vw_osc_participacao_social_conferencia_outra.ft_data_fim_conferencia, 
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
