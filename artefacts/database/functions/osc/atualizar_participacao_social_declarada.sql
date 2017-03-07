DROP FUNCTION IF EXISTS portal.atualizar_participacao_social_declarada(id INTEGER, idparticipacaosocialdeclarada INTEGER, nomeparticipacaosocialdeclarada TEXT, ftnomeparticipacaosocialdeclarada TEXT, tipoparticipacaosocialdeclarada TEXT, fttipoparticipacaosocialdeclarada TEXT, dtingressoparticipacaosocialdeclarada DATE, ftdataingressoparticipacaosocialdeclarada TEXT);

CREATE OR REPLACE FUNCTION portal.atualizar_participacao_social_declarada(id INTEGER, idparticipacaosocialdeclarada INTEGER, nomeparticipacaosocialdeclarada TEXT, ftnomeparticipacaosocialdeclarada TEXT, tipoparticipacaosocialdeclarada TEXT, fttipoparticipacaosocialdeclarada TEXT, dtingressoparticipacaosocialdeclarada DATE, ftdataingressoparticipacaosocialdeclarada TEXT)
 RETURNS TABLE(
	mensagem TEXT
)AS $$

BEGIN 

	UPDATE 
		osc.tb_participacao_social_declarada
	SET 
		id_osc = id, 
		tx_nome_participacao_social_declarada = nomeparticipacaosocialdeclarada, 
		ft_nome_participacao_social_declarada = ftnomeparticipacaosocialdeclarada, 
		tx_tipo_participacao_social_declarada = tipoparticipacaosocialdeclarada, 
		ft_tipo_participacao_social_declarada = fttipoparticipacaosocialdeclarada, 
		dt_data_ingresso_participacao_social_declarada = dtingressoparticipacaosocialdeclarada, 
		ft_data_ingresso_participacao_social_declarada = ftdataingressoparticipacaosocialdeclarada 
	WHERE 
		id_participacao_social_declarada = idparticipacaosocialdeclarada;
	
	mensagem := 'Participação Social Declarada atualizada';
	RETURN NEXT;
END; 
$$ LANGUAGE 'plpgsql';
