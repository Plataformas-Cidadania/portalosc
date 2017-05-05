DROP FUNCTION IF EXISTS portal.atualizar_participacao_social_conferencia_outra(IN id integer, IN idconferenciaoutra integer, IN idconferenciadeclarada integer, IN nomeconferenciadeclarada text, IN ftconferenciadeclarada text, IN ftconferenciadeclaradaoutra text, IN dtanorealizacao date, IN ftanorealizacao text, IN cdformaparticipacaoconferencia integer, IN ftformaparticipacaoconferencia text);

CREATE OR REPLACE FUNCTION portal.atualizar_participacao_social_conferencia_outra(nomeconferencia text, ftnomeconferencia text, idconferencia integer)

 RETURNS TABLE(
	mensagem TEXT
)AS $$

BEGIN 
	UPDATE 
		osc.tb_participacao_social_conferencia_outra
	SET 
		tx_nome_conferencia = nomeconferencia, 
		ft_nome_conferencia = ftnomeconferencia
	WHERE 
		id_conferencia = idconferencia;

	
	mensagem := 'Participação Social Conferencia Outra atualizada';
	RETURN NEXT;
END; 
$$ LANGUAGE 'plpgsql';
