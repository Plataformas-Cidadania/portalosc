CREATE OR REPLACE FUNCTION portal.create_usuario(email TEXT, senha TEXT, nome TEXT, cpf NUMERIC(11, 0), lista_email BOOLEAN) RETURNS VOID AS $$
BEGIN
	INSERT INTO
		portal.tb_usuario (tx_email_usuario, tx_senha_usuario, tx_nome_usuario, nr_cpf_usuario, bo_lista_email, bo_ativo, dt_cadastro, dt_atualizacao)
	VALUES
		(email, senha, nome, cpf, lista_email, false, NOW(), NOW());
END;
$$ LANGUAGE 'plpgsql'