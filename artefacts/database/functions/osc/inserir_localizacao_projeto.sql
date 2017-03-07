DROP FUNCTION IF EXISTS portal.inserir_localizacao_projeto(idprojeto INTEGER, idregiaolocalizacaoprojeto INTEGER, ftregiaolocalizacaoprojeto TEXT, nomeregiaolocalizacaoprojeto TEXT, ftnomeregiaolocalizacaoprojeto TEXT);

CREATE OR REPLACE FUNCTION portal.inserir_localizacao_projeto(idprojeto INTEGER, idregiaolocalizacaoprojeto INTEGER, ftregiaolocalizacaoprojeto TEXT, nomeregiaolocalizacaoprojeto TEXT, ftnomeregiaolocalizacaoprojeto TEXT, oficial BOOLEAN)
 RETURNS BOOLEAN AS $$

 DECLARE
	status BOOLEAN;	

BEGIN
	INSERT INTO osc.tb_localizacao_projeto (id_projeto, id_regiao_localizacao_projeto, ft_regiao_localizacao_projeto, tx_nome_regiao_localizacao_projeto, ft_nome_regiao_localizacao_projeto, bo_oficial)
	VALUES (idprojeto, idregiaolocalizacaoprojeto, ftregiaolocalizacaoprojeto, nomeregiaolocalizacaoprojeto, ftnomeregiaolocalizacaoprojeto, oficial);

	status := true;
	RETURN status;

EXCEPTION 
	WHEN others THEN 
		status := false;
		RETURN status;

END;
$$ LANGUAGE 'plpgsql';
