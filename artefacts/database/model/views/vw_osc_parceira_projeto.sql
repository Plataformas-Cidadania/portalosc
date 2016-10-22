-- object: portal.vw_osc_parceira_projeto | type: VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_parceira_projeto CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_parceira_projeto
AS

SELECT
	parceira.id_projeto,
	parceira.id_osc,
	parceira.ft_osc_parceira_projeto,
	(SELECT COALESCE(tb_dados_gerais.tx_nome_fantasia_osc, tb_dados_gerais.tx_razao_social_osc) FROM osc.tb_dados_gerais WHERE tb_dados_gerais.id_osc = parceira.id_osc) AS tx_nome_osc_parceira_projeto
FROM osc.tb_osc AS osc
INNER JOIN osc.tb_osc_parceira_projeto AS parceira
ON parceira.id_projeto IN (SELECT projeto.id_projeto FROM osc.tb_projeto AS projeto WHERE projeto.id_osc = osc.id_osc)
WHERE osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_parceira_projeto OWNER TO postgres;
-- ddl-end --