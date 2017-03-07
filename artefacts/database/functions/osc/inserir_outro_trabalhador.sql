DROP FUNCTION IF EXISTS portal.inserir_outro_trabalhador(id INTEGER, nrtrabalhadores INTEGER, fttrabalhadores TEXT);

CREATE OR REPLACE FUNCTION portal.inserir_outro_trabalhador(id INTEGER, nrtrabalhadores INTEGER, fttrabalhadores TEXT)
 RETURNS BOOLEAN AS $$

DECLARE
	status BOOLEAN;	

BEGIN
	INSERT INTO osc.tb_relacoes_trabalho_outra (id_osc, nr_trabalhadores, ft_trabalhadores)
    	VALUES (id, nrtrabalhadores, fttrabalhadores);

	status := true;
	RETURN status;

EXCEPTION 
	WHEN others THEN 
		status := false;
		RETURN status;

END;
$$ LANGUAGE 'plpgsql';
