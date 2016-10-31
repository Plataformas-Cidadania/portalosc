DROP FUNCTION IF EXISTS portal.atualizar_trabalhadores(id INTEGER, nrtrabalhadoresvoluntarios INTEGER, fttrabalhadoresvoluntarios TEXT);

CREATE OR REPLACE FUNCTION portal.atualizar_trabalhadores(id INTEGER, nrtrabalhadoresvoluntarios INTEGER, fttrabalhadoresvoluntarios TEXT)
 RETURNS TABLE(
	mensagem TEXT
)AS $$

BEGIN 

	UPDATE 
		osc.tb_relacoes_trabalho 
	SET 
		nr_trabalhadores_voluntarios = nrtrabalhadoresvoluntarios, 
		ft_trabalhadores_voluntarios = fttrabalhadoresvoluntarios 
	WHERE 
		id_osc = id;

	mensagem := 'Número de trabalhadores atualizado';
	RETURN NEXT;
END; 
$$ LANGUAGE 'plpgsql';
