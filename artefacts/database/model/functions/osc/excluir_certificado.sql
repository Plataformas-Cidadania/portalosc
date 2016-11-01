DROP FUNCTION IF EXISTS portal.excluir_certificado(id INTEGER);

CREATE OR REPLACE FUNCTION portal.excluir_certificado(id INTEGER) RETURNS VOID AS $$ 
BEGIN 
	DELETE FROM 
		osc.tb_certificado 
	WHERE 
		id_certificado = id;
END; 
$$ LANGUAGE 'plpgsql';
