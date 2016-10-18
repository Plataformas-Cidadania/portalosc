DROP FUNCTION IF EXISTS portal.obter_osc_dirigente(param TEXT);

CREATE OR REPLACE FUNCTION portal.obter_osc_dirigente(param TEXT) RETURNS TABLE (
	id_dirigente INTEGER, 
	tx_cargo_dirigente TEXT, 
	ft_cargo_dirigente TEXT, 
	tx_nome_dirigente TEXT, 
	ft_nome_dirigente TEXT
) AS $$ 
BEGIN 
	RETURN QUERY 
		SELECT 
			vw_osc_dirigente.id_dirigente, 
			vw_osc_dirigente.tx_cargo_dirigente, 
			vw_osc_dirigente.ft_cargo_dirigente, 
			vw_osc_dirigente.tx_nome_dirigente, 
			vw_osc_dirigente.ft_nome_dirigente 
		FROM 
			portal.vw_osc_dirigente 
		WHERE 
			vw_osc_dirigente.id_osc::TEXT = param OR 
			vw_osc_dirigente.tx_url_osc = param;
	RETURN;
END;
$$ LANGUAGE 'plpgsql';
