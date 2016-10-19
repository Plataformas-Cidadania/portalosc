DROP FUNCTION IF EXISTS portal.logar_representante(email TEXT, senha TEXT);

CREATE OR REPLACE FUNCTION portal.logar_representante(email TEXT, senha TEXT) RETURNS TABLE(
	id_usuario INTEGER, 
	tx_nome_usuario TEXT
) AS $$
BEGIN 
	RETURN QUERY 
		SELECT 
			tb_usuario.id_usuario, 
			tb_usuario.tx_nome_usuario 
		FROM 
			portal.tb_usuario 
		WHERE 
			tx_email_usuario = email AND 
			tx_senha_usuario = senha; 
END; 
$$ LANGUAGE 'plpgsql';
