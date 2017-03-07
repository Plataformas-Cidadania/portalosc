DROP FUNCTION IF EXISTS portal.inserir_participacao_social_outra(id INTEGER, nomeparticipacaosocialoutra TEXT, ftparticipacaosocialoutra TEXT);

CREATE OR REPLACE FUNCTION portal.inserir_participacao_social_outra(id INTEGER, nomeparticipacaosocialoutra TEXT, ftparticipacaosocialoutra TEXT, oficial BOOLEAN)
 RETURNS BOOLEAN AS $$

DECLARE
	status BOOLEAN;	

BEGIN
	INSERT INTO osc.tb_participacao_social_outra (id_osc, tx_nome_participacao_social_outra, ft_participacao_social_outra, bo_oficial) 
	VALUES (id, nomeparticipacaosocialoutra, ftparticipacaosocialoutra, oficial);

	status := true;
	RETURN status;

EXCEPTION 
	WHEN others THEN 
		status := false;
		RETURN status;

END;
$$ LANGUAGE 'plpgsql';
