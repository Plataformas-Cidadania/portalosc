DROP FUNCTION IF EXISTS portal.obter_osc_recursos_outro_osc(param TEXT);

CREATE OR REPLACE FUNCTION portal.obter_osc_recursos_outro_osc(param TEXT) RETURNS TABLE (
	id_recursos_outro_osc INTEGER, 
	tx_nome_fonte_recursos_outro_osc TEXT, 
	ft_nome_fonte_recursos_outro_osc TEXT, 
	dt_ano_recursos_outro_osc TEXT, 
	ft_ano_recursos_outro_osc TEXT, 
	nr_valor_recursos_outro_osc DOUBLE PRECISION, 
	ft_valor_recursos_outro_osc TEXT
) AS $$ 
BEGIN 
	RETURN QUERY 
		SELECT
			vw_osc_recursos_outro_osc.id_recursos_outro_osc,
			vw_osc_recursos_outro_osc.tx_nome_fonte_recursos_outro_osc, 
			vw_osc_recursos_outro_osc.ft_nome_fonte_recursos_outro_osc, 
			vw_osc_recursos_outro_osc.dt_ano_recursos_outro_osc, 
			vw_osc_recursos_outro_osc.ft_ano_recursos_outro_osc, 
			vw_osc_recursos_outro_osc.nr_valor_recursos_outro_osc, 
			vw_osc_recursos_outro_osc.ft_valor_recursos_outro_osc 
		FROM 
			portal.vw_osc_recursos_outro_osc 
		WHERE 
			vw_osc_recursos_outro_osc.id_osc::TEXT = param OR 
			vw_osc_recursos_outro_osc.tx_apelido_osc = param;
	RETURN;
END;
$$ LANGUAGE 'plpgsql';
