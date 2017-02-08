DROP FUNCTION IF EXISTS portal.excluir_certificado(id INTEGER, certificado INTEGER);

CREATE OR REPLACE FUNCTION portal.excluir_certificado(id INTEGER, certificado INTEGER) RETURNS VOID AS $$ 
BEGIN 
	DELETE FROM 
		osc.tb_certificado 
	WHERE 
		id_certificado = id AND 
		cd_certificado = certificado;
END; 
$$ LANGUAGE 'plpgsql';
