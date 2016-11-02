-- object: portal.vw_spat_municipio | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_spat_municipio CASCADE;
CREATE MATERIALIZED VIEW portal.vw_spat_municipio
AS

SELECT
	ed_municipio.edmu_cd_municipio,
	ed_municipio.edmu_nm_municipio,
	UNACCENT(ed_municipio.edmu_nm_municipio) AS edmu_nm_municipio_adjusted,
	(SELECT eduf_sg_uf FROM spat.ed_uf WHERE eduf_cd_uf = ed_municipio.eduf_cd_uf) AS eduf_sg_uf,
    setweight(to_tsvector('portuguese_unaccent', coalesce(ed_municipio.edmu_nm_municipio, '')), 'A') AS document
FROM spat.ed_municipio;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_spat_municipio OWNER TO postgres;
-- ddl-end --