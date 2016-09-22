CREATE OR REPLACE FUNCTION portal.get_osc_dados_gerais(id_request INTEGER) RETURNS TABLE (
	id_osc INTEGER,
	cd_identificador_osc NUMERIC(14, 0),
	ft_identificador_osc TEXT,
	tx_razao_social_osc TEXT,
	ft_razao_social_osc TEXT,
	tx_nome_fantasia_osc TEXT,
	ft_nome_fantasia_osc TEXT,
	im_logo BYTEA,
	ft_logo TEXT,
	tx_atividade_economica_osc TEXT,
	ft_atividade_economica_osc TEXT,
	tx_natureza_juridica_osc TEXT,
	ft_natureza_juridica_osc TEXT,
	tx_sigla_osc TEXT,
	ft_sigla_osc TEXT,
	tx_url_osc TEXT,
	ft_url_osc TEXT,
	dt_fundacao_osc DATE,
	ft_fundacao_osc TEXT,
	tx_nome_responsavel_legal TEXT,
	ft_nome_responsavel_legal TEXT,
	tx_link_estatuto_osc TEXT,
	ft_link_estatuto_osc TEXT,
	tx_resumo_osc TEXT,
	ft_resumo_osc TEXT,
	tx_endereco TEXT,
	ft_endereco TEXT,
	nr_localizacao INTEGER,
	ft_localizacao TEXT,
	tx_endereco_complemento TEXT,
	ft_endereco_complemento TEXT,
	tx_bairro TEXT,
	ft_bairro TEXT,
	tx_municipio CHARACTER VARYING(50),
	ft_municipio TEXT,
	tx_uf CHARACTER VARYING(2),
	ft_uf TEXT,
	nr_cep NUMERIC(8, 0),
	ft_cep TEXT,
	tx_email TEXT,
	ft_email TEXT,
	tx_site TEXT,
	ft_site TEXT,
	tx_telefone TEXT,
	ft_telefone TEXT
) AS $$
BEGIN
	RETURN QUERY
		SELECT *
		FROM portal.vw_osc_dados_gerais AS dados_gerais
		WHERE dados_gerais.id_osc = id_request;
	RETURN;
END;
$$ LANGUAGE 'plpgsql'