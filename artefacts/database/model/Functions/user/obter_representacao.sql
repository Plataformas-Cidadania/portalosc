CREATE OR REPLACE FUNCTION portal.obter_representacao(id INTEGER) RETURNS TABLE(
	id_osc INTEGER,
	tx_nome_osc TEXT
) AS $$
BEGIN
	RETURN QUERY
		SELECT
			vw_osc_dados_gerais.id_osc,
			COALESCE(vw_osc_dados_gerais.tx_nome_fantasia_osc, vw_osc_dados_gerais.tx_razao_social_osc) AS tx_nome_osc
		FROM
			portal.vw_osc_dados_gerais
		WHERE
			vw_osc_dados_gerais.id_osc = ANY(SELECT tb_representacao.id_osc FROM portal.tb_representacao	WHERE tb_representacao.id_usuario = id);
END;
$$ LANGUAGE 'plpgsql'
