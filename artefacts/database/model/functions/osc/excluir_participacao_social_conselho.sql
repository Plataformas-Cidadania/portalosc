DROP FUNCTION IF EXISTS portal.excluir_participacao_social_conselho(id INTEGER);

CREATE OR REPLACE FUNCTION portal.excluir_participacao_social_conselho(id INTEGER) RETURNS VOID AS $$ 

BEGIN 
	DELETE FROM  
		osc.tb_participacao_social_conselho 
	WHERE 
		id_conselho = id;
END; 
$$ LANGUAGE 'plpgsql';
