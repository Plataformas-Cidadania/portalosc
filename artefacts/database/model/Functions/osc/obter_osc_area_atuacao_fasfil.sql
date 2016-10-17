DROP FUNCTION portal.obter_osc_area_atuacao_fasfil(param TEXT);

CREATE OR REPLACE FUNCTION portal.obter_osc_area_atuacao_fasfil(param TEXT) RETURNS TABLE (
	id_area_atuacao_osc INTEGER, 
	tx_nome_macro_area_fasfil TEXT, 
	tx_nome_area_fasfil TEXT, 
	ft_area_atuacao_fasfil TEXT
) AS $$ 
BEGIN 
	RETURN QUERY 
		SELECT 
			vw_osc_area_atuacao_fasfil.id_area_atuacao_osc, 
			vw_osc_area_atuacao_fasfil.tx_nome_macro_area_fasfil, 
			vw_osc_area_atuacao_fasfil.tx_nome_area_fasfil, 
			vw_osc_area_atuacao_fasfil.ft_area_atuacao_fasfil 
		FROM 
			portal.vw_osc_area_atuacao_fasfil 
		WHERE 
			vw_osc_area_atuacao_fasfil.id_osc::TEXT = param OR 
			vw_osc_area_atuacao_fasfil.tx_url_osc = param;
	RETURN;
END;
$$ LANGUAGE 'plpgsql';
