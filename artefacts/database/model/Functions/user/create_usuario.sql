CREATE OR REPLACE FUNCTION portal.create_usuario(email TEXT, senha TEXT, nome TEXT, cpf NUMERIC(11, 0), newsletter BOOLEAN, idosc INTEGER, token TEXT) RETURNS VOID AS $$
DECLARE
	idusuario INTEGER;
BEGIN
	INSERT INTO
		portal.tb_usuario (tx_email_usuario, tx_senha_usuario, tx_nome_usuario, nr_cpf_usuario, bo_lista_email, bo_ativo, dt_cadastro, dt_atualizacao)
	VALUES
		(email, senha, nome, cpf, newsletter, false, NOW(), NOW());
	
	idusuario := (SELECT id_usuario FROM portal.tb_usuario WHERE nr_cpf_usuario = cpf);
	
	INSERT INTO
		portal.tb_token (id_usuario, cd_token, dt_data_token)
	VALUES
		(idusuario, token, NOW());
	
	INSERT INTO
		portal.tb_representacao (id_osc, id_usuario)
	VALUES
		(idosc, idusuario);
END;
$$ LANGUAGE 'plpgsql'