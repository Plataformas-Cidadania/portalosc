DROP FUNCTION IF EXISTS portal.obter_editais();

CREATE OR REPLACE FUNCTION portal.obter_editais() RETURNS TABLE(
	tx_orgao TEXT, 
	tx_programa TEXT, 
	tx_area_interesse_edital TEXT, 
	dt_vencimento DATE, 
	tx_link_edital TEXT,
	tx_numero_chamada TEXT
) AS $$ 
BEGIN 
	RETURN QUERY 
		SELECT 
			tb_edital.tx_orgao, 
			tb_edital.tx_programa, 
			tb_edital.tx_area_interesse_edital, 
			tb_edital.dt_vencimento, 
			tb_edital.tx_link_edital,
			tb_edital.tx_numero_chamada
		FROM 
			portal.tb_edital;
END; 
$$ LANGUAGE 'plpgsql';
