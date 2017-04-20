DROP FUNCTION IF EXISTS portal.atualizar_participacao_social_conselho_outro(id integer, idconselho integer, idconselhooutro integer, cdconselho integer, ftconselho text, nomeconselho text, ftnomeconselho text, cdtipoparticipacao integer, fttipoparticipacao text, periodicidadereuniao text, ftperiodicidadereuniao text, datainicioconselho date, ftdatainicioconselho text, datafimconselho date, ftdatafimconselho text);
CREATE OR REPLACE FUNCTION portal.atualizar_participacao_social_conselho_outro(id integer, idconselho integer, idconselhooutro integer, cdconselho integer, ftconselho text, nomeconselho text, ftnomeconselho text, cdtipoparticipacao integer, fttipoparticipacao text, periodicidadereuniao text, ftperiodicidadereuniao text, datainicioconselho date, ftdatainicioconselho text, datafimconselho date, ftdatafimconselho text)
 RETURNS TABLE(
	mensagem TEXT
)AS $$

BEGIN 
	UPDATE 
		osc.tb_participacao_social_conselho_outro
	SET 
		tx_nome_conselho = nomeconselho,
		ft_nome_conselho = ftnomeconselho
	WHERE 
		id_conselho_outro = idconselhooutro;

	UPDATE 
		osc.tb_participacao_social_conselho
	SET 
		cd_conselho = cdconselho, 
		ft_conselho = ftconselho, 
		cd_tipo_participacao = cdtipoparticipacao, 
		ft_tipo_participacao = fttipoparticipacao, 
		tx_periodicidade_reuniao = periodicidadereuniao, 
		ft_periodicidade_reuniao = ftperiodicidadereuniao, 
		dt_data_inicio_conselho = datainicioconselho, 
		ft_data_inicio_conselho = ftdatainicioconselho, 
		dt_data_fim_conselho = datafimconselho, 
		ft_data_fim_conselho = ftdatafimconselho 
	WHERE 
		id_conselho = idconselho AND id_osc = id;
	
	mensagem := 'Participação Social Conselho Outro atualizado';
	RETURN NEXT;
END; 
$$ LANGUAGE 'plpgsql';
