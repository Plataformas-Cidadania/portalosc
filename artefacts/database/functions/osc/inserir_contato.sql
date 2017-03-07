DROP FUNCTION IF EXISTS portal.inserir_contato(id INTEGER, telefone TEXT, fttelefone TEXT, email TEXT, ftemail TEXT, site TEXT, ftsite TEXT);

CREATE OR REPLACE FUNCTION portal.inserir_contato(id INTEGER, telefone TEXT, fttelefone TEXT, email TEXT, ftemail TEXT, site TEXT, ftsite TEXT)
 RETURNS BOOLEAN AS $$

DECLARE
	status BOOLEAN;	

BEGIN
	INSERT INTO osc.tb_contato(id_osc, tx_telefone, ft_telefone, tx_email, ft_email, tx_site, ft_site) 
	VALUES (id, telefone, fttelefone, email, ftemail, site, ftsite);

	status := true;
	RETURN status;

EXCEPTION 
	WHEN others THEN 
		status := false;
		RETURN status;

END;
$$ LANGUAGE 'plpgsql';
