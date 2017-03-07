DROP FUNCTION IF EXISTS portal.excluir_participacao_social_conferencia_outra(id INTEGER);

CREATE OR REPLACE FUNCTION portal.excluir_participacao_social_conferencia_outra(id INTEGER) RETURNS VOID AS $$ 

DECLARE
	id_declarada INTEGER;

BEGIN 
	id_declarada := (SELECT id_conferencia_declarada FROM osc.tb_participacao_social_conferencia_outra WHERE id_conferencia_outra = id); 

	DELETE FROM  
		osc.tb_participacao_social_conferencia_outra
	WHERE 
		id_conferencia_outra = id;
		
	DELETE FROM  
		osc.tb_conferencia_declarada
	WHERE 
		id_conferencia_declarada = id_declarada;
END; 
$$ LANGUAGE 'plpgsql';
