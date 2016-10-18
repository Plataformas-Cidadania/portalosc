DROP FUNCTION IF EXISTS portal.obter_osc_localizacao_projeto(param TEXT);

CREATE OR REPLACE FUNCTION portal.obter_osc_localizacao_projeto(param TEXT) RETURNS TABLE (
	id_regiao_localizacao_projeto INTEGER, 
	tx_nome_regiao_localizacao_projeto TEXT, 
	ft_nome_regiao_localizacao_projeto TEXT
) AS $$ 
BEGIN 
	RETURN QUERY 
		SELECT 
			vw_osc_localizacao_projeto.id_regiao_localizacao_projeto, 
			vw_osc_localizacao_projeto.tx_nome_regiao_localizacao_projeto, 
			vw_osc_localizacao_projeto.ft_nome_regiao_localizacao_projeto 
		FROM portal.vw_osc_localizacao_projeto 
		WHERE 
			vw_osc_localizacao_projeto.id_projeto::TEXT = param OR 
			vw_osc_localizacao_projeto.tx_url_osc = param;
	RETURN;
END;
$$ LANGUAGE 'plpgsql';
