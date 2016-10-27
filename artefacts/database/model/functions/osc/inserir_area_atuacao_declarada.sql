DROP FUNCTION IF EXISTS portal.inserir_area_atuacao_declarada(nomeareaatuacaodeclarada TEXT, ftnomeareaatuacaodeclarada TEXT);

CREATE OR REPLACE FUNCTION portal.inserir_area_atuacao_declarada(nomeareaatuacaodeclarada TEXT, ftnomeareaatuacaodeclarada TEXT)
 RETURNS INTEGER AS $$

DECLARE
	id INTEGER;

BEGIN
	INSERT INTO osc.tb_area_atuacao_declarada (id_area_atuacao_declarada, tx_nome_area_atuacao_declarada, ft_nome_area_atuacao_declarada) 
	VALUES (DEFAULT, nomeareaatuacaodeclarada, ftnomeareaatuacaodeclarada) 
	RETURNING id_area_atuacao_declarada INTO id;

	RETURN id;

END;
$$ LANGUAGE 'plpgsql';
