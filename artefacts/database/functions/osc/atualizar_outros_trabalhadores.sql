DROP FUNCTION IF EXISTS portal.atualizar_outros_trabalhadores(id INTEGER, nrtrabalhadores INTEGER, fttrabalhadores TEXT);

CREATE OR REPLACE FUNCTION portal.atualizar_outros_trabalhadores(id INTEGER, nrtrabalhadores INTEGER, fttrabalhadores TEXT)
 RETURNS TABLE(
	mensagem TEXT
)AS $$

BEGIN 

	UPDATE 
		osc.tb_relacoes_trabalho_outra 
	SET 
		nr_trabalhadores = nrtrabalhadores, 
		ft_trabalhadores = fttrabalhadores 
	WHERE 
		id_osc = id;

	mensagem := 'Número de trabalhadores atualizado';
	RETURN NEXT;
END; 
$$ LANGUAGE 'plpgsql';
