DROP FUNCTION IF EXISTS portal.excluir_participacao_social_conselho(id_osc_req INTEGER, cd_conselho_req INTEGER);

CREATE OR REPLACE FUNCTION portal.excluir_participacao_social_conselho(id_osc_req INTEGER, cd_conselho_req INTEGER) RETURNS VOID AS $$ 

BEGIN 
	DELETE FROM  
		osc.tb_participacao_social_conselho 
	WHERE 
		id_osc = id_osc_req AND
		cd_conselho = cd_conselho_req;
END; 
$$ LANGUAGE 'plpgsql';
