CREATE OR REPLACE FUNCTION portal.criar_usuario(email TEXT, senha TEXT, nome TEXT, cpf NUMERIC(11, 0), lista_email BOOLEAN, representacao INTEGER[], token TEXT) RETURNS TABLE(
	status BOOLEAN,
	mensagem TEXT,
	nova_representacao INTEGER[]
)AS $$
DECLARE
	idusuario INTEGER;
BEGIN
	IF ARRAY_LENGTH(representacao, 1) > 0 THEN	
		INSERT INTO
			portal.tb_usuario (tx_email_usuario, tx_senha_usuario, tx_nome_usuario, nr_cpf_usuario, bo_lista_email, bo_ativo, dt_cadastro, dt_atualizacao)
		VALUES
			(email, senha, nome, cpf, lista_email, false, NOW(), NOW());
		
		idusuario := (SELECT id_usuario FROM portal.tb_usuario WHERE nr_cpf_usuario = cpf);
		
		INSERT INTO
			portal.tb_token (id_usuario, cd_token, dt_data_token)
		VALUES
			(idusuario, token, NOW());
		
		status := true;
		mensagem := 'Usuário criado';
		nova_representacao := (SELECT portal.atualizar_representacao(idusuario, representacao));
		RETURN NEXT;
	ELSE
		status := false;
		mensagem := 'Campos obrigatórios não preenchido';
		RETURN NEXT;
	END IF;
	
EXCEPTION
	WHEN not_null_violation THEN
		status := false;
		mensagem := 'Campo(s) obrigatório(s) não preenchido(s)';
		RETURN NEXT;
	
	WHEN unique_violation THEN
		status := false;
		mensagem := 'Unicidade de campo(s) violada';
		RETURN NEXT;
	
	WHEN others THEN
		status := false;
		mensagem := 'Ocorreu um erro';
		RETURN NEXT;

END;
$$ LANGUAGE 'plpgsql'