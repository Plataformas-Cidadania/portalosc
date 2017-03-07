DROP FUNCTION IF EXISTS portal.obter_id_por_token(id TEXT);

CREATE OR REPLACE FUNCTION portal.obter_id_por_token(id TEXT) RETURNS TABLE(
	id_usuario INTEGER
) AS $$ 
BEGIN 
	RETURN QUERY 
		SELECT 
			tb_token.id_usuario 
		FROM 
			portal.tb_token 
		WHERE 
			tb_token.tx_token = id; 
END; 
$$ LANGUAGE 'plpgsql';
