DROP FUNCTION IF EXISTS portal.obter_osc_area_atuacao(param TEXT);

CREATE OR REPLACE FUNCTION portal.obter_osc_area_atuacao(param TEXT) RETURNS TABLE (
	cd_area_atuacao INTEGER, 
	tx_nome_area_atuacao TEXT, 
	cd_subarea_atuacao INTEGER, 
	tx_nome_subarea_atuacao TEXT, 
	ft_area_atuacao TEXT
) AS $$ 
BEGIN 
	RETURN QUERY 
		SELECT 
			vw_osc_area_atuacao.cd_area_atuacao, 
			vw_osc_area_atuacao.tx_nome_area_atuacao, 
			vw_osc_area_atuacao.cd_subarea_atuacao, 
			vw_osc_area_atuacao.tx_nome_subarea_atuacao, 
			vw_osc_area_atuacao.ft_area_atuacao 
		FROM 
			portal.vw_osc_area_atuacao 
		WHERE 
			vw_osc_area_atuacao.id_osc::TEXT = param OR 
			vw_osc_area_atuacao.tx_apelido_osc = param;
	RETURN;
END;
$$ LANGUAGE 'plpgsql';
