-- NOTE: the code below contains the SQL for the selected object
-- as well for its dependencies and children (if applicable).
-- 
-- This feature is only a convinience in order to permit you to test
-- the whole object's SQL definition at once.
-- 
-- When exporting or generating the SQL for the whole database model
-- all objects will be placed at their original positions.


-- object: osc.tb_participacao_social_conferencia_outra | type: TABLE --
DROP TABLE IF EXISTS osc.tb_participacao_social_conferencia_outra CASCADE;
CREATE TABLE osc.tb_participacao_social_conferencia_outra(
	id_conferencia_outra serial NOT NULL,
	tx_nome_conferencia text NOT NULL,
	ft_nome_conferencia text,
	id_osc integer NOT NULL,
	dt_ano_realizacao date,
	ft_ano_realizacao text,
	cd_forma_participacao_conferencia integer,
	ft_forma_participacao_conferencia text,
	id_conferencia integer NOT NULL,
	CONSTRAINT pk_tb_participacao_social_conferencia_outra PRIMARY KEY (id_conferencia_outra)

);
-- ddl-end --
COMMENT ON TABLE osc.tb_participacao_social_conferencia_outra IS 'Tabela com as conferências que a OSC faz parte';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conferencia_outra.id_conferencia_outra IS 'Identificador da conferência';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conferencia_outra.tx_nome_conferencia IS 'Nome da conferência';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conferencia_outra.ft_nome_conferencia IS 'Fonte do nome da conferência';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conferencia_outra.id_osc IS 'Identificador da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conferencia_outra.dt_ano_realizacao IS 'Ano de realização da conferência';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conferencia_outra.ft_ano_realizacao IS 'Fonte do ano de realização da conferência';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conferencia_outra.cd_forma_participacao_conferencia IS 'Código da forma de participação em conferência';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conferencia_outra.ft_forma_participacao_conferencia IS 'Fonte da forma de participação em conferência';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conferencia_outra.id_conferencia IS 'Identificador de conferencia';
-- ddl-end --
COMMENT ON CONSTRAINT pk_tb_participacao_social_conferencia_outra ON osc.tb_participacao_social_conferencia_outra  IS 'Chave primária da tabela conferência outra';
-- ddl-end --
ALTER TABLE osc.tb_participacao_social_conferencia_outra OWNER TO postgres;
-- ddl-end --

-- object: fk_id_osc | type: CONSTRAINT --
-- ALTER TABLE osc.tb_participacao_social_conferencia_outra DROP CONSTRAINT IF EXISTS fk_id_osc CASCADE;
ALTER TABLE osc.tb_participacao_social_conferencia_outra ADD CONSTRAINT fk_id_osc FOREIGN KEY (id_osc)
REFERENCES osc.tb_osc (id_osc) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_forma_participacao_conferencia | type: CONSTRAINT --
-- ALTER TABLE osc.tb_participacao_social_conferencia_outra DROP CONSTRAINT IF EXISTS fk_forma_participacao_conferencia CASCADE;
ALTER TABLE osc.tb_participacao_social_conferencia_outra ADD CONSTRAINT fk_forma_participacao_conferencia FOREIGN KEY (cd_forma_participacao_conferencia)
REFERENCES syst.dc_forma_participacao_conferencia (cd_forma_participacao_conferencia) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_id_conferencia | type: CONSTRAINT --
-- ALTER TABLE osc.tb_participacao_social_conferencia_outra DROP CONSTRAINT IF EXISTS fk_id_conferencia CASCADE;
ALTER TABLE osc.tb_participacao_social_conferencia_outra ADD CONSTRAINT fk_id_conferencia FOREIGN KEY (id_conferencia)
REFERENCES osc.tb_participacao_social_conferencia (id_conferencia) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

