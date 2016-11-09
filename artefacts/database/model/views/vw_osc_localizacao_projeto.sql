-- object: portal.vw_osc_localizacao_projeto | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_localizacao_projeto CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_localizacao_projeto
AS

SELECT
	tb_localizacao_projeto.id_projeto,
	tb_localizacao_projeto.id_regiao_localizacao_projeto,
	tb_localizacao_projeto.tx_nome_regiao_localizacao_projeto,
	tb_localizacao_projeto.ft_nome_regiao_localizacao_projeto
FROM osc.tb_osc
INNER JOIN osc.tb_projeto ON osc.tb_projeto.id_osc = osc.tb_osc.id_osc
INNER JOIN osc.tb_localizacao_projeto ON tb_localizacao_projeto.id_projeto = osc.tb_projeto.id_projeto
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_localizacao_projeto OWNER TO postgres;
-- ddl-end --