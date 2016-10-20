DROP FUNCTION IF EXISTS portal.obter_token_representante(id INTEGER);

CREATE OR REPLACE FUNCTION portal.obter_token_representante(id INTEGER, token TEXT) RETURNS TABLE(
	result BOOLEAN
) AS $$ 
BEGIN 
	RETURN QUERY 
		SELECT EXISTS(
			SELECT 
				* 
			FROM 
				portal.tb_token 
			WHERE 
				tb_token.id_usuario = id AND 
				tb_token.cd_token = token
		);
END; 
$$ LANGUAGE 'plpgsql';
