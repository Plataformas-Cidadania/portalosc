-- object: portal.vw_osc_localizacao_projeto | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_localizacao_projeto CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_localizacao_projeto
AS

SELECT
	localizacao.id_projeto,
	localizacao.id_regiao_localizacao_projeto,
	localizacao.tx_nome_regiao_localizacao_projeto,
	localizacao.ft_nome_regiao_localizacao_projeto
FROM osc.tb_osc AS osc
INNER JOIN osc.tb_localizacao_projeto AS localizacao
ON localizacao.id_projeto IN (SELECT projeto.id_projeto FROM osc.tb_projeto AS projeto WHERE projeto.id_osc = osc.id_osc)
WHERE osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_localizacao_projeto OWNER TO postgres;
-- ddl-end --