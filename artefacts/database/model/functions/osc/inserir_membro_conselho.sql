DROP FUNCTION IF EXISTS portal.inserir_membro_conselho(id INTEGER, nomeconselheiro TEXT, ftnomeconselheiro TEXT);

CREATE OR REPLACE FUNCTION portal.inserir_membro_conselho(id INTEGER, nomeconselheiro TEXT, ftnomeconselheiro TEXT, oficial BOOLEAN)
 RETURNS BOOLEAN AS $$

DECLARE
	status BOOLEAN;	

BEGIN
	INSERT INTO osc.tb_conselho_fiscal (id_osc, tx_nome_conselheiro, ft_nome_conselheiro, bo_oficial) 
	VALUES (id, nomeconselheiro, ftnomeconselheiro, oficial);

	status := true;
	RETURN status;

EXCEPTION 
	WHEN others THEN 
		status := false;
		RETURN status;

END;
$$ LANGUAGE 'plpgsql';
