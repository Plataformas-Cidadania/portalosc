DROP FUNCTION IF EXISTS portal.atualizar_area_atuacao(id_osc_req INTEGER, cd_area_atuacao_req INTEGER, cd_subarea_atuacao_req INTEGER, tx_nome_outra_req TEXT, ft_area_atuacao_req TEXT, bo_oficial_req BOOLEAN);

CREATE OR REPLACE FUNCTION portal.atualizar_area_atuacao(id_osc_req INTEGER, cd_area_atuacao_req INTEGER, cd_subarea_atuacao_req INTEGER, tx_nome_outra_req TEXT, ft_area_atuacao_req TEXT, bo_oficial_req BOOLEAN)
 RETURNS TABLE(
	mensagem TEXT
)AS $$

DECLARE 
	cd_subarea_atuacao_ajusted TEXT; 

BEGIN	
	IF cd_subarea_atuacao_req IS NULL THEN 
		cd_subarea_atuacao_ajusted := 'IS NULL;'; 
	ELSE 
		cd_subarea_atuacao_ajusted := '= ' || cd_subarea_atuacao_req::TEXT || ';'; 
	END IF; 

	RETURN QUERY 
		EXECUTE 
			'UPDATE 
				osc.tb_area_atuacao
			SET 
				id_osc = ' || id_osc_req::TEXT || ', 
				cd_area_atuacao = ' || cd_area_atuacao_req::TEXT || ', 
				cd_subarea_atuacao = ' || cd_subarea_atuacao_req::TEXT || ', 
				tx_nome_outra = ''' || tx_nome_outra_req::TEXT || ''', 
				ft_area_atuacao = ''' || ft_area_atuacao_req::TEXT || ''', 
				bo_oficial = ' || bo_oficial_req::TEXT || ' 
			WHERE 
				id_osc = ' || id_osc_req || ' AND 
				cd_area_atuacao =  ' || cd_area_atuacao_req || ' AND 
				cd_subarea_atuacao ' || cd_subarea_atuacao_ajusted; 

	mensagem := 'Área de atuação atualizada';
END; 
$$ LANGUAGE 'plpgsql';
