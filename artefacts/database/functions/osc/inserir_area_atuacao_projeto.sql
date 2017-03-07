DROP FUNCTION IF EXISTS portal.inserir_area_atuacao_projeto(id INTEGER, idprojeto INTEGER, nomeareaatuacaodeclarada TEXT, ftnomeareaatuacaodeclarada TEXT, ftareadeclarada TEXT, ftareaatuacaooutra TEXT);

CREATE OR REPLACE FUNCTION portal.inserir_area_atuacao_projeto(idprojeto INTEGER, cdsubareaatuacao INTEGER, ftareaatuacaoprojeto TEXT, oficial BOOLEAN)
 RETURNS BOOLEAN AS $$

DECLARE
	status BOOLEAN;	

BEGIN

	INSERT INTO osc.tb_area_atuacao_projeto(id_projeto, cd_subarea_atuacao, ft_area_atuacao_projeto, bo_oficial) 
	VALUES (idprojeto, cdsubareaatuacao, ftareaatuacaoprojeto, oficial);

	status := true;
	RETURN status;

EXCEPTION 
	WHEN others THEN 
		status := false;
		RETURN status;

END;
$$ LANGUAGE 'plpgsql';
