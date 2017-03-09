DROP FUNCTION IF EXISTS portal.inserir_projeto(id INTEGER, nomeprojeto TEXT, ftnomeprojeto TEXT, cdstatusprojeto INTEGER, ftstatusprojeto TEXT, dtdatainicioprojeto DATE, ftdatainicioprojeto TEXT, dtdatafimprojeto DATE, ftdatafimprojeto TEXT, nrvalortotalprojeto DOUBLE PRECISION, ftvalortotalprojeto TEXT, link_projeto TEXT, ftlinkprojeto TEXT, cdabrangenciaprojeto INTEGER, ftabrangenciaprojeto TEXT, descricaoprojeto TEXT, ftdescricaoprojeto TEXT, nrtotalbeneficiarios INTEGER, fttotalbeneficiarios TEXT, nrvalorcaptadoprojeto DOUBLE PRECISION, ftvalorcaptadoprojeto TEXT, cdzonaatuacaoprojeto INTEGER, ftzonaatuacao_projeto TEXT, metodologiamonitoramento TEXT, ftmetodologiamonitoramento TEXT, identificadorprojetoexterno TEXT, ftidentificadorprojetoexterno TEXT);

CREATE OR REPLACE FUNCTION portal.inserir_projeto(id INTEGER, nomeprojeto TEXT, ftnomeprojeto TEXT, cdstatusprojeto INTEGER, ftstatusprojeto TEXT, dtdatainicioprojeto DATE, ftdatainicioprojeto TEXT, dtdatafimprojeto DATE, ftdatafimprojeto TEXT, nrvalortotalprojeto DOUBLE PRECISION, ftvalortotalprojeto TEXT, link_projeto TEXT, ftlinkprojeto TEXT, cdabrangenciaprojeto INTEGER, ftabrangenciaprojeto TEXT, descricaoprojeto TEXT, ftdescricaoprojeto TEXT, nrtotalbeneficiarios INTEGER, fttotalbeneficiarios TEXT, nrvalorcaptadoprojeto DOUBLE PRECISION, ftvalorcaptadoprojeto TEXT, cdzonaatuacaoprojeto INTEGER, ftzonaatuacao_projeto TEXT, metodologiamonitoramento TEXT, ftmetodologiamonitoramento TEXT, identificadorprojetoexterno TEXT, ftidentificadorprojetoexterno TEXT, oficial BOOLEAN)
 RETURNS INTEGER AS $$

DECLARE
	id_projeto_osc INTEGER;
	status BOOLEAN;	

BEGIN
	INSERT INTO osc.tb_projeto (id_projeto, id_osc, tx_nome_projeto, ft_nome_projeto, cd_status_projeto, ft_status_projeto, dt_data_inicio_projeto, ft_data_inicio_projeto, dt_data_fim_projeto, ft_data_fim_projeto, nr_valor_total_projeto, ft_valor_total_projeto, tx_link_projeto, ft_link_projeto, cd_abrangencia_projeto, ft_abrangencia_projeto, tx_descricao_projeto, ft_descricao_projeto, nr_total_beneficiarios, ft_total_beneficiarios, nr_valor_captado_projeto, ft_valor_captado_projeto, cd_zona_atuacao_projeto, ft_zona_atuacao_projeto, tx_metodologia_monitoramento, ft_metodologia_monitoramento, tx_identificador_projeto_externo, ft_identificador_projeto_externo, bo_oficial) 
	VALUES (DEFAULT, id, nomeprojeto, ftnomeprojeto, cdstatusprojeto, ftstatusprojeto, dtdatainicioprojeto, ftdatainicioprojeto, dtdatafimprojeto, ftdatafimprojeto, nrvalortotalprojeto, ftvalortotalprojeto, link_projeto, ftlinkprojeto, cdabrangenciaprojeto, ftabrangenciaprojeto, descricaoprojeto, ftdescricaoprojeto, nrtotalbeneficiarios, fttotalbeneficiarios, nrvalorcaptadoprojeto, ftvalorcaptadoprojeto, cdzonaatuacaoprojeto, ftzonaatuacao_projeto, metodologiamonitoramento, ftmetodologiamonitoramento, identificadorprojetoexterno, ftidentificadorprojetoexterno, oficial)
	RETURNING id_projeto INTO id_projeto_osc;

	status := true;
	RETURN id_projeto_osc;

EXCEPTION 
	WHEN others THEN 
		status := false;
		RETURN status;

END;
$$ LANGUAGE 'plpgsql';
