DROP FUNCTION IF EXISTS portal.inserir_edital(orgao TEXT, programa TEXT, areainteresse TEXT, dtvencimento DATE, link TEXT, numerochamada TEXT);

CREATE OR REPLACE FUNCTION portal.inserir_edital(orgao TEXT, programa TEXT, areainteresse TEXT, dtvencimento DATE, link TEXT, numerochamada TEXT)
 RETURNS BOOLEAN AS $$

DECLARE
	status BOOLEAN;

BEGIN
	INSERT INTO portal.tb_edital(tx_orgao, tx_programa, tx_area_interesse_edital, dt_vencimento, tx_link_edital, tx_numero_chamada) 
	VALUES (orgao, programa, areainteresse, dtvencimento, link, numerochamada);

	status := true;
	RETURN status;

EXCEPTION 
	WHEN others THEN 
		status := false;
		RETURN status;

END;
$$ LANGUAGE 'plpgsql';
