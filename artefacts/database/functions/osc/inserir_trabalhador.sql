DROP FUNCTION IF EXISTS portal.inserir_trabalhador(id INTEGER, nrtrabalhadoresvoluntarios INTEGER, fttrabalhadoresvoluntarios TEXT);

CREATE OR REPLACE FUNCTION portal.inserir_trabalhador(id INTEGER, nrtrabalhadoresvoluntarios INTEGER, fttrabalhadoresvoluntarios TEXT)
 RETURNS BOOLEAN AS $$

DECLARE
	status BOOLEAN;	

BEGIN
	INSERT INTO osc.tb_relacoes_trabalho (id_osc, nr_trabalhadores_voluntarios, ft_trabalhadores_voluntarios)
    	VALUES (id, nrtrabalhadoresvoluntarios, fttrabalhadoresvoluntarios);

	status := true;
	RETURN status;

EXCEPTION 
	WHEN others THEN 
		status := false;
		RETURN status;

END;
$$ LANGUAGE 'plpgsql';
