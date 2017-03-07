DROP FUNCTION IF EXISTS portal.obter_osc_recursos_osc_por_fonte_ano(fonte_param INTEGER, ano_param TEXT, osc_param TEXT);

CREATE OR REPLACE FUNCTION portal.obter_osc_recursos_osc_por_fonte_ano(fonte_param INTEGER, ano_param TEXT, osc_param TEXT) RETURNS TABLE (
	cd_fonte_recursos_osc INTEGER, 
	id_recursos_osc INTEGER, 
	nr_valor_recursos_osc DOUBLE PRECISION, 
	ft_valor_recursos_osc TEXT
) AS $$ 
BEGIN 
	RETURN QUERY 
		SELECT 
			vw_osc_recursos_osc.cd_fonte_recursos_osc, 
			vw_osc_recursos_osc.id_recursos_osc, 
			vw_osc_recursos_osc.nr_valor_recursos_osc, 
			vw_osc_recursos_osc.ft_valor_recursos_osc 
		FROM 
			portal.vw_osc_recursos_osc 
		WHERE 
			vw_osc_recursos_osc.cd_fonte_recursos_osc = fonte_param AND 
			vw_osc_recursos_osc.dt_ano_recursos_osc = ano_param AND 
			(vw_osc_recursos_osc.id_osc::TEXT = osc_param OR 
			vw_osc_recursos_osc.tx_apelido_osc = osc_param);
	RETURN;
END;
$$ LANGUAGE 'plpgsql';
