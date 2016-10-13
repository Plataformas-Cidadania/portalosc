CREATE OR REPLACE FUNCTION portal.inserir_token_usuario(idusuario INTEGER, token TEXT, tipo_token INTEGER) RETURNS BOOLEAN AS $$

DECLARE
	status BOOLEAN;

BEGIN
	IF (SELECT tb_token.id_usuario FROM portal.tb_token WHERE tb_token.id_usuario = id_usuario) THEN
		DELETE FROM portal.tb_token
		WHERE tb_token.id_usuario = idusuario;
	END IF;
	
	INSERT INTO portal.tb_token (id_usuario, cd_token, dt_data_token, cd_tipo_token)
	VALUES (idusuario, token, NOW(), tipo_token);
	
	status := true;
	RETURN status;

EXCEPTION
	WHEN others THEN
		status := false;
		RETURN status;

END;
$$ LANGUAGE 'plpgsql'