-- Function: portal.inserir_participacao_social_conselho_outro(integer, integer, text, text, text, integer, text, text, text, date, text, date, text, boolean);

DROP FUNCTION IF EXISTS portal.inserir_participacao_social_conselho_outro(integer, integer, text, text, text, integer, text, text, text, date, text, date, text, boolean);

CREATE OR REPLACE FUNCTION portal.inserir_participacao_social_conselho_outro(nomeconselho text, 
ftnomeconselho text, idconselho integer)
  RETURNS boolean AS
$BODY$

DECLARE
	status BOOLEAN;	

BEGIN
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
ALTER FUNCTION portal.inserir_participacao_social_conselho_outro(text, text, integer)
  OWNER TO postgres;
