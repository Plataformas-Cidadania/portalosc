DROP FUNCTION IF EXISTS portal.atualizar_contato(id INTEGER, telefone TEXT, fttelefone TEXT, email TEXT, ftemail TEXT, site TEXT, ftsite TEXT);

CREATE OR REPLACE FUNCTION portal.atualizar_contato(id INTEGER, telefone TEXT, fttelefone TEXT, email TEXT, ftemail TEXT, site TEXT, ftsite TEXT) RETURNS VOID AS $$ 
BEGIN 
	UPDATE 
		osc.tb_contato
	SET 
		tx_telefone = telefone, 
		ft_telefone = fttelefone, 
		tx_email = email, 
		ft_email = ftemail, 
		tx_site = site, 
		ft_site = ftsite
		 
	WHERE 
		id_osc = id; 
END; 
$$ LANGUAGE 'plpgsql';
