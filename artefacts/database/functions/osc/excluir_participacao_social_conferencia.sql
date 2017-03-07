DROP FUNCTION IF EXISTS portal.excluir_participacao_social_conferencia(id INTEGER);

CREATE OR REPLACE FUNCTION portal.excluir_participacao_social_conferencia(id INTEGER) RETURNS VOID AS $$ 

BEGIN 
	DELETE FROM  
		osc.tb_participacao_social_conferencia
	WHERE 
		id_conferencia = id;
END; 
$$ LANGUAGE 'plpgsql';
