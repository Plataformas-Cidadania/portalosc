DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_dados_gerais;
ALTER TABLE osc.tb_dados_gerais alter column im_logo type text;
ir /vw_osc_dados_gerais.sql;