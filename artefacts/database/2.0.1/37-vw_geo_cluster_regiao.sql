-- object: portal.vw_geo_cluster_regiao | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_geo_cluster_regiao CASCADE;
DROP MATERIALIZED VIEW IF EXISTS spat.vw_geo_cluster_regiao CASCADE;
CREATE MATERIALIZED VIEW spat.vw_geo_cluster_regiao
AS

SELECT 
	edre_cd_regiao AS id_regiao, 
	1 AS cd_tipo_regiao, 
	'Região' AS tx_tipo_regiao, 
	edre_nm_regiao AS tx_nome_regiao, 
	edre_sg_regiao AS tx_sigla_regiao, 
	ST_y(edre_centroid) AS geo_lat_centroid_regiao, 
	ST_X(edre_centroid) AS geo_lng_centroid_regiao, 
	(SELECT COUNT(*) FROM osc.tb_localizacao WHERE SUBSTRING(tb_localizacao.cd_municipio::TEXT from 1 for 1)::NUMERIC(1, 0) = ed_regiao.edre_cd_regiao)::INTEGER AS nr_quantidade_osc_regiao 
FROM 
	spat.ed_regiao 
UNION 
SELECT 
	eduf_cd_uf AS id_regiao, 
	2 AS cd_tipo_regiao, 
	'Estado' AS tx_tipo_regiao, 
	eduf_nm_uf AS tx_nome_regiao, 
	eduf_sg_uf AS tx_sigla_regiao, 
	ST_y(eduf_centroid) AS geo_lat_centroid_regiao, 
	ST_X(eduf_centroid) AS geo_lng_centroid_regiao, 
	(SELECT COUNT(*) FROM osc.tb_localizacao WHERE SUBSTRING(tb_localizacao.cd_municipio::TEXT from 1 for 2)::NUMERIC(2, 0) = ed_uf.eduf_cd_uf)::INTEGER AS nr_quantidade_osc_regiao 
FROM 
	spat.ed_uf 
UNION
SELECT 
	edmu_cd_municipio AS id_regiao, 
	3 AS cd_tipo_regiao, 
	'Município' AS tx_tipo_regiao, 
	edmu_nm_municipio AS tx_nome_regiao, 
	null AS tx_sigla_regiao, 
	ST_y(edmu_centroid) AS geo_lat_centroid_regiao, 
	ST_X(edmu_centroid) AS geo_lng_centroid_regiao, 
	(SELECT COUNT(*) FROM osc.tb_localizacao WHERE tb_localizacao.cd_municipio = ed_municipio.edmu_cd_municipio)::INTEGER AS nr_quantidade_osc_regiao 
FROM 
	spat.ed_municipio;
-- ddl-end --
ALTER MATERIALIZED VIEW spat.vw_geo_cluster_regiao OWNER TO postgres;
-- ddl-end --