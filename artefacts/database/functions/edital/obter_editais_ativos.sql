DROP FUNCTION IF EXISTS portal.obter_editais_ativos();

CREATE OR REPLACE FUNCTION portal.obter_editais_ativos() RETURNS TABLE(
	tx_orgao TEXT, 
	tx_programa TEXT, 
	tx_area_interesse_edital TEXT, 
	dt_vencimento TEXT, 
	tx_link_edital TEXT,
	tx_numero_chamada TEXT
) AS $$ 
BEGIN 
	RETURN QUERY 
		SELECT 
			tb_edital.tx_orgao, 
			tb_edital.tx_programa, 
			tb_edital.tx_area_interesse_edital, 
			to_char(tb_edital.dt_vencimento::timestamp with time zone, 'DD-MM-YYYY'::text) AS dt_vencimento, 
			tb_edital.tx_link_edital,
			tb_edital.tx_numero_chamada
		FROM 
			portal.tb_edital
		WHERE 
			tb_edital.dt_vencimento >= (NOW() - interval '1 day') OR 
			tb_edital.dt_vencimento IS NULL;
END; 
$$ LANGUAGE 'plpgsql';
