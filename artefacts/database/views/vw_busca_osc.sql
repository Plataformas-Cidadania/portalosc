-- object: portal.vw_busca_osc | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS osc.vw_busca_osc CASCADE;
CREATE MATERIALIZED VIEW osc.vw_busca_osc AS 
SELECT 
	tb_osc.id_osc, 
	tb_osc.cd_identificador_osc, 
	TRANSLATE(TRIM(tb_dados_gerais.tx_razao_social_osc), '.,/,\,|,:,#,@,$,&,!,?,(,),[,]', '') AS tx_razao_social_osc, 
	NULLIF(TRANSLATE(TRIM(tb_dados_gerais.tx_nome_fantasia_osc), '.,/,\,|,:,#,@,$,&,!,?,(,),[,]', ''), '') AS tx_nome_fantasia_osc, 
    setweight(to_tsvector('portuguese_unaccent', coalesce(TRANSLATE(TRIM(tb_dados_gerais.tx_razao_social_osc::TEXT), '.,/,\,|,:,#,@,$,&,!,?,(,),[,]', ''), '')), 'A') || 
	setweight(to_tsvector('portuguese_unaccent', coalesce(TRANSLATE(TRIM(tb_dados_gerais.tx_nome_fantasia_osc::TEXT), '.,/,\,|,:,#,@,$,&,!,?,(,),[,]', ''), '')), 'B') AS document 
FROM osc.tb_osc 
LEFT JOIN osc.tb_dados_gerais 
ON tb_osc.id_osc = tb_dados_gerais.id_osc 
WHERE tb_osc.bo_osc_ativa = true;
-- ddl-end --
ALTER MATERIALIZED VIEW osc.vw_busca_osc OWNER TO postgres;
-- ddl-end --
