DROP FUNCTION IF EXISTS portal.obter_osc_area_atuacao_projeto(param INTEGER);

CREATE OR REPLACE FUNCTION portal.obter_osc_area_atuacao_projeto(param INTEGER) RETURNS TABLE (
	cd_area_atuacao_projeto INTEGER, 
	tx_nome_area_atuacao_projeto TEXT, 
	ft_area_atuacao_projeto TEXT
) AS $$ 
BEGIN 
	RETURN QUERY 
		SELECT 
			vw_osc_area_atuacao_projeto.cd_area_atuacao_projeto, 
			vw_osc_area_atuacao_projeto.tx_nome_area_atuacao_projeto, 
			vw_osc_area_atuacao_projeto.ft_area_atuacao_projeto 
		FROM 
			portal.vw_osc_area_atuacao_projeto
		WHERE 
			vw_osc_area_atuacao_projeto.id_projeto = param;
	RETURN;
END;
$$ LANGUAGE 'plpgsql';
