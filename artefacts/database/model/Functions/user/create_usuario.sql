CREATE OR REPLACE FUNCTION portal.create_usuario(email TEXT, senha TEXT, nome TEXT, cpf NUMERIC(11, 0), newsletter BOOLEAN, idosc INTEGER) RETURNS VOID AS $$
BEGIN
	INSERT INTO
		portal.tb_usuario (tx_email_usuario, tx_senha_usuario, tx_nome_usuario, nr_cpf_usuario, bo_lista_email, bo_ativo, dt_cadastro, dt_atualizacao)
	VALUES
		(email, senha, nome, cpf, newsletter, false, NOW(), NOW());
	
	INSERT INTO
		portal.tb_representacao (id_osc, id_usuario)
	VALUES
		(idosc, (SELECT id_usuario AS idusuario FROM portal.tb_usuario WHERE nr_cpf_usuario = cpf));
END;
$$ LANGUAGE 'plpgsql'