DROP FUNCTION IF EXISTS portal.atualizar_participacao_social_conferencia_outra(id INTEGER, idconferenciaoutra INTEGER, nomeconferenciadeclarada TEXT, ftconferenciadeclarada TEXT, ftconferenciadeclaradaoutra TEXT, dtanorealizacao DATE, ftanorealizacao TEXT, cdformaparticipacaoconferencia INTEGER, ftformaparticipacaoconferencia TEXT);

CREATE OR REPLACE FUNCTION portal.atualizar_participacao_social_conferencia_outra(id INTEGER, idconferenciaoutra INTEGER, idconferenciadeclarada INTEGER, nomeconferenciadeclarada TEXT, ftconferenciadeclarada TEXT, ftconferenciadeclaradaoutra TEXT, dtanorealizacao DATE, ftanorealizacao TEXT, cdformaparticipacaoconferencia INTEGER, ftformaparticipacaoconferencia TEXT)
 RETURNS TABLE(
	mensagem TEXT
)AS $$

BEGIN 
	UPDATE 
		osc.tb_conferencia_declarada
	SET 
		tx_nome_conferencia_declarada = nomeconferenciadeclarada, 
		ft_conferencia_declarada = ftconferenciadeclarada	
	WHERE 
		id_conferencia_declarada = idconferenciadeclarada;

	UPDATE 
		osc.tb_participacao_social_conferencia_outra
	SET 
		ft_conferencia_declarada = ftconferenciadeclaradaoutra, 
		id_osc = id, 
		dt_ano_realizacao = dtanorealizacao, 
		ft_ano_realizacao = ftanorealizacao, 
		cd_forma_participacao_conferencia = cdformaparticipacaoconferencia, 
		ft_forma_participacao_conferencia = ftformaparticipacaoconferencia
	
	WHERE 
		id_conferencia_outra = idconferenciaoutra;
	
	mensagem := 'Participação Social Conferencia Outra atualizada';
	RETURN NEXT;
END; 
$$ LANGUAGE 'plpgsql';
