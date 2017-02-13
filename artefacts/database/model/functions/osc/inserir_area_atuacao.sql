DROP FUNCTION IF EXISTS portal.inserir_area_atuacao(id INTEGER, areaatuacao INTEGER, ftareaatuacao TEXT, subareaatuacao INTEGER);

CREATE OR REPLACE FUNCTION portal.inserir_area_atuacao(id INTEGER, areaatuacao INTEGER, subareaatuacao INTEGER, areaatuacaooutra TEXT, ftareaatuacao TEXT, oficial BOOLEAN)
 RETURNS BOOLEAN AS $$

DECLARE
	status BOOLEAN;	

BEGIN
	INSERT INTO osc.tb_area_atuacao (id_osc, cd_area_atuacao, cd_subarea_atuacao, tx_nome_outra, ft_area_atuacao, bo_oficial) 
	VALUES (id, areaatuacao, subareaatuacao, areaatuacaooutra, ftareaatuacao, oficial);

	status := true;
	RETURN status;

EXCEPTION 
	WHEN others THEN 
		status := false;
		RETURN status;

END;
$$ LANGUAGE 'plpgsql';
