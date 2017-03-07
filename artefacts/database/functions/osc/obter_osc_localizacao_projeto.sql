DROP FUNCTION IF EXISTS portal.obter_osc_localizacao_projeto(param INTEGER);

CREATE OR REPLACE FUNCTION portal.obter_osc_localizacao_projeto(param INTEGER) RETURNS TABLE (
	id_regiao_localizacao_projeto INTEGER, 
	tx_nome_regiao_localizacao_projeto TEXT, 
	ft_nome_regiao_localizacao_projeto TEXT, 
	bo_localizacao_prioritaria BOOLEAN, 
	ft_localizacao_prioritaria TEXT
) AS $$ 
BEGIN 
	RETURN QUERY 
		SELECT 
			vw_osc_localizacao_projeto.id_regiao_localizacao_projeto, 
			vw_osc_localizacao_projeto.tx_nome_regiao_localizacao_projeto, 
			vw_osc_localizacao_projeto.ft_nome_regiao_localizacao_projeto, 
			vw_osc_localizacao_projeto.bo_localizacao_prioritaria, 
			vw_osc_localizacao_projeto.ft_localizacao_prioritaria 
		FROM 
			portal.vw_osc_localizacao_projeto 
		WHERE 
			vw_osc_localizacao_projeto.id_projeto = param;
	RETURN;
END;
$$ LANGUAGE 'plpgsql';
