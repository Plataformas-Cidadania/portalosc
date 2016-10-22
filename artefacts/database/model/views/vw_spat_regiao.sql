-- object: portal.vw_spat_regiao | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_spat_regiao CASCADE;
CREATE MATERIALIZED VIEW portal.vw_spat_regiao
AS

SELECT
	ed_regiao.edre_cd_regiao,
	ed_regiao.edre_nm_regiao,
	UNACCENT(ed_regiao.edre_nm_regiao) AS edre_nm_regiao_adjusted,
    setweight(to_tsvector('portuguese_unaccent', coalesce(ed_regiao.edre_nm_regiao, '')), 'A') AS document
FROM spat.ed_regiao;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_spat_regiao OWNER TO postgres;
-- ddl-end --