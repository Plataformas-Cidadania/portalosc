DROP FUNCTION IF EXISTS portal.obter_osc_fonte_recursos_projeto(param TEXT);

CREATE OR REPLACE FUNCTION portal.obter_osc_fonte_recursos_projeto(param TEXT) RETURNS TABLE (
	id_fonte_recursos_projeto INTEGER, 
	tx_nome_fonte_recursos_projeto TEXT, 
	ft_fonte_recursos_projeto TEXT
) AS $$
BEGIN 
	RETURN QUERY 
		SELECT 
			vw_osc_fonte_recursos_projeto.id_fonte_recursos_projeto, 
			vw_osc_fonte_recursos_projeto.tx_nome_fonte_recursos_projeto, 
			vw_osc_fonte_recursos_projeto.ft_fonte_recursos_projeto 
		FROM portal.vw_osc_fonte_recursos_projeto 
		WHERE 
			vw_osc_fonte_recursos_projeto.id_projeto::TEXT = param OR 
			vw_osc_fonte_recursos_projeto.tx_url_osc = param;
	RETURN;
END;
$$ LANGUAGE 'plpgsql';
