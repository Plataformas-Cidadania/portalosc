-- portal.vw_busca_osc --
CREATE INDEX CONCURRENTLY index_document ON portal.vw_busca_osc USING gin(document);
CREATE INDEX CONCURRENTLY index_cd_identificador_osc ON portal.vw_busca_osc USING btree(cd_identificador_osc);
CREATE INDEX CONCURRENTLY index_similarity_tx_razao_social_osc ON portal.vw_busca_osc USING gin(tx_razao_social_osc gin_trgm_ops);
CREATE INDEX CONCURRENTLY index_similarity_tx_nome_fantasia_osc ON portal.vw_busca_osc USING gin(tx_nome_fantasia_osc gin_trgm_ops);

-- portal.vw_busca_osc_geo --
CREATE INDEX CONCURRENTLY index_cd_municipio ON portal.vw_busca_osc_geo USING hash(cd_municipio);
CREATE INDEX CONCURRENTLY index_cd_estado ON portal.vw_busca_osc_geo USING hash(cd_estado);
CREATE INDEX CONCURRENTLY index_cd_regiao ON portal.vw_busca_osc_geo USING hash(cd_regiao);

-- portal.vw_resultado_busca --
CREATE INDEX CONCURRENTLY index_id_osc ON portal.vw_busca_resultado USING hash(id_osc);

-- portal.vw_geo_osc
CREATE INDEX index_geo_id_osc ON portal.vw_geo_osc (id_osc);
