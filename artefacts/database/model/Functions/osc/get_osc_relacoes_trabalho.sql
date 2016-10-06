CREATE OR REPLACE FUNCTION portal.get_osc_relacoes_trabalho(id_request INTEGER) RETURNS TABLE (
	nr_trabalhadores INTEGER,
	nr_trabalhadores_vinculo INTEGER,
	ft_trabalhadores_vinculo TEXT,
	nr_trabalhadores_deficiencia INTEGER,
	ft_trabalhadores_deficiencia TEXT,
	nr_trabalhadores_voluntarios INTEGER,
	ft_trabalhadores_voluntarios TEXT
) AS $$
BEGIN
	RETURN QUERY
		SELECT
			vw_osc_relacoes_trabalho.nr_trabalhadores,
			vw_osc_relacoes_trabalho.nr_trabalhadores_vinculo,
			vw_osc_relacoes_trabalho.ft_trabalhadores_vinculo,
			vw_osc_relacoes_trabalho.nr_trabalhadores_deficiencia,
			vw_osc_relacoes_trabalho.ft_trabalhadores_deficiencia,
			vw_osc_relacoes_trabalho.nr_trabalhadores_voluntarios,
			vw_osc_relacoes_trabalho.ft_trabalhadores_voluntarios
		FROM portal.vw_osc_relacoes_trabalho
		WHERE vw_osc_relacoes_trabalho.id_osc = id_request;
	RETURN;
END;
$$ LANGUAGE 'plpgsql'
