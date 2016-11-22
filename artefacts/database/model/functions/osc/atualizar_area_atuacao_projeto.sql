DROP FUNCTION IF EXISTS portal.atualizar_area_atuacao_projeto(idareaatuacaodeclarada INTEGER, nomeareaatuacaodeclarada TEXT, ftnomeareaatuacaodeclarada TEXT);

CREATE OR REPLACE FUNCTION portal.atualizar_area_atuacao_projeto(idareaatuacaoprojeto INTEGER, cdsubareaatuacao INTEGER, ftareaatuacaoprojeto TEXT)
 RETURNS TABLE(
	mensagem TEXT
)AS $$

BEGIN 	
	UPDATE 
		osc.tb_area_atuacao_projeto
	SET 
		cd_subarea_atuacao = cdsubareaatuacao, 
		ft_area_atuacao_projeto = ftareaatuacaoprojeto 
		 
	WHERE 
		id_area_atuacao_projeto = idareaatuacaoprojeto; 

	mensagem := 'Area Atuacao Projeto atualizada';
	RETURN NEXT;
END; 
$$ LANGUAGE 'plpgsql';
