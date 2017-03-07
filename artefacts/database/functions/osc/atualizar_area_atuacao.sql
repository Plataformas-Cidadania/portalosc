DROP FUNCTION IF EXISTS portal.atualizar_area_atuacao(id_osc_req INTEGER, cd_area_atuacao_req INTEGER, cd_subarea_atuacao_req INTEGER, tx_nome_outra_req TEXT, ft_area_atuacao_req TEXT, bo_oficial_req BOOLEAN);

CREATE OR REPLACE FUNCTION portal.atualizar_area_atuacao(id_osc_req INTEGER, cd_area_atuacao_req INTEGER, cd_subarea_atuacao_req INTEGER, tx_nome_outra_req TEXT, ft_area_atuacao_req TEXT, bo_oficial_req BOOLEAN)
 RETURNS TABLE(
	mensagem TEXT
)AS $$

BEGIN	
	IF cd_subarea_atuacao_req IS NULL THEN 
		UPDATE 
			osc.tb_area_atuacao
		SET 
			id_osc = id_osc_req, 
			cd_area_atuacao = cd_area_atuacao_req, 
			cd_subarea_atuacao = cd_subarea_atuacao_req, 
			tx_nome_outra = tx_nome_outra_req, 
			ft_area_atuacao = ft_area_atuacao_req, 
			bo_oficial = bo_oficial_req 
		WHERE 
			id_osc = id_osc_req AND 
			cd_area_atuacao =  cd_area_atuacao_req AND 
			cd_subarea_atuacao IS NULL; 
	ELSE 
		UPDATE 
			osc.tb_area_atuacao
		SET 
			id_osc = id_osc_req, 
			cd_area_atuacao = cd_area_atuacao_req, 
			cd_subarea_atuacao = cd_subarea_atuacao_req, 
			tx_nome_outra = tx_nome_outra_req, 
			ft_area_atuacao = ft_area_atuacao_req, 
			bo_oficial = bo_oficial_req 
		WHERE 
			id_osc = id_osc_req AND 
			cd_area_atuacao =  cd_area_atuacao_req AND 
			cd_subarea_atuacao = cd_subarea_atuacao_req; 
	END IF; 

	mensagem := 'Área de atuação atualizada';
END; 
$$ LANGUAGE 'plpgsql';
