DROP FUNCTION IF EXISTS portal.obter_osc_objetivo_projeto(param INTEGER);

CREATE OR REPLACE FUNCTION portal.obter_osc_objetivo_projeto(param INTEGER) RETURNS TABLE (
	id_objetivo_projeto INTEGER, 
	cd_objetivo_projeto INTEGER, 
	tx_nome_objetivo_projeto TEXT, 
	cd_meta_projeto INTEGER, 
	tx_nome_meta_projeto TEXT, 
	ft_objetivo_projeto TEXT
) AS $$ 
BEGIN 
	RETURN QUERY 
		SELECT 
			vw_osc_objetivo_projeto.id_objetivo_projeto, 
			vw_osc_objetivo_projeto.cd_objetivo_projeto, 
			vw_osc_objetivo_projeto.tx_nome_objetivo_projeto, 
			vw_osc_objetivo_projeto.cd_meta_projeto, 
			vw_osc_objetivo_projeto.tx_nome_meta_projeto, 
			vw_osc_objetivo_projeto.ft_objetivo_projeto 
		FROM 
			portal.vw_osc_objetivo_projeto 
		WHERE 
			vw_osc_objetivo_projeto.id_projeto = param;
	RETURN;
END;
$$ LANGUAGE 'plpgsql';
