DROP FUNCTION IF EXISTS portal.excluir_recursos_osc(id INTEGER);

CREATE OR REPLACE FUNCTION portal.excluir_recursos_osc(id INTEGER) RETURNS VOID AS $$ 
BEGIN 
	DELETE FROM 
		osc.tb_recursos_osc 
	WHERE 
		id_recursos_osc = id;
END; 
$$ LANGUAGE 'plpgsql';
