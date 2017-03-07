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
	(SELECT edmu_nm_municipio FROM spat.ed_municipio WHERE edmu_cd_municipio = tb_localizacao.cd_municipio) AS tx_nome_municipio,
	(SELECT edmu_centroid FROM spat.ed_municipio WHERE edmu_cd_municipio = tb_localizacao.cd_municipio) AS geo_centroid_municipio,
	tb_localizacao.ft_municipio,
	SUBSTRING(tb_localizacao.cd_municipio::TEXT from 1 for 2)::NUMERIC(2, 0) AS cd_estado,
	(SELECT eduf_nm_uf FROM spat.ed_uf WHERE eduf_cd_uf::TEXT = SUBSTRING(tb_localizacao.cd_municipio::TEXT from 1 for 2)) AS tx_nome_estado,
	(SELECT eduf_sg_uf FROM spat.ed_uf WHERE eduf_cd_uf::TEXT = SUBSTRING(tb_localizacao.cd_municipio::TEXT from 1 for 2)) AS tx_sigla_estado,
	(SELECT eduf_centroid FROM spat.ed_uf WHERE eduf_cd_uf::TEXT = SUBSTRING(tb_localizacao.cd_municipio::TEXT from 1 for 2)) AS geo_centroid_estado,
	tb_localizacao.ft_municipio AS ft_estado,
	SUBSTRING(tb_localizacao.cd_municipio::TEXT from 1 for 1)::NUMERIC(1, 0) AS cd_regiao,
	(SELECT edre_nm_regiao FROM spat.ed_regiao WHERE ed_regiao.edre_cd_regiao::TEXT = SUBSTRING(tb_localizacao.cd_municipio::TEXT from 1 for 1)) AS tx_nome_regiao,
	(SELECT edre_centroid FROM spat.ed_regiao WHERE ed_regiao.edre_cd_regiao::TEXT = SUBSTRING(tb_localizacao.cd_municipio::TEXT from 1 for 1)) AS geo_centroid_regiao,
	tb_localizacao.ft_municipio AS ft_regiao
FROM osc.tb_osc
INNER JOIN osc.tb_localizacao ON tb_osc.id_osc = tb_localizacao.id_osc
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_geo_osc OWNER TO postgres;
-- ddl-end --