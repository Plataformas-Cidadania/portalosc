CREATE OR REPLACE FUNCTION portal.obter_token(id INTEGER) RETURNS INTEGER AS $$
BEGIN
	RETURN QUERY
	SELECT
		tb_token.cd_token
	FROM
		portal.tb_token
	WHERE
		tb_token.id_usuario = id;
END;
$$ LANGUAGE 'plpgsql'
