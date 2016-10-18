DROP FUNCTION IF EXISTS portal.obter_osc_projeto(param TEXT);

CREATE OR REPLACE FUNCTION portal.obter_osc_projeto(param TEXT) RETURNS TABLE (
    id_projeto INTEGER, 
	tx_identificador_projeto_externo TEXT, 
	ft_identificador_projeto_externo TEXT, 
    tx_nome_projeto TEXT, 
    ft_nome_projeto TEXT, 
    tx_nome_status_projeto TEXT, 
    ft_status_projeto TEXT, 
    dt_data_inicio_projeto DATE, 
    ft_data_inicio_projeto TEXT, 
    dt_data_fim_projeto DATE, 
    ft_data_fim_projeto TEXT, 
    tx_link_projeto TEXT, 
    ft_link_projeto TEXT, 
    nr_total_beneficiarios SMALLINT, 
    ft_total_beneficiarios TEXT, 
    nr_valor_total_projeto DOUBLE PRECISION, 
    ft_valor_total_projeto TEXT, 
    nr_valor_captado_projeto DOUBLE PRECISION, 
    ft_valor_captado_projeto TEXT, 
    tx_metodologia_monitoramento TEXT, 
    ft_metodologia_monitoramento TEXT, 
    tx_descricao_projeto TEXT, 
    ft_descricao_projeto TEXT, 
    tx_nome_abrangencia_projeto TEXT, 
    ft_abrangencia_projeto TEXT, 
    tx_nome_zona_atuacao TEXT, 
    ft_zona_atuacao_projeto TEXT
) AS $$ 
BEGIN 
	RETURN QUERY 
		SELECT 
			vw_osc_projeto.id_projeto, 
			vw_osc_projeto.tx_identificador_projeto_externo, 
			vw_osc_projeto.ft_identificador_projeto_externo, 
			vw_osc_projeto.tx_nome_projeto, 
			vw_osc_projeto.ft_nome_projeto, 
			vw_osc_projeto.tx_nome_status_projeto, 
			vw_osc_projeto.ft_status_projeto, 
			vw_osc_projeto.dt_data_inicio_projeto, 
			vw_osc_projeto.ft_data_inicio_projeto, 
			vw_osc_projeto.dt_data_fim_projeto, 
			vw_osc_projeto.ft_data_fim_projeto, 
			vw_osc_projeto.tx_link_projeto, 
			vw_osc_projeto.ft_link_projeto, 
			vw_osc_projeto.nr_total_beneficiarios, 
			vw_osc_projeto.ft_total_beneficiarios, 
			vw_osc_projeto.nr_valor_total_projeto, 
			vw_osc_projeto.ft_valor_total_projeto, 
			vw_osc_projeto.nr_valor_captado_projeto, 
			vw_osc_projeto.ft_valor_captado_projeto, 
			vw_osc_projeto.tx_metodologia_monitoramento, 
			vw_osc_projeto.ft_metodologia_monitoramento, 
			vw_osc_projeto.tx_descricao_projeto, 
			vw_osc_projeto.ft_descricao_projeto, 
			vw_osc_projeto.tx_nome_abrangencia_projeto, 
			vw_osc_projeto.ft_abrangencia_projeto, 
			vw_osc_projeto.tx_nome_zona_atuacao, 
			vw_osc_projeto.ft_zona_atuacao_projeto 
		FROM 
			portal.vw_osc_projeto 
		WHERE 
			vw_osc_projeto.id_osc::TEXT = param OR 
			vw_osc_projeto.tx_url_osc = param;
	RETURN;
END;
$$ LANGUAGE 'plpgsql';
