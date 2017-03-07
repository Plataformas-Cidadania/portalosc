DROP FUNCTION IF EXISTS portal.atualizar_participacao_social_outra(id INTEGER, idparticipacaosocialoutra INTEGER, nomeparticipacaosocialoutra TEXT, ftparticipacaosocialoutra TEXT);

CREATE OR REPLACE FUNCTION portal.atualizar_participacao_social_outra(id INTEGER, idparticipacaosocialoutra INTEGER, nomeparticipacaosocialoutra TEXT, ftparticipacaosocialoutra TEXT)
 RETURNS TABLE(
	mensagem TEXT
)AS $$

BEGIN 

	UPDATE 
		osc.tb_participacao_social_outra
	SET 
		id_osc = id, 
		tx_nome_participacao_social_outra = nomeparticipacaosocialoutra, 
		ft_participacao_social_outra = ftparticipacaosocialoutra 
	WHERE 
		id_participacao_social_outra = idparticipacaosocialoutra;
	
	mensagem := 'Outra Participação Social atualizada';
	RETURN NEXT;
END; 
$$ LANGUAGE 'plpgsql';
