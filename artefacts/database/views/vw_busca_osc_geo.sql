-- object: portal.vw_busca_osc_geo | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_busca_osc_geo CASCADE;
CREATE MATERIALIZED VIEW portal.vw_busca_osc_geo AS 
SELECT 
	tb_osc.id_osc, 
	tb_localizacao.cd_municipio, 
	SUBSTR(tb_localizacao.cd_municipio::TEXT, 0, 3)::NUMERIC(2, 0) AS cd_estado, 
	SUBSTR(tb_localizacao.cd_municipio::TEXT, 0, 2)::NUMERIC(1, 0) AS cd_regiao 
FROM osc.tb_osc 
LEFT JOIN osc.tb_localizacao 
ON tb_osc.id_osc = tb_localizacao.id_osc 
WHERE tb_osc.bo_osc_ativa = true;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_busca_osc_geo OWNER TO postgres;
-- ddl-end --