-- object: portal.vw_osc_area_atuacao_outra | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_area_atuacao_outra CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_area_atuacao_outra
AS

SELECT
	tb_osc.id_osc,
	tb_osc.tx_apelido_osc,
	tb_area_atuacao_outra.id_area_atuacao_outra,
	(SELECT tx_nome_area_atuacao_declarada FROM osc.tb_area_atuacao_declarada WHERE tb_area_atuacao_declarada.id_area_atuacao_declarada = tb_area_atuacao_outra.id_area_atuacao_outra) AS tx_nome_area_atuacao_outra,
	tb_area_atuacao_outra.ft_area_atuacao_outra
FROM osc.tb_osc
INNER JOIN osc.tb_area_atuacao_outra ON tb_osc.id_osc = tb_area_atuacao_outra.id_osc
INNER JOIN osc.tb_dados_gerais ON tb_osc.id_osc = tb_dados_gerais.id_osc
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_area_atuacao_outra OWNER TO postgres;
-- ddl-end --