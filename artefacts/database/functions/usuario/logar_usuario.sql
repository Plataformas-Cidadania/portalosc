DROP FUNCTION IF EXISTS portal.logar_usuario(email TEXT, senha TEXT);

CREATE OR REPLACE FUNCTION portal.logar_usuario(email TEXT, senha TEXT) RETURNS TABLE(
	id_usuario INTEGER, 
	cd_tipo_usuario INTEGER, 
	tx_nome_usuario TEXT,
	bo_ativo BOOLEAN
) AS $$
BEGIN 
	RETURN QUERY 
		SELECT 
			tb_usuario.id_usuario, 
			tb_usuario.cd_tipo_usuario, 
			tb_usuario.tx_nome_usuario, 
			tb_usuario.bo_ativo 
		FROM 
			portal.tb_usuario 
		WHERE 
			tx_email_usuario = email AND 
			tx_senha_usuario = senha; 
END; 
$$ LANGUAGE 'plpgsql';
