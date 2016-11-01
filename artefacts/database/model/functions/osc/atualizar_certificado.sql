DROP FUNCTION IF EXISTS portal.atualizar_certificado(id INTEGER, idcertificado INTEGER, cdcertificado INTEGER, ftcertificado TEXT, dtiniciocertificado DATE, ftiniciocertificado TEXT, dtfimcertificado DATE, ftfimcertificado TEXT);

CREATE OR REPLACE FUNCTION portal.atualizar_certificado(id INTEGER, idcertificado INTEGER, cdcertificado INTEGER, ftcertificado TEXT, dtiniciocertificado DATE, ftiniciocertificado TEXT, dtfimcertificado DATE, ftfimcertificado TEXT)
 RETURNS TABLE(
	mensagem TEXT
)AS $$

BEGIN 
	UPDATE 
		osc.tb_certificado
	SET 
		id_osc = id, 
		cd_certificado = cdcertificado, 
		ft_certificado = ftcertificado, 
		dt_inicio_certificado = dtiniciocertificado, 
		ft_inicio_certificado = ftiniciocertificado, 
		dt_fim_certificado = dtfimcertificado, 
		ft_fim_certificado = ftfimcertificado
		 
	WHERE 
		id_certificado = idcertificado; 

	mensagem := 'Utilidade Publica Estadual atualizado';
	RETURN NEXT;
END; 
$$ LANGUAGE 'plpgsql';
