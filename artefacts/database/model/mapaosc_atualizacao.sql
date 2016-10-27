-- Database generated with pgModeler (PostgreSQL Database Modeler).
-- pgModeler  version: 0.8.1
-- PostgreSQL version: 9.4
-- Project Site: pgmodeler.com.br
-- Model Author: ---


-- Database creation must be done outside an multicommand file.
-- These commands were put in this file only for convenience.
-- -- object: mapaosc | type: DATABASE --
-- -- DROP DATABASE IF EXISTS mapaosc;
-- CREATE DATABASE mapaosc
-- 	ENCODING = 'UTF8'
-- 	LC_COLLATE = 'en_US.UTF8'
-- 	LC_CTYPE = 'en_US.UTF8'
-- 	TABLESPACE = pg_default
-- 	OWNER = postgres
-- ;
-- -- ddl-end --
-- 

-- object: topology | type: SCHEMA --
-- DROP SCHEMA IF EXISTS topology CASCADE;
CREATE SCHEMA topology;
-- ddl-end --
ALTER SCHEMA topology OWNER TO postgres;
-- ddl-end --

-- object: log | type: SCHEMA --
-- DROP SCHEMA IF EXISTS log CASCADE;
CREATE SCHEMA log;
-- ddl-end --
ALTER SCHEMA log OWNER TO postgres;
-- ddl-end --

-- object: osc | type: SCHEMA --
-- DROP SCHEMA IF EXISTS osc CASCADE;
CREATE SCHEMA osc;
-- ddl-end --
ALTER SCHEMA osc OWNER TO postgres;
-- ddl-end --

-- object: syst | type: SCHEMA --
-- DROP SCHEMA IF EXISTS syst CASCADE;
CREATE SCHEMA syst;
-- ddl-end --
ALTER SCHEMA syst OWNER TO postgres;
-- ddl-end --

-- object: portal | type: SCHEMA --
-- DROP SCHEMA IF EXISTS portal CASCADE;
CREATE SCHEMA portal;
-- ddl-end --
ALTER SCHEMA portal OWNER TO postgres;
-- ddl-end --

-- object: spat | type: SCHEMA --
-- DROP SCHEMA IF EXISTS spat CASCADE;
CREATE SCHEMA spat;
-- ddl-end --
ALTER SCHEMA spat OWNER TO postgres;
-- ddl-end --

SET search_path TO pg_catalog,public,topology,log,osc,syst,portal,spat;
-- ddl-end --

-- object: postgis | type: EXTENSION --
-- DROP EXTENSION IF EXISTS postgis CASCADE;
CREATE EXTENSION postgis
      WITH SCHEMA public
      VERSION '2.1.7';
-- ddl-end --
COMMENT ON EXTENSION postgis IS 'PostGIS geometry, geography, and raster spatial types and functions';
-- ddl-end --

-- object: postgis_topology | type: EXTENSION --
-- DROP EXTENSION IF EXISTS postgis_topology CASCADE;
CREATE EXTENSION postgis_topology
      WITH SCHEMA topology
      VERSION '2.1.7';
-- ddl-end --
COMMENT ON EXTENSION postgis_topology IS 'PostGIS topology spatial types and functions';
-- ddl-end --

-- object: unaccent | type: EXTENSION --
-- DROP EXTENSION IF EXISTS unaccent CASCADE;
CREATE EXTENSION unaccent
      WITH SCHEMA public
      VERSION '1.0';
-- ddl-end --
COMMENT ON EXTENSION unaccent IS 'text search dictionary that removes accents';
-- ddl-end --

-- object: log.tb_log_carga | type: TABLE --
-- DROP TABLE IF EXISTS log.tb_log_carga CASCADE;
CREATE TABLE log.tb_log_carga(
	id_log_carga serial NOT NULL,
	cd_identificador_osc integer NOT NULL,
	id_fonte_dados integer NOT NULL,
	cd_status smallint NOT NULL,
	tx_mensagem text NOT NULL,
	CONSTRAINT pk_tb_log_carga PRIMARY KEY (id_log_carga)

);
-- ddl-end --
COMMENT ON TABLE log.tb_log_carga IS 'Log da carga dos dados';
-- ddl-end --
COMMENT ON COLUMN log.tb_log_carga.id_log_carga IS 'Código sequência do log';
-- ddl-end --
COMMENT ON COLUMN log.tb_log_carga.cd_identificador_osc IS 'Número do CNPJ da OSC';
-- ddl-end --
COMMENT ON COLUMN log.tb_log_carga.id_fonte_dados IS 'Chave estrangeira';
-- ddl-end --
COMMENT ON COLUMN log.tb_log_carga.cd_status IS 'Chave estrangeira';
-- ddl-end --
COMMENT ON COLUMN log.tb_log_carga.tx_mensagem IS 'Mensagem de log';
-- ddl-end --
ALTER TABLE log.tb_log_carga OWNER TO postgres;
-- ddl-end --

-- object: osc.tb_osc | type: TABLE --
-- DROP TABLE IF EXISTS osc.tb_osc CASCADE;
CREATE TABLE osc.tb_osc(
	id_osc serial NOT NULL,
	tx_apelido_osc text,
	ft_apelido_osc text,
	cd_identificador_osc numeric(14,0) NOT NULL,
	ft_identificador_osc text,
	ft_osc_ativa text,
	bo_osc_ativa boolean NOT NULL,
	CONSTRAINT pk_tb_osc PRIMARY KEY (id_osc),
	CONSTRAINT un_cd_identificador_osc UNIQUE (cd_identificador_osc)

);
-- ddl-end --
COMMENT ON TABLE osc.tb_osc IS 'Tabela das OSCs';
-- ddl-end --
COMMENT ON COLUMN osc.tb_osc.id_osc IS 'Identificador da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_osc.tx_apelido_osc IS 'Apelido da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_osc.ft_apelido_osc IS 'Fonte do apelido da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_osc.cd_identificador_osc IS 'Número de identificação da OSC - CNPJ ou CEI';
-- ddl-end --
COMMENT ON COLUMN osc.tb_osc.ft_identificador_osc IS 'Fonte do número identificador da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_osc.ft_osc_ativa IS 'Fonte do status da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_osc.bo_osc_ativa IS 'Flag de OSC Ativa';
-- ddl-end --
COMMENT ON CONSTRAINT pk_tb_osc ON osc.tb_osc  IS 'Chave primária da OSC';
-- ddl-end --
ALTER TABLE osc.tb_osc OWNER TO postgres;
-- ddl-end --

-- object: osc.tb_contato | type: TABLE --
-- DROP TABLE IF EXISTS osc.tb_contato CASCADE;
CREATE TABLE osc.tb_contato(
	id_osc integer NOT NULL,
	tx_telefone text,
	ft_telefone text,
	tx_email text,
	ft_email text,
	nm_representante text,
	ft_representante text,
	tx_site text,
	ft_site text,
	tx_facebook text,
	ft_facebook text,
	tx_google text,
	ft_google text,
	tx_linkedin text,
	ft_linkedin text,
	tx_twitter text,
	ft_twitter text,
	CONSTRAINT pk_tb_contato PRIMARY KEY (id_osc)

);
-- ddl-end --
COMMENT ON TABLE osc.tb_contato IS 'Contatos da OSC por fonte de dados';
-- ddl-end --
COMMENT ON COLUMN osc.tb_contato.id_osc IS 'Identificador da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_contato.tx_telefone IS 'Telefone da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_contato.ft_telefone IS 'Fonte do telefone';
-- ddl-end --
COMMENT ON COLUMN osc.tb_contato.tx_email IS 'Email da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_contato.ft_email IS 'Fonte do email';
-- ddl-end --
COMMENT ON COLUMN osc.tb_contato.nm_representante IS 'Nome do representante legal da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_contato.ft_representante IS 'Fonte do representante';
-- ddl-end --
COMMENT ON COLUMN osc.tb_contato.tx_site IS 'Endereço do site da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_contato.ft_site IS 'Fonte do site';
-- ddl-end --
COMMENT ON COLUMN osc.tb_contato.tx_facebook IS 'Facebook OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_contato.ft_facebook IS 'Fonte do facebook';
-- ddl-end --
COMMENT ON COLUMN osc.tb_contato.tx_google IS 'Google+ OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_contato.ft_google IS 'Fonte do google';
-- ddl-end --
COMMENT ON COLUMN osc.tb_contato.tx_linkedin IS 'Linkedin OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_contato.ft_linkedin IS 'Fonte do linkedin';
-- ddl-end --
COMMENT ON COLUMN osc.tb_contato.tx_twitter IS 'Twitter OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_contato.ft_twitter IS 'Fonte twitter';
-- ddl-end --
COMMENT ON CONSTRAINT pk_tb_contato ON osc.tb_contato  IS 'Chave primária da tabela de Contato';
-- ddl-end --
ALTER TABLE osc.tb_contato OWNER TO postgres;
-- ddl-end --

-- object: syst.dc_status_carga | type: TABLE --
-- DROP TABLE IF EXISTS syst.dc_status_carga CASCADE;
CREATE TABLE syst.dc_status_carga(
	cd_status serial NOT NULL,
	tx_nome_status text NOT NULL,
	tx_descricao_status text NOT NULL,
	CONSTRAINT pk_dcsc PRIMARY KEY (cd_status)

);
-- ddl-end --
COMMENT ON TABLE syst.dc_status_carga IS 'Status da carga do dado';
-- ddl-end --
COMMENT ON COLUMN syst.dc_status_carga.cd_status IS 'Código do status';
-- ddl-end --
COMMENT ON COLUMN syst.dc_status_carga.tx_nome_status IS 'Nome do status';
-- ddl-end --
COMMENT ON COLUMN syst.dc_status_carga.tx_descricao_status IS 'Descrição do status';
-- ddl-end --
COMMENT ON CONSTRAINT pk_dcsc ON syst.dc_status_carga  IS 'Chave primária';
-- ddl-end --
ALTER TABLE syst.dc_status_carga OWNER TO postgres;
-- ddl-end --

-- object: osc.tb_localizacao | type: TABLE --
-- DROP TABLE IF EXISTS osc.tb_localizacao CASCADE;
CREATE TABLE osc.tb_localizacao(
	id_osc integer NOT NULL,
	tx_endereco text,
	ft_endereco text,
	nr_localizacao integer,
	ft_localizacao text,
	tx_endereco_complemento text,
	ft_endereco_complemento text,
	tx_bairro text,
	ft_bairro text,
	cd_municipio numeric(7,0) NOT NULL,
	ft_municipio text,
	geo_localizacao geometry(POINT, 4674),
	ft_geo_localizacao text,
	nr_cep numeric(8,0),
	ft_cep text,
	tx_endereco_corrigido text,
	ft_endereco_corrigido text,
	tx_bairro_encontrado text,
	ft_bairro_encontrado text,
	cd_fonte_geocodificacao integer,
	ft_fonte_geocodificacao text,
	dt_geocodificacao date,
	ft_data_geocodificacao text,
	CONSTRAINT pk_tb_localizacao PRIMARY KEY (id_osc)

);
-- ddl-end --
COMMENT ON TABLE osc.tb_localizacao IS 'Localizações da OSC nas várias fontes de dados pesquisadas';
-- ddl-end --
COMMENT ON COLUMN osc.tb_localizacao.id_osc IS 'Identificador da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_localizacao.tx_endereco IS 'Descrição do endereço com Logradouro, número e bairro';
-- ddl-end --
COMMENT ON COLUMN osc.tb_localizacao.ft_endereco IS 'Fonte do endereço';
-- ddl-end --
COMMENT ON COLUMN osc.tb_localizacao.nr_localizacao IS 'Número da localização';
-- ddl-end --
COMMENT ON COLUMN osc.tb_localizacao.ft_localizacao IS 'Fonte do número da localização';
-- ddl-end --
COMMENT ON COLUMN osc.tb_localizacao.tx_endereco_complemento IS 'Complemento do endereço';
-- ddl-end --
COMMENT ON COLUMN osc.tb_localizacao.ft_endereco_complemento IS 'Fonte complemento do endereço';
-- ddl-end --
COMMENT ON COLUMN osc.tb_localizacao.tx_bairro IS 'Nome do Bairro quando houver na fonte de dados';
-- ddl-end --
COMMENT ON COLUMN osc.tb_localizacao.ft_bairro IS 'Fonte do bairro';
-- ddl-end --
COMMENT ON COLUMN osc.tb_localizacao.cd_municipio IS 'Chave estrangeira do município';
-- ddl-end --
COMMENT ON COLUMN osc.tb_localizacao.ft_municipio IS 'Fonte do município';
-- ddl-end --
COMMENT ON COLUMN osc.tb_localizacao.geo_localizacao IS 'Localização da OSC na fonte de dados em coordenadas geográficas (Geometria Postgis)';
-- ddl-end --
COMMENT ON COLUMN osc.tb_localizacao.ft_geo_localizacao IS 'Fonte de geolocalização';
-- ddl-end --
COMMENT ON COLUMN osc.tb_localizacao.nr_cep IS 'Código de endereçamento postal';
-- ddl-end --
COMMENT ON COLUMN osc.tb_localizacao.ft_cep IS 'Fonte do CEP';
-- ddl-end --
COMMENT ON COLUMN osc.tb_localizacao.tx_endereco_corrigido IS 'Endereço formatado e corrigido após processo de geocodificação';
-- ddl-end --
COMMENT ON COLUMN osc.tb_localizacao.ft_endereco_corrigido IS 'Fonte do endereço corrido';
-- ddl-end --
COMMENT ON COLUMN osc.tb_localizacao.tx_bairro_encontrado IS 'Bairro encontrado após a geocodificação dos endereços';
-- ddl-end --
COMMENT ON COLUMN osc.tb_localizacao.ft_bairro_encontrado IS 'Fonte bairro encontrado';
-- ddl-end --
COMMENT ON COLUMN osc.tb_localizacao.cd_fonte_geocodificacao IS 'Chave estrangeira (código da fonte da geocodificação)';
-- ddl-end --
COMMENT ON COLUMN osc.tb_localizacao.ft_fonte_geocodificacao IS 'Fonte do dado de fonte da geocodificação';
-- ddl-end --
COMMENT ON COLUMN osc.tb_localizacao.dt_geocodificacao IS 'Data da geocodificação';
-- ddl-end --
COMMENT ON COLUMN osc.tb_localizacao.ft_data_geocodificacao IS 'Fonte da data de geocodificação';
-- ddl-end --
COMMENT ON CONSTRAINT pk_tb_localizacao ON osc.tb_localizacao  IS 'Chave primária da tabela Localização';
-- ddl-end --
ALTER TABLE osc.tb_localizacao OWNER TO postgres;
-- ddl-end --

-- object: osc.tb_projeto | type: TABLE --
-- DROP TABLE IF EXISTS osc.tb_projeto CASCADE;
CREATE TABLE osc.tb_projeto(
	id_projeto serial NOT NULL,
	id_osc integer,
	tx_nome_projeto text,
	ft_nome_projeto text,
	cd_status_projeto integer,
	ft_status_projeto text,
	dt_data_inicio_projeto date,
	ft_data_inicio_projeto text,
	dt_data_fim_projeto date,
	ft_data_fim_projeto text,
	tx_link_projeto text,
	ft_link_projeto text,
	nr_total_beneficiarios smallint,
	ft_total_beneficiarios text,
	nr_valor_captado_projeto double precision,
	ft_valor_captado_projeto text,
	nr_valor_total_projeto double precision,
	ft_valor_total_projeto text,
	cd_abrangencia_projeto integer,
	ft_abrangencia_projeto text,
	cd_zona_atuacao_projeto integer,
	ft_zona_atuacao_projeto text,
	tx_descricao_projeto text,
	ft_descricao_projeto text,
	ft_metodologia_monitoramento text,
	tx_metodologia_monitoramento text,
	tx_identificador_projeto_externo text,
	ft_identificador_projeto_externo text,
	CONSTRAINT pk_tb_projeto PRIMARY KEY (id_projeto)

);
-- ddl-end --
COMMENT ON TABLE osc.tb_projeto IS 'Tabela de projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_projeto.id_projeto IS 'Identificador do projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_projeto.id_osc IS 'Identificador da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_projeto.tx_nome_projeto IS 'Nome do projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_projeto.ft_nome_projeto IS 'Fonte do nome do projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_projeto.cd_status_projeto IS 'Código do status do projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_projeto.ft_status_projeto IS 'Fonte do status do projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_projeto.dt_data_inicio_projeto IS 'Data do início do projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_projeto.ft_data_inicio_projeto IS 'Fonte da data de inicio do projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_projeto.dt_data_fim_projeto IS 'Data do fim do projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_projeto.ft_data_fim_projeto IS 'Fonte da data do fim do projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_projeto.tx_link_projeto IS 'Link do projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_projeto.ft_link_projeto IS 'Fonte do link do projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_projeto.nr_total_beneficiarios IS 'Número total de beneficiarios do projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_projeto.ft_total_beneficiarios IS 'Fonte total de beneficiários';
-- ddl-end --
COMMENT ON COLUMN osc.tb_projeto.nr_valor_captado_projeto IS 'Valor captado do projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_projeto.ft_valor_captado_projeto IS 'Fonte valor captado do projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_projeto.nr_valor_total_projeto IS 'Valor total do projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_projeto.ft_valor_total_projeto IS 'Fonte do valor total do projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_projeto.cd_abrangencia_projeto IS 'Código da abrangência do projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_projeto.ft_abrangencia_projeto IS 'Fonte abrangencia do projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_projeto.cd_zona_atuacao_projeto IS 'Código da zona de atuação do projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_projeto.ft_zona_atuacao_projeto IS 'Fonte da zona de atuação do projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_projeto.tx_descricao_projeto IS 'Descrição do projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_projeto.ft_descricao_projeto IS 'Fonte da descrição do projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_projeto.ft_metodologia_monitoramento IS 'Fonte da metodologia de monitoramento do projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_projeto.tx_metodologia_monitoramento IS 'Metodologia de monitoramento do projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_projeto.tx_identificador_projeto_externo IS 'Identificador externo de projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_projeto.ft_identificador_projeto_externo IS 'Fonte de projeto externo';
-- ddl-end --
COMMENT ON CONSTRAINT pk_tb_projeto ON osc.tb_projeto  IS 'Chave primária da tabela de projeto';
-- ddl-end --
ALTER TABLE osc.tb_projeto OWNER TO postgres;
-- ddl-end --

-- object: osc.tb_governanca | type: TABLE --
-- DROP TABLE IF EXISTS osc.tb_governanca CASCADE;
CREATE TABLE osc.tb_governanca(
	id_dirigente serial NOT NULL,
	id_osc integer,
	tx_cargo_dirigente text NOT NULL,
	ft_cargo_dirigente text,
	tx_nome_dirigente text NOT NULL,
	ft_nome_dirigente text,
	CONSTRAINT pk_tb_dirigente PRIMARY KEY (id_dirigente)

);
-- ddl-end --
COMMENT ON TABLE osc.tb_governanca IS 'Tabela de Dirigentes';
-- ddl-end --
COMMENT ON COLUMN osc.tb_governanca.id_dirigente IS 'Identificador do Dirigente';
-- ddl-end --
COMMENT ON COLUMN osc.tb_governanca.id_osc IS 'Identificador da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_governanca.tx_cargo_dirigente IS 'Cargo do Dirigente';
-- ddl-end --
COMMENT ON COLUMN osc.tb_governanca.ft_cargo_dirigente IS 'Fonte do cargo do dirigente';
-- ddl-end --
COMMENT ON COLUMN osc.tb_governanca.tx_nome_dirigente IS 'Nome do Dirigente';
-- ddl-end --
COMMENT ON COLUMN osc.tb_governanca.ft_nome_dirigente IS 'Fonte do nome do dirigente';
-- ddl-end --
COMMENT ON CONSTRAINT pk_tb_dirigente ON osc.tb_governanca  IS 'Chave primária da tabela Dirigente';
-- ddl-end --
ALTER TABLE osc.tb_governanca OWNER TO postgres;
-- ddl-end --

-- object: osc.tb_certificado | type: TABLE --
-- DROP TABLE IF EXISTS osc.tb_certificado CASCADE;
CREATE TABLE osc.tb_certificado(
	id_certificado serial NOT NULL,
	id_osc integer,
	cd_certificado integer,
	ft_certificado text,
	dt_inicio_certificado date,
	ft_inicio_certificado text,
	dt_fim_certificado date,
	ft_fim_certificado text,
	CONSTRAINT pk_tb_certificado PRIMARY KEY (id_certificado)

);
-- ddl-end --
COMMENT ON TABLE osc.tb_certificado IS 'Tabela de Certificados';
-- ddl-end --
COMMENT ON COLUMN osc.tb_certificado.id_certificado IS 'Identificador do certificado';
-- ddl-end --
COMMENT ON COLUMN osc.tb_certificado.id_osc IS 'Identificador da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_certificado.cd_certificado IS 'Código do certificado';
-- ddl-end --
COMMENT ON COLUMN osc.tb_certificado.ft_certificado IS 'Fonte do certificado';
-- ddl-end --
COMMENT ON COLUMN osc.tb_certificado.dt_inicio_certificado IS 'Data de início do certificado';
-- ddl-end --
COMMENT ON COLUMN osc.tb_certificado.ft_inicio_certificado IS 'Fonte da data de início do certificado';
-- ddl-end --
COMMENT ON COLUMN osc.tb_certificado.dt_fim_certificado IS 'Data final do certificado';
-- ddl-end --
COMMENT ON COLUMN osc.tb_certificado.ft_fim_certificado IS 'Fonte da data de fim do certificado';
-- ddl-end --
COMMENT ON CONSTRAINT pk_tb_certificado ON osc.tb_certificado  IS 'Chave primária da tabela de Certificado';
-- ddl-end --
ALTER TABLE osc.tb_certificado OWNER TO postgres;
-- ddl-end --

-- object: syst.dc_subclasse_atividade_economica | type: TABLE --
-- DROP TABLE IF EXISTS syst.dc_subclasse_atividade_economica CASCADE;
CREATE TABLE syst.dc_subclasse_atividade_economica(
	cd_subclasse_atividade_economica numeric(7,0) NOT NULL,
	cd_classe_atividade_economica character varying(10) NOT NULL,
	tx_nome_subclasse_atividade_economica text NOT NULL,
	CONSTRAINT pk_cd_subclasse_atividade_economica PRIMARY KEY (cd_subclasse_atividade_economica)

);
-- ddl-end --
COMMENT ON TABLE syst.dc_subclasse_atividade_economica IS 'Dicionário da subclasse do CNAE 2.1';
-- ddl-end --
COMMENT ON COLUMN syst.dc_subclasse_atividade_economica.cd_subclasse_atividade_economica IS 'Código da Atividade Econômica';
-- ddl-end --
COMMENT ON COLUMN syst.dc_subclasse_atividade_economica.cd_classe_atividade_economica IS 'Código da Atividade Economica com traço e barras';
-- ddl-end --
COMMENT ON COLUMN syst.dc_subclasse_atividade_economica.tx_nome_subclasse_atividade_economica IS 'Nome da subclasse da atividade economica';
-- ddl-end --
COMMENT ON CONSTRAINT pk_cd_subclasse_atividade_economica ON syst.dc_subclasse_atividade_economica  IS 'Chave primária da tabela subclasse atividade economica';
-- ddl-end --
ALTER TABLE syst.dc_subclasse_atividade_economica OWNER TO postgres;
-- ddl-end --

-- object: syst.dc_natureza_juridica | type: TABLE --
-- DROP TABLE IF EXISTS syst.dc_natureza_juridica CASCADE;
CREATE TABLE syst.dc_natureza_juridica(
	cd_natureza_juridica numeric(4,0) NOT NULL,
	tx_natureza_juridica text NOT NULL,
	CONSTRAINT pk_dc_natureza_juridica PRIMARY KEY (cd_natureza_juridica)

);
-- ddl-end --
COMMENT ON TABLE syst.dc_natureza_juridica IS 'Dicionário da natureza jurídica das entidades sem fins lucrativos segundo o CONCLA';
-- ddl-end --
COMMENT ON COLUMN syst.dc_natureza_juridica.cd_natureza_juridica IS 'Código da natureza jurídica';
-- ddl-end --
COMMENT ON COLUMN syst.dc_natureza_juridica.tx_natureza_juridica IS 'Denominação da natureza jurídica';
-- ddl-end --
COMMENT ON CONSTRAINT pk_dc_natureza_juridica ON syst.dc_natureza_juridica  IS 'Chave primária da natureza jurídica';
-- ddl-end --
ALTER TABLE syst.dc_natureza_juridica OWNER TO postgres;
-- ddl-end --

-- object: osc.tb_dados_gerais | type: TABLE --
-- DROP TABLE IF EXISTS osc.tb_dados_gerais CASCADE;
CREATE TABLE osc.tb_dados_gerais(
	id_osc integer NOT NULL,
	cd_natureza_juridica_osc numeric(4),
	ft_natureza_juridica_osc text,
	cd_subclasse_atividade_economica_osc numeric(9),
	ft_subclasse_atividade_economica_osc text,
	tx_razao_social_osc text NOT NULL,
	ft_razao_social_osc text,
	tx_nome_fantasia_osc text,
	ft_nome_fantasia_osc text,
	im_logo bytea,
	ft_logo text,
	tx_missao_osc text,
	ft_missao_osc text,
	tx_visao_osc text,
	ft_visao_osc text,
	dt_fundacao_osc date,
	ft_fundacao_osc text,
	dt_ano_cadastro_cnpj date,
	ft_ano_cadastro_cnpj text,
	tx_sigla_osc text,
	ft_sigla_osc text,
	tx_resumo_osc text,
	ft_resumo_osc text,
	cd_situacao_imovel_osc integer,
	ft_situacao_imovel_osc text,
	tx_link_estatuto_osc text,
	ft_link_estatuto_osc text,
	tx_historico text,
	ft_historico text,
	tx_finalidades_estatutarias text,
	ft_finalidades_estatutarias text,
	tx_link_relatorio_auditoria text,
	ft_link_relatorio_auditoria text,
	tx_link_demonstracao_contabil text,
	ft_link_demonstracao_contabil text,
	tx_nome_responsavel_legal text,
	ft_nome_responsavel_legal text,
	CONSTRAINT pk_tb_dados_gerais PRIMARY KEY (id_osc)

);
-- ddl-end --
COMMENT ON TABLE osc.tb_dados_gerais IS 'Tabela de dados gerais';
-- ddl-end --
COMMENT ON COLUMN osc.tb_dados_gerais.id_osc IS 'Identificador OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_dados_gerais.cd_natureza_juridica_osc IS 'Código da natureza jurídica';
-- ddl-end --
COMMENT ON COLUMN osc.tb_dados_gerais.ft_natureza_juridica_osc IS 'Fonte da natureza jurídica';
-- ddl-end --
COMMENT ON COLUMN osc.tb_dados_gerais.cd_subclasse_atividade_economica_osc IS 'Código da subclasse da atividade econômica';
-- ddl-end --
COMMENT ON COLUMN osc.tb_dados_gerais.ft_subclasse_atividade_economica_osc IS 'Fonte subclasse da atividade econômica';
-- ddl-end --
COMMENT ON COLUMN osc.tb_dados_gerais.tx_razao_social_osc IS 'Razão Social OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_dados_gerais.ft_razao_social_osc IS 'Fonte da razão social';
-- ddl-end --
COMMENT ON COLUMN osc.tb_dados_gerais.tx_nome_fantasia_osc IS 'Nome Fantasia OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_dados_gerais.ft_nome_fantasia_osc IS 'Fonte do nome fantasia';
-- ddl-end --
COMMENT ON COLUMN osc.tb_dados_gerais.im_logo IS 'Imagem da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_dados_gerais.ft_logo IS 'Fonte do logo';
-- ddl-end --
COMMENT ON COLUMN osc.tb_dados_gerais.tx_missao_osc IS 'Missão da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_dados_gerais.ft_missao_osc IS 'Fonte da missão';
-- ddl-end --
COMMENT ON COLUMN osc.tb_dados_gerais.tx_visao_osc IS 'Visão da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_dados_gerais.ft_visao_osc IS 'Fonte da visão';
-- ddl-end --
COMMENT ON COLUMN osc.tb_dados_gerais.dt_fundacao_osc IS 'Data de Fundação da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_dados_gerais.ft_fundacao_osc IS 'Fonte data de fundação';
-- ddl-end --
COMMENT ON COLUMN osc.tb_dados_gerais.dt_ano_cadastro_cnpj IS 'Data de cadastro do CNPJ da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_dados_gerais.ft_ano_cadastro_cnpj IS 'Fonte da data de cadastro do CNPJ da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_dados_gerais.tx_sigla_osc IS 'Sigla da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_dados_gerais.ft_sigla_osc IS 'Fonte sigla';
-- ddl-end --
COMMENT ON COLUMN osc.tb_dados_gerais.tx_resumo_osc IS 'Resumo da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_dados_gerais.ft_resumo_osc IS 'Fonte resumo';
-- ddl-end --
COMMENT ON COLUMN osc.tb_dados_gerais.cd_situacao_imovel_osc IS 'Situação do Imóvel da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_dados_gerais.ft_situacao_imovel_osc IS 'Fonte situação do imóvel';
-- ddl-end --
COMMENT ON COLUMN osc.tb_dados_gerais.tx_link_estatuto_osc IS 'Link do estatuto da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_dados_gerais.ft_link_estatuto_osc IS 'Fonte link do estatuto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_dados_gerais.tx_historico IS 'Descrição do histórico da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_dados_gerais.ft_historico IS 'Fonte do histórico da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_dados_gerais.tx_finalidades_estatutarias IS 'Descrição das finalidades estatutárias da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_dados_gerais.ft_finalidades_estatutarias IS 'Fonte finalidades estatutarias';
-- ddl-end --
COMMENT ON COLUMN osc.tb_dados_gerais.tx_link_relatorio_auditoria IS 'Link do relatório de auditoria';
-- ddl-end --
COMMENT ON COLUMN osc.tb_dados_gerais.ft_link_relatorio_auditoria IS 'Fonte link relatório de auditoria';
-- ddl-end --
COMMENT ON COLUMN osc.tb_dados_gerais.tx_link_demonstracao_contabil IS 'Link da demostração contábil';
-- ddl-end --
COMMENT ON COLUMN osc.tb_dados_gerais.ft_link_demonstracao_contabil IS 'Fonte link demonstração contábil';
-- ddl-end --
COMMENT ON COLUMN osc.tb_dados_gerais.tx_nome_responsavel_legal IS 'Nome do responável legal';
-- ddl-end --
COMMENT ON COLUMN osc.tb_dados_gerais.ft_nome_responsavel_legal IS 'Fonte nome do responsável legal';
-- ddl-end --
COMMENT ON CONSTRAINT pk_tb_dados_gerais ON osc.tb_dados_gerais  IS 'Chave primária da tabela dados gerais';
-- ddl-end --
ALTER TABLE osc.tb_dados_gerais OWNER TO postgres;
-- ddl-end --

-- object: osc.tb_relacoes_trabalho | type: TABLE --
-- DROP TABLE IF EXISTS osc.tb_relacoes_trabalho CASCADE;
CREATE TABLE osc.tb_relacoes_trabalho(
	id_osc integer NOT NULL,
	nr_trabalhadores_vinculo integer,
	ft_trabalhadores_vinculo text,
	nr_trabalhadores_deficiencia integer,
	ft_trabalhadores_deficiencia text,
	nr_trabalhadores_voluntarios integer,
	ft_trabalhadores_voluntarios text,
	CONSTRAINT pk_tb_vinculo PRIMARY KEY (id_osc)

);
-- ddl-end --
COMMENT ON TABLE osc.tb_relacoes_trabalho IS 'Tabela de relações de trabalho';
-- ddl-end --
COMMENT ON COLUMN osc.tb_relacoes_trabalho.id_osc IS 'Identificador da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_relacoes_trabalho.nr_trabalhadores_vinculo IS 'Número de trabalhadores com vínculo';
-- ddl-end --
COMMENT ON COLUMN osc.tb_relacoes_trabalho.ft_trabalhadores_vinculo IS 'Fonte do número de trabalhadores com vínculo';
-- ddl-end --
COMMENT ON COLUMN osc.tb_relacoes_trabalho.nr_trabalhadores_deficiencia IS 'Número de trabalhadores portadores de deficiência';
-- ddl-end --
COMMENT ON COLUMN osc.tb_relacoes_trabalho.ft_trabalhadores_deficiencia IS 'Fonte do número de trabalhadores portadores de deficiência';
-- ddl-end --
COMMENT ON COLUMN osc.tb_relacoes_trabalho.nr_trabalhadores_voluntarios IS 'Número de trabalhadores voluntários';
-- ddl-end --
COMMENT ON COLUMN osc.tb_relacoes_trabalho.ft_trabalhadores_voluntarios IS 'Fonte do número de trabalhadores voluntários';
-- ddl-end --
COMMENT ON CONSTRAINT pk_tb_vinculo ON osc.tb_relacoes_trabalho  IS 'Chave primária da tabela de vínculos';
-- ddl-end --
ALTER TABLE osc.tb_relacoes_trabalho OWNER TO postgres;
-- ddl-end --

-- object: syst.dc_fonte_dados | type: TABLE --
-- DROP TABLE IF EXISTS syst.dc_fonte_dados CASCADE;
CREATE TABLE syst.dc_fonte_dados(
	cd_sigla_fonte_dados character varying(15) NOT NULL,
	tx_nome_fonte_dados text NOT NULL,
	tx_descricao_fonte_dados text,
	tx_referencia_fonte_dados text,
	CONSTRAINT pk_dc_fonte_dados PRIMARY KEY (cd_sigla_fonte_dados)

);
-- ddl-end --
COMMENT ON TABLE syst.dc_fonte_dados IS 'Tabela dicionário das fontes de dados';
-- ddl-end --
COMMENT ON COLUMN syst.dc_fonte_dados.cd_sigla_fonte_dados IS 'Código Fonte de Dados';
-- ddl-end --
COMMENT ON COLUMN syst.dc_fonte_dados.tx_nome_fonte_dados IS 'Nome da Fonte de Dados';
-- ddl-end --
COMMENT ON COLUMN syst.dc_fonte_dados.tx_descricao_fonte_dados IS 'Descrição da Fonte de Dados';
-- ddl-end --
COMMENT ON COLUMN syst.dc_fonte_dados.tx_referencia_fonte_dados IS 'Referência da Fonte de Dados';
-- ddl-end --
COMMENT ON CONSTRAINT pk_dc_fonte_dados ON syst.dc_fonte_dados  IS 'Chave primária fonte de dados (dicionário)';
-- ddl-end --
ALTER TABLE syst.dc_fonte_dados OWNER TO postgres;
-- ddl-end --

-- object: syst.dc_certificado | type: TABLE --
-- DROP TABLE IF EXISTS syst.dc_certificado CASCADE;
CREATE TABLE syst.dc_certificado(
	cd_certificado serial NOT NULL,
	tx_nome_certificado text NOT NULL,
	CONSTRAINT pk_dc_certificado PRIMARY KEY (cd_certificado)

);
-- ddl-end --
COMMENT ON TABLE syst.dc_certificado IS 'Tabela de dicionário de certificados';
-- ddl-end --
COMMENT ON COLUMN syst.dc_certificado.cd_certificado IS 'Código do Certificado';
-- ddl-end --
COMMENT ON COLUMN syst.dc_certificado.tx_nome_certificado IS 'Nome do Certificado';
-- ddl-end --
COMMENT ON CONSTRAINT pk_dc_certificado ON syst.dc_certificado  IS 'Chave primária do certificado (dicionário)';
-- ddl-end --
ALTER TABLE syst.dc_certificado OWNER TO postgres;
-- ddl-end --

-- object: syst.dc_tipo_participacao | type: TABLE --
-- DROP TABLE IF EXISTS syst.dc_tipo_participacao CASCADE;
CREATE TABLE syst.dc_tipo_participacao(
	cd_tipo_participacao serial NOT NULL,
	nm_tipo_participacao character varying(30) NOT NULL,
	CONSTRAINT pk_dc_tipo_participacao PRIMARY KEY (cd_tipo_participacao)

);
-- ddl-end --
COMMENT ON TABLE syst.dc_tipo_participacao IS 'Tipo de participação no conselho';
-- ddl-end --
COMMENT ON COLUMN syst.dc_tipo_participacao.cd_tipo_participacao IS 'Código do tipo de participação';
-- ddl-end --
COMMENT ON COLUMN syst.dc_tipo_participacao.nm_tipo_participacao IS 'Nome do tipo de participação';
-- ddl-end --
COMMENT ON CONSTRAINT pk_dc_tipo_participacao ON syst.dc_tipo_participacao  IS 'Chave primária do tipo de participação (dicionário)';
-- ddl-end --
ALTER TABLE syst.dc_tipo_participacao OWNER TO postgres;
-- ddl-end --

-- object: osc.tb_participacao_social_conselho | type: TABLE --
-- DROP TABLE IF EXISTS osc.tb_participacao_social_conselho CASCADE;
CREATE TABLE osc.tb_participacao_social_conselho(
	id_conselho serial NOT NULL,
	id_osc integer,
	cd_conselho integer,
	ft_conselho text,
	cd_tipo_participacao integer NOT NULL,
	ft_tipo_participacao text,
	tx_periodicidade_reuniao text,
	ft_periodicidade_reuniao text,
	CONSTRAINT pk_tb_conselho PRIMARY KEY (id_conselho),
	CONSTRAINT un_tb_conselho UNIQUE (id_osc,cd_conselho)

);
-- ddl-end --
COMMENT ON TABLE osc.tb_participacao_social_conselho IS 'Tabela de relacionamento M:N entre a OSC e os Conselhos e comissões que ela participa';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conselho.id_conselho IS 'Identificador da tabela conselho';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conselho.id_osc IS 'Identificador da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conselho.cd_conselho IS 'Chave estrangeira (código do conselho)';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conselho.ft_conselho IS 'Fonte do conselho';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conselho.cd_tipo_participacao IS 'Código do tipo de participação';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conselho.ft_tipo_participacao IS 'Fonte do tipo de participação';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conselho.tx_periodicidade_reuniao IS 'Periodicidade da reunião do conselho';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conselho.ft_periodicidade_reuniao IS 'Fonte da periodicidade da reunião';
-- ddl-end --
COMMENT ON CONSTRAINT pk_tb_conselho ON osc.tb_participacao_social_conselho  IS 'Chave primária da tabela Conselho';
-- ddl-end --
COMMENT ON CONSTRAINT un_tb_conselho ON osc.tb_participacao_social_conselho  IS 'OSC e Conselho únicos';
-- ddl-end --
ALTER TABLE osc.tb_participacao_social_conselho OWNER TO postgres;
-- ddl-end --

-- object: syst.dc_conselho | type: TABLE --
-- DROP TABLE IF EXISTS syst.dc_conselho CASCADE;
CREATE TABLE syst.dc_conselho(
	cd_conselho serial NOT NULL,
	tx_nome_conselho character varying(100) NOT NULL,
	tx_nome_orgao_vinculado character varying(100) NOT NULL,
	CONSTRAINT pk_dc_conselho PRIMARY KEY (cd_conselho)

);
-- ddl-end --
COMMENT ON TABLE syst.dc_conselho IS 'Tabela de conselhos';
-- ddl-end --
COMMENT ON COLUMN syst.dc_conselho.cd_conselho IS 'Código do conselho';
-- ddl-end --
COMMENT ON COLUMN syst.dc_conselho.tx_nome_conselho IS 'Nome do conselho ou comissão';
-- ddl-end --
COMMENT ON COLUMN syst.dc_conselho.tx_nome_orgao_vinculado IS 'Orgão ao qual a comissão ou conselho está vinculado';
-- ddl-end --
COMMENT ON CONSTRAINT pk_dc_conselho ON syst.dc_conselho  IS 'Chave primária do conselho (dicionário)';
-- ddl-end --
ALTER TABLE syst.dc_conselho OWNER TO postgres;
-- ddl-end --

-- object: portal.tb_representacao | type: TABLE --
-- DROP TABLE IF EXISTS portal.tb_representacao CASCADE;
CREATE TABLE portal.tb_representacao(
	id_representacao serial NOT NULL,
	id_osc integer,
	id_usuario integer,
	CONSTRAINT pk_tb_representacao PRIMARY KEY (id_representacao),
	CONSTRAINT un_representante UNIQUE (id_osc,id_usuario)

);
-- ddl-end --
COMMENT ON TABLE portal.tb_representacao IS 'Tabela de Representação';
-- ddl-end --
COMMENT ON COLUMN portal.tb_representacao.id_osc IS 'Chave estrangeira (código da OSC)';
-- ddl-end --
COMMENT ON COLUMN portal.tb_representacao.id_usuario IS 'Chave estrangeira (código do Usuário)';
-- ddl-end --
COMMENT ON CONSTRAINT pk_tb_representacao ON portal.tb_representacao  IS 'Chave primária da Representação';
-- ddl-end --
COMMENT ON CONSTRAINT un_representante ON portal.tb_representacao  IS 'Representante unico';
-- ddl-end --
ALTER TABLE portal.tb_representacao OWNER TO postgres;
-- ddl-end --

-- object: portal.tb_usuario | type: TABLE --
-- DROP TABLE IF EXISTS portal.tb_usuario CASCADE;
CREATE TABLE portal.tb_usuario(
	id_usuario serial NOT NULL,
	cd_tipo_usuario integer NOT NULL,
	tx_email_usuario text NOT NULL,
	tx_senha_usuario text NOT NULL,
	tx_nome_usuario text NOT NULL,
	nr_cpf_usuario numeric(11),
	bo_lista_email boolean NOT NULL,
	bo_ativo boolean NOT NULL,
	dt_cadastro timestamp NOT NULL,
	dt_atualizacao timestamp,
	CONSTRAINT pk_tb_usuario PRIMARY KEY (id_usuario),
	CONSTRAINT un_email_usuario UNIQUE (tx_email_usuario),
	CONSTRAINT un_cpf_usuario UNIQUE (nr_cpf_usuario)

);
-- ddl-end --
COMMENT ON COLUMN portal.tb_usuario.cd_tipo_usuario IS 'Código do tipo de usuário';
-- ddl-end --
COMMENT ON CONSTRAINT un_email_usuario ON portal.tb_usuario  IS 'Email unico';
-- ddl-end --
COMMENT ON CONSTRAINT un_cpf_usuario ON portal.tb_usuario  IS 'CPF unico';
-- ddl-end --
ALTER TABLE portal.tb_usuario OWNER TO postgres;
-- ddl-end --

-- object: syst.dc_classe_atividade_economica | type: TABLE --
-- DROP TABLE IF EXISTS syst.dc_classe_atividade_economica CASCADE;
CREATE TABLE syst.dc_classe_atividade_economica(
	cd_classe_atividade_economica character varying(10) NOT NULL,
	tx_nome_classe_atividade_economica text NOT NULL,
	CONSTRAINT pk_dc_classe_atividade_economica PRIMARY KEY (cd_classe_atividade_economica)

);
-- ddl-end --
COMMENT ON TABLE syst.dc_classe_atividade_economica IS 'Tabela dicionário atividade econômica';
-- ddl-end --
COMMENT ON COLUMN syst.dc_classe_atividade_economica.cd_classe_atividade_economica IS 'Código da atividade economica';
-- ddl-end --
COMMENT ON COLUMN syst.dc_classe_atividade_economica.tx_nome_classe_atividade_economica IS 'Nome da classe da atividade economica';
-- ddl-end --
COMMENT ON CONSTRAINT pk_dc_classe_atividade_economica ON syst.dc_classe_atividade_economica  IS 'Chave primária atividade econômica';
-- ddl-end --
ALTER TABLE syst.dc_classe_atividade_economica OWNER TO postgres;
-- ddl-end --

-- object: syst.dc_fonte_geocodificacao | type: TABLE --
-- DROP TABLE IF EXISTS syst.dc_fonte_geocodificacao CASCADE;
CREATE TABLE syst.dc_fonte_geocodificacao(
	cd_fonte_geocodoficacao serial NOT NULL,
	tx_fonte_geocodificacao text,
	CONSTRAINT pk_dc_fonte_geocodificacao PRIMARY KEY (cd_fonte_geocodoficacao)

);
-- ddl-end --
COMMENT ON TABLE syst.dc_fonte_geocodificacao IS 'Tabela de dicionário das fontes de geocodificação';
-- ddl-end --
COMMENT ON COLUMN syst.dc_fonte_geocodificacao.cd_fonte_geocodoficacao IS 'Código da fonte de geocodificação';
-- ddl-end --
COMMENT ON COLUMN syst.dc_fonte_geocodificacao.tx_fonte_geocodificacao IS 'Nome da fonte de geocodificação';
-- ddl-end --
COMMENT ON CONSTRAINT pk_dc_fonte_geocodificacao ON syst.dc_fonte_geocodificacao  IS 'Chave primária da fonte de geocodificação';
-- ddl-end --
ALTER TABLE syst.dc_fonte_geocodificacao OWNER TO postgres;
-- ddl-end --

-- object: osc.tb_localizacao_projeto | type: TABLE --
-- DROP TABLE IF EXISTS osc.tb_localizacao_projeto CASCADE;
CREATE TABLE osc.tb_localizacao_projeto(
	id_localizacao_projeto serial NOT NULL,
	id_projeto integer,
	id_regiao_localizacao_projeto integer NOT NULL,
	ft_regiao_localizacao_projeto text,
	tx_nome_regiao_localizacao_projeto text NOT NULL,
	ft_nome_regiao_localizacao_projeto text,
	CONSTRAINT pk_tb_localizacao_projeto PRIMARY KEY (id_localizacao_projeto)

);
-- ddl-end --
COMMENT ON TABLE osc.tb_localizacao_projeto IS 'Tabela de localização do projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_localizacao_projeto.id_localizacao_projeto IS 'Identificador da localização do projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_localizacao_projeto.id_regiao_localizacao_projeto IS 'Identificador da região da localização do projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_localizacao_projeto.ft_regiao_localizacao_projeto IS 'Fonte região da localização do projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_localizacao_projeto.tx_nome_regiao_localizacao_projeto IS 'Nome da região da localização do projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_localizacao_projeto.ft_nome_regiao_localizacao_projeto IS 'Fonte nome região licalização do projeto';
-- ddl-end --
COMMENT ON CONSTRAINT pk_tb_localizacao_projeto ON osc.tb_localizacao_projeto  IS 'Chave primária da tabela localização do projeto';
-- ddl-end --
ALTER TABLE osc.tb_localizacao_projeto OWNER TO postgres;
-- ddl-end --

-- object: osc.tb_financiador_projeto | type: TABLE --
-- DROP TABLE IF EXISTS osc.tb_financiador_projeto CASCADE;
CREATE TABLE osc.tb_financiador_projeto(
	id_financiador_projeto serial NOT NULL,
	id_projeto integer,
	tx_nome_financiador text NOT NULL,
	ft_nome_financiador text,
	CONSTRAINT pk_tb_financiador_projeto PRIMARY KEY (id_financiador_projeto)

);
-- ddl-end --
COMMENT ON TABLE osc.tb_financiador_projeto IS 'Tabela do financiador do projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_financiador_projeto.id_financiador_projeto IS 'Identificador do financiador do projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_financiador_projeto.id_projeto IS 'Identificador do projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_financiador_projeto.tx_nome_financiador IS 'Nome do financiador';
-- ddl-end --
COMMENT ON COLUMN osc.tb_financiador_projeto.ft_nome_financiador IS 'Fonte nome do financiador';
-- ddl-end --
COMMENT ON CONSTRAINT pk_tb_financiador_projeto ON osc.tb_financiador_projeto  IS 'Chave primária da tabela financiador do projeto';
-- ddl-end --
ALTER TABLE osc.tb_financiador_projeto OWNER TO postgres;
-- ddl-end --

-- object: syst.dc_abrangencia_projeto | type: TABLE --
-- DROP TABLE IF EXISTS syst.dc_abrangencia_projeto CASCADE;
CREATE TABLE syst.dc_abrangencia_projeto(
	cd_abrangencia_projeto serial NOT NULL,
	tx_nome_abrangencia_projeto text NOT NULL,
	CONSTRAINT pk_dc_abrangencia_projeto PRIMARY KEY (cd_abrangencia_projeto)

);
-- ddl-end --
ALTER TABLE syst.dc_abrangencia_projeto OWNER TO postgres;
-- ddl-end --

-- object: osc.tb_fonte_recursos_projeto | type: TABLE --
-- DROP TABLE IF EXISTS osc.tb_fonte_recursos_projeto CASCADE;
CREATE TABLE osc.tb_fonte_recursos_projeto(
	id_fonte_recursos_projeto serial NOT NULL,
	id_projeto integer,
	cd_fonte_recursos_projeto integer,
	ft_fonte_recursos_projeto text,
	CONSTRAINT pk_tb_fonte_recursos_projeto PRIMARY KEY (id_fonte_recursos_projeto)

);
-- ddl-end --
COMMENT ON TABLE osc.tb_fonte_recursos_projeto IS 'Tabela de fonte de recursos do projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_fonte_recursos_projeto.id_fonte_recursos_projeto IS 'Identificador da fonte de recursos do projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_fonte_recursos_projeto.id_projeto IS 'Identificador do projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_fonte_recursos_projeto.cd_fonte_recursos_projeto IS 'Código da fonte de recursos do projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_fonte_recursos_projeto.ft_fonte_recursos_projeto IS 'Fonte dos dados da fonte de recursos do projeto';
-- ddl-end --
COMMENT ON CONSTRAINT pk_tb_fonte_recursos_projeto ON osc.tb_fonte_recursos_projeto  IS 'Chave primária da tabela de fonte de recursos do projeto';
-- ddl-end --
ALTER TABLE osc.tb_fonte_recursos_projeto OWNER TO postgres;
-- ddl-end --

-- object: syst.dc_fonte_recursos_projeto | type: TABLE --
-- DROP TABLE IF EXISTS syst.dc_fonte_recursos_projeto CASCADE;
CREATE TABLE syst.dc_fonte_recursos_projeto(
	cd_fonte_recursos_projeto serial NOT NULL,
	tx_nome_fonte_recursos_projeto text NOT NULL,
	CONSTRAINT pk_dc_fonte_recursos_projeto PRIMARY KEY (cd_fonte_recursos_projeto)

);
-- ddl-end --
COMMENT ON TABLE syst.dc_fonte_recursos_projeto IS 'Dicionário da fonte de recursos de projeto';
-- ddl-end --
COMMENT ON COLUMN syst.dc_fonte_recursos_projeto.cd_fonte_recursos_projeto IS 'Código da fonte de recursos de projeto';
-- ddl-end --
COMMENT ON COLUMN syst.dc_fonte_recursos_projeto.tx_nome_fonte_recursos_projeto IS 'Nome da fonte de recursos de projeto';
-- ddl-end --
COMMENT ON CONSTRAINT pk_dc_fonte_recursos_projeto ON syst.dc_fonte_recursos_projeto  IS 'Chave primária da fonte de recursos de projeto';
-- ddl-end --
ALTER TABLE syst.dc_fonte_recursos_projeto OWNER TO postgres;
-- ddl-end --

-- object: portal.tb_token | type: TABLE --
-- DROP TABLE IF EXISTS portal.tb_token CASCADE;
CREATE TABLE portal.tb_token(
	id_token serial NOT NULL,
	id_usuario integer NOT NULL,
	dt_data_expiracao_token date,
	CONSTRAINT pk_tb_token PRIMARY KEY (id_token)

);
-- ddl-end --
COMMENT ON TABLE portal.tb_token IS 'Tabela de token';
-- ddl-end --
COMMENT ON COLUMN portal.tb_token.id_token IS 'Identificador do token';
-- ddl-end --
COMMENT ON COLUMN portal.tb_token.id_usuario IS 'Chave estrangeira';
-- ddl-end --
COMMENT ON COLUMN portal.tb_token.dt_data_expiracao_token IS 'Data de expiração do token';
-- ddl-end --
COMMENT ON CONSTRAINT pk_tb_token ON portal.tb_token  IS 'Chave primária';
-- ddl-end --
ALTER TABLE portal.tb_token OWNER TO postgres;
-- ddl-end --

-- object: log.tb_log_alteracao | type: TABLE --
-- DROP TABLE IF EXISTS log.tb_log_alteracao CASCADE;
CREATE TABLE log.tb_log_alteracao(
	id_log_alteracao serial NOT NULL,
	id_tabela integer NOT NULL,
	dt_alteracao timestamp NOT NULL,
	id_usuario integer NOT NULL,
	tx_nome_campo text NOT NULL,
	tx_dado_anterior text NOT NULL,
	tx_dado_posterior text NOT NULL,
	id_osc integer NOT NULL,
	CONSTRAINT pk_tb_log_alteracao PRIMARY KEY (id_log_alteracao)

);
-- ddl-end --
COMMENT ON TABLE log.tb_log_alteracao IS 'Tabela de histórico de alteração';
-- ddl-end --
COMMENT ON COLUMN log.tb_log_alteracao.id_log_alteracao IS 'Identificador do Log de Alteração';
-- ddl-end --
COMMENT ON COLUMN log.tb_log_alteracao.id_tabela IS 'Identificador da Tabela alterada';
-- ddl-end --
COMMENT ON COLUMN log.tb_log_alteracao.dt_alteracao IS 'Data de alteração do dado';
-- ddl-end --
COMMENT ON COLUMN log.tb_log_alteracao.id_usuario IS 'Identificador do usuário';
-- ddl-end --
COMMENT ON COLUMN log.tb_log_alteracao.tx_nome_campo IS 'Nome de campo alterado';
-- ddl-end --
COMMENT ON COLUMN log.tb_log_alteracao.tx_dado_anterior IS 'Valor Dado Anterior';
-- ddl-end --
COMMENT ON COLUMN log.tb_log_alteracao.tx_dado_posterior IS 'Valor do Dado Atualizado';
-- ddl-end --
COMMENT ON COLUMN log.tb_log_alteracao.id_osc IS 'Identificador da OSC';
-- ddl-end --
COMMENT ON CONSTRAINT pk_tb_log_alteracao ON log.tb_log_alteracao  IS 'Chave primária da tabela de log de alteração';
-- ddl-end --
ALTER TABLE log.tb_log_alteracao OWNER TO postgres;
-- ddl-end --

-- object: portal.tb_newsletters | type: TABLE --
-- DROP TABLE IF EXISTS portal.tb_newsletters CASCADE;
CREATE TABLE portal.tb_newsletters(
	id_newsletters serial NOT NULL,
	tx_nome_assinante text NOT NULL,
	tx_email_assinante text NOT NULL
);
-- ddl-end --
COMMENT ON TABLE portal.tb_newsletters IS 'Tabela de newsletters';
-- ddl-end --
COMMENT ON COLUMN portal.tb_newsletters.id_newsletters IS 'Identificador da tabela newslatters';
-- ddl-end --
COMMENT ON COLUMN portal.tb_newsletters.tx_nome_assinante IS 'Nome do assinante';
-- ddl-end --
COMMENT ON COLUMN portal.tb_newsletters.tx_email_assinante IS 'Email do assinante';
-- ddl-end --
ALTER TABLE portal.tb_newsletters OWNER TO postgres;
-- ddl-end --

-- object: syst.dc_situacao_imovel | type: TABLE --
-- DROP TABLE IF EXISTS syst.dc_situacao_imovel CASCADE;
CREATE TABLE syst.dc_situacao_imovel(
	cd_situacao_imovel serial NOT NULL,
	tx_nome_situacao_imovel text NOT NULL,
	CONSTRAINT pk_dc_situacao_imovel PRIMARY KEY (cd_situacao_imovel)

);
-- ddl-end --
COMMENT ON TABLE syst.dc_situacao_imovel IS 'Tabela de situação do imóvel';
-- ddl-end --
COMMENT ON COLUMN syst.dc_situacao_imovel.cd_situacao_imovel IS 'Código da situação';
-- ddl-end --
COMMENT ON COLUMN syst.dc_situacao_imovel.tx_nome_situacao_imovel IS 'Nome da situação do imóvel';
-- ddl-end --
COMMENT ON CONSTRAINT pk_dc_situacao_imovel ON syst.dc_situacao_imovel  IS 'Chave primária de situação do imóvel';
-- ddl-end --
ALTER TABLE syst.dc_situacao_imovel OWNER TO postgres;
-- ddl-end --

-- object: osc.tb_area_atuacao_outra | type: TABLE --
-- DROP TABLE IF EXISTS osc.tb_area_atuacao_outra CASCADE;
CREATE TABLE osc.tb_area_atuacao_outra(
	id_area_atuacao_outra serial NOT NULL,
	id_osc integer NOT NULL,
	id_area_declarada integer,
	ft_area_declarada text,
	CONSTRAINT pk_tb_area_atuacao_outra PRIMARY KEY (id_area_atuacao_outra)

);
-- ddl-end --
COMMENT ON TABLE osc.tb_area_atuacao_outra IS 'Tabela da área de atuação da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_area_atuacao_outra.id_area_atuacao_outra IS 'Identificador da área de atuação da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_area_atuacao_outra.id_osc IS 'Identificador da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_area_atuacao_outra.id_area_declarada IS 'Chave estrangeira para a área de atuação declarada pela OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_area_atuacao_outra.ft_area_declarada IS 'Fonte da área declarada';
-- ddl-end --
COMMENT ON CONSTRAINT pk_tb_area_atuacao_outra ON osc.tb_area_atuacao_outra  IS 'Chave primária da tabela área de atuação';
-- ddl-end --
ALTER TABLE osc.tb_area_atuacao_outra OWNER TO postgres;
-- ddl-end --

-- object: syst.dc_subarea_atuacao | type: TABLE --
-- DROP TABLE IF EXISTS syst.dc_subarea_atuacao CASCADE;
CREATE TABLE syst.dc_subarea_atuacao(
	cd_subarea_atuacao serial NOT NULL,
	tx_nome_subarea_atuacao text NOT NULL,
	cd_area_atuacao integer NOT NULL,
	CONSTRAINT pk_cd_subarea_atuacao_fasfil PRIMARY KEY (cd_subarea_atuacao)

);
-- ddl-end --
COMMENT ON TABLE syst.dc_subarea_atuacao IS 'Dicionário da subárea de atuação';
-- ddl-end --
COMMENT ON COLUMN syst.dc_subarea_atuacao.cd_subarea_atuacao IS 'Código de identificação da subárea de atuação';
-- ddl-end --
COMMENT ON COLUMN syst.dc_subarea_atuacao.tx_nome_subarea_atuacao IS 'Nome da subárea de atuação';
-- ddl-end --
COMMENT ON COLUMN syst.dc_subarea_atuacao.cd_area_atuacao IS 'Código da área de atuação';
-- ddl-end --
COMMENT ON CONSTRAINT pk_cd_subarea_atuacao_fasfil ON syst.dc_subarea_atuacao  IS 'Chave primária da tabela de dicionário da subárea de atuação';
-- ddl-end --
ALTER TABLE syst.dc_subarea_atuacao OWNER TO postgres;
-- ddl-end --

-- object: osc.tb_area_atuacao_declarada | type: TABLE --
-- DROP TABLE IF EXISTS osc.tb_area_atuacao_declarada CASCADE;
CREATE TABLE osc.tb_area_atuacao_declarada(
	id_area_atuacao_declarada serial NOT NULL,
	tx_nome_area_atuacao_declarada text NOT NULL,
	ft_nome_area_atuacao_declarada text,
	CONSTRAINT pk_id_area_atuacao_declarada PRIMARY KEY (id_area_atuacao_declarada)

);
-- ddl-end --
COMMENT ON TABLE osc.tb_area_atuacao_declarada IS 'Tabela com as áreas de atuações declaradas pelas OSCs';
-- ddl-end --
COMMENT ON COLUMN osc.tb_area_atuacao_declarada.id_area_atuacao_declarada IS 'Identificador da área de atuação declarada';
-- ddl-end --
COMMENT ON COLUMN osc.tb_area_atuacao_declarada.tx_nome_area_atuacao_declarada IS 'Nome da área de atuação declarada';
-- ddl-end --
COMMENT ON COLUMN osc.tb_area_atuacao_declarada.ft_nome_area_atuacao_declarada IS 'Fonte do nome da área de atuação declarada';
-- ddl-end --
COMMENT ON CONSTRAINT pk_id_area_atuacao_declarada ON osc.tb_area_atuacao_declarada  IS 'Chave primára da tabela área de atuação declarada';
-- ddl-end --
ALTER TABLE osc.tb_area_atuacao_declarada OWNER TO postgres;
-- ddl-end --

-- object: osc.tb_participacao_social_conferencia | type: TABLE --
-- DROP TABLE IF EXISTS osc.tb_participacao_social_conferencia CASCADE;
CREATE TABLE osc.tb_participacao_social_conferencia(
	id_conferencia serial NOT NULL,
	cd_conferencia integer NOT NULL,
	ft_conferencia text,
	id_osc integer NOT NULL,
	tx_nome_conferencia text NOT NULL,
	ft_nome_conferencia text,
	dt_data_inicio_conferencia date,
	ft_data_inicio_conferencia text,
	dt_data_fim_conferencia date,
	ft_data_fim_conferencia text,
	cd_forma_participacao_conferencia integer,
	ft_forma_participacao_conferencia text,
	CONSTRAINT pk_tb_participacao_social_conferencia PRIMARY KEY (id_conferencia)

);
-- ddl-end --
COMMENT ON TABLE osc.tb_participacao_social_conferencia IS 'Tabela com as conferências que a OSC faz parte';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conferencia.id_conferencia IS 'Identificador da conferência';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conferencia.cd_conferencia IS 'Código da conferência';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conferencia.ft_conferencia IS 'Fonte da conferência';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conferencia.id_osc IS 'Identificador da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conferencia.tx_nome_conferencia IS 'Nome da conferência';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conferencia.ft_nome_conferencia IS 'Fonte do nome da conferência';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conferencia.dt_data_inicio_conferencia IS 'Data de início da participação da OSC na conferência';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conferencia.ft_data_inicio_conferencia IS 'Fonte da data do início da conferência';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conferencia.dt_data_fim_conferencia IS 'Data de fim da participação da OSC na conferência';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conferencia.ft_data_fim_conferencia IS 'Fonte da data do fim da conferência';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conferencia.cd_forma_participacao_conferencia IS 'Código da forma de participação em conferência';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conferencia.ft_forma_participacao_conferencia IS 'Fonte da forma participação conferência';
-- ddl-end --
COMMENT ON CONSTRAINT pk_tb_participacao_social_conferencia ON osc.tb_participacao_social_conferencia  IS 'Chave primária da tabela conferência';
-- ddl-end --
ALTER TABLE osc.tb_participacao_social_conferencia OWNER TO postgres;
-- ddl-end --

-- object: osc.tb_participacao_social_declarada | type: TABLE --
-- DROP TABLE IF EXISTS osc.tb_participacao_social_declarada CASCADE;
CREATE TABLE osc.tb_participacao_social_declarada(
	id_participacao_social_declarada serial NOT NULL,
	id_osc integer NOT NULL,
	tx_nome_participacao_social_declarada text NOT NULL,
	ft_nome_participacao_social_declarada text,
	tx_tipo_participacao_social_declarada text,
	ft_tipo_participacao_social_declarada text,
	dt_data_ingresso_participacao_social_declarada date,
	ft_data_ingresso_participacao_social_declarada text,
	CONSTRAINT pk_tb_participacao_social_declarada PRIMARY KEY (id_participacao_social_declarada)

);
-- ddl-end --
COMMENT ON TABLE osc.tb_participacao_social_declarada IS 'Tabela da participação social declarada';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_declarada.id_participacao_social_declarada IS 'Identificador de outra participação social';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_declarada.id_osc IS 'Identificador da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_declarada.tx_nome_participacao_social_declarada IS 'Nome da participação social declarada';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_declarada.ft_nome_participacao_social_declarada IS 'Fonte do nome da participação social declarada';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_declarada.tx_tipo_participacao_social_declarada IS 'Tipo da participação social declarada';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_declarada.ft_tipo_participacao_social_declarada IS 'Fonte do tipo da participação social declarada';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_declarada.dt_data_ingresso_participacao_social_declarada IS 'Data do ingresso na participação social declarada';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_declarada.ft_data_ingresso_participacao_social_declarada IS 'Fonte da data do ingresso na participação social declarada';
-- ddl-end --
COMMENT ON CONSTRAINT pk_tb_participacao_social_declarada ON osc.tb_participacao_social_declarada  IS 'Chave primária da tabela participação social declarada';
-- ddl-end --
ALTER TABLE osc.tb_participacao_social_declarada OWNER TO postgres;
-- ddl-end --

-- object: osc.tb_conselho_fiscal | type: TABLE --
-- DROP TABLE IF EXISTS osc.tb_conselho_fiscal CASCADE;
CREATE TABLE osc.tb_conselho_fiscal(
	id_conselheiro serial NOT NULL,
	id_osc integer,
	tx_nome_conselheiro text NOT NULL,
	ft_nome_conselheiro text,
	tx_cargo_conselheiro text NOT NULL,
	ft_cargo_conselheiro text,
	CONSTRAINT pk_tb_conselho_contabil PRIMARY KEY (id_conselheiro)

);
-- ddl-end --
COMMENT ON TABLE osc.tb_conselho_fiscal IS 'Tabela de conselheiros';
-- ddl-end --
COMMENT ON COLUMN osc.tb_conselho_fiscal.id_conselheiro IS 'Identificador do conselheiro';
-- ddl-end --
COMMENT ON COLUMN osc.tb_conselho_fiscal.id_osc IS 'Identificador da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_conselho_fiscal.tx_nome_conselheiro IS 'Nome do conselheiro';
-- ddl-end --
COMMENT ON COLUMN osc.tb_conselho_fiscal.ft_nome_conselheiro IS 'Fonte nome do conselheiro';
-- ddl-end --
COMMENT ON COLUMN osc.tb_conselho_fiscal.tx_cargo_conselheiro IS 'Cargo do conselheiro';
-- ddl-end --
COMMENT ON COLUMN osc.tb_conselho_fiscal.ft_cargo_conselheiro IS 'Fonte cargo do conselheiro';
-- ddl-end --
COMMENT ON CONSTRAINT pk_tb_conselho_contabil ON osc.tb_conselho_fiscal  IS 'Chave primária da tabela conselheiro contábil';
-- ddl-end --
ALTER TABLE osc.tb_conselho_fiscal OWNER TO postgres;
-- ddl-end --

-- object: syst.dc_status_projeto | type: TABLE --
-- DROP TABLE IF EXISTS syst.dc_status_projeto CASCADE;
CREATE TABLE syst.dc_status_projeto(
	cd_status_projeto serial NOT NULL,
	tx_nome_status_projeto text NOT NULL,
	CONSTRAINT pk_cd_status_projeto PRIMARY KEY (cd_status_projeto)

);
-- ddl-end --
COMMENT ON TABLE syst.dc_status_projeto IS 'Dicionário do status do projeto';
-- ddl-end --
COMMENT ON COLUMN syst.dc_status_projeto.cd_status_projeto IS 'Código do status do projeto';
-- ddl-end --
COMMENT ON COLUMN syst.dc_status_projeto.tx_nome_status_projeto IS 'Nome do status do projeto';
-- ddl-end --
COMMENT ON CONSTRAINT pk_cd_status_projeto ON syst.dc_status_projeto  IS 'Chave primária do status do projeto';
-- ddl-end --
ALTER TABLE syst.dc_status_projeto OWNER TO postgres;
-- ddl-end --

-- object: osc.tb_area_atuacao_outra_projeto | type: TABLE --
-- DROP TABLE IF EXISTS osc.tb_area_atuacao_outra_projeto CASCADE;
CREATE TABLE osc.tb_area_atuacao_outra_projeto(
	id_area_atuacao_outra_projeto serial NOT NULL,
	id_projeto integer NOT NULL,
	id_area_atuacao_outra integer NOT NULL,
	ft_area_atuacao_outra text,
	CONSTRAINT pk_tb_area_atuacao_outra_projeto PRIMARY KEY (id_area_atuacao_outra_projeto)

);
-- ddl-end --
COMMENT ON TABLE osc.tb_area_atuacao_outra_projeto IS 'Tabela de outra área de atuação do projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_area_atuacao_outra_projeto.id_area_atuacao_outra_projeto IS 'Identificador da tabela de outra área de atuação do projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_area_atuacao_outra_projeto.id_projeto IS 'Identificador do projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_area_atuacao_outra_projeto.id_area_atuacao_outra IS 'Identificador da outra área de atuação';
-- ddl-end --
COMMENT ON COLUMN osc.tb_area_atuacao_outra_projeto.ft_area_atuacao_outra IS 'Fonte da outra área de atuação';
-- ddl-end --
COMMENT ON CONSTRAINT pk_tb_area_atuacao_outra_projeto ON osc.tb_area_atuacao_outra_projeto  IS 'Chave primária da tabela de outra área de atuação do projeto';
-- ddl-end --
ALTER TABLE osc.tb_area_atuacao_outra_projeto OWNER TO postgres;
-- ddl-end --

-- object: osc.tb_area_atuacao | type: TABLE --
-- DROP TABLE IF EXISTS osc.tb_area_atuacao CASCADE;
CREATE TABLE osc.tb_area_atuacao(
	id_area_atuacao serial NOT NULL,
	id_osc integer NOT NULL,
	cd_area_atuacao integer NOT NULL,
	cd_subarea_atuacao integer,
	ft_area_atuacao text,
	CONSTRAINT pk_tb_area_atuacao PRIMARY KEY (id_area_atuacao)

);
-- ddl-end --
COMMENT ON TABLE osc.tb_area_atuacao IS 'Tabela de área de atuação fasfil';
-- ddl-end --
COMMENT ON COLUMN osc.tb_area_atuacao.id_area_atuacao IS 'Identificador da área de atuação fasfil';
-- ddl-end --
COMMENT ON COLUMN osc.tb_area_atuacao.id_osc IS 'Identificador da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_area_atuacao.cd_area_atuacao IS 'Código da área de atuação';
-- ddl-end --
COMMENT ON COLUMN osc.tb_area_atuacao.cd_subarea_atuacao IS 'Código da subárea de atuação';
-- ddl-end --
COMMENT ON COLUMN osc.tb_area_atuacao.ft_area_atuacao IS 'Fonte da área de atuação';
-- ddl-end --
COMMENT ON CONSTRAINT pk_tb_area_atuacao ON osc.tb_area_atuacao  IS 'Chave primária da tabela área de atuação';
-- ddl-end --
ALTER TABLE osc.tb_area_atuacao OWNER TO postgres;
-- ddl-end --

-- object: osc.tb_area_atuacao_projeto | type: TABLE --
-- DROP TABLE IF EXISTS osc.tb_area_atuacao_projeto CASCADE;
CREATE TABLE osc.tb_area_atuacao_projeto(
	id_area_atuacao_projeto serial NOT NULL,
	id_projeto integer NOT NULL,
	cd_area_atuacao integer NOT NULL,
	ft_area_atuacao text,
	CONSTRAINT pk_tb_area_atuacao_projeto PRIMARY KEY (id_area_atuacao_projeto)

);
-- ddl-end --
COMMENT ON TABLE osc.tb_area_atuacao_projeto IS 'Tabela área de atuação do projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_area_atuacao_projeto.id_area_atuacao_projeto IS 'Identificador da área de atuação do projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_area_atuacao_projeto.id_projeto IS 'Identificador do projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_area_atuacao_projeto.cd_area_atuacao IS 'Código da área de atuação';
-- ddl-end --
COMMENT ON COLUMN osc.tb_area_atuacao_projeto.ft_area_atuacao IS 'Fonte da área de atuação';
-- ddl-end --
COMMENT ON CONSTRAINT pk_tb_area_atuacao_projeto ON osc.tb_area_atuacao_projeto  IS 'Chave primária da tabela área de atuação do projeto';
-- ddl-end --
ALTER TABLE osc.tb_area_atuacao_projeto OWNER TO postgres;
-- ddl-end --

-- object: spat.ed_municipio | type: TABLE --
-- DROP TABLE IF EXISTS spat.ed_municipio CASCADE;
CREATE TABLE spat.ed_municipio(
	edmu_cd_municipio numeric(7,0) NOT NULL,
	edmu_nm_municipio character varying(50) NOT NULL,
	eduf_cd_uf smallint NOT NULL,
	edmu_geometry geometry(MULTIPOLYGON, 4674) NOT NULL,
	edmu_centroid geometry(POINT, 4674) NOT NULL,
	edmu_bounding_box geometry(POLYGON, 4674) NOT NULL,
	CONSTRAINT pk_edmu PRIMARY KEY (edmu_cd_municipio)

);
-- ddl-end --
COMMENT ON TABLE spat.ed_municipio IS 'Tabela de município';
-- ddl-end --
COMMENT ON COLUMN spat.ed_municipio.edmu_cd_municipio IS 'Código do municipio no IBGE';
-- ddl-end --
COMMENT ON COLUMN spat.ed_municipio.edmu_nm_municipio IS 'Nome do municipio';
-- ddl-end --
COMMENT ON COLUMN spat.ed_municipio.eduf_cd_uf IS 'Chave estrangeira';
-- ddl-end --
COMMENT ON COLUMN spat.ed_municipio.edmu_geometry IS 'Geometria do municipio';
-- ddl-end --
COMMENT ON COLUMN spat.ed_municipio.edmu_centroid IS 'Centróide do município';
-- ddl-end --
COMMENT ON COLUMN spat.ed_municipio.edmu_bounding_box IS 'Retângulo envolvente do município';
-- ddl-end --
COMMENT ON CONSTRAINT pk_edmu ON spat.ed_municipio  IS 'Chave primária da dimensão de municípios';
-- ddl-end --
ALTER TABLE spat.ed_municipio OWNER TO postgres;
-- ddl-end --

-- object: spat.ed_uf | type: TABLE --
-- DROP TABLE IF EXISTS spat.ed_uf CASCADE;
CREATE TABLE spat.ed_uf(
	eduf_cd_uf numeric(2,0) NOT NULL,
	eduf_nm_uf character varying(20) NOT NULL,
	eduf_sg_uf character varying(2) NOT NULL,
	edre_cd_regiao smallint NOT NULL,
	eduf_geometry geometry(MULTIPOLYGON, 4674) NOT NULL,
	eduf_centroid geometry(POINT, 4674) NOT NULL,
	eduf_bounding_box geometry(POLYGON, 4674) NOT NULL,
	CONSTRAINT pk_eduf PRIMARY KEY (eduf_cd_uf)

);
-- ddl-end --
COMMENT ON TABLE spat.ed_uf IS 'Tabela de Unidade Federativa';
-- ddl-end --
COMMENT ON COLUMN spat.ed_uf.eduf_cd_uf IS 'Código da unidade da federação no IBGE';
-- ddl-end --
COMMENT ON COLUMN spat.ed_uf.eduf_nm_uf IS 'Nome da unidade da federação';
-- ddl-end --
COMMENT ON COLUMN spat.ed_uf.eduf_sg_uf IS 'Sigla da UF';
-- ddl-end --
COMMENT ON COLUMN spat.ed_uf.edre_cd_regiao IS 'Chave estrangeira';
-- ddl-end --
COMMENT ON COLUMN spat.ed_uf.eduf_geometry IS 'Geometria da unidade da federação';
-- ddl-end --
COMMENT ON COLUMN spat.ed_uf.eduf_centroid IS 'Centroide da UF';
-- ddl-end --
COMMENT ON COLUMN spat.ed_uf.eduf_bounding_box IS 'Retângulo envolvente da unidade da federação';
-- ddl-end --
COMMENT ON CONSTRAINT pk_eduf ON spat.ed_uf  IS 'Chave primária da dimensão de regiões';
-- ddl-end --
ALTER TABLE spat.ed_uf OWNER TO postgres;
-- ddl-end --

-- object: spat.ed_regiao | type: TABLE --
-- DROP TABLE IF EXISTS spat.ed_regiao CASCADE;
CREATE TABLE spat.ed_regiao(
	edre_cd_regiao numeric NOT NULL,
	edre_sg_regiao character varying(2) NOT NULL,
	edre_nm_regiao character varying(20) NOT NULL,
	edre_geometry geometry(MULTIPOLYGON, 4674) NOT NULL,
	edre_centroid geometry(POINT, 4674) NOT NULL,
	edre_bounding_box geometry(POLYGON, 4674) NOT NULL,
	CONSTRAINT pk_edre PRIMARY KEY (edre_cd_regiao)

);
-- ddl-end --
COMMENT ON TABLE spat.ed_regiao IS 'Tabela de Região';
-- ddl-end --
COMMENT ON COLUMN spat.ed_regiao.edre_cd_regiao IS 'Código da macroregião no IBGE';
-- ddl-end --
COMMENT ON COLUMN spat.ed_regiao.edre_sg_regiao IS 'Sigla da região';
-- ddl-end --
COMMENT ON COLUMN spat.ed_regiao.edre_nm_regiao IS 'Nome da Macroregiao';
-- ddl-end --
COMMENT ON COLUMN spat.ed_regiao.edre_geometry IS 'Geometria da Macroregião';
-- ddl-end --
COMMENT ON COLUMN spat.ed_regiao.edre_centroid IS 'Centroide da região';
-- ddl-end --
COMMENT ON COLUMN spat.ed_regiao.edre_bounding_box IS 'Retângulo envolvente da macroregião';
-- ddl-end --
COMMENT ON CONSTRAINT pk_edre ON spat.ed_regiao  IS 'Chave primária da dimensão de regiões';
-- ddl-end --
ALTER TABLE spat.ed_regiao OWNER TO postgres;
-- ddl-end --

-- object: osc.tb_publico_beneficiado_projeto | type: TABLE --
-- DROP TABLE IF EXISTS osc.tb_publico_beneficiado_projeto CASCADE;
CREATE TABLE osc.tb_publico_beneficiado_projeto(
	id_projeto integer NOT NULL,
	id_publico_beneficiado integer NOT NULL,
	ft_publico_beneficiado_projeto text,
	CONSTRAINT pk_id_publico_beneficiado_projeto PRIMARY KEY (id_projeto,id_publico_beneficiado)

);
-- ddl-end --
COMMENT ON TABLE osc.tb_publico_beneficiado_projeto IS 'Tabela de público beneficiado do projeto';
-- ddl-end --
ALTER TABLE osc.tb_publico_beneficiado_projeto OWNER TO postgres;
-- ddl-end --

-- object: osc.tb_osc_parceira_projeto | type: TABLE --
-- DROP TABLE IF EXISTS osc.tb_osc_parceira_projeto CASCADE;
CREATE TABLE osc.tb_osc_parceira_projeto(
	id_osc integer NOT NULL,
	id_projeto integer NOT NULL,
	ft_osc_parceira_projeto text,
	CONSTRAINT pk_tb_osc_parceira_projeto PRIMARY KEY (id_osc,id_projeto)

);
-- ddl-end --
COMMENT ON TABLE osc.tb_osc_parceira_projeto IS 'Tabela ternária entre OSC e Projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_osc_parceira_projeto.id_osc IS 'Identificação da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_osc_parceira_projeto.id_projeto IS 'Identificação do Projeto';
-- ddl-end --
COMMENT ON COLUMN osc.tb_osc_parceira_projeto.ft_osc_parceira_projeto IS 'Fonte da ligação';
-- ddl-end --
COMMENT ON CONSTRAINT pk_tb_osc_parceira_projeto ON osc.tb_osc_parceira_projeto  IS 'Chave primária de OSC e Projeto';
-- ddl-end --
ALTER TABLE osc.tb_osc_parceira_projeto OWNER TO postgres;
-- ddl-end --

-- object: syst.dc_zona_atuacao_projeto | type: TABLE --
-- DROP TABLE IF EXISTS syst.dc_zona_atuacao_projeto CASCADE;
CREATE TABLE syst.dc_zona_atuacao_projeto(
	cd_zona_atuacao_projeto serial NOT NULL,
	tx_nome_zona_atuacao text NOT NULL,
	CONSTRAINT pk_dc_zona_atuacao_projeto PRIMARY KEY (cd_zona_atuacao_projeto)

);
-- ddl-end --
COMMENT ON COLUMN syst.dc_zona_atuacao_projeto.cd_zona_atuacao_projeto IS 'Código da zona de atuação';
-- ddl-end --
COMMENT ON COLUMN syst.dc_zona_atuacao_projeto.tx_nome_zona_atuacao IS 'Nome da zona de atução do projeto';
-- ddl-end --
COMMENT ON CONSTRAINT pk_dc_zona_atuacao_projeto ON syst.dc_zona_atuacao_projeto  IS 'Chave primária da zona de atuação (dicionário)';
-- ddl-end --
ALTER TABLE syst.dc_zona_atuacao_projeto OWNER TO postgres;
-- ddl-end --

-- object: osc.tb_publico_beneficiado | type: TABLE --
-- DROP TABLE IF EXISTS osc.tb_publico_beneficiado CASCADE;
CREATE TABLE osc.tb_publico_beneficiado(
	id_publico_beneficiado serial NOT NULL,
	tx_nome_publico_beneficiado text NOT NULL,
	ft_publico_beneficiado text,
	CONSTRAINT pk_tb_publico_beneficiado PRIMARY KEY (id_publico_beneficiado)

);
-- ddl-end --
ALTER TABLE osc.tb_publico_beneficiado OWNER TO postgres;
-- ddl-end --

-- object: syst.dc_area_atuacao | type: TABLE --
-- DROP TABLE IF EXISTS syst.dc_area_atuacao CASCADE;
CREATE TABLE syst.dc_area_atuacao(
	cd_area_atuacao serial NOT NULL,
	tx_nome_area_atuacao text NOT NULL,
	CONSTRAINT pk_dc_area_atuacao PRIMARY KEY (cd_area_atuacao)

);
-- ddl-end --
COMMENT ON TABLE syst.dc_area_atuacao IS 'Dicionário da área de atuação';
-- ddl-end --
COMMENT ON COLUMN syst.dc_area_atuacao.cd_area_atuacao IS 'Código da área de atuação';
-- ddl-end --
COMMENT ON COLUMN syst.dc_area_atuacao.tx_nome_area_atuacao IS 'Nome da área de atuação';
-- ddl-end --
COMMENT ON CONSTRAINT pk_dc_area_atuacao ON syst.dc_area_atuacao  IS 'Chave primária da tabela de dicionário da área de atuação';
-- ddl-end --
ALTER TABLE syst.dc_area_atuacao OWNER TO postgres;
-- ddl-end --

-- object: osc.tb_relacoes_trabalho_outra | type: TABLE --
-- DROP TABLE IF EXISTS osc.tb_relacoes_trabalho_outra CASCADE;
CREATE TABLE osc.tb_relacoes_trabalho_outra(
	id_relacoes_trabalho_outra serial NOT NULL,
	id_osc integer NOT NULL,
	nr_trabalhadores integer,
	ft_trabalhadores text,
	tx_tipo_relacao_trabalho text,
	ft_tipo_relacao_trabalho text,
	CONSTRAINT pk_tb_relacoes_trabalho_outra PRIMARY KEY (id_relacoes_trabalho_outra)

);
-- ddl-end --
COMMENT ON TABLE osc.tb_relacoes_trabalho_outra IS 'Tabela de outras relações de trabalho';
-- ddl-end --
COMMENT ON COLUMN osc.tb_relacoes_trabalho_outra.id_relacoes_trabalho_outra IS 'Identificados da relação de trabalho outra';
-- ddl-end --
COMMENT ON COLUMN osc.tb_relacoes_trabalho_outra.id_osc IS 'Identificador da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_relacoes_trabalho_outra.nr_trabalhadores IS 'Número de trabalhadores';
-- ddl-end --
COMMENT ON COLUMN osc.tb_relacoes_trabalho_outra.ft_trabalhadores IS 'Fonte do número de trabalhadores';
-- ddl-end --
COMMENT ON COLUMN osc.tb_relacoes_trabalho_outra.tx_tipo_relacao_trabalho IS 'Tipo de relação de trabalho';
-- ddl-end --
COMMENT ON COLUMN osc.tb_relacoes_trabalho_outra.ft_tipo_relacao_trabalho IS 'Fonte do tipo da relação de trabalho';
-- ddl-end --
COMMENT ON CONSTRAINT pk_tb_relacoes_trabalho_outra ON osc.tb_relacoes_trabalho_outra  IS 'Chave primária da relação de trabalho outra';
-- ddl-end --
ALTER TABLE osc.tb_relacoes_trabalho_outra OWNER TO postgres;
-- ddl-end --

-- object: portal.tb_edital | type: TABLE --
-- DROP TABLE IF EXISTS portal.tb_edital CASCADE;
CREATE TABLE portal.tb_edital(
	id_edital serial NOT NULL,
	tx_orgao text NOT NULL,
	tx_programa text,
	tx_area_interesse_edital text,
	dt_vencimento date,
	tx_link_edital text NOT NULL,
	tx_numero_chamada text,
	CONSTRAINT pk_tb_edital PRIMARY KEY (id_edital)

);
-- ddl-end --
COMMENT ON TABLE portal.tb_edital IS 'Tabela de Edital';
-- ddl-end --
COMMENT ON COLUMN portal.tb_edital.id_edital IS 'Identificador do Edital';
-- ddl-end --
COMMENT ON COLUMN portal.tb_edital.tx_orgao IS 'Orgão do Edital';
-- ddl-end --
COMMENT ON COLUMN portal.tb_edital.tx_programa IS 'Programa do edital';
-- ddl-end --
COMMENT ON COLUMN portal.tb_edital.tx_area_interesse_edital IS 'Área de Interesse do edital';
-- ddl-end --
COMMENT ON COLUMN portal.tb_edital.dt_vencimento IS 'Data de vencimento';
-- ddl-end --
COMMENT ON COLUMN portal.tb_edital.tx_link_edital IS 'Link do edital';
-- ddl-end --
COMMENT ON COLUMN portal.tb_edital.tx_numero_chamada IS 'Número da chamada';
-- ddl-end --
COMMENT ON CONSTRAINT pk_tb_edital ON portal.tb_edital  IS 'Chave Primária';
-- ddl-end --
ALTER TABLE portal.tb_edital OWNER TO postgres;
-- ddl-end --

-- object: syst.dc_tipo_usuario | type: TABLE --
-- DROP TABLE IF EXISTS syst.dc_tipo_usuario CASCADE;
CREATE TABLE syst.dc_tipo_usuario(
	cd_tipo_usuario integer NOT NULL,
	tx_nome_tipo_usuario text NOT NULL,
	CONSTRAINT pk_dc_tipo_usuario PRIMARY KEY (cd_tipo_usuario)

);
-- ddl-end --
COMMENT ON TABLE syst.dc_tipo_usuario IS 'Dicionário do tipo de usuário';
-- ddl-end --
COMMENT ON COLUMN syst.dc_tipo_usuario.cd_tipo_usuario IS 'Código do tipo de usuário';
-- ddl-end --
COMMENT ON COLUMN syst.dc_tipo_usuario.tx_nome_tipo_usuario IS 'Nome do tipo de usuário';
-- ddl-end --
COMMENT ON CONSTRAINT pk_dc_tipo_usuario ON syst.dc_tipo_usuario  IS 'Chave primária do tipo de usuário';
-- ddl-end --
ALTER TABLE syst.dc_tipo_usuario OWNER TO postgres;
-- ddl-end --

-- object: pg_trgm | type: EXTENSION --
-- DROP EXTENSION IF EXISTS pg_trgm CASCADE;
CREATE EXTENSION pg_trgm
      WITH SCHEMA public;
-- ddl-end --
COMMENT ON EXTENSION pg_trgm IS 'The pg_trgm module provides functions and operators for determining the similarity of ASCII alphanumeric text based on trigram matching, as well as index operator classes that support fast searching for similar strings.';
-- ddl-end --

-- object: osc.tb_representante_conselho | type: TABLE --
-- DROP TABLE IF EXISTS osc.tb_representante_conselho CASCADE;
CREATE TABLE osc.tb_representante_conselho(
	id_representante_conselho serial NOT NULL,
	id_participacao_social_conselho integer NOT NULL,
	tx_nome_representante_conselho text NOT NULL,
	ft_nome_representante_conselho text,
	dt_data_inicio_conselho date,
	ft_data_inicio_conselho text,
	dt_data_fim_conselho date,
	ft_data_fim_conselho text,
	CONSTRAINT pk_tb_representante_conselho PRIMARY KEY (id_representante_conselho)

);
-- ddl-end --
COMMENT ON TABLE osc.tb_representante_conselho IS 'Tabela de representantes de conselho';
-- ddl-end --
COMMENT ON COLUMN osc.tb_representante_conselho.id_representante_conselho IS 'Identificador do representante de conselho';
-- ddl-end --
COMMENT ON COLUMN osc.tb_representante_conselho.id_participacao_social_conselho IS 'Identificador do conselho';
-- ddl-end --
COMMENT ON COLUMN osc.tb_representante_conselho.tx_nome_representante_conselho IS 'Nome do representante de conselho';
-- ddl-end --
COMMENT ON COLUMN osc.tb_representante_conselho.ft_nome_representante_conselho IS 'Fonte do nome do representante de conselho';
-- ddl-end --
COMMENT ON COLUMN osc.tb_representante_conselho.dt_data_inicio_conselho IS 'Data de início da participação no conselho';
-- ddl-end --
COMMENT ON COLUMN osc.tb_representante_conselho.ft_data_inicio_conselho IS 'Fonte da data de início da participação no conselho';
-- ddl-end --
COMMENT ON COLUMN osc.tb_representante_conselho.dt_data_fim_conselho IS 'Data de fim da participação no conselho';
-- ddl-end --
COMMENT ON COLUMN osc.tb_representante_conselho.ft_data_fim_conselho IS 'Fonte da data de fim da participação no conselho';
-- ddl-end --
COMMENT ON CONSTRAINT pk_tb_representante_conselho ON osc.tb_representante_conselho  IS 'Chave primária do representante de conselho';
-- ddl-end --
ALTER TABLE osc.tb_representante_conselho OWNER TO postgres;
-- ddl-end --

-- object: syst.dc_conferencia | type: TABLE --
-- DROP TABLE IF EXISTS syst.dc_conferencia CASCADE;
CREATE TABLE syst.dc_conferencia(
	cd_conferencia serial NOT NULL,
	tx_nome_conferencia text NOT NULL,
	CONSTRAINT pk_dc_conferencia PRIMARY KEY (cd_conferencia)

);
-- ddl-end --
COMMENT ON TABLE syst.dc_conferencia IS 'Dicionário de conferências';
-- ddl-end --
COMMENT ON COLUMN syst.dc_conferencia.cd_conferencia IS 'Código da conferência';
-- ddl-end --
COMMENT ON COLUMN syst.dc_conferencia.tx_nome_conferencia IS 'Nome da conferência';
-- ddl-end --
COMMENT ON CONSTRAINT pk_dc_conferencia ON syst.dc_conferencia  IS 'Chave primária da conferência';
-- ddl-end --
ALTER TABLE syst.dc_conferencia OWNER TO postgres;
-- ddl-end --

-- object: osc.tb_conferencia | type: TABLE --
-- DROP TABLE IF EXISTS osc.tb_conferencia CASCADE;
CREATE TABLE osc.tb_conferencia(
	id_conferencia serial NOT NULL,
	tx_nome_conferencia text NOT NULL,
	ft_conferencia text,
	CONSTRAINT pk_tb_conferencia PRIMARY KEY (id_conferencia)

);
-- ddl-end --
COMMENT ON TABLE osc.tb_conferencia IS 'Tabela de conferências';
-- ddl-end --
COMMENT ON COLUMN osc.tb_conferencia.id_conferencia IS 'Identificador da conferência';
-- ddl-end --
COMMENT ON COLUMN osc.tb_conferencia.tx_nome_conferencia IS 'Nome da conferência';
-- ddl-end --
COMMENT ON COLUMN osc.tb_conferencia.ft_conferencia IS 'Fonte da conferência';
-- ddl-end --
COMMENT ON CONSTRAINT pk_tb_conferencia ON osc.tb_conferencia  IS 'Chave primária da conferência';
-- ddl-end --
ALTER TABLE osc.tb_conferencia OWNER TO postgres;
-- ddl-end --

-- object: osc.tb_participacao_social_conferencia_outra | type: TABLE --
-- DROP TABLE IF EXISTS osc.tb_participacao_social_conferencia_outra CASCADE;
CREATE TABLE osc.tb_participacao_social_conferencia_outra(
	id_conferencia_outra serial NOT NULL,
	id_conferencia integer NOT NULL,
	ft_conferencia text,
	id_osc integer NOT NULL,
	tx_nome_conferencia text NOT NULL,
	ft_nome_conferencia text,
	dt_data_inicio_conferencia date,
	ft_data_inicio_conferencia text,
	dt_data_fim_conferencia date,
	ft_data_fim_conferencia text,
	cd_forma_participacao_conferencia integer,
	ft_forma_participacao_conferencia integer,
	CONSTRAINT pk_tb_participacao_social_conferencia_outra PRIMARY KEY (id_conferencia_outra)

);
-- ddl-end --
COMMENT ON TABLE osc.tb_participacao_social_conferencia_outra IS 'Tabela com as conferências que a OSC faz parte';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conferencia_outra.id_conferencia_outra IS 'Identificador da conferência';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conferencia_outra.id_conferencia IS 'Identificador da conferência';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conferencia_outra.ft_conferencia IS 'Fonte da conferência';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conferencia_outra.id_osc IS 'Identificador da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conferencia_outra.tx_nome_conferencia IS 'Nome da conferência';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conferencia_outra.ft_nome_conferencia IS 'Fonte do nome da conferência';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conferencia_outra.dt_data_inicio_conferencia IS 'Data de início da participação da OSC na conferência';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conferencia_outra.ft_data_inicio_conferencia IS 'Fonte da data do início da conferência';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conferencia_outra.dt_data_fim_conferencia IS 'Data de fim da participação da OSC na conferência';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conferencia_outra.ft_data_fim_conferencia IS 'Fonte da data do fim da conferência';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conferencia_outra.cd_forma_participacao_conferencia IS 'Código da forma de participação em conferência';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_conferencia_outra.ft_forma_participacao_conferencia IS 'Fonte da forma de participação em conferência';
-- ddl-end --
COMMENT ON CONSTRAINT pk_tb_participacao_social_conferencia_outra ON osc.tb_participacao_social_conferencia_outra  IS 'Chave primária da tabela conferência';
-- ddl-end --
ALTER TABLE osc.tb_participacao_social_conferencia_outra OWNER TO postgres;
-- ddl-end --

-- object: syst.dc_forma_participacao_conferencia | type: TABLE --
-- DROP TABLE IF EXISTS syst.dc_forma_participacao_conferencia CASCADE;
CREATE TABLE syst.dc_forma_participacao_conferencia(
	cd_forma_participacao_conferencia serial NOT NULL,
	tx_nome_forma_participacao_conferencia text NOT NULL,
	CONSTRAINT pk_dc_forma_participacao_conferencia PRIMARY KEY (cd_forma_participacao_conferencia)

);
-- ddl-end --
COMMENT ON TABLE syst.dc_forma_participacao_conferencia IS 'Dicionário da forma de participação da conferência';
-- ddl-end --
COMMENT ON COLUMN syst.dc_forma_participacao_conferencia.tx_nome_forma_participacao_conferencia IS 'Nome da forma de participação em conferência';
-- ddl-end --
COMMENT ON CONSTRAINT pk_dc_forma_participacao_conferencia ON syst.dc_forma_participacao_conferencia  IS 'Chave primária da forma de participação em conferência';
-- ddl-end --
ALTER TABLE syst.dc_forma_participacao_conferencia OWNER TO postgres;
-- ddl-end --

-- object: osc.tb_participacao_social_outra | type: TABLE --
-- DROP TABLE IF EXISTS osc.tb_participacao_social_outra CASCADE;
CREATE TABLE osc.tb_participacao_social_outra(
	id_participacao_social_outra serial NOT NULL,
	id_osc integer NOT NULL,
	tx_nome_participacao_social_outra text NOT NULL,
	CONSTRAINT pk_tb_participacao_social_outra PRIMARY KEY (id_participacao_social_outra)

);
-- ddl-end --
COMMENT ON TABLE osc.tb_participacao_social_outra IS 'Tabela da participação social outra';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_outra.id_participacao_social_outra IS 'Identificador de outra participação social';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_outra.id_osc IS 'Identificador da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_participacao_social_outra.tx_nome_participacao_social_outra IS 'Nome da participação social outra';
-- ddl-end --
COMMENT ON CONSTRAINT pk_tb_participacao_social_outra ON osc.tb_participacao_social_outra  IS 'Chave primária da participação social outra';
-- ddl-end --
ALTER TABLE osc.tb_participacao_social_outra OWNER TO postgres;
-- ddl-end --

-- object: osc.tb_recursos_osc | type: TABLE --
-- DROP TABLE IF EXISTS osc.tb_recursos_osc CASCADE;
CREATE TABLE osc.tb_recursos_osc(
	id_recursos_osc serial NOT NULL,
	id_osc integer NOT NULL,
	cd_fonte_recursos_osc integer NOT NULL,
	dt_ano date NOT NULL,
	nr_valor_recursos_osc double precision NOT NULL,
	CONSTRAINT pk_tb_recursos_osc PRIMARY KEY (id_recursos_osc),
	CONSTRAINT un_recursos_osc UNIQUE (id_osc,cd_fonte_recursos_osc,dt_ano)

);
-- ddl-end --
COMMENT ON TABLE osc.tb_recursos_osc IS 'Tabela de rercursos da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_recursos_osc.id_recursos_osc IS 'Identificador de recursos da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_recursos_osc.id_osc IS 'Identificador da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_recursos_osc.cd_fonte_recursos_osc IS 'Código da fonte de recursos da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_recursos_osc.dt_ano IS 'Ano dos recursos da OSC';
-- ddl-end --
COMMENT ON COLUMN osc.tb_recursos_osc.nr_valor_recursos_osc IS 'Valor do recursos da OSC';
-- ddl-end --
COMMENT ON CONSTRAINT pk_tb_recursos_osc ON osc.tb_recursos_osc  IS 'Chave primária de recursos da OSC';
-- ddl-end --
COMMENT ON CONSTRAINT un_recursos_osc ON osc.tb_recursos_osc  IS 'Unicidade de recursos da OSC';
-- ddl-end --
ALTER TABLE osc.tb_recursos_osc OWNER TO postgres;
-- ddl-end --

-- object: syst.dc_fonte_recursos_osc | type: TABLE --
-- DROP TABLE IF EXISTS syst.dc_fonte_recursos_osc CASCADE;
CREATE TABLE syst.dc_fonte_recursos_osc(
	cd_fonte_recursos_osc serial NOT NULL,
	cd_origem_fonte_recursos_osc integer NOT NULL,
	tx_nome_fonte_recursos_osc text NOT NULL,
	CONSTRAINT pk_dc_fonte_recursos_osc PRIMARY KEY (cd_fonte_recursos_osc)

);
-- ddl-end --
COMMENT ON TABLE syst.dc_fonte_recursos_osc IS 'Dicionário da fonte de recursos da OSC';
-- ddl-end --
COMMENT ON COLUMN syst.dc_fonte_recursos_osc.cd_fonte_recursos_osc IS 'Código de identificador da fonte de recursos da OSC';
-- ddl-end --
COMMENT ON COLUMN syst.dc_fonte_recursos_osc.cd_origem_fonte_recursos_osc IS 'Código da origem da fonte de recursos da OSC';
-- ddl-end --
COMMENT ON COLUMN syst.dc_fonte_recursos_osc.tx_nome_fonte_recursos_osc IS 'Nome da fonte de recursos da OSC';
-- ddl-end --
COMMENT ON CONSTRAINT pk_dc_fonte_recursos_osc ON syst.dc_fonte_recursos_osc  IS 'Chave primária da fonte de recursos da OSC';
-- ddl-end --
ALTER TABLE syst.dc_fonte_recursos_osc OWNER TO postgres;
-- ddl-end --

-- object: syst.dc_origem_fonte_recursos_osc | type: TABLE --
-- DROP TABLE IF EXISTS syst.dc_origem_fonte_recursos_osc CASCADE;
CREATE TABLE syst.dc_origem_fonte_recursos_osc(
	cd_origem_fonte_recursos_osc serial NOT NULL,
	tx_nome_origem_fonte_recursos_osc text NOT NULL,
	CONSTRAINT pk_dc_origem_fonte_recursos_osc PRIMARY KEY (cd_origem_fonte_recursos_osc)

);
-- ddl-end --
COMMENT ON TABLE syst.dc_origem_fonte_recursos_osc IS 'Origem da fonte de recursos da OSC';
-- ddl-end --
COMMENT ON COLUMN syst.dc_origem_fonte_recursos_osc.cd_origem_fonte_recursos_osc IS 'Código de identificação da origem da fonte de recursos da OSC';
-- ddl-end --
COMMENT ON COLUMN syst.dc_origem_fonte_recursos_osc.tx_nome_origem_fonte_recursos_osc IS 'Nome da origem da fonte de recursos da OSC';
-- ddl-end --
COMMENT ON CONSTRAINT pk_dc_origem_fonte_recursos_osc ON syst.dc_origem_fonte_recursos_osc  IS 'Chave primária da origem da fonte de recursos da OSC';
-- ddl-end --
ALTER TABLE syst.dc_origem_fonte_recursos_osc OWNER TO postgres;
-- ddl-end --

-- object: fk_cd_identificador_osc | type: CONSTRAINT --
-- ALTER TABLE log.tb_log_carga DROP CONSTRAINT IF EXISTS fk_cd_identificador_osc CASCADE;
ALTER TABLE log.tb_log_carga ADD CONSTRAINT fk_cd_identificador_osc FOREIGN KEY (cd_identificador_osc)
REFERENCES osc.tb_osc (id_osc) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_cd_status | type: CONSTRAINT --
-- ALTER TABLE log.tb_log_carga DROP CONSTRAINT IF EXISTS fk_cd_status CASCADE;
ALTER TABLE log.tb_log_carga ADD CONSTRAINT fk_cd_status FOREIGN KEY (cd_status)
REFERENCES syst.dc_status_carga (cd_status) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_tb_osc | type: CONSTRAINT --
-- ALTER TABLE osc.tb_contato DROP CONSTRAINT IF EXISTS fk_tb_osc CASCADE;
ALTER TABLE osc.tb_contato ADD CONSTRAINT fk_tb_osc FOREIGN KEY (id_osc)
REFERENCES osc.tb_osc (id_osc) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_id_osc | type: CONSTRAINT --
-- ALTER TABLE osc.tb_localizacao DROP CONSTRAINT IF EXISTS fk_id_osc CASCADE;
ALTER TABLE osc.tb_localizacao ADD CONSTRAINT fk_id_osc FOREIGN KEY (id_osc)
REFERENCES osc.tb_osc (id_osc) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_cd_fonte_geocodificacao | type: CONSTRAINT --
-- ALTER TABLE osc.tb_localizacao DROP CONSTRAINT IF EXISTS fk_cd_fonte_geocodificacao CASCADE;
ALTER TABLE osc.tb_localizacao ADD CONSTRAINT fk_cd_fonte_geocodificacao FOREIGN KEY (cd_fonte_geocodificacao)
REFERENCES syst.dc_fonte_geocodificacao (cd_fonte_geocodoficacao) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_cd_municipio | type: CONSTRAINT --
-- ALTER TABLE osc.tb_localizacao DROP CONSTRAINT IF EXISTS fk_cd_municipio CASCADE;
ALTER TABLE osc.tb_localizacao ADD CONSTRAINT fk_cd_municipio FOREIGN KEY (cd_municipio)
REFERENCES spat.ed_municipio (edmu_cd_municipio) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_id_osc | type: CONSTRAINT --
-- ALTER TABLE osc.tb_projeto DROP CONSTRAINT IF EXISTS fk_id_osc CASCADE;
ALTER TABLE osc.tb_projeto ADD CONSTRAINT fk_id_osc FOREIGN KEY (id_osc)
REFERENCES osc.tb_osc (id_osc) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_cd_status_projeto | type: CONSTRAINT --
-- ALTER TABLE osc.tb_projeto DROP CONSTRAINT IF EXISTS fk_cd_status_projeto CASCADE;
ALTER TABLE osc.tb_projeto ADD CONSTRAINT fk_cd_status_projeto FOREIGN KEY (cd_status_projeto)
REFERENCES syst.dc_status_projeto (cd_status_projeto) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_cd_abrangencia_projeto | type: CONSTRAINT --
-- ALTER TABLE osc.tb_projeto DROP CONSTRAINT IF EXISTS fk_cd_abrangencia_projeto CASCADE;
ALTER TABLE osc.tb_projeto ADD CONSTRAINT fk_cd_abrangencia_projeto FOREIGN KEY (cd_abrangencia_projeto)
REFERENCES syst.dc_abrangencia_projeto (cd_abrangencia_projeto) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_zona_atuacao_projeto | type: CONSTRAINT --
-- ALTER TABLE osc.tb_projeto DROP CONSTRAINT IF EXISTS fk_zona_atuacao_projeto CASCADE;
ALTER TABLE osc.tb_projeto ADD CONSTRAINT fk_zona_atuacao_projeto FOREIGN KEY (cd_zona_atuacao_projeto)
REFERENCES syst.dc_zona_atuacao_projeto (cd_zona_atuacao_projeto) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_id_osc | type: CONSTRAINT --
-- ALTER TABLE osc.tb_governanca DROP CONSTRAINT IF EXISTS fk_id_osc CASCADE;
ALTER TABLE osc.tb_governanca ADD CONSTRAINT fk_id_osc FOREIGN KEY (id_osc)
REFERENCES osc.tb_osc (id_osc) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_id_osc | type: CONSTRAINT --
-- ALTER TABLE osc.tb_certificado DROP CONSTRAINT IF EXISTS fk_id_osc CASCADE;
ALTER TABLE osc.tb_certificado ADD CONSTRAINT fk_id_osc FOREIGN KEY (id_osc)
REFERENCES osc.tb_osc (id_osc) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_cod_certificado | type: CONSTRAINT --
-- ALTER TABLE osc.tb_certificado DROP CONSTRAINT IF EXISTS fk_cod_certificado CASCADE;
ALTER TABLE osc.tb_certificado ADD CONSTRAINT fk_cod_certificado FOREIGN KEY (cd_certificado)
REFERENCES syst.dc_certificado (cd_certificado) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_dc_subclasse_atividade_economica | type: CONSTRAINT --
-- ALTER TABLE syst.dc_subclasse_atividade_economica DROP CONSTRAINT IF EXISTS fk_dc_subclasse_atividade_economica CASCADE;
ALTER TABLE syst.dc_subclasse_atividade_economica ADD CONSTRAINT fk_dc_subclasse_atividade_economica FOREIGN KEY (cd_classe_atividade_economica)
REFERENCES syst.dc_classe_atividade_economica (cd_classe_atividade_economica) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_id_osc | type: CONSTRAINT --
-- ALTER TABLE osc.tb_dados_gerais DROP CONSTRAINT IF EXISTS fk_id_osc CASCADE;
ALTER TABLE osc.tb_dados_gerais ADD CONSTRAINT fk_id_osc FOREIGN KEY (id_osc)
REFERENCES osc.tb_osc (id_osc) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_cd_natureza_juridica_osc | type: CONSTRAINT --
-- ALTER TABLE osc.tb_dados_gerais DROP CONSTRAINT IF EXISTS fk_cd_natureza_juridica_osc CASCADE;
ALTER TABLE osc.tb_dados_gerais ADD CONSTRAINT fk_cd_natureza_juridica_osc FOREIGN KEY (cd_natureza_juridica_osc)
REFERENCES syst.dc_natureza_juridica (cd_natureza_juridica) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_cd_subclasse_atividade_economica_osc | type: CONSTRAINT --
-- ALTER TABLE osc.tb_dados_gerais DROP CONSTRAINT IF EXISTS fk_cd_subclasse_atividade_economica_osc CASCADE;
ALTER TABLE osc.tb_dados_gerais ADD CONSTRAINT fk_cd_subclasse_atividade_economica_osc FOREIGN KEY (cd_subclasse_atividade_economica_osc)
REFERENCES syst.dc_subclasse_atividade_economica (cd_subclasse_atividade_economica) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_cd_situacao_imovel_osc | type: CONSTRAINT --
-- ALTER TABLE osc.tb_dados_gerais DROP CONSTRAINT IF EXISTS fk_cd_situacao_imovel_osc CASCADE;
ALTER TABLE osc.tb_dados_gerais ADD CONSTRAINT fk_cd_situacao_imovel_osc FOREIGN KEY (cd_situacao_imovel_osc)
REFERENCES syst.dc_situacao_imovel (cd_situacao_imovel) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_id_osc | type: CONSTRAINT --
-- ALTER TABLE osc.tb_relacoes_trabalho DROP CONSTRAINT IF EXISTS fk_id_osc CASCADE;
ALTER TABLE osc.tb_relacoes_trabalho ADD CONSTRAINT fk_id_osc FOREIGN KEY (id_osc)
REFERENCES osc.tb_osc (id_osc) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_id_osc | type: CONSTRAINT --
-- ALTER TABLE osc.tb_participacao_social_conselho DROP CONSTRAINT IF EXISTS fk_id_osc CASCADE;
ALTER TABLE osc.tb_participacao_social_conselho ADD CONSTRAINT fk_id_osc FOREIGN KEY (id_osc)
REFERENCES osc.tb_osc (id_osc) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_cd_conselho | type: CONSTRAINT --
-- ALTER TABLE osc.tb_participacao_social_conselho DROP CONSTRAINT IF EXISTS fk_cd_conselho CASCADE;
ALTER TABLE osc.tb_participacao_social_conselho ADD CONSTRAINT fk_cd_conselho FOREIGN KEY (cd_conselho)
REFERENCES syst.dc_conselho (cd_conselho) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_cd_tipo_participacao | type: CONSTRAINT --
-- ALTER TABLE osc.tb_participacao_social_conselho DROP CONSTRAINT IF EXISTS fk_cd_tipo_participacao CASCADE;
ALTER TABLE osc.tb_participacao_social_conselho ADD CONSTRAINT fk_cd_tipo_participacao FOREIGN KEY (cd_tipo_participacao)
REFERENCES syst.dc_tipo_participacao (cd_tipo_participacao) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_id_osc | type: CONSTRAINT --
-- ALTER TABLE portal.tb_representacao DROP CONSTRAINT IF EXISTS fk_id_osc CASCADE;
ALTER TABLE portal.tb_representacao ADD CONSTRAINT fk_id_osc FOREIGN KEY (id_osc)
REFERENCES osc.tb_osc (id_osc) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_id_usuario | type: CONSTRAINT --
-- ALTER TABLE portal.tb_representacao DROP CONSTRAINT IF EXISTS fk_id_usuario CASCADE;
ALTER TABLE portal.tb_representacao ADD CONSTRAINT fk_id_usuario FOREIGN KEY (id_usuario)
REFERENCES portal.tb_usuario (id_usuario) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_cd_tipo_usuario | type: CONSTRAINT --
-- ALTER TABLE portal.tb_usuario DROP CONSTRAINT IF EXISTS fk_cd_tipo_usuario CASCADE;
ALTER TABLE portal.tb_usuario ADD CONSTRAINT fk_cd_tipo_usuario FOREIGN KEY (cd_tipo_usuario)
REFERENCES syst.dc_tipo_usuario (cd_tipo_usuario) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_id_projeto | type: CONSTRAINT --
-- ALTER TABLE osc.tb_localizacao_projeto DROP CONSTRAINT IF EXISTS fk_id_projeto CASCADE;
ALTER TABLE osc.tb_localizacao_projeto ADD CONSTRAINT fk_id_projeto FOREIGN KEY (id_projeto)
REFERENCES osc.tb_projeto (id_projeto) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_id_projeto | type: CONSTRAINT --
-- ALTER TABLE osc.tb_financiador_projeto DROP CONSTRAINT IF EXISTS fk_id_projeto CASCADE;
ALTER TABLE osc.tb_financiador_projeto ADD CONSTRAINT fk_id_projeto FOREIGN KEY (id_projeto)
REFERENCES osc.tb_projeto (id_projeto) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_id_projeto | type: CONSTRAINT --
-- ALTER TABLE osc.tb_fonte_recursos_projeto DROP CONSTRAINT IF EXISTS fk_id_projeto CASCADE;
ALTER TABLE osc.tb_fonte_recursos_projeto ADD CONSTRAINT fk_id_projeto FOREIGN KEY (id_projeto)
REFERENCES osc.tb_projeto (id_projeto) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_cd_fonte_recursos_projeto | type: CONSTRAINT --
-- ALTER TABLE osc.tb_fonte_recursos_projeto DROP CONSTRAINT IF EXISTS fk_cd_fonte_recursos_projeto CASCADE;
ALTER TABLE osc.tb_fonte_recursos_projeto ADD CONSTRAINT fk_cd_fonte_recursos_projeto FOREIGN KEY (cd_fonte_recursos_projeto)
REFERENCES syst.dc_fonte_recursos_projeto (cd_fonte_recursos_projeto) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_cd_token | type: CONSTRAINT --
-- ALTER TABLE portal.tb_token DROP CONSTRAINT IF EXISTS fk_cd_token CASCADE;
ALTER TABLE portal.tb_token ADD CONSTRAINT fk_cd_token FOREIGN KEY (id_usuario)
REFERENCES portal.tb_usuario (id_usuario) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_id_area_declarada | type: CONSTRAINT --
-- ALTER TABLE osc.tb_area_atuacao_outra DROP CONSTRAINT IF EXISTS fk_id_area_declarada CASCADE;
ALTER TABLE osc.tb_area_atuacao_outra ADD CONSTRAINT fk_id_area_declarada FOREIGN KEY (id_area_declarada)
REFERENCES osc.tb_area_atuacao_declarada (id_area_atuacao_declarada) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_id_osc | type: CONSTRAINT --
-- ALTER TABLE osc.tb_area_atuacao_outra DROP CONSTRAINT IF EXISTS fk_id_osc CASCADE;
ALTER TABLE osc.tb_area_atuacao_outra ADD CONSTRAINT fk_id_osc FOREIGN KEY (id_osc)
REFERENCES osc.tb_osc (id_osc) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_cd_id_area_atuacao | type: CONSTRAINT --
-- ALTER TABLE syst.dc_subarea_atuacao DROP CONSTRAINT IF EXISTS fk_cd_id_area_atuacao CASCADE;
ALTER TABLE syst.dc_subarea_atuacao ADD CONSTRAINT fk_cd_id_area_atuacao FOREIGN KEY (cd_area_atuacao)
REFERENCES syst.dc_area_atuacao (cd_area_atuacao) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_id_osc | type: CONSTRAINT --
-- ALTER TABLE osc.tb_participacao_social_conferencia DROP CONSTRAINT IF EXISTS fk_id_osc CASCADE;
ALTER TABLE osc.tb_participacao_social_conferencia ADD CONSTRAINT fk_id_osc FOREIGN KEY (id_osc)
REFERENCES osc.tb_osc (id_osc) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_cd_conferencia | type: CONSTRAINT --
-- ALTER TABLE osc.tb_participacao_social_conferencia DROP CONSTRAINT IF EXISTS fk_cd_conferencia CASCADE;
ALTER TABLE osc.tb_participacao_social_conferencia ADD CONSTRAINT fk_cd_conferencia FOREIGN KEY (cd_conferencia)
REFERENCES syst.dc_conferencia (cd_conferencia) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_cd_forma_participacao_conferencia | type: CONSTRAINT --
-- ALTER TABLE osc.tb_participacao_social_conferencia DROP CONSTRAINT IF EXISTS fk_cd_forma_participacao_conferencia CASCADE;
ALTER TABLE osc.tb_participacao_social_conferencia ADD CONSTRAINT fk_cd_forma_participacao_conferencia FOREIGN KEY (cd_forma_participacao_conferencia)
REFERENCES syst.dc_forma_participacao_conferencia (cd_forma_participacao_conferencia) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_id_osc | type: CONSTRAINT --
-- ALTER TABLE osc.tb_participacao_social_declarada DROP CONSTRAINT IF EXISTS fk_id_osc CASCADE;
ALTER TABLE osc.tb_participacao_social_declarada ADD CONSTRAINT fk_id_osc FOREIGN KEY (id_osc)
REFERENCES osc.tb_osc (id_osc) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_id_osc | type: CONSTRAINT --
-- ALTER TABLE osc.tb_conselho_fiscal DROP CONSTRAINT IF EXISTS fk_id_osc CASCADE;
ALTER TABLE osc.tb_conselho_fiscal ADD CONSTRAINT fk_id_osc FOREIGN KEY (id_osc)
REFERENCES osc.tb_osc (id_osc) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_id_projeto | type: CONSTRAINT --
-- ALTER TABLE osc.tb_area_atuacao_outra_projeto DROP CONSTRAINT IF EXISTS fk_id_projeto CASCADE;
ALTER TABLE osc.tb_area_atuacao_outra_projeto ADD CONSTRAINT fk_id_projeto FOREIGN KEY (id_projeto)
REFERENCES osc.tb_projeto (id_projeto) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_id_area_atuacao_outra | type: CONSTRAINT --
-- ALTER TABLE osc.tb_area_atuacao_outra_projeto DROP CONSTRAINT IF EXISTS fk_id_area_atuacao_outra CASCADE;
ALTER TABLE osc.tb_area_atuacao_outra_projeto ADD CONSTRAINT fk_id_area_atuacao_outra FOREIGN KEY (id_area_atuacao_outra)
REFERENCES osc.tb_area_atuacao_outra (id_area_atuacao_outra) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_id_osc | type: CONSTRAINT --
-- ALTER TABLE osc.tb_area_atuacao DROP CONSTRAINT IF EXISTS fk_id_osc CASCADE;
ALTER TABLE osc.tb_area_atuacao ADD CONSTRAINT fk_id_osc FOREIGN KEY (id_osc)
REFERENCES osc.tb_osc (id_osc) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_cd_area_area_atuacao | type: CONSTRAINT --
-- ALTER TABLE osc.tb_area_atuacao DROP CONSTRAINT IF EXISTS fk_cd_area_area_atuacao CASCADE;
ALTER TABLE osc.tb_area_atuacao ADD CONSTRAINT fk_cd_area_area_atuacao FOREIGN KEY (cd_area_atuacao)
REFERENCES syst.dc_area_atuacao (cd_area_atuacao) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_cd_subarea_area_atuacao | type: CONSTRAINT --
-- ALTER TABLE osc.tb_area_atuacao DROP CONSTRAINT IF EXISTS fk_cd_subarea_area_atuacao CASCADE;
ALTER TABLE osc.tb_area_atuacao ADD CONSTRAINT fk_cd_subarea_area_atuacao FOREIGN KEY (cd_subarea_atuacao)
REFERENCES syst.dc_subarea_atuacao (cd_subarea_atuacao) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_id_projeto | type: CONSTRAINT --
-- ALTER TABLE osc.tb_area_atuacao_projeto DROP CONSTRAINT IF EXISTS fk_id_projeto CASCADE;
ALTER TABLE osc.tb_area_atuacao_projeto ADD CONSTRAINT fk_id_projeto FOREIGN KEY (id_projeto)
REFERENCES osc.tb_projeto (id_projeto) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_cd_area_atuacao | type: CONSTRAINT --
-- ALTER TABLE osc.tb_area_atuacao_projeto DROP CONSTRAINT IF EXISTS fk_cd_area_atuacao CASCADE;
ALTER TABLE osc.tb_area_atuacao_projeto ADD CONSTRAINT fk_cd_area_atuacao FOREIGN KEY (cd_area_atuacao)
REFERENCES syst.dc_subarea_atuacao (cd_subarea_atuacao) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_eduf_edmu | type: CONSTRAINT --
-- ALTER TABLE spat.ed_municipio DROP CONSTRAINT IF EXISTS fk_eduf_edmu CASCADE;
ALTER TABLE spat.ed_municipio ADD CONSTRAINT fk_eduf_edmu FOREIGN KEY (eduf_cd_uf)
REFERENCES spat.ed_uf (eduf_cd_uf) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_edre_eduf | type: CONSTRAINT --
-- ALTER TABLE spat.ed_uf DROP CONSTRAINT IF EXISTS fk_edre_eduf CASCADE;
ALTER TABLE spat.ed_uf ADD CONSTRAINT fk_edre_eduf FOREIGN KEY (edre_cd_regiao)
REFERENCES spat.ed_regiao (edre_cd_regiao) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_id_projeto | type: CONSTRAINT --
-- ALTER TABLE osc.tb_publico_beneficiado_projeto DROP CONSTRAINT IF EXISTS fk_id_projeto CASCADE;
ALTER TABLE osc.tb_publico_beneficiado_projeto ADD CONSTRAINT fk_id_projeto FOREIGN KEY (id_projeto)
REFERENCES osc.tb_projeto (id_projeto) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_id_publico_beneficiado | type: CONSTRAINT --
-- ALTER TABLE osc.tb_publico_beneficiado_projeto DROP CONSTRAINT IF EXISTS fk_id_publico_beneficiado CASCADE;
ALTER TABLE osc.tb_publico_beneficiado_projeto ADD CONSTRAINT fk_id_publico_beneficiado FOREIGN KEY (id_publico_beneficiado)
REFERENCES osc.tb_publico_beneficiado (id_publico_beneficiado) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_tb_osc | type: CONSTRAINT --
-- ALTER TABLE osc.tb_osc_parceira_projeto DROP CONSTRAINT IF EXISTS fk_tb_osc CASCADE;
ALTER TABLE osc.tb_osc_parceira_projeto ADD CONSTRAINT fk_tb_osc FOREIGN KEY (id_osc)
REFERENCES osc.tb_osc (id_osc) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_tb_projeto | type: CONSTRAINT --
-- ALTER TABLE osc.tb_osc_parceira_projeto DROP CONSTRAINT IF EXISTS fk_tb_projeto CASCADE;
ALTER TABLE osc.tb_osc_parceira_projeto ADD CONSTRAINT fk_tb_projeto FOREIGN KEY (id_projeto)
REFERENCES osc.tb_projeto (id_projeto) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: id_osc | type: CONSTRAINT --
-- ALTER TABLE osc.tb_relacoes_trabalho_outra DROP CONSTRAINT IF EXISTS id_osc CASCADE;
ALTER TABLE osc.tb_relacoes_trabalho_outra ADD CONSTRAINT id_osc FOREIGN KEY (id_osc)
REFERENCES osc.tb_osc (id_osc) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_id_participacao_social_conselho | type: CONSTRAINT --
-- ALTER TABLE osc.tb_representante_conselho DROP CONSTRAINT IF EXISTS fk_id_participacao_social_conselho CASCADE;
ALTER TABLE osc.tb_representante_conselho ADD CONSTRAINT fk_id_participacao_social_conselho FOREIGN KEY (id_participacao_social_conselho)
REFERENCES osc.tb_participacao_social_conselho (id_conselho) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_id_osc | type: CONSTRAINT --
-- ALTER TABLE osc.tb_participacao_social_conferencia_outra DROP CONSTRAINT IF EXISTS fk_id_osc CASCADE;
ALTER TABLE osc.tb_participacao_social_conferencia_outra ADD CONSTRAINT fk_id_osc FOREIGN KEY (id_osc)
REFERENCES osc.tb_osc (id_osc) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_id_conferencia | type: CONSTRAINT --
-- ALTER TABLE osc.tb_participacao_social_conferencia_outra DROP CONSTRAINT IF EXISTS fk_id_conferencia CASCADE;
ALTER TABLE osc.tb_participacao_social_conferencia_outra ADD CONSTRAINT fk_id_conferencia FOREIGN KEY (id_conferencia)
REFERENCES osc.tb_conferencia (id_conferencia) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_forma_participacao_conferencia | type: CONSTRAINT --
-- ALTER TABLE osc.tb_participacao_social_conferencia_outra DROP CONSTRAINT IF EXISTS fk_forma_participacao_conferencia CASCADE;
ALTER TABLE osc.tb_participacao_social_conferencia_outra ADD CONSTRAINT fk_forma_participacao_conferencia FOREIGN KEY (cd_forma_participacao_conferencia)
REFERENCES syst.dc_forma_participacao_conferencia (cd_forma_participacao_conferencia) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_id_osc | type: CONSTRAINT --
-- ALTER TABLE osc.tb_participacao_social_outra DROP CONSTRAINT IF EXISTS fk_id_osc CASCADE;
ALTER TABLE osc.tb_participacao_social_outra ADD CONSTRAINT fk_id_osc FOREIGN KEY (id_osc)
REFERENCES osc.tb_osc (id_osc) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_id_osc | type: CONSTRAINT --
-- ALTER TABLE osc.tb_recursos_osc DROP CONSTRAINT IF EXISTS fk_id_osc CASCADE;
ALTER TABLE osc.tb_recursos_osc ADD CONSTRAINT fk_id_osc FOREIGN KEY (id_osc)
REFERENCES osc.tb_osc (id_osc) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_cd_fonte_recursos_osc | type: CONSTRAINT --
-- ALTER TABLE osc.tb_recursos_osc DROP CONSTRAINT IF EXISTS fk_cd_fonte_recursos_osc CASCADE;
ALTER TABLE osc.tb_recursos_osc ADD CONSTRAINT fk_cd_fonte_recursos_osc FOREIGN KEY (cd_fonte_recursos_osc)
REFERENCES syst.dc_fonte_recursos_osc (cd_fonte_recursos_osc) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: fk_cd_origem_fonte_recursos_osc | type: CONSTRAINT --
-- ALTER TABLE syst.dc_fonte_recursos_osc DROP CONSTRAINT IF EXISTS fk_cd_origem_fonte_recursos_osc CASCADE;
ALTER TABLE syst.dc_fonte_recursos_osc ADD CONSTRAINT fk_cd_origem_fonte_recursos_osc FOREIGN KEY (cd_fonte_recursos_osc)
REFERENCES syst.dc_origem_fonte_recursos_osc (cd_origem_fonte_recursos_osc) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --


