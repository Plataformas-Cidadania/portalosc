DROP FUNCTION IF EXISTS portal.obter_recursos_projeto(param TEXT);

CREATE OR REPLACE FUNCTION portal.obter_recursos_projeto(param TEXT) RETURNS TABLE (
	nr_valor_total DOUBLE PRECISION, 
	nr_valor_federal DOUBLE PRECISION, 
	nr_valor_estadual DOUBLE PRECISION, 
	nr_valor_municipal DOUBLE PRECISION, 
	nr_valor_privado DOUBLE PRECISION, 
	nr_valor_proprio DOUBLE PRECISION, 
	tx_link_relatorio_auditoria TEXT, 
	ft_link_relatorio_auditoria TEXT, 
	tx_link_demonstracao_contabil TEXT, 
	ft_link_demonstracao_contabil TEXT
) AS $$ 
BEGIN 
	RETURN QUERY 
		SELECT 
			vw_osc_recursos_projeto.nr_valor_total, 
			vw_osc_recursos_projeto.nr_valor_federal, 
			vw_osc_recursos_projeto.nr_valor_estadual, 
			vw_osc_recursos_projeto.nr_valor_municipal, 
			vw_osc_recursos_projeto.nr_valor_privado, 
			vw_osc_recursos_projeto.nr_valor_proprio, 
			vw_osc_recursos_projeto.tx_link_relatorio_auditoria, 
			vw_osc_recursos_projeto.ft_link_relatorio_auditoria, 
			vw_osc_recursos_projeto.tx_link_demonstracao_contabil, 
			vw_osc_recursos_projeto.ft_link_demonstracao_contabil 
		FROM 
			portal.vw_osc_recursos_projeto 
		WHERE 
			vw_osc_recursos_projeto.id_osc::TEXT = param OR 
			vw_osc_recursos_projeto.tx_apelido_osc = param;
	RETURN;
END;
$$ LANGUAGE 'plpgsql';
