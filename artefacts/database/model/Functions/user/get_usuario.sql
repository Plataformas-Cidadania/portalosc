CREATE OR REPLACE FUNCTION portal.get_usuario(id INTEGER) RETURNS TABLE(
	tx_email_usuario TEXT,
	tx_senha_usuario TEXT,
	tx_nome_usuario TEXT,
	nr_cpf_usuario NUMERIC(11, 0),
	bo_lista_email BOOLEAN
) AS $$
BEGIN
	RETURN QUERY
	SELECT
		usuario.tx_email_usuario,
		usuario.tx_senha_usuario,
		usuario.tx_nome_usuario,
		usuario.nr_cpf_usuario,
		usuario.bo_lista_email
	FROM
		portal.tb_usuario AS usuario
	WHERE
		usuario.id_usuario = id;
END;
$$ LANGUAGE 'plpgsql'