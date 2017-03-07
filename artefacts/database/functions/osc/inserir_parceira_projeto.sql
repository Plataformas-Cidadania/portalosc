DROP FUNCTION IF EXISTS portal.inserir_parceira_projeto(idprojeto INTEGER, idosc INTEGER, ftoscparceiraprojeto TEXT);

CREATE OR REPLACE FUNCTION portal.inserir_parceira_projeto(idprojeto INTEGER, idosc INTEGER, ftoscparceiraprojeto TEXT, oficial BOOLEAN)
 RETURNS BOOLEAN AS $$

DECLARE
	status BOOLEAN;	

BEGIN
	INSERT INTO osc.tb_osc_parceira_projeto (id_projeto, id_osc, ft_osc_parceira_projeto, bo_oficial) 
	VALUES(idprojeto, idosc, ftoscparceiraprojeto, oficial);

	status := true;
	RETURN status;

EXCEPTION 
	WHEN others THEN 
		status := false;
		RETURN status;

END;
$$ LANGUAGE 'plpgsql';
