DROP FUNCTION IF EXISTS portal.obter_osc_utilidade_publica_municipal(param TEXT);

CREATE OR REPLACE FUNCTION portal.obter_osc_utilidade_publica_municipal(param TEXT) RETURNS TABLE (
	dt_data_validade DATE, 
	ft_utilidade_publica_municipal TEXT
) AS $$ 
BEGIN 
	RETURN QUERY 
		SELECT 
			vw_osc_utilidade_publica_municipal.dt_data_validade, 
			vw_osc_utilidade_publica_municipal.ft_utilidade_publica_municipal 
		FROM 
			portal.vw_osc_utilidade_publica_municipal 
		WHERE 
			vw_osc_utilidade_publica_municipal.id_osc::TEXT = param OR 
			vw_osc_utilidade_publica_municipal.tx_apelido_osc = param;
	RETURN;
END;
$$ LANGUAGE 'plpgsql';
