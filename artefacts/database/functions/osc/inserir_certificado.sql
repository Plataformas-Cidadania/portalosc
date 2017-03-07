DROP FUNCTION IF EXISTS portal.inserir_certificado(id INTEGER, cdcertificado INTEGER, ftcertificado TEXT, dtiniciocertificado DATE, ftiniciocertificado TEXT, dtfimcertificado DATE, ftfimcertificado TEXT);

CREATE OR REPLACE FUNCTION portal.inserir_certificado(id INTEGER, cdcertificado INTEGER, ftcertificado TEXT, dtiniciocertificado DATE, ftiniciocertificado TEXT, dtfimcertificado DATE, ftfimcertificado TEXT, oficial BOOLEAN)
 RETURNS BOOLEAN AS $$

DECLARE
	status BOOLEAN;	

BEGIN
	INSERT INTO osc.tb_certificado(id_osc, cd_certificado, ft_certificado, dt_inicio_certificado, ft_inicio_certificado, dt_fim_certificado, ft_fim_certificado, bo_oficial) 
	VALUES (id, cdcertificado, ftcertificado, dtiniciocertificado, ftiniciocertificado, dtfimcertificado, ftfimcertificado, oficial);

	status := true;
	RETURN status;

EXCEPTION 
	WHEN others THEN 
		status := false;
		RETURN status;

END;
$$ LANGUAGE 'plpgsql';
