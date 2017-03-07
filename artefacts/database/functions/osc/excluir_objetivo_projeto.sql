DROP FUNCTION IF EXISTS portal.excluir_objetivo_projeto(id INTEGER);

CREATE OR REPLACE FUNCTION portal.excluir_objetivo_projeto(id INTEGER) RETURNS VOID AS $$ 

BEGIN 
	DELETE FROM  
		osc.tb_objetivo_projeto 
	WHERE 
		id_objetivo_projeto = id;
END; 
$$ LANGUAGE 'plpgsql';
