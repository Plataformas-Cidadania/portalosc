-- object: portal.vw_spat_estado | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_spat_estado CASCADE;
DROP MATERIALIZED VIEW IF EXISTS spat.vw_spat_estado CASCADE;
CREATE MATERIALIZED VIEW spat.vw_spat_estado
AS

SELECT
	ed_uf.eduf_cd_uf,
	ed_uf.eduf_nm_uf,
	UNACCENT(ed_uf.eduf_nm_uf) AS eduf_nm_uf_adjusted,
	ed_uf.eduf_sg_uf,
    setweight(to_tsvector('portuguese_unaccent', coalesce(ed_uf.eduf_nm_uf, '')), 'A') ||
	setweight(to_tsvector('portuguese_unaccent', coalesce(ed_uf.eduf_sg_uf, '')), 'B')
	AS document
FROM spat.ed_uf;
-- ddl-end --
ALTER MATERIALIZED VIEW spat.vw_spat_estado OWNER TO postgres;
-- ddl-end --