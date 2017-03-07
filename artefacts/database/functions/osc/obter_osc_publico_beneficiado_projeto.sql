DROP FUNCTION IF EXISTS portal.obter_osc_publico_beneficiado_projeto(param INTEGER);

CREATE OR REPLACE FUNCTION portal.obter_osc_publico_beneficiado_projeto(param INTEGER) RETURNS TABLE (
	id_publico_beneficiado INTEGER, 
	tx_nome_publico_beneficiado TEXT, 
	nr_estimativa_pessoas_atendidas INTEGER, 
	ft_publico_beneficiado_projeto TEXT
) AS $$ 
BEGIN 
	RETURN QUERY 
		SELECT 
			vw_osc_publico_beneficiado_projeto.id_publico_beneficiado, 
			vw_osc_publico_beneficiado_projeto.tx_nome_publico_beneficiado, 
			vw_osc_publico_beneficiado_projeto.nr_estimativa_pessoas_atendidas, 
			vw_osc_publico_beneficiado_projeto.ft_publico_beneficiado_projeto 
		FROM 
			portal.vw_osc_publico_beneficiado_projeto 
		WHERE 
			vw_osc_publico_beneficiado_projeto.id_projeto = param;
	RETURN;
END;
$$ LANGUAGE 'plpgsql';
