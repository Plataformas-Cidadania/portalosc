DROP FUNCTION IF EXISTS portal.ativar_representante(id INTEGER);

CREATE OR REPLACE FUNCTION portal.ativar_representante(id INTEGER) RETURNS VOID AS $$ 
BEGIN 
	UPDATE 
		portal.tb_usuario 
	SET 
		bo_ativo = true, 
		dt_atualizacao = NOW() 
	WHERE 
		id_usuario = id; 
END; 
$$ LANGUAGE 'plpgsql';
