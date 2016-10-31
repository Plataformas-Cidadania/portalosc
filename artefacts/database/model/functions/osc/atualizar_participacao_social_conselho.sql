DROP FUNCTION IF EXISTS portal.atualizar_participacao_social_conselho(id INTEGER, idconselho INTEGER, cdconselho INTEGER, ftconselho TEXT, cdtipoparticipacao INTEGER, fttipoparticipacao TEXT, periodicidadereuniao TEXT, ftperiodicidadereuniao TEXT, dtinicioconselho DATE, ftdtinicioconselho TEXT, dtfimconselho DATE, ftdtfimconselho TEXT);

CREATE OR REPLACE FUNCTION portal.atualizar_participacao_social_conselho(id INTEGER, idconselho INTEGER, cdconselho INTEGER, ftconselho TEXT, cdtipoparticipacao INTEGER, fttipoparticipacao TEXT, periodicidadereuniao TEXT, ftperiodicidadereuniao TEXT, dtinicioconselho DATE, ftdtinicioconselho TEXT, dtfimconselho DATE, ftdtfimconselho TEXT)
 RETURNS TABLE(
	mensagem TEXT
)AS $$

BEGIN 

	UPDATE 
		osc.tb_participacao_social_conselho 
	SET 
		id_osc = id,
		cd_conselho = cdconselho, 
		ft_conselho = ftconselho,
		cd_tipo_participacao = cdtipoparticipacao, 
		ft_tipo_participacao = fttipoparticipacao, 
		tx_periodicidade_reuniao = periodicidadereuniao, 
		ft_periodicidade_reuniao = ftperiodicidadereuniao, 
		dt_data_inicio_conselho = dtinicioconselho, 
		ft_data_inicio_conselho = ftdtinicioconselho, 
		dt_data_fim_conselho = dtfimconselho, 
		ft_data_fim_conselho = ftdtfimconselho

	WHERE 
		id_conselho = idconselho;

	mensagem := 'Participação Social Conselho atualizada';
	RETURN NEXT;
END; 
$$ LANGUAGE 'plpgsql';
