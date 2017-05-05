-- object: portal.vw_busca_osc | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS osc.vw_busca_osc CASCADE;
CREATE MATERIALIZED VIEW osc.vw_busca_osc AS 
SELECT 
	tb_osc.id_osc, 
	tb_osc.cd_identificador_osc, 
	REGEXP_REPLACE(REGEXP_REPLACE(TRIM(LOWER(tb_dados_gerais.tx_razao_social_osc)), '[^ a-zA-Z0-9]+', ' ','g'), '(\s\s*)', ' ', 'g') AS tx_razao_social_osc, 
	NULLIF(REGEXP_REPLACE(REGEXP_REPLACE(TRIM(LOWER(tb_dados_gerais.tx_nome_fantasia_osc)), '[^ a-zA-Z0-9]+', ' ','g'), '(\s\s*)', ' ', 'g'), '') AS tx_nome_fantasia_osc, 
    setweight(to_tsvector('portuguese_unaccent', coalesce(REGEXP_REPLACE(REGEXP_REPLACE(TRIM(LOWER(tb_dados_gerais.tx_razao_social_osc::TEXT)), '[^ a-zA-Z0-9]+', ' ','g'), '(\s\s*)', ' ', 'g'), '')), 'A') || 
	setweight(to_tsvector('portuguese_unaccent', coalesce(REGEXP_REPLACE(REGEXP_REPLACE(TRIM(LOWER(tb_dados_gerais.tx_nome_fantasia_osc::TEXT)), '[^ a-zA-Z0-9]+', ' ','g'), '(\s\s*)', ' ', 'g'), '')), 'B') AS document 
FROM osc.tb_osc 
LEFT JOIN osc.tb_dados_gerais 
ON tb_osc.id_osc = tb_dados_gerais.id_osc 
WHERE tb_osc.bo_osc_ativa = true;
-- ddl-end --
ALTER MATERIALIZED VIEW osc.vw_busca_osc OWNER TO postgres;
-- ddl-end --
