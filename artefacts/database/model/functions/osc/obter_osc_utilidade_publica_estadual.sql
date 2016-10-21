DROP FUNCTION IF EXISTS portal.obter_osc_utilidade_publica_estadual(param TEXT);

CREATE OR REPLACE FUNCTION portal.obter_osc_utilidade_publica_estadual(param TEXT) RETURNS TABLE (
	dt_data_validade DATE, 
	ft_utilidade_publica_estadual TEXT
) AS $$ 
BEGIN 
	RETURN QUERY 
		SELECT 
			vw_osc_utilidade_publica_estadual.dt_data_validade, 
			vw_osc_utilidade_publica_estadual.ft_utilidade_publica_estadual 
		FROM 
			portal.vw_osc_utilidade_publica_estadual 
		WHERE 
			vw_osc_utilidade_publica_estadual.id_osc::TEXT = param OR 
			vw_osc_utilidade_publica_estadual.tx_apelido_osc = param;
	RETURN;
END;
$$ LANGUAGE 'plpgsql';
