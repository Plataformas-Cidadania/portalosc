DROP FUNCTION IF EXISTS portal.excluir_participacao_social_conselho_outro(id INTEGER);

CREATE OR REPLACE FUNCTION portal.excluir_participacao_social_conselho_outro(id INTEGER) RETURNS VOID AS $$ 

DECLARE
	idconselho INTEGER;

BEGIN 
	idconselho := (SELECT id_conselho FROM osc.tb_participacao_social_conselho_outro WHERE id_conselho_outro = id); 

	DELETE FROM  
		osc.tb_participacao_social_conselho_outro
	WHERE 
		id_conselho_outro = id;
		
	DELETE FROM  
		osc.tb_participacao_social_conselho
	WHERE 
		id_conselho = idconselho;
END; 
$$ LANGUAGE 'plpgsql';
