DROP FUNCTION IF EXISTS portal.obter_osc_area_atuacao_outra_projeto(param INTEGER);

CREATE OR REPLACE FUNCTION portal.obter_osc_area_atuacao_outra_projeto(param INTEGER) RETURNS TABLE (
	vw_osc_area_atuacao_outra INTEGER, 
	tx_nome_area_atuacao_outra TEXT, 
	ft_area_atuacao_outra TEXT
) AS $$ 
BEGIN 
	RETURN QUERY 
		SELECT 
			vw_osc_area_atuacao_outra_projeto.id_area_atuacao_outra_projeto, 
			vw_osc_area_atuacao_outra_projeto.tx_nome_area_atuacao_outra, 
			vw_osc_area_atuacao_outra_projeto.ft_area_atuacao_outra 
		FROM 
			portal.vw_osc_area_atuacao_outra_projeto
		WHERE 
			vw_osc_area_atuacao_outra_projeto.id_projeto = param;
	RETURN;
END;
$$ LANGUAGE 'plpgsql';
