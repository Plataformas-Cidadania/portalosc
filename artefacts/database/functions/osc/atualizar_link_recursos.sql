DROP FUNCTION IF EXISTS portal.atualizar_link_recursos(id INTEGER, linkrelatorioauditoria TEXT, ftlinkrelatorioauditoria TEXT, linkdemonstracaocontabil TEXT, ftlinkdemonstracaocontabil TEXT);

CREATE OR REPLACE FUNCTION portal.atualizar_link_recursos(id INTEGER, linkrelatorioauditoria TEXT, ftlinkrelatorioauditoria TEXT, linkdemonstracaocontabil TEXT, ftlinkdemonstracaocontabil TEXT)
  RETURNS TABLE(
	mensagem TEXT
)AS $$

BEGIN
	UPDATE 
		osc.tb_dados_gerais 
	SET 
		tx_link_relatorio_auditoria = linkrelatorioauditoria, 
		ft_link_relatorio_auditoria = ftlinkrelatorioauditoria, 
		tx_link_demonstracao_contabil = linkdemonstracaocontabil, 
		ft_link_demonstracao_contabil = ftlinkdemonstracaocontabil
		 
	WHERE 
		id_osc = id; 

	mensagem := 'Link Recursos atualizado';
	RETURN NEXT;
END; 
$$ LANGUAGE 'plpgsql';
