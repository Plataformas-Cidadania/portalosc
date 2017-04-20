DROP TABLE IF EXISTS osc.tb_participacao_social_conferencia_outra CASCADE;
CREATE TABLE osc.tb_participacao_social_conferencia_outra(
	id_conferencia_outra serial NOT NULL,
	tx_nome_conferencia text NOT NULL,
	ft_nome_conferencia text,
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
COMMENT ON COLUMN osc.tb_participacao_social_conferencia_outra.id_conferencia IS 'Identificador de conferencia';
-- ddl-end --
COMMENT ON CONSTRAINT pk_tb_participacao_social_conferencia_outra ON osc.tb_participacao_social_conferencia_outra  IS 'Chave primária da tabela conferência outra';
-- ddl-end --
ALTER TABLE osc.tb_participacao_social_conferencia_outra OWNER TO postgres;
-- ddl-end --

-- object: fk_id_conferencia | type: CONSTRAINT --
-- ALTER TABLE osc.tb_participacao_social_conferencia_outra DROP CONSTRAINT IF EXISTS fk_id_conferencia CASCADE;
ALTER TABLE osc.tb_participacao_social_conferencia_outra ADD CONSTRAINT fk_id_conferencia FOREIGN KEY (id_conferencia)
REFERENCES osc.tb_participacao_social_conferencia (id_conferencia) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --
