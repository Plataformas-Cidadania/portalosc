DROP FUNCTION IF EXISTS portal.inserir_participacao_social_outra(id INTEGER, nomeparticipacaosocialoutra TEXT, ftparticipacaosocialoutra TEXT);

CREATE OR REPLACE FUNCTION portal.inserir_participacao_social_outra(id INTEGER, nomeparticipacaosocialoutra TEXT, ftparticipacaosocialoutra TEXT)
 RETURNS BOOLEAN AS $$

DECLARE
	status BOOLEAN;	

BEGIN
	INSERT INTO osc.tb_participacao_social_outra (id_osc, tx_nome_participacao_social_outra, ft_participacao_social_outra) 
	VALUES (id, nomeparticipacaosocialoutra, ftparticipacaosocialoutra);

	status := true;
	RETURN status;

EXCEPTION 
	WHEN others THEN 
		status := false;
		RETURN status;

END;
$$ LANGUAGE 'plpgsql';
