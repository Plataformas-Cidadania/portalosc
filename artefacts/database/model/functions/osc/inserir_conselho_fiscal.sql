DROP FUNCTION IF EXISTS portal.inserir_conselho_fiscal(id INTEGER, nomeconselheiro TEXT, ftnomeconselheiro TEXT, cargoconselheiro TEXT, ftcargoconselheiro TEXT);

CREATE OR REPLACE FUNCTION portal.inserir_conselho_fiscal(id INTEGER, nomeconselheiro TEXT, ftnomeconselheiro TEXT)
 RETURNS BOOLEAN AS $$

DECLARE
	status BOOLEAN;	

BEGIN
	INSERT INTO osc.tb_conselho_fiscal (id_osc, tx_nome_conselheiro, ft_nome_conselheiro)
	VALUES (id, nomeconselheiro, ftnomeconselheiro);

	status := true;
	RETURN status;

EXCEPTION 
	WHEN others THEN 
		status := false;
		RETURN status;

END;
$$ LANGUAGE 'plpgsql';
