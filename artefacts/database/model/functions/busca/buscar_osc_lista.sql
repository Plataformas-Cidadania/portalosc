-- Function: portal.buscar_osc_lista(text, integer, integer)

DROP FUNCTION portal.buscar_osc_lista(text, integer, integer);

CREATE OR REPLACE FUNCTION portal.buscar_osc_lista(
    IN param text,
    IN limit_result integer,
    IN offset_result integer)
  RETURNS TABLE(id_osc integer, tx_nome_osc text, cd_identificador_osc numeric, tx_natureza_juridica_osc text, tx_endereco_osc text, tx_nome_atividade_economica text) AS
$BODY$

BEGIN
	RETURN QUERY
		SELECT
			vw_busca_resultado.id_osc,
			vw_busca_resultado.tx_nome_osc,
			vw_busca_resultado.cd_identificador_osc,
			vw_busca_resultado.tx_natureza_juridica_osc,
			vw_busca_resultado.tx_endereco_osc,
			vw_busca_resultado.tx_nome_atividade_economica
		FROM
			portal.vw_busca_resultado
		WHERE
			vw_busca_resultado.id_osc IN (
				SELECT a.id_osc FROM portal.buscar_osc(param, limit_result, offset_result) a
			);
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION portal.buscar_osc_lista(text, integer, integer)
  OWNER TO i3geo;
