CREATE OR REPLACE FUNCTION portal.get_osc_relacoes_trabalho(id_request INTEGER) RETURNS TABLE (
	id_osc INTEGER,
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
		SELECT *
		FROM portal.vw_osc_relacoes_trabalho AS relacoes_trabalho
		WHERE relacoes_trabalho.id_osc = id_request;
	RETURN;
END;
$$ LANGUAGE 'plpgsql'