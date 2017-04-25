DROP FUNCTION IF EXISTS portal.atualizar_participacao_social_conferencia_outra(IN id integer, IN idconferenciaoutra integer, IN idconferenciadeclarada integer, IN nomeconferenciadeclarada text, IN ftconferenciadeclarada text, IN ftconferenciadeclaradaoutra text, IN dtanorealizacao date, IN ftanorealizacao text, IN cdformaparticipacaoconferencia integer, IN ftformaparticipacaoconferencia text);

CREATE OR REPLACE FUNCTION portal.atualizar_participacao_social_conferencia_outra(id integer, idconferencia integer, idconferenciaoutra integer, cdconferencia integer, ftconferencia text, nomeconferencia text, ftnomeconferencia text, 
dtanorealizacao date, ftanorealizacao text, cdformaparticipacaoconferencia integer, ftformaparticipacaoconferencia text)

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
		id_conferencia_outra = idconferenciaoutra;

	UPDATE 
		osc.tb_participacao_social_conferencia
	SET 
		cd_conferencia = cdconferencia, 
		ft_conferencia = ftconferencia, 
		dt_ano_realizacao = dtanorealizacao, 
		ft_ano_realizacao = ftanorealizacao, 
		cd_forma_participacao_conferencia = cdformaparticipacaoconferencia, 
		ft_forma_participacao_conferencia = ftformaparticipacaoconferencia

	WHERE 
		id_conferencia = idconferencia AND id_osc = id;
	
	mensagem := 'Participação Social Conferencia Outra atualizada';
	RETURN NEXT;
END; 
$$ LANGUAGE 'plpgsql';
