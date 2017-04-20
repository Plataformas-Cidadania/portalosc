-- object: osc.tb_participacao_social_conselho_outro | type: TABLE --
DROP TABLE IF EXISTS osc.tb_participacao_social_conselho_outro CASCADE;
CREATE TABLE osc.tb_participacao_social_conselho_outro(
	id_conselho_outro serial NOT NULL,
	tx_nome_conselho text NOT NULL,
	ft_nome_conselho text,
	id_osc integer NOT NULL,
	dt_data_inicio_conselho date,
	ft_data_inicio_conselho text,
	dt_data_fim_conselho date,
	ft_data_fim_conselho text,
	cd_tipo_participacao integer,
	ft_tipo_participacao text,
	tx_periodicidade_reuniao text,
	ft_periodicidade_reuniao text,
	CONSTRAINT pk_id_participacao_social_conselho_outro PRIMARY KEY (id_conselho_outro)

);
-- ddl-end --
COMMENT ON TABLE osc.tb_participacao_social_conselho_outro IS 'Tabela de participação social - outro conselho';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conselho_outro.id_conselho_outro IS 'Identificador outro conselho';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conselho_outro.tx_nome_conselho IS 'Nome do conselho';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conselho_outro.ft_nome_conselho IS 'Fonte nome do conselho';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conselho_outro.id_osc IS 'Identificador da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conselho_outro.dt_data_inicio_conselho IS 'Data inicio do conselho';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conselho_outro.ft_data_inicio_conselho IS 'Fonte do inicio do conselho';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conselho_outro.dt_data_fim_conselho IS 'Data do fim do conselho';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conselho_outro.ft_data_fim_conselho IS 'Fonte fim do conselho';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conselho_outro.cd_tipo_participacao IS 'Tipo de participação';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conselho_outro.ft_tipo_participacao IS 'Fonte tipo partipação';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conselho_outro.tx_periodicidade_reuniao IS 'Periodicidade da reunião';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conselho_outro.ft_periodicidade_reuniao IS 'Fonte da periodicidade da reunião';
-- ddl-end --
COMMENT ON CONSTRAINT pk_id_participacao_social_conselho_outro ON osc.tb_participacao_social_conselho_outro  IS 'Chave primária da tabela';
-- ddl-end --
ALTER TABLE osc.tb_participacao_social_conselho_outro OWNER TO postgres;
-- ddl-end --

