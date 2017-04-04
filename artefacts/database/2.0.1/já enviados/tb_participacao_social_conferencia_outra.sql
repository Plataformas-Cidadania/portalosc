DROP MATERIALIZED VIEW portal.vw_osc_participacao_social_declarada;
DROP TABLE IF EXISTS osc.tb_participacao_social_declarada;
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
COMMENT ON CONSTRAINT pk_tb_participacao_social_conferencia_outra ON osc.tb_participacao_social_conferencia_outra  IS 'Chave primária da tabela conferência outra';
-- ddl-end --
ALTER TABLE osc.tb_participacao_social_conferencia_outra OWNER TO postgres;
-- ddl-end --