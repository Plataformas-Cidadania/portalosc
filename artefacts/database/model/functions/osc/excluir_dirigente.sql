DROP FUNCTION IF EXISTS portal.excluir_dirigente(id INTEGER);

CREATE OR REPLACE FUNCTION portal.excluir_dirigente(id INTEGER) RETURNS VOID AS $$ 
BEGIN 
	DELETE FROM 
		osc.tb_governanca
	WHERE 
		id_dirigente = id; 
END; 
$$ LANGUAGE 'plpgsql';
