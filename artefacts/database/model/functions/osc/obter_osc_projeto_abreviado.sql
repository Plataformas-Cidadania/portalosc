DROP FUNCTION IF EXISTS portal.obter_osc_projeto_abreviado(param TEXT);

CREATE OR REPLACE FUNCTION portal.obter_osc_projeto_abreviado(param TEXT) RETURNS TABLE (
    id_projeto INTEGER, 
    tx_nome_projeto TEXT
) AS $$ 
BEGIN 
	RETURN QUERY 
		SELECT 
			vw_osc_projeto.id_projeto, 
			vw_osc_projeto.tx_nome_projeto 
		FROM 
			portal.vw_osc_projeto 
		WHERE 
			vw_osc_projeto.id_osc::TEXT = param OR 
			vw_osc_projeto.tx_apelido_osc = param;
	RETURN;
END;
$$ LANGUAGE 'plpgsql';
