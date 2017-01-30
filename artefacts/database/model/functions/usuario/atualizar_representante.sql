DROP FUNCTION IF EXISTS portal.atualizar_representante(id INTEGER, email TEXT, senha TEXT, nome TEXT, representacao INTEGER[]);

CREATE OR REPLACE FUNCTION portal.atualizar_representante(id INTEGER, email TEXT, senha TEXT, nome TEXT, representacao INTEGER[]) RETURNS TABLE(
	status BOOLEAN, 
	mensagem TEXT, 
	nova_representacao INTEGER[]
)AS $$
BEGIN 
	IF ARRAY_LENGTH(representacao, 1) > 0 THEN 
		IF senha IS NOT NULL THEN
			UPDATE 
				portal.tb_usuario 
			SET 
				tx_email_usuario = email, 
				tx_senha_usuario = senha, 
				tx_nome_usuario = nome, 
				dt_atualizacao = NOW() 
			WHERE 
				tb_usuario.id_usuario = id; 
		ELSE
			UPDATE 
				portal.tb_usuario 
			SET 
				tx_email_usuario = email, 
				tx_nome_usuario = nome, 
				dt_atualizacao = NOW() 
			WHERE 
				tb_usuario.id_usuario = id; 
		END IF; 
		
		status := true; 
		mensagem := 'Usuário atualizado'; 
		nova_representacao := (SELECT portal.atualizar_representacao(id, representacao)); 
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
$$ LANGUAGE 'plpgsql';
