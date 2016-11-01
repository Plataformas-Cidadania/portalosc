DROP FUNCTION IF EXISTS portal.excluir_participacao_social_conferencia_outra(id INTEGER);

CREATE OR REPLACE FUNCTION portal.excluir_participacao_social_conferencia_outra(id INTEGER) RETURNS VOID AS $$ 

BEGIN 
	DELETE FROM  
		osc.tb_participacao_social_conferencia_outra
	WHERE 
		id_conferencia_outra = id;
END; 
$$ LANGUAGE 'plpgsql';
