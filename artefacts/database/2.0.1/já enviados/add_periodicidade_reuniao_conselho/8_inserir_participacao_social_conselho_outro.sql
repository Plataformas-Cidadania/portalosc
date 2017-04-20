-- Function: portal.inserir_participacao_social_conselho_outro(integer, integer, text, text, text, integer, text, text, text, date, text, date, text, boolean);

-- DROP FUNCTION portal.inserir_participacao_social_conselho_outro(integer, integer, text, text, text, integer, text, text, text, date, text, date, text, boolean);

CREATE OR REPLACE FUNCTION portal.inserir_participacao_social_conselho_outro(
id integer, cdconselho integer, ftconselho text, nomeconselho text, 
ftnomeconselho text,cdtipoparticipacao integer, fttipoparticipacao text, 
periodicidadereuniao text, ftperiodicidadereuniao text, 
datainicioconselho date, ftdatainicioconselho text, datafimconselho date, 
ftdatafimconselho text, oficial boolean)
  RETURNS boolean AS
$BODY$

DECLARE
	idconselho INTEGER;
	status BOOLEAN;	

BEGIN
	INSERT INTO osc.tb_participacao_social_conselho (id_conselho, id_osc, cd_conselho, ft_conselho, cd_tipo_participacao, ft_tipo_participacao, tx_periodicidade_reuniao, ft_periodicidade_reuniao, dt_data_inicio_conselho, ft_data_inicio_conselho, dt_data_fim_conselho, ft_data_fim_conselho, bo_oficial) 
	VALUES (DEFAULT, id, cdconselho, ftconselho, cdtipoparticipacao, fttipoparticipacao, periodicidadereuniao, ftperiodicidadereuniao, datainicioconselho, ftdatainicioconselho, datafimconselho, ftdatafimconselho, oficial)
	RETURNING id_conselho INTO idconselho;

	INSERT INTO osc.tb_participacao_social_conselho_outro (tx_nome_conselho, ft_nome_conselho, id_conselho) 
	VALUES (nomeconselho, ftnomeconselho, idconselho);

	status := true;
	RETURN status;

EXCEPTION 
	WHEN others THEN 
		status := false;
		RETURN status;

END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION portal.inserir_participacao_social_conselho_outro(integer, integer, text, text, text, integer, text, text, text, date, text, date, text, boolean)
  OWNER TO postgres;
