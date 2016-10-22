-- object: portal.vw_osc_area_atuacao_outra_projeto | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_area_atuacao_outra_projeto CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_area_atuacao_outra_projeto
AS

SELECT
	area_atuacao.id_projeto,
	area_atuacao.id_area_atuacao_outra_projeto,
	(SELECT tb_area_atuacao_declarada.tx_nome_area_atuacao_declarada FROM osc.tb_area_atuacao_declarada WHERE tb_area_atuacao_declarada.id_area_atuacao_declarada = area_atuacao.id_area_atuacao_outra) AS tx_nome_area_atuacao_outra,
	area_atuacao.ft_area_atuacao_outra
FROM osc.tb_osc AS osc
INNER JOIN osc.tb_area_atuacao_outra_projeto AS area_atuacao
ON area_atuacao.id_projeto IN (SELECT projeto.id_projeto FROM osc.tb_projeto AS projeto WHERE projeto.id_osc = osc.id_osc)
WHERE osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_area_atuacao_outra_projeto OWNER TO postgres;
-- ddl-end --