DROP FUNCTION IF EXISTS portal.excluir_participacao_social_declarada(id INTEGER);

CREATE OR REPLACE FUNCTION portal.excluir_participacao_social_declarada(id INTEGER) RETURNS VOID AS $$ 

BEGIN 
	DELETE FROM  
		osc.tb_participacao_social_declarada
	WHERE 
		id_participacao_social_declarada = id;
END; 
$$ LANGUAGE 'plpgsql';
