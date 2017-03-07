DROP FUNCTION IF EXISTS portal.atualizar_localizacao_projeto(idprojeto INTEGER, idlocalizacaoprojeto INTEGER, idregiaolocalizacaoprojeto INTEGER, ftregiaolocalizacaoprojeto TEXT, nomeregiaolocalizacaoprojeto TEXT, ftnomeregiaolocalizacaoprojeto TEXT);

CREATE OR REPLACE FUNCTION portal.atualizar_localizacao_projeto(idprojeto INTEGER, idlocalizacaoprojeto INTEGER, idregiaolocalizacaoprojeto INTEGER, ftregiaolocalizacaoprojeto TEXT, nomeregiaolocalizacaoprojeto TEXT, ftnomeregiaolocalizacaoprojeto TEXT)
 RETURNS TABLE(
	mensagem TEXT
)AS $$

BEGIN 
	UPDATE 
		osc.tb_localizacao_projeto
	SET 
		id_projeto = idprojeto, 
		id_regiao_localizacao_projeto = idregiaolocalizacaoprojeto, 
		ft_regiao_localizacao_projeto = ftregiaolocalizacaoprojeto, 
		tx_nome_regiao_localizacao_projeto = nomeregiaolocalizacaoprojeto, 
		ft_nome_regiao_localizacao_projeto = ftnomeregiaolocalizacaoprojeto
		 
	WHERE 
		id_localizacao_projeto = idlocalizacaoprojeto; 

	mensagem := 'Localizacao Projeto atualizada';
	RETURN NEXT;
END; 
$$ LANGUAGE 'plpgsql';
