-- NOTE: the code below contains the SQL for the selected object
-- as well for its dependencies and children (if applicable).
-- 
-- This feature is only a convinience in order to permit you to test
-- the whole object's SQL definition at once.
-- 
-- When exporting or generating the SQL for the whole database model
-- all objects will be placed at their original positions.


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
	id_conselho integer NOT NULL,
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
COMMENT ON COLUMN osc.tb_participacao_social_conselho_outro.id_conselho IS 'Identificador do Conselho';
-- ddl-end --
COMMENT ON CONSTRAINT pk_id_participacao_social_conselho_outro ON osc.tb_participacao_social_conselho_outro  IS 'Chave primária da tabela';
-- ddl-end --
ALTER TABLE osc.tb_participacao_social_conselho_outro OWNER TO postgres;
-- ddl-end --

-- object: fk_id_osc | type: CONSTRAINT --
-- ALTER TABLE osc.tb_participacao_social_conselho_outro DROP CONSTRAINT IF EXISTS fk_id_osc CASCADE;
ALTER TABLE osc.tb_participacao_social_conselho_outro ADD CONSTRAINT fk_id_osc FOREIGN KEY (id_osc)
REFERENCES osc.tb_osc (id_osc) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_tipo_participacao | type: CONSTRAINT --
-- ALTER TABLE osc.tb_participacao_social_conselho_outro DROP CONSTRAINT IF EXISTS fk_tipo_participacao CASCADE;
ALTER TABLE osc.tb_participacao_social_conselho_outro ADD CONSTRAINT fk_tipo_participacao FOREIGN KEY (cd_tipo_participacao)
REFERENCES syst.dc_tipo_participacao (cd_tipo_participacao) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_id_conselho | type: CONSTRAINT --
-- ALTER TABLE osc.tb_participacao_social_conselho_outro DROP CONSTRAINT IF EXISTS fk_id_conselho CASCADE;
ALTER TABLE osc.tb_participacao_social_conselho_outro ADD CONSTRAINT fk_id_conselho FOREIGN KEY (id_conselho)
REFERENCES osc.tb_participacao_social_conselho (id_conselho) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

