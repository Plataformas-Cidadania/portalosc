DROP FUNCTION IF EXISTS portal.excluir_publico_beneficiado(id INTEGER);

CREATE OR REPLACE FUNCTION portal.excluir_publico_beneficiado(id INTEGER) RETURNS VOID AS $$ 

BEGIN 
	DELETE FROM  
		osc.tb_publico_beneficiado_projeto 
	WHERE 
		id_publico_beneficiado = id;

	DELETE FROM 
		 osc.tb_publico_beneficiado
	WHERE 
		id_publico_beneficiado = id;
		

END; 
$$ LANGUAGE 'plpgsql';
