DROP FUNCTION IF EXISTS portal.inserir_participacao_social_conselho(id INTEGER, cdconselho INTEGER, ftconselho TEXT, cdtipoparticipacao INTEGER, fttipoparticipacao TEXT, periodicidadereuniao TEXT, ftperiodicidadereuniao TEXT, dtinicioconselho DATE, ftdtinicioconselho TEXT, dtfimconselho DATE, ftdtfimconselho TEXT);

CREATE OR REPLACE FUNCTION portal.inserir_participacao_social_conselho(id INTEGER, cdconselho INTEGER, ftconselho TEXT, cdtipoparticipacao INTEGER, fttipoparticipacao TEXT, periodicidadereuniao TEXT, ftperiodicidadereuniao TEXT, dtinicioconselho DATE, ftdtinicioconselho TEXT, dtfimconselho DATE, ftdtfimconselho TEXT, oficial BOOLEAN)
 RETURNS BOOLEAN AS $$

DECLARE
	status BOOLEAN;	

BEGIN
	INSERT INTO osc.tb_participacao_social_conselho (id_osc, cd_conselho, ft_conselho, cd_tipo_participacao, ft_tipo_participacao, tx_periodicidade_reuniao, ft_periodicidade_reuniao, dt_data_inicio_conselho, ft_data_inicio_conselho, dt_data_fim_conselho, ft_data_fim_conselho, bo_oficial) 
	VALUES (id, cdconselho, ftconselho, cdtipoparticipacao, fttipoparticipacao, periodicidadereuniao, ftperiodicidadereuniao, dtinicioconselho, ftdtinicioconselho, dtfimconselho, ftdtfimconselho, oficial);

	status := true;
	RETURN status;

EXCEPTION 
	WHEN others THEN 
		status := false;
		RETURN status;

END;
$$ LANGUAGE 'plpgsql';
