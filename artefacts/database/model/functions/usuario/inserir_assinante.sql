DROP FUNCTION IF EXISTS portal.inserir_assinante(email TEXT, nome TEXT);

CREATE OR REPLACE FUNCTION portal.inserir_assinante(email TEXT, nome TEXT) RETURNS TABLE(
	status BOOLEAN,
	mensagem TEXT
)AS $$

DECLARE
	idusuario INTEGER;

BEGIN
	INSERT INTO 
		portal.tb_newsletters (tx_email_assinante, tx_nome_assinante) 
	VALUES 
		(email, nome);

	status := true;
	mensagem := 'Assinante cadastrado.';
	RETURN NEXT;

EXCEPTION 
	WHEN not_null_violation THEN 
		status := false;
		mensagem := 'O campo e-mail é obrigatório.';
		RETURN NEXT;

	WHEN unique_violation THEN 
		status := false;
		mensagem := 'Este e-mail já está sendo utilizado.';
		RETURN NEXT;

	WHEN others THEN 
		status := false;
		mensagem := 'Ocorreu um erro.';
		RETURN NEXT;

END;
$$ LANGUAGE 'plpgsql';