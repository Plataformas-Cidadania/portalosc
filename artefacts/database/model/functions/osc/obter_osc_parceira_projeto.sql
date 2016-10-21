DROP FUNCTION IF EXISTS portal.obter_osc_parceira_projeto(param INTEGER);

CREATE OR REPLACE FUNCTION portal.obter_osc_parceira_projeto(param INTEGER) RETURNS TABLE (
	id_osc INTEGER, 
	tx_nome_osc_parceira_projeto TEXT, 
	id_projeto INTEGER, 
	ft_osc_parceira_projeto TEXT
) AS $$ 
BEGIN 
	RETURN QUERY 
		SELECT 
			vw_osc_parceira_projeto.id_osc, 
			vw_osc_parceira_projeto.tx_nome_osc_parceira_projeto, 
			vw_osc_parceira_projeto.id_projeto, 
			vw_osc_parceira_projeto.ft_osc_parceira_projeto 
		FROM portal.vw_osc_parceira_projeto 
		WHERE 
			vw_osc_parceira_projeto.id_projeto::TEXT = param;
	RETURN;
END;
$$ LANGUAGE 'plpgsql';
