DROP FUNCTION IF EXISTS portal.atualizar_dados_gerais(id INTEGER, nomefantasia TEXT, ftnomefantasia TEXT, 
sigla TEXT, ft_sigla TEXT, situacaoimovel INTEGER, ftsituacaoimovel TEXT, nomeresponsavellegal TEXT, ftnomeresponsavellegal TEXT, 
anocadastrocnpj DATE, ftanocadastrocnpj TEXT, dtfundacao DATE, ftfundacao TEXT, resumo TEXT, ft_resumo TEXT);

CREATE OR REPLACE FUNCTION portal.atualizar_dados_gerais(id INTEGER, nomefantasia TEXT, ftnomefantasia TEXT, 
sigla TEXT, ft_sigla TEXT, situacaoimovel INTEGER, ftsituacaoimovel TEXT, nomeresponsavellegal TEXT, ftnomeresponsavellegal TEXT, 
anocadastrocnpj DATE, ftanocadastrocnpj TEXT, dtfundacao DATE, ftfundacao TEXT, resumo TEXT, ft_resumo TEXT) 
  RETURNS TABLE(
	mensagem TEXT
)AS $$

BEGIN 
	UPDATE 
		osc.tb_dados_gerais 
	SET 
		tx_nome_fantasia_osc = nomefantasia,
    		ft_nome_fantasia_osc = ftnomefantasia, 
    		tx_sigla_osc = sigla, 
    		ft_sigla_osc = ft_sigla, 
    		cd_situacao_imovel_osc = situacaoimovel, 
    		ft_situacao_imovel_osc = ftsituacaoimovel, 
    		tx_nome_responsavel_legal = nomeresponsavellegal,
    		ft_nome_responsavel_legal = ftnomeresponsavellegal, 
		dt_ano_cadastro_cnpj = anocadastrocnpj,
		ft_ano_cadastro_cnpj = ftanocadastrocnpj,
    		dt_fundacao_osc = dtfundacao, 
    		ft_fundacao_osc = ftfundacao, 
    		tx_resumo_osc = resumo,
    		ft_resumo_osc = ft_resumo
		 
	WHERE 
		id_osc = id; 

	mensagem := 'Dados gerais atualizados';
	RETURN NEXT;
END; 
$$ LANGUAGE 'plpgsql';
