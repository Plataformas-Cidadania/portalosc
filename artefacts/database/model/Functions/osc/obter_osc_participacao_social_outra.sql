DROP FUNCTION portal.obter_osc_participacao_social_outra(param TEXT);

CREATE OR REPLACE FUNCTION portal.obter_osc_participacao_social_outra(param TEXT) RETURNS TABLE (
	id_outra_participacao_social INTEGER, 
	tx_nome_outra_participacao_social TEXT, 
	ft_nome_outra_participacao_social TEXT, 
	tx_tipo_outra_participacao_social TEXT, 
	ft_tipo_outra_participacao_social TEXT, 
	dt_data_ingresso_outra_participacao_social DATE, 
	ft_data_ingresso_outra_participacao_social TEXT
) AS $$ 
BEGIN 
	RETURN QUERY 
		SELECT 
			vw_osc_participacao_social_outra.id_outra_participacao_social, 
			vw_osc_participacao_social_outra.tx_nome_outra_participacao_social, 
			vw_osc_participacao_social_outra.ft_nome_outra_participacao_social, 
			vw_osc_participacao_social_outra.tx_tipo_outra_participacao_social, 
			vw_osc_participacao_social_outra.ft_tipo_outra_participacao_social, 
			vw_osc_participacao_social_outra.dt_data_ingresso_outra_participacao_social, 
			vw_osc_participacao_social_outra.ft_data_ingresso_outra_participacao_social 
		FROM
			portal.vw_osc_participacao_social_outra 
		WHERE 
			vw_osc_participacao_social_outra.id_osc::TEXT = param OR 
			vw_osc_participacao_social_outra.tx_url_osc = param;
	RETURN;
END;
$$ LANGUAGE 'plpgsql';
