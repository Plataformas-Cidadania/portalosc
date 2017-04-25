DROP FUNCTION IF EXISTS portal.excluir_participacao_social_conferencia_outra(id integer);

CREATE OR REPLACE FUNCTION portal.excluir_participacao_social_conferencia_outra(id INTEGER) RETURNS VOID AS $$ 

DECLARE
	idconferencia INTEGER;

BEGIN 
	idconferencia := (SELECT id_conferencia FROM osc.tb_participacao_social_conferencia_outra WHERE id_conferencia_outra = id); 

	DELETE FROM  
		osc.tb_participacao_social_conferencia_outra
	WHERE 
		id_conferencia_outra = id;
		
	DELETE FROM  
		osc.tb_participacao_social_conferencia
	WHERE 
		id_conferencia = idconferencia;
END; 
$$ LANGUAGE 'plpgsql';
