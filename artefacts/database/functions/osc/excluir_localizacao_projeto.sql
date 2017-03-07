DROP FUNCTION IF EXISTS portal.excluir_localizacao_projeto(id INTEGER);

CREATE OR REPLACE FUNCTION portal.excluir_localizacao_projeto(id INTEGER) RETURNS VOID AS $$ 
BEGIN 
	DELETE FROM 
		osc.tb_localizacao_projeto 
	WHERE 
		id_localizacao_projeto = id;
END; 
$$ LANGUAGE 'plpgsql';
