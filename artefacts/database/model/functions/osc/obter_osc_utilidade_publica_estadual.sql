DROP FUNCTION IF EXISTS portal.obter_osc_utilidade_publica_estadual(param TEXT);

CREATE OR REPLACE FUNCTION portal.obter_osc_utilidade_publica_estadual(param TEXT) RETURNS TABLE (
	id_utilidade_publica_estadual INTEGER, 
	dt_data_validade DATE, 
	ft_utilidade_publica_estadual TEXT
) AS $$ 
BEGIN 
	RETURN QUERY 
		SELECT 
			tb_utilidade_publica_estadual.id_utilidade_publica_estadual, 
			tb_utilidade_publica_estadual.dt_data_validade, 
			tb_utilidade_publica_estadual.ft_utilidade_publica_estadual 
		FROM portal.tb_utilidade_publica_estadual 
		WHERE 
			tb_utilidade_publica_estadual.id_osc::TEXT = param OR 
			tb_utilidade_publica_estadual.tx_apelido_osc = param;
	RETURN;
END;
$$ LANGUAGE 'plpgsql';
