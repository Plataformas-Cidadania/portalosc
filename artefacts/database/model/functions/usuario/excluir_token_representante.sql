DROP FUNCTION IF EXISTS portal.ecluir_token_representante(id INTEGER);

CREATE OR REPLACE FUNCTION portal.ecluir_token_representante(id INTEGER) RETURNS VOID AS $$ 
BEGIN 
	DELETE FROM 
		portal.tb_token 
	WHERE 
		id_usuario = id; 
END; 
$$ LANGUAGE 'plpgsql';
