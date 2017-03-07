DROP FUNCTION IF EXISTS portal.obter_osc_representante_conselho(param TEXT);

CREATE OR REPLACE FUNCTION portal.obter_osc_representante_conselho(param TEXT) RETURNS TABLE (
	id_representante_conselho INTEGER, 
	id_participacao_social_conselho INTEGER, 
	tx_nome_representante_conselho TEXT, 
	ft_nome_representante_conselho TEXT
) AS $$ 
BEGIN 
	RETURN QUERY 
		SELECT 
			vw_osc_representante_conselho.id_representante_conselho, 
			vw_osc_representante_conselho.id_participacao_social_conselho, 
			vw_osc_representante_conselho.tx_nome_representante_conselho, 
			vw_osc_representante_conselho.ft_nome_representante_conselho 
		FROM 
			portal.vw_osc_representante_conselho 
		WHERE 
			vw_osc_representante_conselho.id_participacao_social_conselho::TEXT = param;
	RETURN;
END;
$$ LANGUAGE 'plpgsql';
