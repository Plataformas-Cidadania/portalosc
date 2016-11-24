DROP FUNCTION IF EXISTS portal.obter_geo_cluster_regiao(cd_tipo_regiao_req INTEGER, id_regiao_req INTEGER);

CREATE OR REPLACE FUNCTION portal.obter_geo_cluster_regiao(cd_tipo_regiao_req INTEGER, id_regiao_req INTEGER) RETURNS TABLE (
	id_regiao NUMERIC, 
	tx_nome_regiao CHARACTER VARYING, 
	tx_sigla_regiao CHARACTER VARYING, 
	geo_lat_centroid_regiao DOUBLE PRECISION, 
	geo_lng_centroid_regiao DOUBLE PRECISION, 
	nr_quantidade_osc_regiao INTEGER 
) AS $$ 

DECLARE 
	query_extension TEXT; 

BEGIN 
	IF id_regiao_req > 2 THEN 
		query_extension := ' AND vw_geo_cluster_regiao.id_regiao = ' || id_regiao_req || ');'; 
	ELSIF id_regiao_req > 1 THEN 
		query_extension := ' AND (
				SUBSTR(vw_geo_cluster_regiao.id_regiao::TEXT, 0, 3)::NUMERIC(2, 0) = ' || id_regiao_req || ' OR ' || '
				vw_geo_cluster_regiao.id_regiao = ' || id_regiao_req || ');'; 
	ELSIF id_regiao_req > 0 THEN 
		query_extension := ' AND (
				SUBSTR(vw_geo_cluster_regiao.id_regiao::TEXT, 0, 2)::NUMERIC(1, 0) = ' || id_regiao_req || ' OR ' || '
				SUBSTR(vw_geo_cluster_regiao.id_regiao::TEXT, 0, 3)::NUMERIC(2, 0) = ' || id_regiao_req || ' OR ' || '
				vw_geo_cluster_regiao.id_regiao = ' || id_regiao_req || ');'; 
	ELSE 
		query_extension := ';'; 
	END IF; 
	
	RETURN QUERY 
		EXECUTE 
			'SELECT 
				vw_geo_cluster_regiao.id_regiao, 
				vw_geo_cluster_regiao.tx_nome_regiao, 
				vw_geo_cluster_regiao.tx_sigla_regiao, 
				vw_geo_cluster_regiao.geo_lat_centroid_regiao, 
				vw_geo_cluster_regiao.geo_lng_centroid_regiao, 
				vw_geo_cluster_regiao.nr_quantidade_osc_regiao 
			FROM portal.vw_geo_cluster_regiao 
			WHERE vw_geo_cluster_regiao.cd_tipo_regiao = ' || cd_tipo_regiao_req::TEXT || query_extension;
		
END;
$$ LANGUAGE 'plpgsql';