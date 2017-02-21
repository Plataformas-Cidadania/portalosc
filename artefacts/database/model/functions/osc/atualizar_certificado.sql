DROP FUNCTION IF EXISTS portal.atualizar_certificado(idosc INTEGER, cdcertificado INTEGER, dtiniciocertificado DATE, ftiniciocertificado TEXT, dtfimcertificado DATE, ftfimcertificado TEXT, booficial BOOLEAN);

CREATE OR REPLACE FUNCTION portal.atualizar_certificado(idosc INTEGER, cdcertificado INTEGER, dtiniciocertificado DATE, ftiniciocertificado TEXT, dtfimcertificado DATE, ftfimcertificado TEXT, booficial BOOLEAN)
 RETURNS TABLE(
	mensagem TEXT
)AS $$

BEGIN 
	UPDATE 
		osc.tb_certificado
	SET 
		dt_inicio_certificado = dtiniciocertificado, 
		ft_inicio_certificado = ftiniciocertificado, 
		dt_fim_certificado = dtfimcertificado, 
		ft_fim_certificado = ftfimcertificado, 
		bo_oficial = booficial 
	WHERE 
		id_osc = idosc AND 
		cd_certificado = cdcertificado; 

	mensagem := 'Certificados atualizado';
	RETURN NEXT;
END; 
$$ LANGUAGE 'plpgsql';
