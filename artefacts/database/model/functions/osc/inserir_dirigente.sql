DROP FUNCTION IF EXISTS portal.inserir_dirigente(id INTEGER, cargo TEXT, ftcargo TEXT, nome TEXT, ftnome TEXT);

CREATE OR REPLACE FUNCTION portal.inserir_dirigente(id INTEGER, cargo TEXT, ftcargo TEXT, nome TEXT, ftnome TEXT)
 RETURNS BOOLEAN AS $$

DECLARE
	status BOOLEAN;	

BEGIN
	INSERT INTO osc.tb_governanca (id_osc , tx_cargo_dirigente, ft_cargo_dirigente, tx_nome_dirigente, ft_nome_dirigente)
	VALUES (id, cargo, ftcargo, nome, ftnome);

	status := true;
	RETURN status;

EXCEPTION 
	WHEN others THEN 
		status := false;
		RETURN status;

END;
$$ LANGUAGE 'plpgsql';
