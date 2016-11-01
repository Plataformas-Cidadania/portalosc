DROP FUNCTION IF EXISTS portal.inserir_participacao_social_conferencia_outra(id INTEGER, idconferenciadeclarada INTEGER, ftconferenciadeclarada TEXT, dtinicioconferencia DATE, ftdatainicioconferencia TEXT, dtfimconferencia DATE, ftdatafimconferencia TEXT, cdformaparticipacaoconferencia INTEGER, ftformaparticipacaoconferencia TEXT);

CREATE OR REPLACE FUNCTION portal.inserir_participacao_social_conferencia_outra(id INTEGER, idconferenciadeclarada INTEGER, ftconferenciadeclarada TEXT, dtinicioconferencia DATE, ftdatainicioconferencia TEXT, dtfimconferencia DATE, ftdatafimconferencia TEXT, cdformaparticipacaoconferencia INTEGER, ftformaparticipacaoconferencia TEXT)
 RETURNS BOOLEAN AS $$

DECLARE
	status BOOLEAN;	

BEGIN
 
	INSERT INTO osc.tb_participacao_social_conferencia_outra (id_conferencia_declarada, ft_conferencia_declarada, id_osc, dt_data_inicio_conferencia, ft_data_inicio_conferencia, dt_data_fim_conferencia, ft_data_fim_conferencia, cd_forma_participacao_conferencia, ft_forma_participacao_conferencia) 
	VALUES (idconferenciadeclarada, ftconferenciadeclarada, id, dtinicioconferencia, ftdatainicioconferencia, dtfimconferencia, ftdatafimconferencia, cdformaparticipacaoconferencia, ftformaparticipacaoconferencia);

	status := true;
	RETURN status;

EXCEPTION 
	WHEN others THEN 
		status := false;
		RETURN status;

END;
$$ LANGUAGE 'plpgsql';
