DROP FUNCTION IF EXISTS portal.obter_osc_relacoes_trabalho(param TEXT);

CREATE OR REPLACE FUNCTION portal.obter_osc_relacoes_trabalho(param TEXT) RETURNS TABLE (
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
			COALESCE(tb_relacoes_trabalho.nr_trabalhadores_vinculo, 0) + COALESCE(tb_relacoes_trabalho.nr_trabalhadores_deficiencia, 0) + COALESCE(tb_relacoes_trabalho.nr_trabalhadores_voluntarios, 0) AS nr_trabalhadores,
			tb_relacoes_trabalho.nr_trabalhadores_vinculo,
			tb_relacoes_trabalho.ft_trabalhadores_vinculo,
			tb_relacoes_trabalho.nr_trabalhadores_deficiencia,
			tb_relacoes_trabalho.ft_trabalhadores_deficiencia,
			tb_relacoes_trabalho.nr_trabalhadores_voluntarios,
			tb_relacoes_trabalho.ft_trabalhadores_voluntarios
		 FROM osc.tb_osc
		     JOIN osc.tb_relacoes_trabalho ON tb_osc.id_osc = tb_relacoes_trabalho.id_osc
		 WHERE tb_osc.bo_osc_ativa AND
		 osc.tb_osc.id_osc::TEXT = param OR 
		 osc.tb_osc.tx_apelido_osc = param;
	RETURN;
END;
$$ LANGUAGE 'plpgsql';
