DROP FUNCTION IF EXISTS portal.criar_representante(email TEXT, senha TEXT, nome TEXT, cpf NUMERIC(11, 0), lista_email BOOLEAN, representacao INTEGER[], token TEXT);

CREATE OR REPLACE FUNCTION portal.criar_representante(email TEXT, senha TEXT, nome TEXT, cpf NUMERIC(11, 0), lista_email BOOLEAN, representacao INTEGER[], token TEXT) RETURNS TABLE(
	status BOOLEAN,
	mensagem TEXT,
	nova_representacao INTEGER[]
)AS $$

DECLARE
	idusuario INTEGER;

BEGIN
	IF ARRAY_LENGTH(representacao, 1) > 0 THEN 
		INSERT INTO 
			portal.tb_usuario (cd_tipo_usuario, tx_email_usuario, tx_senha_usuario, tx_nome_usuario, nr_cpf_usuario, bo_lista_email, bo_ativo, dt_cadastro, dt_atualizacao) 
		VALUES 
			(2, email, senha, nome, cpf, lista_email, false, NOW(), NOW());

		idusuario := (SELECT id_usuario FROM portal.tb_usuario WHERE nr_cpf_usuario = cpf);

		PERFORM portal.inserir_token_usuario(idusuario::INTEGER, token::TEXT, (NOW() + (30 * interval '1 day'))::DATE);
		
		PERFORM portal.atualizar_representacao(idusuario, representacao);

		status := true;
		mensagem := 'Usuário criado';
		RETURN NEXT;
	ELSE 
		status := false;
		mensagem := 'Campos obrigatórios não preenchido';
		RETURN NEXT;
	END IF;

EXCEPTION 
	WHEN not_null_violation THEN 
		status := false;
		mensagem := 'Campo(s) obrigatório(s) não foram preenchido(s)';
		RETURN NEXT;

	WHEN unique_violation THEN 
		status := false;
		mensagem := 'Este CPF e/ou e-mail já está(ão) sendo utilizado(s).';
		RETURN NEXT;

	WHEN others THEN 
		status := false;
		mensagem := 'Ocorreu um erro';
		RETURN NEXT;

END;
$$ LANGUAGE 'plpgsql';