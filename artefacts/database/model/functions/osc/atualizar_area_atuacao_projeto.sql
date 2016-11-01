DROP FUNCTION IF EXISTS portal.atualizar_area_atuacao_projeto(idareaatuacaodeclarada INTEGER, nomeareaatuacaodeclarada TEXT, ftnomeareaatuacaodeclarada TEXT);

CREATE OR REPLACE FUNCTION portal.atualizar_area_atuacao_projeto(idareaatuacaodeclarada INTEGER, nomeareaatuacaodeclarada TEXT, ftnomeareaatuacaodeclarada TEXT)
 RETURNS TABLE(
	mensagem TEXT
)AS $$

BEGIN 
	UPDATE 
		osc.tb_area_atuacao_declarada
	SET 
		tx_nome_area_atuacao_declarada = nomeareaatuacaodeclarada, 
		ft_nome_area_atuacao_declarada = ftnomeareaatuacaodeclarada
		 
	WHERE 
		id_area_atuacao_declarada = idareaatuacaodeclarada; 

	mensagem := 'Area Atuacao Declarada atualizada';
	RETURN NEXT;
END; 
$$ LANGUAGE 'plpgsql';
