DROP FUNCTION IF EXISTS portal.excluir_parceira_projeto(id INTEGER);

CREATE OR REPLACE FUNCTION portal.excluir_parceira_projeto(id INTEGER) RETURNS VOID AS $$ 
BEGIN 
	DELETE FROM 
		osc.tb_osc_parceira_projeto
	WHERE 
		id_osc = id; 
END; 
$$ LANGUAGE 'plpgsql';
