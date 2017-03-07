DROP FUNCTION IF EXISTS portal.atualizar_projeto(id INTEGER, idprojeto INTEGER, nomeprojeto TEXT, ftnomeprojeto TEXT, cdstatusprojeto INTEGER, ftstatusprojeto TEXT, dtdatainicioprojeto DATE, ftdatainicioprojeto TEXT, dtdatafimprojeto DATE, ftdatafimprojeto TEXT, nrvalortotalprojeto DOUBLE PRECISION, ftvalortotalprojeto TEXT, link_projeto TEXT, ftlinkprojeto TEXT, cdabrangenciaprojeto INTEGER, ftabrangenciaprojeto TEXT, descricaoprojeto TEXT, ftdescricaoprojeto TEXT, nrtotalbeneficiarios SMALLINT, fttotalbeneficiarios TEXT, nrvalorcaptadoprojeto DOUBLE PRECISION, ftvalorcaptadoprojeto TEXT, cdzonaatuacaoprojeto INTEGER, ftzonaatuacao_projeto TEXT, metodologiamonitoramento TEXT, ftmetodologiamonitoramento TEXT, identificadorprojetoexterno TEXT, ftidentificadorprojetoexterno TEXT);

CREATE OR REPLACE FUNCTION portal.atualizar_projeto(id INTEGER, idprojeto INTEGER, nomeprojeto TEXT, ftnomeprojeto TEXT, cdstatusprojeto INTEGER, ftstatusprojeto TEXT, dtdatainicioprojeto DATE, ftdatainicioprojeto TEXT, dtdatafimprojeto DATE, ftdatafimprojeto TEXT, nrvalortotalprojeto DOUBLE PRECISION, ftvalortotalprojeto TEXT, link_projeto TEXT, ftlinkprojeto TEXT, cdabrangenciaprojeto INTEGER, ftabrangenciaprojeto TEXT, descricaoprojeto TEXT, ftdescricaoprojeto TEXT, nrtotalbeneficiarios SMALLINT, fttotalbeneficiarios TEXT, nrvalorcaptadoprojeto DOUBLE PRECISION, ftvalorcaptadoprojeto TEXT, cdzonaatuacaoprojeto INTEGER, ftzonaatuacao_projeto TEXT, metodologiamonitoramento TEXT, ftmetodologiamonitoramento TEXT, identificadorprojetoexterno TEXT, ftidentificadorprojetoexterno TEXT)
  RETURNS TABLE(
	mensagem TEXT
)AS $$

BEGIN 
	UPDATE 
		osc.tb_projeto 
	SET 
		id_osc = id, 
		tx_nome_projeto = nomeprojeto, 
		ft_nome_projeto = ftnomeprojeto, 
		cd_status_projeto = cdstatusprojeto, 
		ft_status_projeto = ftstatusprojeto, 
		dt_data_inicio_projeto = dtdatainicioprojeto, 
		ft_data_inicio_projeto = ftdatainicioprojeto, 
		dt_data_fim_projeto = dtdatafimprojeto, 
		ft_data_fim_projeto = ftdatafimprojeto, 
		nr_valor_total_projeto = nrvalortotalprojeto, 
		ft_valor_total_projeto = ftvalortotalprojeto, 
		tx_link_projeto = link_projeto, 
		ft_link_projeto = ftlinkprojeto, 
		cd_abrangencia_projeto = cdabrangenciaprojeto, 
		ft_abrangencia_projeto = ftabrangenciaprojeto, 
		tx_descricao_projeto = descricaoprojeto, 
		ft_descricao_projeto = ftdescricaoprojeto, 
		nr_total_beneficiarios = nrtotalbeneficiarios, 
		ft_total_beneficiarios = fttotalbeneficiarios, 
		nr_valor_captado_projeto = nrvalorcaptadoprojeto, 
		ft_valor_captado_projeto = ftvalorcaptadoprojeto, 
		cd_zona_atuacao_projeto = cdzonaatuacaoprojeto, 
		ft_zona_atuacao_projeto = ftzonaatuacao_projeto, 
		tx_metodologia_monitoramento = metodologiamonitoramento, 
		ft_metodologia_monitoramento = ftmetodologiamonitoramento, 
		tx_identificador_projeto_externo = identificadorprojetoexterno, 
		ft_identificador_projeto_externo = ftidentificadorprojetoexterno 
	WHERE 
		id_projeto = idprojeto; 

	mensagem := 'Projeto atualizado';
	RETURN NEXT;
END; 
$$ LANGUAGE 'plpgsql';
