DROP FUNCTION IF EXISTS portal.obter_osc_utilidade_publica_municipal(param TEXT);

CREATE OR REPLACE FUNCTION portal.obter_osc_utilidade_publica_municipal(param TEXT) RETURNS TABLE (
	id_utilidade_publica_municipal INTEGER, 
	dt_data_validade DATE, 
	ft_utilidade_publica_municipal TEXT
) AS $$ 
BEGIN 
	RETURN QUERY 
		SELECT 
			tb_utilidade_publica_municipal.id_utilidade_publica_municipal, 
			tb_utilidade_publica_municipal.dt_data_validade, 
			tb_utilidade_publica_municipal.ft_utilidade_publica_municipal 
		FROM portal.tb_utilidade_publica_municipal 
		WHERE 
			tb_utilidade_publica_municipal.id_osc::TEXT = param OR 
			tb_utilidade_publica_municipal.tx_apelido_osc = param;
	RETURN;
END;
$$ LANGUAGE 'plpgsql';
