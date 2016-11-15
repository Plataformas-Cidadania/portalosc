DROP FUNCTION IF EXISTS portal.inserir_area_atuacao_outra(id INTEGER, ftareadeclarada TEXT, nomeareaatuacaodeclarada TEXT, ftnomeareaatuacaodeclarada TEXT);

CREATE OR REPLACE FUNCTION portal.inserir_area_atuacao_outra(id INTEGER, ftareadeclarada TEXT, nomeareaatuacaodeclarada TEXT, ftnomeareaatuacaodeclarada TEXT)
 RETURNS BOOLEAN AS $$

DECLARE
	id_declarada INTEGER;
	status BOOLEAN;	

BEGIN
	INSERT INTO osc.tb_area_atuacao_declarada (id_area_atuacao_declarada, tx_nome_area_atuacao_declarada, ft_nome_area_atuacao_declarada) 
	VALUES (DEFAULT, nomeareaatuacaodeclarada, ftnomeareaatuacaodeclarada) 
	RETURNING id_area_atuacao_declarada INTO id_declarada;

	INSERT INTO osc.tb_area_atuacao_outra (id_osc, id_area_atuacao_declarada, ft_area_atuacao_outra) 
	VALUES (id, id_declarada, ftareadeclarada);

	status := true;
	RETURN status;

EXCEPTION 
	WHEN others THEN 
		status := false;
		RETURN status;

END;
$$ LANGUAGE 'plpgsql';
