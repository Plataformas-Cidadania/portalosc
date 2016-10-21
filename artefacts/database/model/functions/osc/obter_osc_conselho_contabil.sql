DROP FUNCTION IF EXISTS portal.obter_osc_conselho_contabil(param TEXT);

CREATE OR REPLACE FUNCTION portal.obter_osc_conselho_contabil(param TEXT) RETURNS TABLE (
	id_conselheiro INTEGER, 
	tx_nome_conselheiro TEXT, 
	ft_nome_conselheiro TEXT, 
	tx_cargo_conselheiro TEXT, 
	ft_cargo_conselheiro TEXT
) AS $$ 
BEGIN 
	RETURN QUERY 
		SELECT 
			vw_osc_conselho_contabil.id_conselheiro, 
			vw_osc_conselho_contabil.tx_nome_conselheiro, 
			vw_osc_conselho_contabil.ft_nome_conselheiro, 
			vw_osc_conselho_contabil.tx_cargo_conselheiro, 
			vw_osc_conselho_contabil.ft_cargo_conselheiro 
		FROM portal.vw_osc_conselho_contabil 
		WHERE 
			vw_osc_conselho_contabil.id_osc::TEXT = param OR 
			vw_osc_conselho_contabil.tx_apelido_osc = param;
	RETURN;
END;
$$ LANGUAGE 'plpgsql';
