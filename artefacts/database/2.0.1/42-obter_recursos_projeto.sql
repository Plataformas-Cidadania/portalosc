DROP FUNCTION IF EXISTS portal.obter_recursos_projeto(text);

CREATE OR REPLACE FUNCTION portal.obter_recursos_projeto(IN param text)
  RETURNS TABLE(nr_valor_total double precision, tx_link_relatorio_auditoria text, ft_link_relatorio_auditoria text, tx_link_demonstracao_contabil text, ft_link_demonstracao_contabil text) AS
$BODY$ 
BEGIN 
	RETURN QUERY 
		SELECT 
			vw_osc_recursos_projeto.nr_valor_total, 
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
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;