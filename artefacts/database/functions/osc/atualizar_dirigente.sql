DROP FUNCTION IF EXISTS portal.atualizar_dirigente(id INTEGER, iddirigente INTEGER, cargo TEXT, ftcargo TEXT, nome TEXT, ftnome TEXT);

CREATE OR REPLACE FUNCTION portal.atualizar_dirigente(id INTEGER, iddirigente INTEGER, cargo TEXT, ftcargo TEXT, nome TEXT, ftnome TEXT)
 RETURNS TABLE(
	mensagem TEXT
)AS $$

BEGIN 
	UPDATE 
		osc.tb_governanca
	SET 
		id_osc = id, 
		tx_cargo_dirigente = cargo, 
		ft_cargo_dirigente = ftcargo, 
		tx_nome_dirigente = nome, 
		ft_nome_dirigente = ftnome
		 
	WHERE 
		id_dirigente = iddirigente; 

	mensagem := 'Dirigente atualizado';
	RETURN NEXT;
END; 
$$ LANGUAGE 'plpgsql';
