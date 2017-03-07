DROP FUNCTION IF EXISTS portal.excluir_area_atuacao(id_osc_req INTEGER, cd_area_atuacao_req INTEGER, cd_subarea_atuacao_req INTEGER);

CREATE OR REPLACE FUNCTION portal.excluir_area_atuacao(id_osc_req INTEGER, cd_area_atuacao_req INTEGER, cd_subarea_atuacao_req INTEGER) RETURNS VOID AS $$ 

BEGIN 
	IF cd_subarea_atuacao_req IS NULL THEN 
		DELETE FROM  
			osc.tb_area_atuacao 
		WHERE 
			id_osc = id_osc_req AND 
			cd_area_atuacao = cd_area_atuacao_req AND 
			cd_subarea_atuacao IS NULL; 

	ELSE 
		DELETE FROM  
			osc.tb_area_atuacao 
		WHERE 
			id_osc = id_osc_req AND 
			cd_area_atuacao = cd_area_atuacao_req AND 
			cd_subarea_atuacao = cd_subarea_atuacao_req; 
	END IF; 
END; 
$$ LANGUAGE 'plpgsql';
