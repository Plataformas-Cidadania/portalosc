DROP FUNCTION IF EXISTS portal.atualizar_participacao_social_conferencia(id INTEGER, idconferencia INTEGER, cdconferencia INTEGER, ftconferencia TEXT, dtanorealizacao DATE, ftanorealizacao TEXT, cdformaparticipacaoconferencia INTEGER, ftformaparticipacaoconferencia TEXT);

CREATE OR REPLACE FUNCTION portal.atualizar_participacao_social_conferencia(id INTEGER, idconferencia INTEGER, cdconferencia INTEGER, ftconferencia TEXT, dtanorealizacao DATE, ftanorealizacao TEXT, cdformaparticipacaoconferencia INTEGER, ftformaparticipacaoconferencia TEXT)
 RETURNS TABLE(
	mensagem TEXT
)AS $$

BEGIN 

	UPDATE 
		osc.tb_participacao_social_conferencia
	SET 
		cd_conferencia = cdconferencia, 
		ft_conferencia = ftconferencia, 
		id_osc = id, 
		dt_ano_realizacao = dtanorealizacao, 
		ft_ano_realizacao = ftanorealizacao, 
		cd_forma_participacao_conferencia = cdformaparticipacaoconferencia, 
		ft_forma_participacao_conferencia = ftformaparticipacaoconferencia 

	WHERE 
		id_conferencia = idconferencia;
	
	mensagem := 'Participação Social Conferencia atualizada';
	RETURN NEXT;
END; 
$$ LANGUAGE 'plpgsql';
