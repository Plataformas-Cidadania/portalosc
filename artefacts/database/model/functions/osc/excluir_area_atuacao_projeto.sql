DROP FUNCTION IF EXISTS portal.excluir_area_atuacao_projeto(id INTEGER);

CREATE OR REPLACE FUNCTION portal.excluir_area_atuacao_projeto(id INTEGER) RETURNS VOID AS $$ 

DECLARE
	id_outra INTEGER;

BEGIN 
	id_outra := (SELECT id_area_atuacao_outra FROM osc.tb_area_atuacao_outra WHERE id_area_declarada = id);
	
	DELETE FROM 
		 osc.tb_area_atuacao_outra_projeto
	WHERE 
		id_area_atuacao_outra = id_outra;

	DELETE FROM  
		osc.tb_area_atuacao_outra 
	WHERE 
		id_area_declarada = id;
		
	DELETE FROM  
		osc.tb_area_atuacao_declarada 
	WHERE 
		id_area_atuacao_declarada = id;

END; 
$$ LANGUAGE 'plpgsql';
