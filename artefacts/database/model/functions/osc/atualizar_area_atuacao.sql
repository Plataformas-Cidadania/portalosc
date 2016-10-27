DROP FUNCTION IF EXISTS portal.atualizar_area_atuacao(id INTEGER, idareaatuacao INTEGER, areaatuacao INTEGER, ftareaatuacao TEXT, subareaatuacao INTEGER);

CREATE OR REPLACE FUNCTION portal.atualizar_area_atuacao(id INTEGER, idareaatuacao INTEGER, areaatuacao INTEGER, ftareaatuacao TEXT, subareaatuacao INTEGER)
 RETURNS TABLE(
	mensagem TEXT
)AS $$

BEGIN 
	UPDATE 
		osc.tb_area_atuacao
	SET 
		id_osc = id, 
		cd_area_atuacao = areaatuacao, 
		ft_area_atuacao = ftareaatuacao, 
		cd_subarea_atuacao = subareaatuacao
		 
	WHERE 
		id_area_atuacao = idareaatuacao; 

	mensagem := 'Area atuacao atualizada';
	RETURN NEXT;
END; 
$$ LANGUAGE 'plpgsql';
