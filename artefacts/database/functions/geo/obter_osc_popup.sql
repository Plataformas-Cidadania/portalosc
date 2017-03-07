DROP FUNCTION IF EXISTS portal.obter_osc_popup(param TEXT);

CREATE OR REPLACE FUNCTION portal.obter_osc_popup(param TEXT) RETURNS TABLE (
	tx_nome_osc TEXT, 
	tx_endereco TEXT, 
	tx_bairro TEXT, 
	tx_nome_natureza_juridica TEXT, 
	tx_nome_atividade_economica TEXT
) AS $$ 
BEGIN 
	RETURN QUERY 
		SELECT 
			vw_osc_dados_gerais.tx_nome_osc, 
			(vw_osc_dados_gerais.tx_endereco || ', ' || vw_osc_dados_gerais.nr_localizacao || COALESCE(' - ' || vw_osc_dados_gerais.tx_endereco_complemento, '')) AS tx_endereco, 
			(vw_osc_dados_gerais.tx_bairro || ', ' || vw_osc_dados_gerais.tx_nome_municipio || ' - ' || vw_osc_dados_gerais.tx_sigla_uf) AS tx_bairro, 
			vw_osc_dados_gerais.tx_nome_natureza_juridica_osc, 
			vw_osc_dados_gerais.tx_nome_atividade_economica_osc 
		FROM 
			portal.vw_osc_dados_gerais 
		WHERE 
			vw_osc_dados_gerais.id_osc::TEXT = param OR 
			vw_osc_dados_gerais.tx_apelido_osc = param;
	RETURN;
END;
$$ LANGUAGE 'plpgsql';
