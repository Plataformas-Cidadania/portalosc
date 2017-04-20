DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_participacao_social_conselho;

ALTER TABLE osc.tb_participacao_social_conselho DROP COLUMN tx_periodicidade_reuniao RESTRICT;

ALTER TABLE osc.tb_participacao_social_conselho ADD cd_periodicidade_reuniao_conselho INTEGER UNIQUE;

ALTER TABLE osc.tb_participacao_social_conselho 
ADD CONSTRAINT fk_cd_periodicidade_reuniao_conselho FOREIGN KEY (cd_periodicidade_reuniao_conselho) 
REFERENCES syst.dc_periodicidade_reuniao_conselho (cd_periodicidade_reuniao_conselho) MATCH FULL 
ON UPDATE NO ACTION ON DELETE NO ACTION;
