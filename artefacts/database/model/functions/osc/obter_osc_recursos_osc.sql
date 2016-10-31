DROP FUNCTION IF EXISTS portal.obter_osc_recursos_osc(param TEXT);

CREATE OR REPLACE FUNCTION portal.obter_osc_recursos_osc(param TEXT) RETURNS TABLE (
	tx_nome_origem_fonte_recursos_osc TEXT, 
	tx_nome_fonte_recursos_osc TEXT, 
	ft_fonte_recursos TEXT, 
	dt_ano DATE, 
	ft_ano TEXT, 
	nr_valor_recursos_osc DOUBLE PRECISION, 
	ft_valor_recursos_osc TEXT
) AS $$ 
BEGIN 
	RETURN QUERY 
		SELECT 
			vw_osc_recursos_osc.tx_nome_origem_fonte_recursos_osc, 
			vw_osc_recursos_osc.tx_nome_fonte_recursos_osc, 
			vw_osc_recursos_osc.ft_fonte_recursos, 
			vw_osc_recursos_osc.dt_ano, 
			vw_osc_recursos_osc.ft_ano, 
			vw_osc_recursos_osc.nr_valor_recursos_osc, 
			vw_osc_recursos_osc.ft_valor_recursos_osc 
		FROM 
			portal.vw_osc_recursos_osc 
		WHERE 
			vw_osc_recursos_osc.id_osc::TEXT = param OR 
			vw_osc_recursos_osc.tx_apelido_osc = param;
	RETURN;
END;
$$ LANGUAGE 'plpgsql';
