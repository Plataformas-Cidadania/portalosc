DROP FUNCTION IF EXISTS portal.atualizar_participacao_social_conselho_outro(id integer, idconselho integer, idconselhooutro integer, cdconselho integer, ftconselho text, nomeconselho text, ftnomeconselho text, cdtipoparticipacao integer, fttipoparticipacao text, periodicidadereuniao text, ftperiodicidadereuniao text, datainicioconselho date, ftdatainicioconselho text, datafimconselho date, ftdatafimconselho text);
CREATE OR REPLACE FUNCTION portal.atualizar_participacao_social_conselho_outro(nomeconselho text, ftnomeconselho text, idconselho integer)
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
		id_conselho = idconselho;
	
	mensagem := 'Participação Social Conselho Outro atualizado';
	RETURN NEXT;
END; 
$$ LANGUAGE 'plpgsql';
