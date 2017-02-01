DROP FUNCTION IF EXISTS portal.excluir_area_atuacao(id INTEGER, area_atuacao INTEGER, subarea_atuacao INTEGER);

CREATE OR REPLACE FUNCTION portal.excluir_area_atuacao(id INTEGER, area_atuacao INTEGER, subarea_atuacao INTEGER) RETURNS VOID AS $$ 

BEGIN 
	DELETE FROM  
		osc.tb_area_atuacao 
	WHERE 
		id_osc = id AND 
		cd_area_atuacao = area_atuacao AND 
		cd_subarea_atuacao = subarea_atuacao;
END; 
$$ LANGUAGE 'plpgsql';
