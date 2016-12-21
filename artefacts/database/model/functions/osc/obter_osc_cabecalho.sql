DROP FUNCTION IF EXISTS portal.obter_osc_cabecalho(param TEXT);

CREATE OR REPLACE FUNCTION portal.obter_osc_cabecalho(param TEXT) RETURNS TABLE (
	cd_identificador_osc NUMERIC(14, 0), 
	ft_identificador_osc TEXT, 
	tx_razao_social_osc TEXT, 
	ft_razao_social_osc TEXT, 
	cd_natureza_juridica_osc NUMERIC(4, 0), 
	tx_nome_natureza_juridica_osc TEXT, 
	ft_natureza_juridica_osc TEXT, 
	im_logo TEXT, 
	ft_logo TEXT
) AS $$ 
BEGIN 
	RETURN QUERY 
		SELECT 
			vw_osc_dados_gerais.cd_identificador_osc, 
			vw_osc_dados_gerais.ft_identificador_osc, 
			vw_osc_dados_gerais.tx_razao_social_osc, 
			vw_osc_dados_gerais.ft_razao_social_osc, 
			vw_osc_dados_gerais.cd_natureza_juridica_osc, 
			vw_osc_dados_gerais.tx_nome_natureza_juridica_osc, 
			vw_osc_dados_gerais.ft_natureza_juridica_osc, 
			vw_osc_dados_gerais.im_logo, 
			vw_osc_dados_gerais.ft_logo 
		FROM 
			portal.vw_osc_dados_gerais 
		WHERE 
			vw_osc_dados_gerais.id_osc::TEXT = param OR 
			vw_osc_dados_gerais.tx_apelido_osc = param;
	RETURN;
END;
$$ LANGUAGE 'plpgsql';
