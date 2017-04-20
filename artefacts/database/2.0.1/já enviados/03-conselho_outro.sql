DROP TABLE IF EXISTS osc.tb_participacao_social_conselho_outro CASCADE;
CREATE TABLE osc.tb_participacao_social_conselho_outro(
	id_conselho_outro serial NOT NULL,
	tx_nome_conselho text NOT NULL,
	ft_nome_conselho text,
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
COMMENT ON COLUMN osc.tb_participacao_social_conselho_outro.id_conselho IS 'Identificador do Conselho';
-- ddl-end --
COMMENT ON CONSTRAINT pk_id_participacao_social_conselho_outro ON osc.tb_participacao_social_conselho_outro  IS 'Chave primária da tabela';
-- ddl-end --
ALTER TABLE osc.tb_participacao_social_conselho_outro OWNER TO postgres;
-- ddl-end --

-- object: fk_id_conselho | type: CONSTRAINT --
-- ALTER TABLE osc.tb_participacao_social_conselho_outro DROP CONSTRAINT IF EXISTS fk_id_conselho CASCADE;
ALTER TABLE osc.tb_participacao_social_conselho_outro ADD CONSTRAINT fk_id_conselho FOREIGN KEY (id_conselho)
REFERENCES osc.tb_participacao_social_conselho (id_conselho) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --