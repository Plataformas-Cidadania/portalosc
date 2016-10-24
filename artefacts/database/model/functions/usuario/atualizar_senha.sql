CREATE OR REPLACE FUNCTION portal.atualizar_senha(id INTEGER, senha TEXT) RETURNS TABLE(
	status BOOLEAN,
	mensagem TEXT
)AS $$
BEGIN
		UPDATE
			portal.tb_usuario
		SET
			tx_senha_usuario = senha,
			dt_atualizacao = NOW()
		WHERE
			tb_usuario.id_usuario = id;

		status := true;
		mensagem := 'Senha atualizada';
		RETURN NEXT;

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
