DROP FUNCTION IF EXISTS portal.obter_osc_relacoes_trabalho_outra(param TEXT);

CREATE OR REPLACE FUNCTION portal.obter_osc_relacoes_trabalho_outra(param TEXT) RETURNS TABLE (
	nr_trabalhadores INTEGER, 
	ft_trabalhadores TEXT, 
	tx_tipo_relacao_trabalho TEXT, 
	ft_tipo_relacao_trabalho TEXT
) AS $$ 
BEGIN 
	RETURN QUERY 
		SELECT 
			vw_osc_relacoes_trabalho_outra.nr_trabalhadores, 
			vw_osc_relacoes_trabalho_outra.ft_trabalhadores, 
			vw_osc_relacoes_trabalho_outra.tx_tipo_relacao_trabalho, 
			vw_osc_relacoes_trabalho_outra.ft_tipo_relacao_trabalho 
		FROM portal.vw_osc_relacoes_trabalho_outra 
		WHERE 
			vw_osc_relacoes_trabalho_outra.id_osc::TEXT = param OR 
			vw_osc_relacoes_trabalho_outra.tx_apelido_osc = param;
	RETURN;
END;
$$ LANGUAGE 'plpgsql';
