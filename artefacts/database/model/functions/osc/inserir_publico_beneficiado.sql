DROP FUNCTION IF EXISTS portal.inserir_publico_beneficiado(idprojeto INTEGER, nomepublicobeneficiado TEXT, ftpublicobeneficiado TEXT, ftpublicobeneficiadoprojeto TEXT);

CREATE OR REPLACE FUNCTION portal.inserir_publico_beneficiado(idprojeto INTEGER, nomepublicobeneficiado TEXT, ftpublicobeneficiado TEXT, ftpublicobeneficiadoprojeto TEXT)
 RETURNS BOOLEAN AS $$

DECLARE
	id_publico INTEGER;
	status BOOLEAN;	

BEGIN
	INSERT INTO osc.tb_publico_beneficiado (id_publico_beneficiado, tx_nome_publico_beneficiado, ft_publico_beneficiado) 
	VALUES (DEFAULT, nomepublicobeneficiado, ftpublicobeneficiado) 
	RETURNING id_publico_beneficiado INTO id_publico;
	
	INSERT INTO osc.tb_publico_beneficiado_projeto (id_projeto, id_publico_beneficiado, ft_publico_beneficiado_projeto) 
	VALUES (idprojeto, id_publico, ftpublicobeneficiadoprojeto);

	status := true;
	RETURN status;

EXCEPTION 
	WHEN others THEN 
		status := false;
		RETURN status;

END;
$$ LANGUAGE 'plpgsql';
