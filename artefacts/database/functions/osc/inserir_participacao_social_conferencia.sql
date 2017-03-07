DROP FUNCTION IF EXISTS portal.inserir_participacao_social_conferencia(id INTEGER, cdconferencia INTEGER, ftconferencia TEXT, dtanorealizacao DATE, ftanorealizacao TEXT, cdformaparticipacaoconferencia INTEGER, ftformaparticipacaoconferencia TEXT);

CREATE OR REPLACE FUNCTION portal.inserir_participacao_social_conferencia(id INTEGER, cdconferencia INTEGER, ftconferencia TEXT, dtanorealizacao DATE, ftanorealizacao TEXT, cdformaparticipacaoconferencia INTEGER, ftformaparticipacaoconferencia TEXT, oficial BOOLEAN)
 RETURNS BOOLEAN AS $$

DECLARE
	status BOOLEAN;	

BEGIN
	INSERT INTO osc.tb_participacao_social_conferencia (cd_conferencia, ft_conferencia, id_osc, dt_ano_realizacao, ft_ano_realizacao, cd_forma_participacao_conferencia, ft_forma_participacao_conferencia, bo_oficial) 
	VALUES (cdconferencia, ftconferencia, id, dtanorealizacao, ftanorealizacao, cdformaparticipacaoconferencia, ftformaparticipacaoconferencia, oficial);

	status := true;
	RETURN status;

EXCEPTION 
	WHEN others THEN 
		status := false;
		RETURN status;

END;
$$ LANGUAGE 'plpgsql';
