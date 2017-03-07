DROP FUNCTION IF EXISTS portal.inserir_area_atuacao_outra_projeto(id INTEGER, idprojeto INTEGER, nomeareaatuacaodeclarada TEXT, ftnomeareaatuacaodeclarada TEXT, ftareadeclarada TEXT, ftareaatuacaooutra TEXT);

CREATE OR REPLACE FUNCTION portal.inserir_area_atuacao_outra_projeto(id INTEGER, idprojeto INTEGER, nomeareaatuacaodeclarada TEXT, ftnomeareaatuacaodeclarada TEXT, ftareadeclarada TEXT, ftareaatuacaooutra TEXT)
 RETURNS BOOLEAN AS $$

DECLARE
	id_atuacao_declarada INTEGER;
	id_atuacao_outra INTEGER;
	status BOOLEAN;	

BEGIN
	INSERT INTO osc.tb_area_atuacao_declarada (id_area_atuacao_declarada, tx_nome_area_atuacao_declarada, ft_nome_area_atuacao_declarada) 
	VALUES (DEFAULT, nomeareaatuacaodeclarada, ftnomeareaatuacaodeclarada) 
	RETURNING id_area_atuacao_declarada INTO id_atuacao_declarada;
	
	INSERT INTO osc.tb_area_atuacao_outra (id_area_atuacao_outra, id_osc, id_area_atuacao_declarada, ft_area_atuacao_outra) 
	VALUES (DEFAULT, id, id_atuacao_declarada, ftareadeclarada)
	RETURNING id_area_atuacao_outra INTO id_atuacao_outra;

	INSERT INTO osc.tb_area_atuacao_outra_projeto (id_projeto, id_area_atuacao_outra, ft_area_atuacao_outra_projeto) 
	VALUES (idprojeto, id_atuacao_outra, ftareaatuacaooutra);

	status := true;
	RETURN status;

EXCEPTION 
	WHEN others THEN 
		status := false;
		RETURN status;

END;
$$ LANGUAGE 'plpgsql';