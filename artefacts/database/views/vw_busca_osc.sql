-- object: portal.vw_busca_osc | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_busca_osc CASCADE;
CREATE MATERIALIZED VIEW portal.vw_busca_osc AS 
SELECT 
	tb_osc.id_osc, 
	tb_osc.cd_identificador_osc, 
	tb_dados_gerais.tx_razao_social_osc, 
	tb_dados_gerais.tx_nome_fantasia_osc, 
    setweight(to_tsvector('portuguese_unaccent', coalesce(tb_osc.cd_identificador_osc::TEXT, '')), 'A') || 
    setweight(to_tsvector('portuguese_unaccent', coalesce(tb_dados_gerais.tx_razao_social_osc::TEXT, '')), 'B') || 
	setweight(to_tsvector('portuguese_unaccent', coalesce(tb_dados_gerais.tx_nome_fantasia_osc::TEXT, '')), 'C') AS document 
FROM osc.tb_osc 
LEFT JOIN osc.tb_dados_gerais 
ON tb_osc.id_osc = tb_dados_gerais.id_osc 
WHERE tb_osc.bo_osc_ativa = true;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_busca_osc OWNER TO postgres;
-- ddl-end --
