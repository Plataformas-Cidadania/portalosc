DROP FUNCTION IF EXISTS portal.obter_osc_governanca(param TEXT);

CREATE OR REPLACE FUNCTION portal.obter_osc_governanca(param TEXT) RETURNS TABLE (
	id_dirigente INTEGER, 
	tx_cargo_dirigente TEXT, 
	ft_cargo_dirigente TEXT, 
	tx_nome_dirigente TEXT, 
	ft_nome_dirigente TEXT
) AS $$ 
BEGIN 
	RETURN QUERY 
		SELECT 
			vw_osc_governanca.id_dirigente, 
			vw_osc_governanca.tx_cargo_dirigente, 
			vw_osc_governanca.ft_cargo_dirigente, 
			vw_osc_governanca.tx_nome_dirigente, 
			vw_osc_governanca.ft_nome_dirigente 
		FROM 
			portal.vw_osc_governanca 
		WHERE 
			vw_osc_governanca.id_osc::TEXT = param OR 
			vw_osc_governanca.tx_apelido_osc = param;
	RETURN;
END;
$$ LANGUAGE 'plpgsql';
