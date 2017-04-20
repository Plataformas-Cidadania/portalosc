DROP FUNCTION IF EXISTS portal.inserir_participacao_social_conselho(INTEGER, INTEGER, TEXT, INTEGER, TEXT, TEXT, TEXT, DATE, TEXT, DATE, TEXT, BOOLEAN);

CREATE OR REPLACE FUNCTION portal.inserir_participacao_social_conselho(id INTEGER, cdconselho INTEGER, ftconselho TEXT, cdtipoparticipacao INTEGER, fttipoparticipacao TEXT, cdperiodicidadereuniaoconselho INTEGER, ftperiodicidadereuniao TEXT, dtinicioconselho DATE, ftdtinicioconselho TEXT, dtfimconselho DATE, ftdtfimconselho TEXT, oficial BOOLEAN)
 RETURNS BOOLEAN AS $$

DECLARE
	status BOOLEAN;	

BEGIN
	INSERT INTO osc.tb_participacao_social_conselho (id_osc, cd_conselho, ft_conselho, cd_tipo_participacao, ft_tipo_participacao, cd_periodicidade_reuniao_conselho, ft_periodicidade_reuniao, dt_data_inicio_conselho, ft_data_inicio_conselho, dt_data_fim_conselho, ft_data_fim_conselho, bo_oficial) 
	VALUES (id, cdconselho, ftconselho, cdtipoparticipacao, fttipoparticipacao, cdperiodicidadereuniaoconselho, ftperiodicidadereuniao, dtinicioconselho, ftdtinicioconselho, dtfimconselho, ftdtfimconselho, oficial);

	status := true;
	RETURN status;

EXCEPTION 
	WHEN others THEN 
		status := false;
		RETURN status;

END;
$$ LANGUAGE 'plpgsql';
