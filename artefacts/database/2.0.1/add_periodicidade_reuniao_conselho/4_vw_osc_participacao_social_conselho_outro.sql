-- Materialized View: portal.vw_osc_participacao_social_conselho_outro

DROP MATERIALIZED VIEW portal.vw_osc_participacao_social_conselho_outro;

CREATE MATERIALIZED VIEW portal.vw_osc_participacao_social_conselho_outro AS 
 SELECT tb_osc.id_osc,
    tb_osc.tx_apelido_osc,
    tb_participacao_social_conselho_outro.id_conselho_outro,
    tb_participacao_social_conselho_outro.tx_nome_conselho,
    tb_participacao_social_conselho_outro.ft_nome_conselho,
    to_char(tb_participacao_social_conselho.dt_data_inicio_conselho::timestamp with time zone, 'DD-MM-YYYY'::text) AS dt_data_inicio_conselho,
    tb_participacao_social_conselho.ft_data_inicio_conselho,
    to_char(tb_participacao_social_conselho.dt_data_fim_conselho::timestamp with time zone, 'DD-MM-YYYY'::text) AS dt_data_fim_conselho,
    tb_participacao_social_conselho.ft_data_fim_conselho,
    tb_participacao_social_conselho.cd_tipo_participacao,
    ( SELECT dc_tipo_participacao.tx_nome_tipo_participacao
           FROM syst.dc_tipo_participacao
          WHERE dc_tipo_participacao.cd_tipo_participacao = tb_participacao_social_conselho.cd_tipo_participacao)::TEXT AS tx_nome_tipo_participacao,
    tb_participacao_social_conselho.ft_tipo_participacao,
	tb_participacao_social_conselho.cd_periodicidade_reuniao_conselho,
    (SELECT tx_nome_periodicidade_reuniao_conselho FROM syst.dc_periodicidade_reuniao_conselho WHERE cd_periodicidade_reuniao_conselho = tb_participacao_social_conselho.cd_periodicidade_reuniao_conselho)::TEXT AS tx_nome_periodicidade_reuniao_conselho,
    tb_participacao_social_conselho.ft_periodicidade_reuniao,
    tb_participacao_social_conselho_outro.id_conselho
   FROM osc.tb_osc
     JOIN osc.tb_participacao_social_conselho ON tb_osc.id_osc = tb_participacao_social_conselho.id_osc
     JOIN osc.tb_participacao_social_conselho_outro ON tb_participacao_social_conselho.id_conselho = tb_participacao_social_conselho_outro.id_conselho
  WHERE tb_osc.bo_osc_ativa
WITH DATA;

ALTER TABLE portal.vw_osc_participacao_social_conselho_outro
  OWNER TO postgres;
