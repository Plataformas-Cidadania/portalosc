DROP FUNCTION IF EXISTS portal.atualizar_publico_beneficiado(idpublicobeneficiado INTEGER, txnomepublicobeneficiado TEXT, ftpublicobeneficiado TEXT);

CREATE OR REPLACE FUNCTION portal.atualizar_publico_beneficiado(idpublicobeneficiado INTEGER, txnomepublicobeneficiado TEXT, ftpublicobeneficiado TEXT)
 RETURNS TABLE(
	mensagem TEXT
)AS $$

BEGIN 
	UPDATE 
		osc.tb_publico_beneficiado 
	SET 
		tx_nome_publico_beneficiado = txnomepublicobeneficiado, 
		ft_publico_beneficiado = ftpublicobeneficiado
	WHERE 
		id_publico_beneficiado = idpublicobeneficiado;

	mensagem := 'Publico Beneficiado atualizado';
	RETURN NEXT;
END; 
$$ LANGUAGE 'plpgsql';
