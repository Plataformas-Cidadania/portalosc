DROP FUNCTION IF EXISTS portal.obter_token_representante(id INTEGER);

CREATE OR REPLACE FUNCTION portal.obter_token_representante(id INTEGER) RETURNS TABLE(
	cd_token TEXT
) AS $$ 
BEGIN 
	RETURN QUERY 
		SELECT 
			tb_token.cd_token 
		FROM 
			portal.tb_token 
		WHERE 
			tb_token.id_usuario = id; 
END; 
$$ LANGUAGE 'plpgsql';
