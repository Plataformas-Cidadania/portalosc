DROP FUNCTION IF EXISTS portal.obter_osc_recursos_osc(param TEXT);

CREATE OR REPLACE FUNCTION portal.obter_osc_recursos_osc(param TEXT) RETURNS TABLE (
	id_recursos_osc INTEGER, 
	cd_fonte_recursos_osc INTEGER, 
	tx_nome_origem_fonte_recursos_osc TEXT, 
	tx_nome_fonte_recursos_osc TEXT, 
	ft_fonte_recursos_osc TEXT, 
	dt_ano_recursos_osc TEXT, 
	ft_ano_recursos_osc TEXT, 
	nr_valor_recursos_osc DOUBLE PRECISION, 
	ft_valor_recursos_osc TEXT
) AS $$ 
BEGIN 
	RETURN QUERY 
		SELECT
			vw_osc_recursos_osc.id_recursos_osc, 
			vw_osc_recursos_osc.cd_fonte_recursos_osc, 
			vw_osc_recursos_osc.tx_nome_origem_fonte_recursos_osc, 
			vw_osc_recursos_osc.tx_nome_fonte_recursos_osc, 
			vw_osc_recursos_osc.ft_fonte_recursos_osc, 
			vw_osc_recursos_osc.dt_ano_recursos_osc, 
			vw_osc_recursos_osc.ft_ano_recursos_osc, 
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
