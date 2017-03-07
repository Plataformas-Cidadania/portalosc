DROP FUNCTION IF EXISTS portal.excluir_area_atuacao_projeto(id INTEGER);

CREATE OR REPLACE FUNCTION portal.excluir_area_atuacao_projeto(id INTEGER) RETURNS VOID AS $$ 

BEGIN 
	
	DELETE FROM 
		 osc.tb_area_atuacao_projeto
	WHERE 
		id_area_atuacao_projeto = id;

	
END; 
$$ LANGUAGE 'plpgsql';
