DROP FUNCTION IF EXISTS portal.atualizar_objetivo_projeto(idprojeto INTEGER, idobjetivoprojeto INTEGER, cdmetaprojeto INTEGER, ftobjetivoprojeto TEXT);

CREATE OR REPLACE FUNCTION portal.atualizar_objetivo_projeto(idprojeto INTEGER, idobjetivoprojeto INTEGER, cdmetaprojeto INTEGER, ftobjetivoprojeto TEXT)
 RETURNS TABLE(
	mensagem TEXT
)AS $$

BEGIN 
	UPDATE 
		osc.tb_objetivo_projeto
	SET 
		id_projeto = idprojeto,
		cd_meta_projeto = cdmetaprojeto,
		ft_objetivo_projeto = ftobjetivoprojeto	 
	WHERE 
		id_objetivo_projeto = idobjetivoprojeto;

	mensagem := 'Objetivo do Projeto atualizado';
	RETURN NEXT;
END; 
$$ LANGUAGE 'plpgsql';
