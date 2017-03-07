DROP TABLE log.tb_log_alteracao;



-- Table: log.tb_log_alteracao

-- DROP TABLE log.tb_log_alteracao;

CREATE TABLE log.tb_log_alteracao
(
  id_log_alteracao serial NOT NULL, -- Identificador do log de alteração
  tx_nome_tabela TEXT NOT NULL, -- Nome da tabela alterada
  tx_nome_campo TEXT NOT NULL, -- Nome do campo alterada
  id_tabela integer NOT NULL, -- Identificador do tabela alterada
  id_usuario integer NOT NULL, -- Identificador do usuário
  dt_alteracao timestamp without time zone NOT NULL, -- Data de alteração do dado
  tx_dado_anterior text, -- Valor dado anterior
  tx_dado_posterior text, -- Valor do dado atualizado
  CONSTRAINT pk_tb_log_alteracao PRIMARY KEY (id_log_alteracao) -- Chave primária da tabela de log de alteração
)
WITH (
  OIDS=FALSE
);
ALTER TABLE log.tb_log_alteracao
  OWNER TO postgres;
COMMENT ON TABLE log.tb_log_alteracao
  IS 'Tabela de histórico de alteração';
COMMENT ON COLUMN log.tb_log_alteracao.id_log_alteracao IS 'Identificador do log de alteração';
COMMENT ON COLUMN log.tb_log_alteracao.tx_nome_tabela IS 'Nome da tabela alterada';
COMMENT ON COLUMN log.tb_log_alteracao.tx_nome_campo IS 'Nome do campo alterada';
COMMENT ON COLUMN log.tb_log_alteracao.id_tabela IS 'Identificador do tabela alterada';
COMMENT ON COLUMN log.tb_log_alteracao.id_usuario IS 'Identificador do usuário';
COMMENT ON COLUMN log.tb_log_alteracao.dt_alteracao IS 'Data de alteração do dado';
COMMENT ON COLUMN log.tb_log_alteracao.tx_dado_anterior IS 'Valor dado anterior';
COMMENT ON COLUMN log.tb_log_alteracao.tx_dado_posterior IS 'Valor do dado atualizado';

COMMENT ON CONSTRAINT pk_tb_log_alteracao ON log.tb_log_alteracao IS 'Chave primária da tabela de log de alteração';
