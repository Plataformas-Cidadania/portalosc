CREATE OR REPLACE FUNCTION portal.update_usuario(id INTEGER, email TEXT, senha TEXT, nome TEXT, cpf NUMERIC(11, 0), lista_email BOOLEAN) RETURNS VOID AS $$
BEGIN
	UPDATE
		portal.tb_usuario
	SET
		tx_email_usuario = email,
		tx_senha_usuario = senha,
		tx_nome_usuario = nome,
		nr_cpf_usuario = cpf,
		bo_lista_email = lista_email,
		dt_atualizacao = NOW()
	WHERE
		id_usuario = id;
END;
$$ LANGUAGE 'plpgsql'