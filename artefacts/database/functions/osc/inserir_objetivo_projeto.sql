DROP FUNCTION IF EXISTS portal.inserir_objetivo_projeto(idprojeto INTEGER, cdmetaprojeto INTEGER, ftobjetivoprojeto TEXT, oficial BOOLEAN);

CREATE OR REPLACE FUNCTION portal.inserir_objetivo_projeto(idprojeto INTEGER, cdmetaprojeto INTEGER, ftobjetivoprojeto TEXT, oficial BOOLEAN)
 RETURNS BOOLEAN AS $$

DECLARE
	status BOOLEAN;	

BEGIN
	INSERT INTO osc.tb_objetivo_projeto (id_projeto, cd_meta_projeto, ft_objetivo_projeto, bo_oficial) 
	VALUES (idprojeto, cdmetaprojeto, ftobjetivoprojeto, oficial);

	status := true;
	RETURN status;

EXCEPTION 
	WHEN others THEN 
		status := false;
		RETURN status;

END;
$$ LANGUAGE 'plpgsql';
