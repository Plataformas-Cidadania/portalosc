DROP FUNCTION IF EXISTS portal.atualizar_conselho_fiscal(id INTEGER, idconselheiro INTEGER, nomeconselheiro TEXT, ftnomeconselheiro TEXT, cargoconselheiro TEXT, ftcargoconselheiro TEXT);

CREATE OR REPLACE FUNCTION portal.atualizar_conselho_fiscal(id INTEGER, idconselheiro INTEGER, nomeconselheiro TEXT, ftnomeconselheiro TEXT)
  RETURNS TABLE(
	mensagem TEXT
)AS $$

BEGIN
	UPDATE 
		osc.tb_conselho_fiscal 
	SET 
		id_osc = id, 
		tx_nome_conselheiro = nomeconselheiro, 
		ft_nome_conselheiro = ftnomeconselheiro
    	WHERE 
		id_conselheiro = idconselheiro;

	mensagem := 'Conselho Fiscal atualizado';
	RETURN NEXT;
END; 
$$ LANGUAGE 'plpgsql';
