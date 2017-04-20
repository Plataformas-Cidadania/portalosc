-- Function: portal.obter_osc_participacao_social_conselho_outro(text)

DROP FUNCTION IF EXISTS portal.obter_osc_participacao_social_conselho_outro(text);

CREATE OR REPLACE FUNCTION portal.obter_osc_participacao_social_conselho_outro(IN param text)
  RETURNS TABLE(id_conselho_outro integer, tx_nome_conselho text, ft_nome_conselho text) AS
$BODY$ 
BEGIN 
	RETURN QUERY 
		SELECT 
			vw_osc_participacao_social_conselho_outro.id_conselho_outro,
			vw_osc_participacao_social_conselho_outro.tx_nome_conselho, 
			vw_osc_participacao_social_conselho_outro.ft_nome_conselho
			
		FROM 
			portal.vw_osc_participacao_social_conselho_outro 
		WHERE 
			vw_osc_participacao_social_conselho_outro.id_osc::TEXT = param OR 
			vw_osc_participacao_social_conselho_outro.tx_apelido_osc = param;
	RETURN;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION portal.obter_osc_participacao_social_conselho_outro(text)
  OWNER TO postgres;
