DROP FUNCTION IF EXISTS portal.obter_osc_participacao_social_outra(param TEXT);

CREATE OR REPLACE FUNCTION portal.obter_osc_participacao_social_outra(param TEXT) RETURNS TABLE (
	id_participacao_social_outra INTEGER, 
	tx_nome_participacao_social_outra TEXT, 
	ft_participacao_social_outra TEXT
) AS $$ 
BEGIN 
	RETURN QUERY 
		SELECT 
			vw_osc_participacao_social_outra.id_participacao_social_outra, 
			vw_osc_participacao_social_outra.tx_nome_participacao_social_outra, 
			vw_osc_participacao_social_outra.ft_participacao_social_outra 
		FROM
			portal.vw_osc_participacao_social_outra 
		WHERE 
			vw_osc_participacao_social_outra.id_osc::TEXT = param OR 
			vw_osc_participacao_social_outra.tx_apelido_osc = param;
	RETURN;
END;
$$ LANGUAGE 'plpgsql';
