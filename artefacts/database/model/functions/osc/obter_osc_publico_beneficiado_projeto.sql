DROP FUNCTION IF EXISTS portal.obter_osc_publico_beneficiado_projeto(param TEXT);

CREATE OR REPLACE FUNCTION portal.obter_osc_publico_beneficiado_projeto(param TEXT) RETURNS TABLE (
	id_publico_beneficiado INTEGER, 
	tx_nome_publico_beneficiado TEXT, 
	ft_area_atuacao_outra TEXT
) AS $$ 
BEGIN 
	RETURN QUERY 
		SELECT 
			vw_osc_publico_beneficiado_projeto.id_publico_beneficiado, 
			vw_osc_publico_beneficiado_projeto.tx_nome_publico_beneficiado, 
			vw_osc_publico_beneficiado_projeto.ft_area_atuacao_outra 
		FROM 
			portal.vw_osc_publico_beneficiado_projeto 
		WHERE 
			vw_osc_publico_beneficiado_projeto.id_projeto::TEXT = param OR 
			vw_osc_publico_beneficiado_projeto.tx_url_osc = param;
	RETURN;
END;
$$ LANGUAGE 'plpgsql';
