DROP FUNCTION IF EXISTS portal.obter_osc_area_atuacao(param TEXT);

CREATE OR REPLACE FUNCTION portal.obter_osc_area_atuacao(param TEXT) RETURNS TABLE (
	id_area_atuacao INTEGER, 
	tx_nome_area_atuacao TEXT, 
	tx_nome_subarea_atuacao TEXT, 
	ft_area_atuacao TEXT, 
	tx_nome_atividade_economica TEXT, 
	ft_atividade_economica TEXT
) AS $$ 
BEGIN 
	RETURN QUERY 
		SELECT 
			vw_osc_area_atuacao.id_area_atuacao, 
			vw_osc_area_atuacao.tx_nome_area_atuacao, 
			vw_osc_area_atuacao.tx_nome_subarea_atuacao, 
			vw_osc_area_atuacao.ft_area_atuacao, 
			vw_osc_area_atuacao.tx_nome_atividade_economica, 
			vw_osc_area_atuacao.ft_atividade_economica 
		FROM 
			portal.vw_osc_area_atuacao 
		WHERE 
			vw_osc_area_atuacao.id_osc::TEXT = param OR 
			vw_osc_area_atuacao.tx_apelido_osc = param;
	RETURN;
END;
$$ LANGUAGE 'plpgsql';
