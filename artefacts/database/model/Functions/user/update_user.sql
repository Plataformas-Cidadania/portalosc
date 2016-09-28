CREATE OR REPLACE FUNCTION portal.update_user(id_usuario INTEGER, email TEXT, senha TEXT, nome TEXT, cpf NUMERIC(11, 0), lista_email BOOLEAN, id_osc INTEGER) RETURNS VOID AS $$
DECLARE
	id_representacao INTEGER;
BEGIN
	UPDATE
		portal.tb_usuario
	SET
		tb_usuario.tx_email_usuario = email,
		tb_usuario.tx_senha_usuario = senha,
		tb_usuario.tx_nome_usuario = nome,
		tb_usuario.nr_cpf_usuario = cpf,
		tb_usuario.bo_lista_email = lista_email,
		tb_usuario.dt_atualizacao = NOW()
	WHERE
		id_usuario = id_usuario;
END;
$$ LANGUAGE 'plpgsql'