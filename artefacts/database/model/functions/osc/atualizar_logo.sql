DROP FUNCTION IF EXISTS portal.atualizar_logo(id INTEGER, img BYTEA);

CREATE OR REPLACE FUNCTION portal.atualizar_logo(id INTEGER, img BYTEA) 
 RETURNS TABLE(
	mensagem TEXT
)AS $$

BEGIN 
	UPDATE 
		osc.tb_dados_gerais
	SET 
		im_logo = img	 
	WHERE 
		id_osc = id; 

	mensagem := 'Logo atualizada';
	RETURN NEXT;
END; 
$$ LANGUAGE 'plpgsql';
