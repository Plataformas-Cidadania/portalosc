DROP FUNCTION IF EXISTS portal.excluir_area_atuacao(id INTEGER);

CREATE OR REPLACE FUNCTION portal.excluir_area_atuacao(id INTEGER) RETURNS VOID AS $$ 

BEGIN 
	DELETE FROM  
		osc.tb_area_atuacao 
	WHERE 
		id_area_atuacao = id;
END; 
$$ LANGUAGE 'plpgsql';
