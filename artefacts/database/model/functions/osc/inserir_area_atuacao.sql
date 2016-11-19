DROP FUNCTION IF EXISTS portal.inserir_area_atuacao(id INTEGER, areaatuacao INTEGER, ftareaatuacao TEXT, subareaatuacao INTEGER);

CREATE OR REPLACE FUNCTION portal.inserir_area_atuacao(id INTEGER, areaatuacao INTEGER, ftareaatuacao TEXT, subareaatuacao INTEGER, oficial BOOLEAN)
 RETURNS BOOLEAN AS $$

DECLARE
	status BOOLEAN;	

BEGIN
	INSERT INTO osc.tb_area_atuacao (id_osc, cd_area_atuacao, ft_area_atuacao, cd_subarea_atuacao, bo_oficial) 
	VALUES (id, areaatuacao, ftareaatuacao, subareaatuacao, oficial);

	status := true;
	RETURN status;

EXCEPTION 
	WHEN others THEN 
		status := false;
		RETURN status;

END;
$$ LANGUAGE 'plpgsql';
