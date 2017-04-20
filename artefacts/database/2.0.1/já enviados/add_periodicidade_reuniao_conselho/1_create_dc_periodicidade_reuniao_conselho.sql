-- object: syst.dc_periodicidade_reuniao_conselho | type: TABLE --
DROP TABLE IF EXISTS syst.dc_periodicidade_reuniao_conselho CASCADE;
CREATE TABLE syst.dc_periodicidade_reuniao_conselho(
	cd_periodicidade_reuniao_conselho SERIAL NOT NULL,
	tx_nome_periodicidade_reuniao_conselho TEXT NOT NULL,
	CONSTRAINT pk_dc_periodicidade_reuniao_conselho PRIMARY KEY (cd_periodicidade_reuniao_conselho)
);
-- ddl-end --
COMMENT ON TABLE syst.dc_periodicidade_reuniao_conselho IS 'Dicionário da periodicidade de reunião de conselho';
-- ddl-end --
COMMENT ON COLUMN syst.dc_periodicidade_reuniao_conselho.cd_periodicidade_reuniao_conselho IS 'Código da periodicidade de reunião de conselho';
-- ddl-end --
COMMENT ON COLUMN syst.dc_periodicidade_reuniao_conselho.tx_nome_periodicidade_reuniao_conselho IS 'Nome da periodicidade de reunião de conselho';
-- ddl-end --
ALTER TABLE syst.dc_periodicidade_reuniao_conselho OWNER TO postgres;
-- ddl-end --



INSERT INTO syst.dc_periodicidade_reuniao_conselho (cd_periodicidade_reuniao_conselho, tx_nome_periodicidade_reuniao_conselho) 
VALUES (1, 'Semanal');

INSERT INTO syst.dc_periodicidade_reuniao_conselho (cd_periodicidade_reuniao_conselho, tx_nome_periodicidade_reuniao_conselho) 
VALUES (2, 'Mensal');

INSERT INTO syst.dc_periodicidade_reuniao_conselho (cd_periodicidade_reuniao_conselho, tx_nome_periodicidade_reuniao_conselho) 
VALUES (3, 'Trimestral');

INSERT INTO syst.dc_periodicidade_reuniao_conselho (cd_periodicidade_reuniao_conselho, tx_nome_periodicidade_reuniao_conselho) 
VALUES (4, 'Semestral');

INSERT INTO syst.dc_periodicidade_reuniao_conselho (cd_periodicidade_reuniao_conselho, tx_nome_periodicidade_reuniao_conselho) 
VALUES (5, 'Anual');

INSERT INTO syst.dc_periodicidade_reuniao_conselho (cd_periodicidade_reuniao_conselho, tx_nome_periodicidade_reuniao_conselho) 
VALUES (6, 'Outra');
