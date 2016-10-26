DROP FUNCTION IF EXISTS portal.buscar_osc_municipio_autocomplete(param NUMERIC);

CREATE OR REPLACE FUNCTION portal.buscar_osc_municipio_autocomplete(param NUMERIC) RETURNS TABLE(
	id_osc INTEGER,
	tx_nome_osc TEXT
) AS $$
DECLARE
	id_osc_search INTEGER;
BEGIN
	RETURN QUERY
		SELECT
			vw_busca_resultado.id_osc,
			vw_busca_resultado.tx_nome_osc
		FROM portal.vw_busca_resultado
		WHERE vw_busca_resultado.id_osc IN (
			SELECT id_osc FROM portal.buscar_osc_municipio(param)
		);
END;
$$ LANGUAGE 'plpgsql';
