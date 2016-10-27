DROP FUNCTION IF EXISTS portal.inserir_area_atuacao_outra(id INTEGER, areadeclarada INTEGER, ftareadeclarada TEXT);

CREATE OR REPLACE FUNCTION portal.inserir_area_atuacao_outra(id INTEGER, areadeclarada INTEGER, ftareadeclarada TEXT)
 RETURNS BOOLEAN AS $$

DECLARE
	status BOOLEAN;	

BEGIN
	INSERT INTO osc.tb_area_atuacao_outra (id_osc, id_area_declarada, ft_area_declarada) 
	VALUES (id, areadeclarada, ftareadeclarada);

	status := true;
	RETURN status;

EXCEPTION 
	WHEN others THEN 
		status := false;
		RETURN status;

END;
$$ LANGUAGE 'plpgsql';
