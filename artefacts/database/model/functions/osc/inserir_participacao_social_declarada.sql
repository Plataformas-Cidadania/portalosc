DROP FUNCTION IF EXISTS portal.inserir_participacao_social_declarada(id INTEGER, nomeparticipacaosocialdeclarada TEXT, ftnomeparticipacaosocialdeclarada TEXT, tipoparticipacaosocialdeclarada TEXT, fttipoparticipacaosocialdeclarada TEXT, dtingressoparticipacaosocialdeclarada DATE, ftdataingressoparticipacaosocialdeclarada TEXT);

CREATE OR REPLACE FUNCTION portal.inserir_participacao_social_declarada(id INTEGER, nomeparticipacaosocialdeclarada TEXT, ftnomeparticipacaosocialdeclarada TEXT, tipoparticipacaosocialdeclarada TEXT, fttipoparticipacaosocialdeclarada TEXT, dtingressoparticipacaosocialdeclarada DATE, ftdataingressoparticipacaosocialdeclarada TEXT)
 RETURNS BOOLEAN AS $$

DECLARE
	status BOOLEAN;	

BEGIN
	INSERT INTO osc.tb_participacao_social_declarada (id_osc, tx_nome_participacao_social_declarada, ft_nome_participacao_social_declarada, tx_tipo_participacao_social_declarada, ft_tipo_participacao_social_declarada, dt_data_ingresso_participacao_social_declarada, ft_data_ingresso_participacao_social_declarada) 
	VALUES (id, nomeparticipacaosocialdeclarada, ftnomeparticipacaosocialdeclarada, tipoparticipacaosocialdeclarada, fttipoparticipacaosocialdeclarada, dtingressoparticipacaosocialdeclarada, ftdataingressoparticipacaosocialdeclarada);

	status := true;
	RETURN status;

EXCEPTION 
	WHEN others THEN 
		status := false;
		RETURN status;

END;
$$ LANGUAGE 'plpgsql';
