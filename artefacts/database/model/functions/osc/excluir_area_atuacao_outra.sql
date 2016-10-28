DROP FUNCTION IF EXISTS portal.excluir_area_atuacao_outra(id INTEGER);

CREATE OR REPLACE FUNCTION portal.excluir_area_atuacao_outra(id INTEGER) RETURNS VOID AS $$ 

DECLARE
	id_declarada INTEGER;

BEGIN 
	id_declarada := (SELECT id_area_declarada FROM osc.tb_area_atuacao_outra WHERE id_area_atuacao_outra = id); 

	DELETE FROM  
		osc.tb_area_atuacao_outra 
	WHERE 
		id_area_atuacao_outra = id;

	DELETE FROM 
		 osc.tb_area_atuacao_declarada
	WHERE 
		id_area_atuacao_declarada = id_declarada;
		

END; 
$$ LANGUAGE 'plpgsql';
