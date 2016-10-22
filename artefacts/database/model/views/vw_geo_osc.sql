-- object: portal.vw_geo_osc | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_geo_osc CASCADE;
CREATE MATERIALIZED VIEW portal.vw_geo_osc
AS

SELECT
	tb_osc.id_osc,
	tb_osc.tx_apelido_osc,
	ST_Y(ST_TRANSFORM(tb_localizacao.geo_localizacao, 4674)) AS geo_lat,
	ST_x(ST_TRANSFORM(tb_localizacao.geo_localizacao, 4674)) AS geo_lng,
	tb_localizacao.ft_geo_localizacao,
	tb_localizacao.cd_municipio,
	tb_localizacao.ft_municipio,
	(SELECT eduf_cd_uf FROM spat.ed_municipio WHERE edmu_cd_municipio = tb_localizacao.cd_municipio) AS cd_estado,
	tb_localizacao.ft_municipio AS ft_estado,
	(SELECT ed_uf.edre_cd_regiao FROM spat.ed_uf WHERE ed_uf.eduf_cd_uf = (SELECT ed_municipio.eduf_cd_uf FROM spat.ed_municipio WHERE ed_municipio.edmu_cd_municipio = tb_localizacao.cd_municipio)) AS cd_regiao,
	tb_localizacao.ft_municipio AS ft_regiao
FROM osc.tb_osc
INNER JOIN osc.tb_localizacao ON tb_osc.id_osc = tb_localizacao.id_osc
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_geo_osc OWNER TO postgres;
-- ddl-end --